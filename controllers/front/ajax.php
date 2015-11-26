<?php


class EgcallmeajaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
    
        parent::initContent();

        $context = Context::getContext();
        
        $action = Tools::getValue('action');
        
        $view = '';
        if (!$action) {
            $view = 'form';
        } else {
            $phone = Tools::getValue('eg_phone');
            $fname = Tools::getValue('eg_fname');
            $lname = Tools::getValue('eg_lname');
            $message = Tools::getValue('eg_message');
            $this->newMessage($phone, $fname, $lname, $message, $context);
        }
        
        
        $this->context->smarty->assign(array(
                    'ajaxcontroller' => $this->context->link->getModuleLink('egcallme', 'ajax'),
                    'mask' => Configuration::get('EGCALLME_PHONE_MASK'),
                    'fname' => Configuration::get('EGCALLME_FIELD_FNAME'),
                    'lname' => Configuration::get('EGCALLME_FIELD_LNAME'),
                    'mess' => Configuration::get('EGCALLME_FIELD_MESS'),
                    'view' => $view
                ));

        $this->smartyOutputContent($this->getTemplatePath('ajax.tpl'));
    }

    private function newMessage($phone, $fname, $lname, $message, $context)
    {
        // insert to DB
        $query = "insert into "._DB_PREFIX_.egcallme::INSTALL_SQL_BD1NAME." 
        (`id_shop`, `host`, `type`, `phone`, `fname`,`lname`, `message`) 
        values ('".(int)$context->shop->id."', '".Tools::getHttpHost()."', 'callback', '".$phone."',
            '".$fname."','".$lname."', '".$message."')";
        Db::getInstance()->execute(trim($query));
        
        // notify by email
        $emails_param = Configuration::get('EGCALLME_EMAIL_NOTIFY');

        if (trim($emails_param)!="") {
            $param = array(
                '{phone}'    => $phone,
                 '{message}'    => $message,
                '{fname}'    => $fname,
                '{lname}'    => $lname
            );

            $emails = explode(';', $emails_param);

            $dir = egcallme::getModuleDir().'/mails/';
                
            foreach ($emails as $email) {
                $email_theme = "email_notify";
                Mail::Send(
                    (int)$context->language->id,
                    $email_theme,
                    Mail::l("NEW Callback ".$phone, $this->context->language->id),
                    $param,
                    trim($email),
                    "",
                    null,
                    null,
                    null,
                    null,
                    $dir,
                    false,
                    (int)$context->shop->id
                );
            }
            $phone = "+".preg_replace('#\D+#', '', $phone);          

            $http_message = "CallBack ".$host." ".$phone." ".$fname." ".$lname." ".$message;
            $http_message = urlencode($http_message);
            if (Configuration::get('EGCALLME_HTTPNOT_1')!='') {
            	$request = str_replace('{message}', $http_message, Configuration::get('EGCALLME_HTTPNOT_1'));
            	$result = file_get_contents($request);
            }
            if (Configuration::get('EGCALLME_HTTPNOT_2')!='') {
            	$request = str_replace('{message}', $http_message, Configuration::get('EGCALLME_HTTPNOT_2'));
            	$result = file_get_contents($request);
            }
            
        }
    }
}
