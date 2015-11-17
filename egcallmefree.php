<?php
/**
 *  Leo Theme for Prestashop 1.6.x
 *
 * @author    http://www.leotheme.com
 * @copyright Copyright (C) October 2013 LeoThemes.com <@emai:leotheme@gmail.com>
 *               <info@leotheme.com>.All rights reserved.
 * @license   GNU General Public License version 2
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
class EgcallmeFree extends Module
{
    private $html = '';

    public function __construct()
    {
        $this->name = 'egcallmefree';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Evgeny Grishin';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;
        $this->html = '';

        parent::__construct();

        $this->displayName = $this->l('Easy callback free!');
        $this->description = $this->l('Addon for callback on website.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function getContent()
    {
        if (Tools::isSubmit('submitEgcallmeFree')) {
            Configuration::updateValue('EGCALLMEFREE_BTN_VIEW', Tools::getValue('button_type'));
            Configuration::updateValue('EGCALLMEFREE_EMAIL_NOTIFY', Tools::getValue('email_notify'));
            Configuration::updateValue('EGCALLMEFREE_PHONE_TUBE', Tools::getValue('button_type_tube'));
            Configuration::updateValue('EGCALLMEFREE_FIELD_FNAME', Tools::getValue('fname'));
            Configuration::updateValue('EGCALLMEFREE_FIELD_MESS', Tools::getValue('message'));
            $this->html .= $this->displayConfirmation($this->l('Settings updated.'));
        }
        $this->html .= $this->renderForm();
        return $this->html;
    }

    private function renderForm()
    {
        $fields_form1 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Callback button'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Type of button :'),
                        'name' => 'button_type',
                        'options' => array(
                        'query' => array(
                                    0 => array('id' => 'Hide', 'name' => $this->l('Hide')),
                                    1 => array('id' => 'Show', 'name' => $this->l('Show')),
                                    ),
                        'id' => 'id',
                        'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Email for notifications:'),
                        'name' => 'email_notify',
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $fields_form2 = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Additional button'),
                    'icon' => 'icon-cogs'
                ),
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Tube button:'),
                        'name' => 'button_type_tube',
                        'options' => array(
                        'query' => array(
                                    0 => array('id' => 'No', 'name' => $this->l('No')),
                                    1 => array('id' => 'Show', 'name' => $this->l('Show')),
                                    ),
                        'id' => 'id',
                        'name' => 'name'
                        ),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                )
            ),
        );

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
        $helper->default_form_language = $lang->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ?
         Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitEgcallmeFree';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name
            .'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFieldsValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id
        );

        return $helper->generateForm(array($fields_form1, $fields_form2));
    }

    public function getConfigFieldsValues()
    {
        return array(
            'button_type' => Tools::getValue('button_type', Configuration::get('EGCALLMEFREE_BTN_VIEW')),
            'email_notify' => Tools::getValue('email_notify', Configuration::get('EGCALLMEFREE_EMAIL_NOTIFY')),
            'button_type_tube' => Tools::getValue('button_type_tube', Configuration::get('EGCALLMEFREE_PHONE_TUBE')),
        );
    }

    public function hookHeader($params)
    {
        $this->context->controller->addJS($this->_path.'views/js/callme.js', 'all');
        $this->context->controller->addJS($this->_path.'views/js/jquery.validate.min.js', 'all');
        $this->context->controller->addCSS($this->_path.'views/css/callme.css', 'all');
    }

    public function hookDisplayNav($params)
    {
         $this->smarty->assign(array(
             'btn_view' => Configuration::get('EGCALLMEFREE_BTN_VIEW'),
             'phone_tube' => Configuration::get('EGCALLMEFREE_PHONE_TUBE'),
             'ajaxcontroller' => $this->context->link->getModuleLink($this->name, 'ajax'),
        ));

        return $this->display(__FILE__, 'main_hook.tpl');
    }


    public function hookDisplayTop($params)
    {
        return $this->hookDisplayNav($params);
    }

    public function hookDisplayLeftColumn($params)
    {
        return $this->hookDisplayNav($params);
    }

    public function hookDisplayRightColumn($params)
    {
        return $this->hookDisplayNav($params);
    }

    public static function getModuleDir()
    {
        return dirname(__FILE__);
    }

    public function install()
    {
        $this->registerHook('displayNav');
        $this->registerHook('header');
        Configuration::updateValue('EGCALLMEFREE_BTN_VIEW', 'Show');
        Configuration::updateValue('EGCALLMEFREE_PHONE_TUBE', 'Show');
        Configuration::updateValue('EGCALLMEFREE_EMAIL_NOTIFY', 'mail@domain.com');
        return parent::install();
    }

    public function uninstall()
    {
        Configuration::deleteByName('EGCALLMEFREE_BTN_VIEW');
        Configuration::deleteByName('EGCALLMEFREE_PHONE_TUBE');
        Configuration::deleteByName('EGCALLMEFREE_EMAIL_NOTIFY');
        $this->unregisterHook('displayTop');
        $this->unregisterHook('displayNav');
        $this->unregisterHook('displayLeftColumn');
        !$this->unregisterHook('displayRightColumn');
        $this->unregisterHook('header');
        return parent::uninstall();
    }

    
    public function reset()
    {
        if (!$this->uninstall(false)) {
            return false;
        }
        if (!$this->install(false)) {
            return false;
        }
        return true;
    }
}
