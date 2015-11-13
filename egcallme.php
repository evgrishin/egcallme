<?php
if (!defined('_PS_VERSION_'))
  exit;
  
  class egcallme extends Module
  {
	const INSTALL_SQL_FILE = 'install.sql';
	const INSTALL_SQL_BD1NAME = 'egcallme';
	
    public function __construct()
    {
	    $this->name = 'egcallme';
	    $this->tab = 'front_office_features';
	    $this->version = '0.1.1';
	    $this->author = 'Evgeny Grishin';
	    $this->need_instance = 0;
	    $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_); 
	    $this->bootstrap = true;
	 
	    parent::__construct();
	 
	    $this->displayName = $this->l('Call me addon');
	    $this->description = $this->l('Addon for callback.');
	 
	    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
	 
  	}	
  	
  	public function getContent()
	{
		
		$output = null;
		/**
		 * 
		 * 
		 */
		return $output = "configuration";
	}
	
  	public function hookHeader($params)
	{
		$this->context->controller->addJS($this->_path.'views/js/jquery.maskedinput.js', 'all');		
		$this->context->controller->addJS($this->_path.'views/js/callme.js', 'all');
		$this->context->controller->addCSS($this->_path.'views/css/callme.css', 'all');
	}
	
	public function hookDisplayNav($params)
	{
 		$this->smarty->assign(array(
 			'phone_tube' => Configuration::get('EGCALLME_PHONE_TUBE'),
 			'btn_view' => Configuration::get('EGCALLME_BTN_VIEW'),
 			'btn_self' => Configuration::get('EGCALLME_BTN_SELF'),
 			'phone_color' => Configuration::get('EGCALLME_PHONE_TUBE_C'),
			'ajaxcontroller' => $this->context->link->getModuleLink($this->name, 'ajax')
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

	public function install($keep = true)
	{
		if ($keep)
			{
				if (!file_exists(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
					return false;
				else if (!$sql = file_get_contents(dirname(__FILE__).'/'.self::INSTALL_SQL_FILE))
					return false;
				$sql = str_replace(array('PREFIX_', 'ENGINE_TYPE', 'DB1NAME'), array(_DB_PREFIX_, _MYSQL_ENGINE_, self::INSTALL_SQL_BD1NAME), $sql);
				$sql = preg_split("/;\s*[\r\n]+/", trim($sql));
	
				foreach ($sql as $query)
					if (!Db::getInstance()->execute(trim($query)))
						return false;
	
			}
			
	  if (!parent::install() ||
	  	!$this->registerHook('displayNav') ||
		!$this->registerHook('header') ||	
		!Configuration::updateValue('EGCALLME_BTN_VIEW', 'link')||//not|link|btn|self
		!Configuration::updateValue('EGCALLME_BTN_SELF', '')||//textarea code
		!Configuration::updateValue('EGCALLME_PHONE_MASK', '+4 (123) 456-789-99')||				
		!Configuration::updateValue('EGCALLME_PHONE_TUBE', 'view')||//not|view|ani
		!Configuration::updateValue('EGCALLME_PHONE_TUBE_C', 'green')||//color
		!Configuration::updateValue('EGCALLME_EMAIL_NOTIFY', '')||//list of emails ";"
		!Configuration::updateValue('EGCALLME_FIELD_FNAME', 'mondatory')||//not|view|mondatory
		!Configuration::updateValue('EGCALLME_FIELD_LNAME', 'mondatory')||//not|view|mondatory
		!Configuration::updateValue('EGCALLME_FIELD_MESS', 'mondatory')//not|view|mondatory
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