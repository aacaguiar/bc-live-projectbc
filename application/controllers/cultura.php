<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cultura extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('cultura_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->library('pagination');
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
	
	function cadastrar_cultura()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
	
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css'=> $arquivo_css,
					'lista_menu'=> $lista_menu,
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		
			if($this->form_validation->run('cultura/cadastrar_cultura') != FALSE)
			{
				$dados = array(
						//'cli_id'=>'DEFAULT',
						'nome_cultura' => $this->input->post('nome_cult'),
				);				
												
				$dados_inseridos = $this->cultura_model->cadastrar_cultura($dados);	
				$msg = ($dados_inseridos) ? "Cultura cadastrada com sucesso" : "Erro ao cadastrar Cultura";
				print "<script type='text/javascript'>
							var msg = '$msg';
							alert(msg);
					   </script>";
				redirect('../cultura/cadastrar_cultura', 'refresh');	
			}
			else
			{
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('cultura/cadastro_cultura_view');
				$this->load->view ('templates/rodape_view');
			}
		}
	
		else{
			$this->load->view ('erro_acesso');
		}
	
	}//fim do cadastrar
	
	
	function consultar_cultura()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//paginação
				
			$limite = 10;
			($this->uri->segment(3) !='') ? $inicio = $this->uri->segment(3) : $inicio = 0 ;
			$lista_cultura = $this->cultura_model->listar_cultura2();
			$total_linhas = $this->db->count_all('cultura');
			$config = $this->paginacao(base_url('cultura/consultar_cultura'), $limite, $total_linhas);
			$this->pagination->initialize($config);
	
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/lista_cultura.css');
				
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
					'lista_cultura'=>$lista_cultura,
					'pagination'=>$this->pagination->create_links(),
					'inicio'=>$inicio,
					'pag'=>$pag,
					'total_pag'=>$total_pag,
					'total_linhas' => $total_linhas
			);
	
			$this->load->view('templates/topo_view',$data);
			$this->load->view('cultura/consulta_cultura_view');
			$this->load->view('templates/rodape_view');
		}
		else{
			$this->load->view ('erro_acesso');
		}
			
	}//fim do consultar cutlura
	
	
	function alterar_cultura()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
	
			$nome_cultura = $this->input->post('nome_cultura');
			$cod_cultura = $this->input->post('cod_cultura');
			
	
			$data = array(
					'nome_usuario'=>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'nome_cultura'=>$nome_cultura,
					'cod_cultura'=>$cod_cultura,
			);
	
			$this->load->view('templates/topo_view',$data);
			$this->load->view('cultura/alterar_cultura_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//alterar cultura
	
	
	function alterar_dados_cultura()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
	
			$dados['nome_cultura'] =  $this->input->post('nome_cultura');
			$dados['cod_cultura'] =  $this->input->post('cod_cultura');
			
			$data = array(
					'nome_usuario' => $nome_usuario, 
					'arquivo_css'=> $arquivo_css, 
					'lista_menu'=> $lista_menu,
					'nome_cultura' => $dados['nome_cultura'],
					'cod_cultura' => $dados['cod_cultura']
				);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('cultura/alterar_dados_cultura') != FALSE)
			{			
				$dados_inseridos = $this->cultura_model->alterar_dados_cultura($dados);	
				$msg = ($dados_inseridos) ? "Cultura alterada com sucesso" : "Erro ao alterar a Cultura";
				print "<script type='text/javascript'>
							var msg = '$msg';
							alert(msg);
					   </script>";
				redirect('../cultura/consultar_cultura', 'refresh');
	
			}
			else
			{
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('cultura/alterar_cultura_view');
				$this->load->view ('templates/rodape_view');
			}
		}
	
		else{
			$this->load->view ('erro_acesso');
		}
	
	}//fim alterar_dados_cultura
	
	
	function excluir_cultura()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$cod_cultura = $this->input->post('cod_cultura');
			$dados_excluidos = $this->cultura_model->excluir_cultura($cod_cultura);
			$msg = ($dados_excluidos) ? "Cultura excluída com sucesso" : "Erro ao excluir a cultura";
			print "<script type='text/javascript'>
					var msg = '$msg';
					alert(msg);
				  </script>";
			redirect('../cultura/consultar_cultura', 'refresh');
		}
			else{
					$this->load->view ('erro_acesso');
					}
	
	}//fim ecluir_cultura
	
	
	
	function cadastrar_variedade()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
			$lista_cultura = $this->cultura_model->listar_cultura();
			$qtde_var_adicionar = array(1=>1, 2=>2, 3=>3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8, 9=>9, 10=>10);
			//array_unshift($qtde_var_adicionar,0);
	
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css'=> $arquivo_css,
					'lista_menu'=> $lista_menu,
					'lista_cultura' => $lista_cultura,
					'qtde_var_adicionar'=>$qtde_var_adicionar
			);
				
			//$errors = $this->form_validation->error_array();
			//if($qtde_var!='0'){
				//$nome_var = $this->input->post('nome_var');
				//for ($i=1;$i<=sizeof($qtde_var);$i++){
					//$this->form_validation->set_rules('nome_var[1]','','callback_check_nome_variedade');
				//}
			//}
			
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('cultura/cadastrar_variedade') != FALSE)
			{			
				$cod_cultura = $this->input->post('cultura');
				$qtde_var = $this->input->post('qtde_var');
				
				if($qtde_var!='0'){
					$nome_var = $this->input->post('nome_var');
					$sigla_var = $this->input->post('nome_sigla');
					$dados=array();
					for ($i=1;$i<=$qtde_var;$i++){
						//$nome_var[$i]=strtoupper($nome_var[$i]);
						$sigla_var[$i]=strtoupper($sigla_var[$i]);		
						$dados[$i]=array(
							'nome_variedade'=>$nome_var[$i],
							'sigla_variedade'=>$sigla_var[$i],
							'cod_cultura'=>$cod_cultura,
							/*'nome_cultura'=>' '*/
						);
					}	
				}
								
				$dados_inseridos = $this->cultura_model->cadastrar_variedade($dados, $qtde_var);
				$msg = ($dados_inseridos) ? "Variedade Cadastra com sucesso" : "Erro ao excluir a Variedade";
				print "<script type='text/javascript'>
						var msg = '$msg';
						alert(msg);
				  	   </script>";
				redirect('../cultura/cadastrar_variedade', 'refresh');
			}
			else
			{
				$data['cultura_selec'] = $this->input->post('cultura');
				$data['qtde_var_selec']= $this->input->post('qtde_var_selec');
				$data['nome_var']=$this->input->post('nome_var');
				$data['nome_sigla']=$this->input->post('nome_sigla');	
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('cultura/cadastro_variedade_view');
				$this->load->view ('templates/rodape_view');
			}
		}
		else{
			$this->load->view ('erro_acesso');
		}
	
	}//fim do cadastrar_variedade
		
	
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
	
	
	function consultar_variedade($cod_cultura=0)
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/lista_cultura.css');
			$lista_cultura = $this->cultura_model->listar_cultura();
			
			$data = array(
					'nome_usuario'=>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_cultura'=>$lista_cultura,
					'lista_variedade'=>'',
					'cultura_selec'=>'',
					'pag'=>''
			);
			
			$cod_cultura = ($cod_cultura!='' && $cod_cultura!=0) ? $cod_cultura : $this->input->get_post('cultura');	
			if($cod_cultura!=0 && $cod_cultura!='')
			{
					//paginação
					$limite = 10;
					$inicio = ($this->uri->segment(4)!='') ? $this->uri->segment(4) : 0 ;
					$lista_variedade = $this->cultura_model->carregar_variedade($cod_cultura,$limite,$inicio);
					$total_linhas = $this->cultura_model->total_linhas_carregar_var($cod_cultura);
					$config = $this->paginacao(base_url('cultura/consultar_variedade/'.$cod_cultura), $limite, $total_linhas);	
					$this->pagination->initialize($config);
					
					$inicio++;
					if($inicio<10){
						$pag=1;
					}else{
						$pag=(int)($inicio/10);
						$pag++;
					}
					
					$total_pag = ($total_linhas<10) ? 1 : ($total_linhas/10);
					$total_pag = (is_float($total_pag)) ? (int)++$total_pag : $total_pag;
					
		
					$data['pagination'] = $this->pagination->create_links();
					$data['inicio'] = $inicio;
					$data['pag'] = $pag;
					$data['total_pag'] = $total_pag;
					$data['total_linhas'] = $total_linhas;
					$data['lista_variedade']=$lista_variedade;
					$data['cultura_selec'] = $cod_cultura;				
			}
						
			$this->load->view('templates/topo_view',$data);
			$this->load->view('cultura/consulta_variedade_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
		
	}//fim do consultar_variedade
	
	
	function alterar_variedade()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
			
			$nome_cultura = $this->input->post('nome_cultura');
			$cod_variedade = $this->input->post('cod_variedade');
			$nome_variedade = $this->input->post('nome_variedade');
			$sigla_variedade = $this->input->post('sigla_variedade');
				
			$data = array(
					'nome_usuario'=>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'nome_cultura'=>$nome_cultura,
					'cod_variedade'=>$cod_variedade,
					'nome_variedade'=>$nome_variedade,
					'sigla_variedade'=>$sigla_variedade
			);
									
			$this->load->view('templates/topo_view',$data);
			$this->load->view('cultura/alterar_variedade_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
		
	}//fim alterar_variedade
	
	
	function alterar_dados_variedade()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
	
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css'=> $arquivo_css,
					'lista_menu'=> $lista_menu,
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('cultura/alterar_dados_variedade') != FALSE)
			{
				$dados = array(
						'cod_variedade' => $this->input->post('cod_variedade'),
						'nome_variedade' => $this->input->post('nome_variedade'),
						'sigla_variedade' => $this->input->post('sigla_variedade'),
				);				
								
				$dados_inseridos = $this->cultura_model->alterar_dados_variedade($dados);
					
				$msg = ($dados_inseridos) ? "Variedade alterada com sucesso" : "Erro ao alterar a variedade";
				print "<script type='text/javascript'>
						var msg = '$msg';
   						alert(msg);
   						</script>";		
				redirect('../cultura/consultar_variedade', 'refresh');
				
			}
			else
			{
				$data['nome_cultura'] = $this->input->post('nome_cultura');
				$data['cod_variedade'] = $this->input->post('cod_variedade');
				$data['nome_variedade'] = $this->input->post('nome_variedade');
				$data['sigla_variedade'] = $this->input->post('sigla_variedade');
				
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('cultura/alterar_variedade_view');
				$this->load->view ('templates/rodape_view');
			}
		}
	
		else{
			$this->load->view ('erro_acesso');
		}
		
	}//fim alterar_dados_variedade
	
	
	function excluir_variedade()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$cod_variedade = $this->input->post('cod_variedade');
			$dados_excluidos = $this->cultura_model->excluir_variedade($cod_variedade);		
			$msg = ($dados_excluidos) ? "Variedade excluída com sucesso" : "Erro ao excluir a variedade";
			print "<script type='text/javascript'>
					var msg = '$msg';
   					alert(msg);
   					</script>";		
			redirect('../cultura/consultar_variedade', 'refresh');
		}
		else{
			$this->load->view ('erro_acesso');
		}
		
	}//fim ecluir_variedade
	
	
	//método ajax - 2º opcao de listagem
	function carregar_variedade($var=0)
	{
		//$var = $this->input->post('cultura');
		//$cod_cultura = ($var!=0 && $var!='') ? $var : $cod_cultura;
		$cod_cultura = $this->input->post('cultura');
		if($cod_cultura!=0 && $cod_cultura!='')
		{
			//$lista_variedade = $this->cultura_model->carregar_variedade($cod_cultura);
			$limite = 10;
			$inicio = ($this->uri->segment(3) !='') ? $this->uri->segment(3) : 0 ;
			$lista_variedade = $this->cultura_model->carregar_variedade($cod_cultura,$limite,$inicio);
			$total_linhas = $this->cultura_model->total_linhas_carregar_var($cod_cultura);
			$config = $this->paginacao(base_url('cultura/carregar_variedade/'.$cod_cultura), $limite, $total_linhas);	
			$this->pagination->initialize($config);
			
			$inicio++;
			if($inicio<10){
				$pag=1;
			}else{
				$pag=(int)($inicio/10);
				$pag++;
			}
			
			$data2=array(
				'lista_variedade' => $lista_variedade,
				'lista_cultura' => $this->cultura_model->listar_cultura(),
				'cultura_selec' => $cod_cultura,
				'pagination' => $this->pagination->create_links(),
				'inicio' => $inicio,
				'pag' => $pag,
				'total_linhas'=>$total_linhas	
			);
			$this->load->view('cultura/consulta2_variedade_view',$data2);	
		}
		
		if($var!=0 && $var!='')
		{
			$cod_cultura = $var;
			$limite = 10;
			$inicio = ($this->uri->segment(4) !='') ? $this->uri->segment(4) : 0 ;
			$lista_variedade = $this->cultura_model->carregar_variedade($cod_cultura,$limite,$inicio);
			$total_linhas = $this->cultura_model->total_linhas_carregar_var($cod_cultura);
			$config = $this->paginacao(base_url('cultura/carregar_variedade/'.$cod_cultura), $limite, $total_linhas);
			$this->pagination->initialize($config);
			
			$inicio++;
			if($inicio<10){
				$pag=1;
			}else{
				$pag=(int)($inicio/10);
				$pag++;
			}
			
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cultura/cultura.css');
			$lista_cultura = $this->cultura_model->listar_cultura();
				
			$data2 = array(
					'nome_usuario'=>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_cultura'=>$lista_cultura,
					'cultura_selec' => $cod_cultura,
					'pagination' => $this->pagination->create_links(),
					'inicio' => $inicio,
					'pag' => $pag,
					'total_linhas'=>$total_linhas
			);
			
			$this->load->view('cultura/consulta2_variedade_view',$data2);	
		}
	}
	
	
	function check_nome_cultura($nome_cult)
	{	
		if($nome_cult==''){
			$this->form_validation->set_message('check_nome_cultura', 'O Nome da Cultura não foi preenchido');
			return false;
		}else if($nome_cult == '0'){
			$this->form_validation->set_message('check_nome_cultura', 'O Nome da Cultura não foi escolhido');
			return false;
		}
		else{
			return $this->check_cultura_existe($nome_cult);
		}
	}
	
	function check_cultura_existe($nome_cult)
	{
		$retorno = $this->cultura_model->check_cultura_existe($nome_cult);
		if($retorno){
			$this->form_validation->set_message('check_nome_cultura', 'O Nome da Cultura já existe');
			return false;
		}else{
			return true;
		}
	}
	
	//cadastro de variedades
	function check_nome_variedade($nome_var,$i)
	{
		$qtde_var = $this->input->post('qtde_var');
		if($qtde_var>=$i)
		{
			if($nome_var==''){
				$this->form_validation->set_message('check_nome_variedade', "O Nome da Variedade não foi preenchido");
				return false;
			}else{
				//return $this->check_variedade_existe($nome_var);
				$retorno = $this->cultura_model->check_variedade_existe($nome_var);
				if($retorno){
					$this->form_validation->set_message('check_nome_variedade', "O Nome da Variedade já existe");
					return false;
				}else{
					return true;
				}
			}
		}else{
			return true;
		}		
	}
	
		
/*	
	function check_variedade_existe($nome_var)
	{
			$retorno = $this->cultura_model->check_variedade_existe($nome_var);
			if($retorno){
				$this->form_validation->set_message('check_nome_variedade', "O Nome da Variedade já existe");
				return false;
			}else{
				return true;
			}	
	}
*/	
	//cadastro de Sigla
	function check_sigla_variedade($nome_sigla,$i)
	{	
		$qtde_var = $this->input->post('qtde_var');
		if($qtde_var>=$i)
		{
			if($nome_sigla==''){
				$this->form_validation->set_message('check_sigla_variedade', 'Sigla vazia');
				return false;
			}else{
				//return $this->check_sigla_existe($nome_sigla);
				$retorno = $this->cultura_model->check_sigla_existe($nome_sigla);
				if($retorno){
					$this->form_validation->set_message('check_sigla_variedade', "A Sigla já existe para uma Variedade");
					return false;
				}else{
					return true;
				}
			}
		}else{
			return true;
		}
	}
	

/*
	 function check_sigla_existe($nome_sigla)
	 {
		$retorno = $this->cultura_model->check_sigla_existe($nome_sigla);
		if($retorno){
			$this->form_validation->set_message('check_sigla_variedade', "A Sigla já existe para uma Variedade");
			return false;
		}else{
			return true;
		}
	}
*/
	//alteração de variedade
	function check_nome_var($nome_var)
	{
		$cod = $this->input->post('cod_variedade');
		if($nome_var==''){
			$this->form_validation->set_message('check_nome_var', "O Nome da Variedade não foi preenchido");
			return false;
		}else{
			$retorno = $this->cultura_model->check_nome_var($nome_var,$cod);
			if($retorno){
				$this->form_validation->set_message('check_nome_var', "O Nome da Variedade já existe");
				return false;
			}else{
				return true;
			}
		}
	}
	
	//alteração da Sigla
	function check_sigla_var($nome_sigla)
	{
		$cod = $this->input->post('cod_variedade');
		if($nome_sigla==''){
			$this->form_validation->set_message('check_sigla_var', 'Sigla vazia');
			return false;
		}else{
			$retorno = $this->cultura_model->check_sigla_var($nome_sigla,$cod);
			if($retorno){
				$this->form_validation->set_message('check_sigla_var', "A Sigla já existe para uma Variedade");
				return false;
			}else{
				return true;
			}
		}
	}
	
	function check_qtde_var()
	{
		$qtde_var = $this->input->post('qtde_var');
		if($qtde_var=='0'){
			$this->form_validation->set_message('check_qtde_var', 'Escolha o nº de variedades a cadastrar');
			return false;
		}else{
			return true;
		}
	}
	
	
}//fim da class



