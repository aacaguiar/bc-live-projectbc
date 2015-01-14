<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Email extends CI_Email {

	/*
	 | -------------------------------------------------------------------
	| EMAIL CONFING
	| -------------------------------------------------------------------
	| Configuration of outgoing mail server.
	| servidor stmp hotmail: smtp.live.com  porta:25 ou 465
	|
	| */
	
	function __construct(){
		$config['protocol']='smtp';
		$config['smtp_host']='ssl://smtp.googlemail.com';
		$config['smtp_port']='465';
		$config['smtp_timeout']='60';
		$config['smtp_user']='bioclonebiofabrica@gmail.com';
		$config['smtp_pass']='bioclone1';
		$config['charset']='utf-8';
		$config['newline']="\r\n";
		$config['mailtype']="html";
		parent::__construct($config);
		
// 		$config['protocol']='smtp';
// 		$config['smtp_host']='smtp.live.com';
// 		$config['smtp_port']='587';
// 		$config['smtp_timeout']='30';
// 		$config['smtp_user']='seu email gmail aqui';
// 		$config['smtp_pass']='sua senha gmail';
// 		$config['charset']='utf-8';
// 		$config['newline']="\r\n";
// 		$config['mailtype']="html";
// 		parent::__construct($config);
		
	}
}