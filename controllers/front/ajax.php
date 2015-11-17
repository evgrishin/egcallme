<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

class EgcallmeFreeajaxModuleFrontController extends ModuleFrontController
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
            $message = Tools::getValue('eg_message');
            $this->newMessage($phone, $fname, $message, $context);
        }
        
        
        $this->context->smarty->assign(array(
                    'ajaxcontroller' => $this->context->link->getModuleLink('egcallmefree', 'ajax'),
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
