<?php
/**
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*/

class EgcallmeajaxModuleFrontController extends ModuleFrontController
{

    public function initContent()
    {
    
        parent::initContent();

        $context = Context::getContext();
        
        $action = Tools::getValue('action');
        
        
        if (!$action) {
            $view = 'form';
        } else {
            $phone = Tools::getValue('eg_phone');
            $fname = Tools::getValue('eg_fname');
            $message = Tools::getValue('eg_message');
            $this->newMessage($phone, $fname, $message, $context);
        }
        
        
        $this->context->smarty->assign(array(
                    'ajaxcontroller' => $this->context->link->getModuleLink('egcallme', 'ajax'),
                    'fname' => Configuration::get('EGCALLME_FIELD_FNAME'),
                    'lname' => Configuration::get('EGCALLME_FIELD_LNAME'),
                    'mess' => Configuration::get('EGCALLME_FIELD_MESS'),
                    'view' => $view
                ));

        $this->smartyOutputContent($this->getTemplatePath('ajax.tpl'));
    }

    private function newMessage($phone, $fname, $message, $context)
    {
        $email = Configuration::get('EGCALLME_EMAIL_NOTIFY');

        if (trim($email)!="") {
            $param = array(
                '{phone}'    => $phone,
                 '{message}'    => $message,
                '{fname}'    => $fname
            );

            $dir = egcallme::getModuleDir().'/mails/';
                
            Mail::Send(
                (int)$context->language->id,
                "email_notify",
                Mail::l("NEW Callback ".$phone, $this->context->language->id),
                $param,
                $email,
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
    }
}
