<?php
/**
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*/

if (!defined('_PS_VERSION_')){
  exit;
} 
class Egcallme extends Module
{
	const INSTALL_SQL_FILE = 'install.sql';
	const INSTALL_SQL_BD1NAME = 'egcallme';
	private $html = '';
	
	/**
	 * 1)translations
	 * 2)tab for maintanence
	 * 4) comments for configurations
	 * Enter description here ...
	 */
    public function __construct()
    {
	    $this->name = 'egcallme';
	    $this->tab = 'front_office_features';
	    $this->version = '0.1.1';
	    $this->author = 'Evgeny Grishin';
	    $this->need_instance = 0;
	    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
	    $this->bootstrap = true;
	    $this->html = '';
	 
	    parent::__construct();
	 
	    $this->displayName = $this->l('Call me addon');
	    $this->description = $this->l('Addon for callback.');
	 
	    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	 
  	}	
  	
  	public function getContent()
	{
		if (Tools::isSubmit('submitEgcallme'))
		{
			Configuration::updateValue('EGCALLME_BTN_VIEW', Tools::getValue('button_type'));
			Configuration::updateValue('EGCALLME_BTN_SELF', Tools::getValue('button_code'));
			Configuration::updateValue('EGCALLME_EMAIL_NOTIFY', Tools::getValue('email_notify'));
			Configuration::updateValue('EGCALLME_PHONE_TUBE', Tools::getValue('button_type_tube'));
			Configuration::updateValue('EGCALLME_PHONE_TUBE_C', Tools::getValue('tube_color'));
			Configuration::updateValue('EGCALLME_PHONE_MASK', Tools::getValue('mask'));
			Configuration::updateValue('EGCALLME_FIELD_FNAME', Tools::getValue('fname'));
			Configuration::updateValue('EGCALLME_FIELD_LNAME', Tools::getValue('lname'));
			Configuration::updateValue('EGCALLME_FIELD_MESS', Tools::getValue('message'));
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
									1 => array('id' => 'Link', 'name' => $this->l('Link')),
									2 => array('id' => 'Button', 'name' => $this->l('Button')),
									//3 => array('id' => 'Self', 'name' => $this->l('Self')),
									),
						'id' => 'id',
						'name' => 'name'
						),
					),
					/*array(
						'type' => 'textarea',
						'label' => $this->l('Code button:'),
						'name' => 'button_code',
					),*/
					array(
						'type' => 'text',
						'label' => $this->l('Emails for notifications:'),
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
									2 => array('id' => 'Animation', 'name' => $this->l('Animation')),
									),
						'id' => 'id',
						'name' => 'name'
						),
					),
					array(
						'type' => 'text',
						'label' => $this->l('Tube color:'),
						'name' => 'tube_color',
					),
				),
				'submit' => array(
					'title' => $this->l('Save'),
				)
			),			
		);	

		$fields_form3 = array(
			'form' => array(
				'legend' => array(
					'title' => $this->l('Window configuration'),
					'icon' => 'icon-cogs'
				),
				'input' => array(
					array(
						'type' => 'text',
						'label' => $this->l('Phone mask:'),
						'name' => 'mask',
					),				
					array(
						'type' => 'select',
						'label' => $this->l('First name:'),
						'name' => 'fname',
						'options' => array(
						'query' => array(
									0 => array('id' => 'Hide', 'name' => $this->l('Hide')),
									1 => array('id' => 'Show', 'name' => $this->l('Show')),
									2 => array('id' => 'Required', 'name' => $this->l('Required')),
									),
						'id' => 'id',
						'name' => 'name'
						),
					),
					array(
						'type' => 'select',
						'label' => $this->l('Last name:'),
						'name' => 'lname',
						'options' => array(
						'query' => array(
									0 => array('id' => 'Hide', 'name' => $this->l('Hide')),
									1 => array('id' => 'Show', 'name' => $this->l('Show')),
									2 => array('id' => 'Required', 'name' => $this->l('Required')),
									),
						'id' => 'id',
						'name' => 'name'
						),
					),						
					array(
						'type' => 'select',
						'label' => $this->l('Message:'),
						'name' => 'message',
						'options' => array(
						'query' => array(
									0 => array('id' => 'Hide', 'name' => $this->l('Hide')),
									1 => array('id' => 'Show', 'name' => $this->l('Show')),
									2 => array('id' => 'Required', 'name' => $this->l('Required')),
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
		$helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') ? Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG') : 0;

		$helper->identifier = $this->identifier;
		$helper->submit_action = 'submitEgcallme';
		$helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false).'&configure='.$this->name
			.'&tab_module='.$this->tab.'&module_name='.$this->name;
		$helper->token = Tools::getAdminTokenLite('AdminModules');
		$helper->tpl_vars = array(
			'fields_value' => $this->getConfigFieldsValues(),
			'languages' => $this->context->controller->getLanguages(),
			'id_language' => $this->context->language->id
		);

		return $helper->generateForm(array($fields_form1, $fields_form2, $fields_form3));		
	}
	
  	public function getConfigFieldsValues()
	{
		return array(
			'button_type' => Tools::getValue('button_type', Configuration::get('EGCALLME_BTN_VIEW')), 
			'button_code' => Tools::getValue('button_code', Configuration::get('EGCALLME_BTN_SELF')),
			'email_notify' => Tools::getValue('email_notify', Configuration::get('EGCALLME_EMAIL_NOTIFY')),
			'button_type_tube' => Tools::getValue('button_type_tube', Configuration::get('EGCALLME_PHONE_TUBE')),
			'tube_color' => Tools::getValue('tube_color', Configuration::get('EGCALLME_PHONE_TUBE_C')),
			'mask' => Tools::getValue('mask', Configuration::get('EGCALLME_PHONE_MASK')),
			'fname' => Tools::getValue('fname', Configuration::get('EGCALLME_FIELD_FNAME')),
			'lname' => Tools::getValue('lname', Configuration::get('EGCALLME_FIELD_LNAME')),
			'message' => Tools::getValue('message', Configuration::get('EGCALLME_FIELD_MESS')),
		);
	}
	
  	public function hookHeader($params)
	{
		if (Configuration::get('EGCALLME_PHONE_MASK'))
		{
			$this->context->controller->addJS($this->_path.'views/js/jquery.maskedinput.min.js', 'all');
		}		
		$this->context->controller->addJS($this->_path.'views/js/callme.js', 'all');
		$this->context->controller->addJS($this->_path.'views/js/jquery.validate.min.js', 'all');		
	}
	

	
	public function hookDisplayNav($params)
	{
 		$this->smarty->assign(array(
 			'btn_view' => Configuration::get('EGCALLME_BTN_VIEW'), 		
 			'phone_tube' => Configuration::get('EGCALLME_PHONE_TUBE'),
 			'btn_self' => Configuration::get('EGCALLME_BTN_SELF'),
 			'mask' => Configuration::get('EGCALLME_PHONE_MASK'),
 			'phone_color' => str_replace("#", "", Configuration::get('EGCALLME_PHONE_TUBE_C')),
			'ajaxcontroller' => $this->context->link->getModuleLink($this->name, 'ajax'),
 			'rgb' => egcallme::hex2rgb(Configuration::get('EGCALLME_PHONE_TUBE_C')),
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
	
	public static function hex2rgb($hex) {
		$hex = str_replace("#", "", $hex);
		if(Tools::strlen($hex) == 3) {
			$r = hexdec(Tools::substr($hex,0,1).Tools::substr($hex,0,1));
			$g = hexdec(Tools::substr($hex,1,1).Tools::substr($hex,1,1));
			$b = hexdec(Tools::substr($hex,2,1).Tools::substr($hex,2,1));
		}
		else
		{
			$r = hexdec(Tools::substr($hex,0,2));
			$g = hexdec(Tools::substr($hex,2,2));
			$b = hexdec(Tools::substr($hex,4,2));
			}
		return array($r, $g, $b);
	}

	public function install($keep = true)
	{
		if ($keep)
			{
				if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE)){
					return false;
				}
				else if (!$sql = Tools::file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE)){
					return false;
				}
				$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE', 'DB1NAME'), array(_DB_PREFIX_, _MYSQL_ENGINE_, self::INSTALL_SQL_BD1NAME), $sql);
				$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
	
				foreach ($sql as $query)
				{
					if (!Db::getInstance()->execute(trim($query))){
						return false;
					}
				}
	
			}
			
	  if (!parent::install() ||
	  	!$this->registerHook('displayNav') ||
		!$this->registerHook('header') ||
		!Configuration::updateValue('EGCALLME_BTN_VIEW', 'Link')||//Hide|Link|Button|Self
		!Configuration::updateValue('EGCALLME_BTN_SELF', '<div class="clearfix pull-left"><button class="eg_callme_btn" type="button">Custom callback button</button></div>')||//textarea code
		!Configuration::updateValue('EGCALLME_PHONE_MASK', '+4 (999) 999-99-99')||				
		!Configuration::updateValue('EGCALLME_PHONE_TUBE', 'Show')||//Hide|Show|Animation
		!Configuration::updateValue('EGCALLME_PHONE_TUBE_C', '68cafa')||//Color
		!Configuration::updateValue('EGCALLME_EMAIL_NOTIFY', 'first.mail@domain.com; second.mail@domain.com')||//list of emails ";"
		!Configuration::updateValue('EGCALLME_FIELD_FNAME', 'Required')||//Hide|Show|Required
		!Configuration::updateValue('EGCALLME_FIELD_LNAME', 'Required')||//Hide|Show|Required
		!Configuration::updateValue('EGCALLME_FIELD_MESS', 'Required')//Hide|Show|Required
		)
	    return false;
	  return true;
	}  	
	
	public function uninstall($keep = true)
	{
	  if (!parent::uninstall() || ($keep && !$this->deleteTables()) ||
			!Configuration::deleteByName('EGCALLME_BTN_VIEW') ||
			!Configuration::deleteByName('EGCALLME_BTN_SELF') ||
			!Configuration::deleteByName('EGCALLME_PHONE_MASK') ||				  
			!Configuration::deleteByName('EGCALLME_PHONE_TUBE') ||
			!Configuration::deleteByName('EGCALLME_PHONE_TUBE_C') ||
			!Configuration::deleteByName('EGCALLME_EMAIL_NOTIFY')||
			!Configuration::deleteByName('EGCALLME_FIELD_FNAME')|| 			
			!Configuration::deleteByName('EGCALLME_FIELD_LNAME') ||
			!Configuration::deleteByName('EGCALLME_FIELD_MESS') ||
			!$this->unregisterHook('displayTop') ||
			!$this->unregisterHook('displayNav') ||
			!$this->unregisterHook('displayLeftColumn') ||
			!$this->unregisterHook('displayRightColumn') ||
			!$this->deleteTables()||
			!$this->unregisterHook('header'))
	    return false;
	  return true;
	}	
 
	
  	public function reset()
	{
		if (!$this->uninstall(false))
			return false;
		if (!$this->install(false))
			return false;
		return true;
	}	
	
	public function deleteTables()
	{
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS
			`'._DB_PREFIX_.self::INSTALL_SQL_BD1NAME.'`');
	}		
  	
  }