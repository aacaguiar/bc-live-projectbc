<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrato_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
}//fim da class
