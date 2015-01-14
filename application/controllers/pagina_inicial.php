<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//include_once 'system/libraries/Session.php';
class Pagina_inicial extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('menu');
	}	
	
	public function index()
	{
		$permissao = $this->session->userdata('permissao');
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
		$lista_menu = $this->menu->gerenciar_menu($permissao);
		
		$data = array(
				'nome_usuario' =>$nome_usuario,
				'lista_menu'=>$lista_menu
		);
		
		if (! (empty ($nome_usuario) or empty ($senha)) ) 
		{
			//$lista_menu = $this->menu->gerenciar_menu($permissao);
			//$data = array('nome_usuario' =>$nome_usuario,'lista_menu'=>$lista_menu);
	
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('templates/corpo_view');
			$this->load->view ('templates/rodape_view');	
		} 
		else 
		{
			$this->load->view ( 'erro_acesso' );
		}
		
	}
	
	public function fechar_sessao()
	{
		$array_items = array('nome_usuario' => '', 'senha' => '');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		redirect('../Login');
	}
	

}


//fim da class controlador/pagina_inicial

