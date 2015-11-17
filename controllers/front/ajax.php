<?php
/**
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*/

class EgcallmeFreeajaxModuleFrontController extends ModuleFrontController
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
                    'ajaxcontroller' => $this->context->link->getModuleLink('egcallmefree', 'ajax'),
                    'fname' => Configuration::get('EGCALLMEFREE_FIELD_FNAME'),
                    'mess' => Configuration::get('EGCALLMEFREE_FIELD_MESS'),
                    'view' => $view
                ));

        $this->smartyOutputContent($this->getTemplatePath('ajax.tpl'));
    }

    private function newMessage($phone, $fname, $message, $context)
    {
        $email = Configuration::get('EGCALLMEFREE_EMAIL_NOTIFY');

        if (trim($email)!="") {
            $param = array(
                '{phone}'    => $phone,
                '{message}'    => $message,
                '{fname}'    => $fname
            );

            $dir = EgcallmeFree::getModuleDir().'/mails/';
 
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
