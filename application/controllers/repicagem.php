<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repicagem extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('repicagem_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->library('pagination');
	}

	public function check_sessao()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function cadastrar_repicador()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao 		= $this->session->userdata('permissao');
			$nome_usuario 	= $this->session->userdata('nome_usuario');
			$lista_menu 	= $this->menu->gerenciar_menu($permissao);
			$arquivo_css 	= base_url('css/repicagem/cadastro_repicador.css');
	
			$data = array(
					'nome_usuario' 	=>	$nome_usuario,
					'arquivo_css'	=> 	$arquivo_css,
					'lista_menu'	=> 	$lista_menu,
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('repicagem/cadastrar_repicador') != FALSE)
			{
				$dados = array(
					'repicador'=> $this->input->post('repicador'),
					'ativo' => 't'
				);
				
				$dados_inseridos = $this->repicagem_model->cadastrar_repicador($dados);
				
				$msg = ($dados_inseridos) ? "repicador(a) cadastrado(a) com sucesso" : "Erro ao cadastrar Repicador(a)";
				print "<script type='text/javascript'>
							var msg = '$msg';
							alert(msg);
						</script>";
				redirect(base_url('repicagem/cadastrar_repicador'),'refresh');
			}
			else
			{
				$this->load->view('templates/topo_view',$data);
				$this->load->view('repicagem/cadastro_repicador_view');
				$this->load->view('templates/rodape_view');
			}
		}
		else
		{
			$this->load->view('erro_acesso');
		}
		
	}//fim cadastrar_repicador
	
	function paginacao($url, $limite, $total_linhas)
	{
		//paginação
		$config['base_url'] = $url;/*endereço base*/
		$config['total_rows'] = $total_linhas;/*nº linhas paginadas*/
		$config['per_page'] = $limite;/*registros por página*/
		$config['num_links'] = 5;
	
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="'.$url.'">';
		$config['cur_tag_close'] = '</a></li>';
			
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
	
		return $config;
	}
	
	function listar_repicadores()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//paginação
	
			$limite = 10;
			($this->uri->segment(3) !='') ? $inicio = $this->uri->segment(3) : $inicio = 0 ;
			$lista_repicadores = $this->repicagem_model->listar_repicadores($inicio, $limite);
			$total_linhas = $this->db->count_all('repicador');
			$config = $this->paginacao(base_url('repicagem/listar_repicadores'), $limite, $total_linhas);
			$this->pagination->initialize($config);
	
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/repicagem/lista_repicagem.css');
	
			$inicio++;
			if($inicio<10){
				$pag=1;
			}else{
				$pag=(int)($inicio/10);
				$pag++;
			}
	
			$total_pag = ($total_linhas<10) ? 1 : ($total_linhas/10);
			$total_pag = (is_float($total_pag)) ? (int)++$total_pag : $total_pag;
	
			$data = array(
					'nome_usuario'=>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_repicadores'=>$lista_repicadores,
					'pagination'=>$this->pagination->create_links(),
					'inicio'=>$inicio,
					'pag'=>$pag,
					'total_pag'=>$total_pag,
					'total_linhas' => $total_linhas
			);
	
			$this->load->view('templates/topo_view',$data);
			$this->load->view('repicagem/listar_repicadores_view');
			$this->load->view('templates/rodape_view');
		}
		else{
			$this->load->view ('erro_acesso');
		}
			
	}//fim do listar repicadores
	
	
	function alterar_repicador()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
			
			$data = array(
					'nome_usuario'	=> $nome_usuario,
					'arquivo_css' 	=> $arquivo_css,
					'lista_menu' 	=> $lista_menu,
					'id_repicador' 	=> $this->input->post('id_repicador'),
					'repicador' 	=> $this->input->post('repicador'),
					'ativo' 		=> $this->input->post('ativo')
			);
	
			$this->load->view('templates/topo_view',$data);
			$this->load->view('repicagem/altera_repicador_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//alterar repicador
	
	
	function alterar_dados_repicador()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//seta variáveis
			$permissao 		= $this->session->userdata('permissao');
			$nome_usuario 	= $this->session->userdata('nome_usuario');
			$lista_menu 	= $this->menu->gerenciar_menu($permissao);
			$arquivo_css 	= base_url('css/repicagem/cadastro_repicador.css');
			
			$data = array(
					'nome_usuario'	=> $nome_usuario,
					'arquivo_css' 	=> $arquivo_css,
					'lista_menu' 	=> $lista_menu,
					'id_repicador' 	=> $this->input->post('id_repicador'),
					'repicador' 	=> $this->input->post('repicador'),
					'ativo' 		=> $this->input->post('ativo')
			);
			
			$dados = array(
					'repicador' => $data['repicador'],
					'ativo'		=> $data['ativo']
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('repicagem/cadastrar_repicador') != FALSE)
			{
				
// 				echo $data['id_repicador']."<br>";
// 				echo $data['repicador']."<br>";
//  			echo $data['ativo'];
				$dados_inseridos = $this->repicagem_model->alterar_dados_repicador($dados, $data['id_repicador']);
				$msg = ($dados_inseridos) ? "Repicador alterado com sucesso" : "Erro ao alterar dados do Repicador";
				print "<script type='text/javascript'>
						var msg = '$msg';
						alert(msg);
						</script>";
				redirect(base_url('repicagem/listar_repicadores'), 'refresh');
				
			}
			else
			{
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('repicagem/altera_repicador_view');
				$this->load->view ('templates/rodape_view');
			}
		}
	
		else{
			$this->load->view ('erro_acesso');
			}
	
	}//fim alterar_dados_repicador
	
	public function indicador_prod_semanal($ano=null, $num_semana_selec=null, $dados=null)
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao 		= $this->session->userdata('permissao');
			$nome_usuario 	= $this->session->userdata('nome_usuario');
			$lista_menu 	= $this->menu->gerenciar_menu($permissao);
			$arquivo_css 	= base_url('css/repicagem/indicador_prod_sem.css');
			//$arquivo_css 	= base_url('css/lote/controle.css');
			$lista_repicadores = $this->repicagem_model->listar_selec_repicadores();
						
			$data_atual = date("m/d/Y"); //mês, dia, ano
			$num_semana = date("W", strtotime($data_atual));

			$data = array(
					'nome_usuario' 	=>	$nome_usuario,
					'arquivo_css'	=> 	$arquivo_css,
					'lista_menu'	=> 	$lista_menu,
					'lista_repicadores' => $lista_repicadores,
					'lista_ind_semanal' => '',
					'dados' => $dados,
					'num_semana' => $num_semana,
					'lista_prod_semanal' => 0
			);

			if($num_semana_selec == NULL){//verifica se $num_semana_selec é null ao iniciar o método
				$data['num_semana_selec'] = $this->input->post('semana');
			}else{
				$data['num_semana_selec'] = $num_semana_selec;
			}
			
			if($ano == NULL){//verifica se ano é null ao iniciar o método
				$data['ano'] = $this->input->post('ano'); //checa name 'ano' ao clicar no btn submit
				if(empty($data['ano'])){
					$data['ano'] = date("Y");
				}
			}else{
				$data['ano'] = $ano;
			}
			
			if($data['num_semana_selec'] !='')
			{
				$lista_prod_semanal = $this->repicagem_model->lista_prod_semanal($data['ano'], $data['num_semana_selec']);
				$campos = array ('repicador' => 'repicador', 'total_expl_prod' => 'total_expl_prod', 'media_tx_mult'=>'media_tx_mult',
								 'pontuacao' => 'pontuacao', 'producao' => 'producao' );
				
				$data['campos'] = $campos;
				$data['lista_prod_semanal'] = $lista_prod_semanal;
			}
			
			$this->load->view('templates/topo_view',$data);
			$this->load->view('repicagem/indicador_prod_sem_view');
			$this->load->view('templates/rodape_view');	
		}
		else
		{
			$this->load->view('erro_acesso');
		}
		
	}//fim do indicador_prod_semanal
	
	
	function cadastrar_prod_semanal()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$ano = $this->input->post('ano');
			$num_semana_selec = $this->input->post('n');
			
			$dados = array(
						'id_repicador'	  => $this->input->post('repicador'),
						'total_expl_prod' => $this->input->post('total_expl_prod'),
						'media_tx_mult'	  => $this->input->post('media_tx_mult'),
						'pontuacao' 	  => $this->input->post('pontuacao'),
						'producao' 		  => $this->input->post('producao'),	
						'ano'			  => $ano,
						'num_semana' 	  => $num_semana_selec				
					);
					
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('repicagem/cadastrar_prod_semanal') != FALSE)
			{
				$dados_inseridos = $this->repicagem_model->cadastrar_prod_semanal($dados);
				$msg = ($dados_inseridos) ? "indicador de Prod. semanal cadastrado com sucesso" : "Erro ao cadastrar indicador de Prod. semanal";
				print "<script type='text/javascript'>
				var msg = '$msg';
				alert(msg);
				</script>";
				redirect(base_url("repicagem/indicador_prod_semanal/$ano/$num_semana_selec"), 'refresh');
				//$this->indicador_prod_semanal($ano, $num_semana_selec);
			}
			else
			{
				//echo $ano.$num_semana_selec;
				$this->indicador_prod_semanal($ano, $num_semana_selec, $dados);
			}
		}
		else
		{
			$this->load->view('erro_acesso');
		}
	
	}//fim da cadastrar_prod_semanal
				
				
	/*
	 * Funções de validação
	 */
	function check_nome_repicador($nome_repicador)
	{		
		if(empty($nome_repicador)){
			$this->form_validation->set_message('check_nome_repicador', 'O Nome do Repicador(a) não foi preenchido');
			return false;
		}
		else{
			//return $this->check_repicador_existe($nome_repicador);
		}
	}
	
	function check_repicador_existe()
	{
		$id_repicador = $this->input->post('id_repicador');// usada no alterar_repicador_view
		$nome_repicador = $this->input->post('repicador');
		
		$retorno = $this->repicagem_model->check_repicador_existe($nome_repicador, $id_repicador);
		if($retorno){
			$this->form_validation->set_message('check_repicador_existe', 'O Nome do Repicador já existe');
			return false;
		}else{
			return true;
		}
	}
	
	function check_campo_vazio($valor, $nome_campo)
	{
		if($valor == ''){
			$this->form_validation->set_message('check_campo_vazio', "O campo: <font color='000'> $nome_campo </font> não foi preenchido");
			return false;
		}else{
			return true; //$this->check_campo_numerico($valor, $nome_campo);
		}
	}
	
	function check_selecao_repicador($valor, $nome_campo)
	{
		if($valor == ''){
			$this->form_validation->set_message('check_selecao_repicador', "O campo: <font color='000'> $nome_campo </font> não foi preenchido");
			return false;
		}else{
			return true;
		}
	}
		
}



