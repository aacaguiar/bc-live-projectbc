<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajuda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('cliente_fornecedor_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
	}
	
	public function check_sessao()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) ){
			return true;
		}
		else{
			$this->load->view ('erro_acesso');
		}
	}
	
	
	public function exibir_catalogo()
	{
		$this->load->view ('exibir_catalogo');
	}
	
	public function exibir_catalogo2()
	{
		print "<script type=\"text/javascript\">
   						window.open('', 'new', 'width=300,height=150,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no');
   				</script>";
	}
	
}
