<?php


class egcallmeajaxModuleFrontController extends ModuleFrontController
{

	public function initContent()
	{
	
		parent::initContent();

		$context = Context::getContext();
		
		$action = Tools::getValue('action');
		
		
		if (!$action)
		{
			$view = 'form';
		}
		else
		{
			$phone = Tools::getValue('eg_phone');
			$fname = Tools::getValue('eg_fname');
			$lname = Tools::getValue('eg_lname');
			$message = Tools::getValue('eg_message');
			$this->newMessage($phone, $fname, $lname, $message, $context);
		}
		
		
		$this->context->smarty->assign(array(
					'ajaxcontroller' => $this->context->link->getModuleLink('egcallme', 'ajax'),
					'mask' => Configuration::get('EGCALLME_PHONE_MASK'),
					'view' =>	$view
				)); 

		$this->smartyOutputContent($this->getTemplatePath('ajax.tpl'));
		
	}

	private function newMessage($phone, $fname, $lname, $message, $context)
	{

		//$phone = preg_replace('#\D+#', '', $phone);
		// insert to DB
		$query = "insert into "._DB_PREFIX_.egcallme::INSTALL_SQL_BD1NAME." 
		(`id_shop`, `phone`, `fname`,`lname`, `message`) 
		values ('".(int)$context->shop->id."', '".$phone."',
			'".$fname."','".$lname."', '".$message."')";
		Db::getInstance()->execute(trim($query));
		
		// notify by email
		$emails_param = Configuration::get('EGCALLME_EMAIL_NOTIFY');

		if (trim($email_param)!="")
		{	
			$param = array(
				'{phone}'	=> $phone,
			 	'{message}'	=> $message,
				'{fname}'	=> $fname,
				'{lname}'	=> $lname
			);
				
			$emails = explode(';', $email_param);
				
			foreach ($emails as $email)
			{
				/*
				Mail::Send(
					(int)$context->language->id,
					$email_theme,
					Mail::l($type, " ".$phone." ".$host),
					$param,
					$email,
					$cname,
					null,
					null,
					null,
					null,
					_PS_MAIL_DIR_,
					false,
					(int)$context->shop->id
				);
				*/
			}
		}

	}
	
}


?>