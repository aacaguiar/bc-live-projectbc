<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entregas extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->model('entregas_model');
	}
		
	public function check_sessao()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) ){
			return true;
		}
		else{
			return false;
		}
	}
	
	
	public function consultar_entrega()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/entregas/entregas.css');
						
			$data = array(
					'nome_usuario' 	=> $nome_usuario,
					'arquivo_css'	=> $arquivo_css,
					'lista_menu'	=> $lista_menu
			);
			
			$this->load->view('templates/topo_view', $data);
			$this->load->view('entregas/entregas_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view('erro_acesso');
		}	
	}
	
	//chamada ajax
	public function listar_entregas()
	{
		$dias_mes = array(1=>'31', 2=>'28', 3=>'31', 4=>'30', 5=>'31', 6=>'30', 7=>'31', 8=>'31', 9=>'30', 10=>'31', 11=>'30', 12=>'31');
		
		if(date("Y")%4 == 0){
			if( substr($ano, -2) == 00){
				$dias_mes[2] = ($ano%400 == 0) ? '29' : '28';
			}else{
				$dias_mes[2] = '29';
			}
		}
		
		$num_mes = $this->input->post('mes');
		$dias_mes = $dias_mes[$num_mes];
		
		if($num_mes<10){
			$mes = '0'.$num_mes;
		}
		
		$dados_ent = $this->entregas_model->listar_entregas($mes, $dias_mes, '2014');
		
		$dados = array(
			'accordion'		=> 'accordion'.$num_mes,
			'tot_entregas'	=> $dados_ent['tot_entregas'],
			'entregas'		=> $dados_ent['entregas'],
		);
		
		$this->load->view('entregas/dados_view', $dados );
		
		//ENVIANDO DADOS NO FORMATO JSON DO PHP P/ JQUERY
		//$dados = array('dia'=> '15/09/2014', 'tot_entregas'=>4);
		//$dia = '01';
		//echo json_encode($dados);
		
	}
	
	function concluir_ent_parcial()
	{
		$id = $this->input->post('id');
		$dados_atualizados = $this->entregas_model->concluir_ent_parcial($id);
		echo ($dados_atualizados) ? true : false ;
	}
	
		
	
}//fim da class




