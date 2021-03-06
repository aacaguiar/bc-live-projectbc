﻿<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente extends CI_Controller
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
	
// 	public function cadastrar_cliente()
// 	{
// 		$retorno = $this->check_sessao ();
// 		if ($retorno)
// 		{
// 			$permissao = $this->session->userdata('permissao');
// 			$nome_usuario = $this->session->userdata('nome_usuario');
// 			$lista_menu = $this->menu->gerenciar_menu($permissao);
// 			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
// 			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
	
// 			$data = array(
// 					'nome_usuario' =>$nome_usuario,
// 					'arquivo_css'=>$arquivo_css,
// 					'lista_menu'=>$lista_menu,
// 					'lista_estados'=>$lista_estados,
// 					'tipo_cliente'=>$this->input->post('tipo_cliente'),
// 					'selecao_estado'=> $this->input->post('estado'),
// 					'selecao_cidade' => $this->input->post('cidade'),
// 					//'lista_permissoes'=> $this->cliente_fornecedor_model->listar_permissao()
// 			);
						
// 			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
	
// 			if($this->form_validation->run('cliente/cadastrar_cliente') != FALSE)
// 			{
					
// 				$caracteres = array(".","/","-","(",")");
// 				//$cpf = str_replace($caracteres,"", $this->input->post('cpf'));
// 				//$cnpj = str_replace($caracteres,"", $this->input->post('cnpj'));
// 				$fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));
// 				$fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));
// 				$cep = str_replace($caracteres,"", $this->input->post('cep'));
// 				//$email = $this->input->post('email');
// 				//$endereco = $this->input->post('endereco');
// 				//$bairro = $this->input->post('bairro');
										
// 				(empty($fone)) ? $fone=" " : $fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));		
// 				(empty($fone_celular)) ? $fone_celular=" " : $fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));	
// 				(empty($cep)) ? $cep=" " : $cep = str_replace($caracteres,"", $this->input->post('cep'));	
// 				(empty($this->input->post('email'))) ? $email = " " : $email = $this->input->post('email');
// 				(empty($this->input->post('endereco'))) ? $endereco=" " : $endereco = $this->input->post('endereco');
// 				(empty($this->input->post('bairro'))) ? $bairro=" " : $bairro = $this->input->post('bairro');
		
								
// 				$tipo_cliente = $this->input->post('tipo_cliente');
							
// 				$endereco = array(
// 						'endereco' =>$endereco,
// 						'bairro' =>$bairro,
// 						'estado' =>$this->input->post('estado'),
// 						'cidade' =>$this->input->post('cidade'),
// 						'cep' =>$cep,
// 						'fone_residencial' =>$fone,
// 						'fone_celular' =>$fone_celular,
// 						'email' =>$email,
// 				);
				
// 				$dados = array(
// 						'check_cliente'=>'t',
// 						'check_fornecedor'=>$this->input->post('check_fornecedor'),
// 						/*'cod_fornecedor'=>$this->input->post('cod_fornecedor')*/
// 				);
				
				
// 				//print_r($dados['check_fornecedor']);
// 				//break;
				
// 				if($dados['check_fornecedor']!='t' ){
// 					$dados['check_fornecedor']='f';
// 					$dados['cod_fornecedor'] = " ";
// 				}else{
					
// 				}
				
// 				if($tipo_cliente == 'fisica'){
// 					$dados['nome'] = $this->input->post('nome');
// 					$dados ['cpf'] = str_replace($caracteres,"", $this->input->post('cpf'));
// 				}
					
// 				if($tipo_cliente == 'juridica'){
// 					$dados['razao_social'] = $this->input->post('razao_social');
// 					$dados['cnpj'] = str_replace($caracteres,"", $this->input->post('cnpj'));
// 					//$dados['contato'] = $this->input->post('contato');
// 				}
					
// 				$dados_inseridos = $this->cliente_fornecedor_model->cadastra_cliente($endereco,$dados,$tipo_cliente);
					
// 				if($dados_inseridos)
// 				{
// 					print "<script type=\"text/javascript\">
//    						alert('Cliente cadastrado com sucesso!');
//    						</script>";
	
// 					redirect('../cliente/cadastrar_cliente/', 'refresh');
// 				}
// 				else
// 				{
// 					print "<script type=\"text/javascript\">
//    						alert('Erro ao cadastrar o Cliente');
//    						</script>";
	
// 					redirect('../cliente/cadastrar_cliente/', 'refresh');
// 				}
					
// 			}
// 			else
// 			{					
// 				$data['valor_checkbox'] = $this->input->post('check_fornecedor');
						
// 				$this->load->view ( 'templates/topo_view',$data);
// 				$this->load->view ( 'cliente/cadastro_cliente_view' );
// 				$this->load->view ( 'templates/rodape_view' );
// 			}
	
// 		}
	
// 		else
// 		{
// 			$this->load->view ( 'erro_acesso' );
// 		}
	
// 	}//fim Cadastrar_cliente
	
	
	public function cadastrar_cliente()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
	
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css' => $arquivo_css,
					'lista_menu' => $lista_menu,
					'lista_estados' => $lista_estados,
					'tipo_cliente' => $this->input->post('tipo_cliente'),
					'selecao_estado'=> $this->input->post('estado'),
					'selecao_cidade' => $this->input->post('cidade'),
					'tipo_cadastro' => 'cliente'
					//'lista_permissoes'=> $this->cliente_fornecedor_model->listar_permissao()
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
	
			if($this->form_validation->run('cliente/cadastrar_cliente') != FALSE)
			{
					
				$caracteres = array(".","/","-","(",")");
				$fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));
				$fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));
				$cep = str_replace($caracteres,"", $this->input->post('cep'));
	
				(empty($fone)) ? $fone=" " : $fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));
				(empty($fone_celular)) ? $fone_celular=" " : $fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));
				(empty($cep)) ? $cep=" " : $cep = str_replace($caracteres,"", $this->input->post('cep'));
				
				$email = $this->input->post('email');
				$email = (empty($email)) ?  " " : $email ;
				
				$endereco = $this->input->post('endereco');
				$endereco = (empty($endereco)) ? " " : $endereco ;
				
				$bairro = $this->input->post('bairro');
				$bairro = (empty($bairro)) ? " " : $bairro ;
	
				$tipo_cliente = $this->input->post('tipo_cliente');
					
				$endereco = array(
						'endereco' =>$endereco,
						'bairro' =>$bairro,
						'estado' =>$this->input->post('estado'),
						'cidade' =>$this->input->post('cidade'),
						'cep' =>$cep,
						'fone_residencial' =>$fone,
						'fone_celular' =>$fone_celular,
						'email' =>$email,
				);
	
				$dados = array(
						'check_cliente' => 't',
						'check_fornecedor' => $this->input->post('check_fornecedor'),/* se não for preenchido é zero */
						'cod_fornecedor'   => $this->cliente_fornecedor_model->gerar_cod_fornec(),
						'contato' => null,
						'nome_rsocial' => $this->input->post('nome_rsocial'),
						'cpf_cnpj' => str_replace($caracteres,"", $this->input->post('cpf_cnpj')),
				);
				
				$dados['check_pf'] = ($tipo_cliente == 'fisica') ? 't' : 'f';
	
				if( $dados['check_fornecedor'] == '0' ){
					$dados['check_fornecedor'] = 'f';
					$dados['cod_fornecedor'] = null;
				}
								
				$dados_inseridos = $this->cliente_fornecedor_model->cadastrar_cliente_fornec($endereco, $dados);
					
				$msg = ($dados_inseridos) ? 'Cliente cadastrado com sucesso!' : 'Erro ao cadastrar o Cliente';
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
				redirect('../cliente/cadastrar_cliente/', 'refresh');
				
			}
			else
			{
				$data['valor_checkbox'] = $this->input->post('check_fornecedor');
	
				$this->load->view ( 'templates/topo_view',$data);
				$this->load->view ( 'cliente/cadastro_cliente_view' );
				$this->load->view ( 'templates/rodape_view' );
			}
	
		}
	
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	
	}//fim Cadastrar_cliente
	
	
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
	
	
	function consultar_cliente($tipo_cliente)
	{
		//$opcao string:pfísica, pjuridica
		$retorno = $this->check_sessao();
		
		if ($retorno)
		{
			//paginação
			$limite = 10;
			($this->uri->segment(4) !='') ? $inicio = $this->uri->segment(4) : $inicio = 0 ;
			$lista_cliente = $this->cliente_fornecedor_model->listar_cliente_fornec($limite, $inicio, $tipo_cliente, $check_tipo = 'check_cliente');
			$total_linhas = $this->cliente_fornecedor_model->obter_total_linhas($tipo_cliente, $check_tipo = 'check_cliente');
			$config = $this->paginacao(base_url('cliente/consultar_cliente/'.$tipo_cliente), $limite, $total_linhas);
			
			$this->pagination->initialize($config);
			
			//seta variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cliente/lista_cliente.css');
		
			//$lista_cliente = $this->cliente_fornecedor_model->listar_cliente($limite=0,$inicio=0,$tipo_cliente);
			//$total_linhas = $this->cliente_fornecedor_model->total_linhas_cliente($tipo_cliente);
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
					'nome_usuario'	=> $nome_usuario,
					'arquivo_css'	=> $arquivo_css,
					'lista_menu'	=> $lista_menu,
					'lista_cliente'	=> $lista_cliente,
					'tipo_cliente'	=> $tipo_cliente,
					'total_linhas'	=> $total_linhas,
					'pagination'	=> $this->pagination->create_links(),
					'inicio'		=> $inicio,
					'pag'			=> $pag,
					'total_pag'		=> $total_pag
			);
		
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('cliente/lista_cliente_view');
			$this->load->view ('templates/rodape_view');
		
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
		
	}
	

	function excluir_cliente()
	{
		$retorno = $this->check_sessao();
		
		if ($retorno)
		{
			$tipo_cliente = $this->input->post('tipo_cliente');					
			$id_clifor = $this->input->post('id_clifor');
			
			$dados_excluidos = $this->cliente_fornecedor_model->excluir_cliente_fornec($id_clifor);		
			
			$msg = ($dados_excluidos) ? 'Cliente excluído com sucesso!' : 'Erro ao excluir o Cliente';
			print "<script type=\"text/javascript\"> alert('$msg'); </script>";
			($tipo_cliente == 'fisica') ? redirect('../cliente/consultar_cliente/fisica', 'refresh') : redirect('../cliente/consultar_cliente/juridica', 'refresh');			
		}
		else{
			$this->load->view ('erro_acesso');
		}
	}
	

	function alterar_cliente()
	{
		$retorno = $this->check_sessao();
	
		if ($retorno)
		{
			$permissao	= $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
				
			$data = array(
					'nome_usuario' =>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_estados'=>$lista_estados,
			);

			$tipo_cliente = $this->input->post('tipo_cliente');
			
			$endereco = array(
					'cod_endereco'=>$this->input->post('cod_endereco'),
					'endereco' =>$this->input->post('endereco'),
					'bairro' =>$this->input->post('bairro'),
					'estado' =>$this->input->post('estado'),
					'cidade' =>$this->input->post('cidade'),
					'cep' =>$this->input->post('cep'),
					'fone_residencial' =>$this->input->post('fone_residencial'),
					'fone_celular' =>$this->input->post('fone_celular'),
					'email' =>$this->input->post('email'),
			);
			
			$dados = array(
					'check_fornecedor' => $this->input->post('check_fornecedor'),
					'cod_fornecedor' => $this->input->post('cod_fornecedor'),
					'id_clifor' => $this->input->post('id_clifor'),
					'nome_rsocial' => $this->input->post('nome_rsocial'),
					'cpf_cnpj' => $this->input->post('cpf_cnpj')
			);
	
			$data['dados'] = $dados;
			$data['endereco'] = $endereco;
			$data['tipo_cliente'] = $tipo_cliente;
			$data['valor_checkbox'] = $this->input->post('check_fornecedor');
	
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('cliente/altera_cliente_view');
			$this->load->view ('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//fim alterar_cliente
	
	

/*
	function alterar_cliente()
	{	
		$retorno = $this->check_sessao();
		
		if ($retorno)
		{
			$permissao	= $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
			
			$data = array(
					'nome_usuario' =>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_estados'=>$lista_estados,
				);
			
			$dados = array(
					'clifor_id'=>$this->input->post('id'),
					'clifor_pessoa_fisica'=> $this->input->post('pessoa_fisica'),
					'clifor_cpf' => $this->input->post('cpf'),
					'clifor_pessoa_juridica' => $this->input->post('pessoa_juridica'),
					//'clifor_contato' => $this->input->post('contato'),
					'clifor_cnpj' => $this->input->post('cnpj'),
					'clifor_endereco' =>$this->input->post('endereco'),
					'clifor_bairro' =>$this->input->post('bairro'),
					'clifor_estado' =>$this->input->post('estado'),
					'clifor_cidade' =>$this->input->post('cidade'),
					'clifor_cep' =>$this->input->post('cep'),
					'clifor_fone_residencial' =>$this->input->post('fone_residencial'),
					'clifor_fone_celular' =>$this->input->post('fone_celular'),
					'clifor_email' =>$this->input->post('email'),
					'clifor_cod_fornecedor'=>$this->input->post('cod_fornecedor'),
					'clifor_fornecedor'=>$this->input->post('fornecedor'),
					'clifor_tipo_cliente'=>$this->input->post('tipo_cliente')
				);
						
			$data['dados'] = $dados;
								
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('cliente/altera_dados_cliente_view');
			$this->load->view ('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
		
	}//fim alterar_cliente
*/

	
	public function alterar_dados_cliente()
	{
		$retorno = $this->check_sessao ();
	
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
	
			$data = array(
					'nome_usuario' =>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_estados'=>$lista_estados,
					//'lista_permissoes'=> $this->cliente_fornecedor_model->listar_permissao()
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
	
			$caracteres = array(".","/","-","(",")");
			//$cpf = str_replace($caracteres,"", $this->input->post('cpf'));
			//$cnpj = str_replace($caracteres,"", $this->input->post('cnpj'));
			$fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));
			$fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));
			$cep = str_replace($caracteres,"", $this->input->post('cep'));
			$email = $this->input->post('email');
			$endereco = $this->input->post('endereco');
			$bairro = $this->input->post('bairro');
				
			(empty($fone)) ? $fone=" " : $fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));		
			(empty($fone_celular)) ? $fone_celular=" " : $fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));	
			(empty($cep)) ? $cep=" " : $cep = str_replace($caracteres,"", $this->input->post('cep'));	
			(empty($email)) ? $email = " " : $email = $this->input->post('email');
			(empty($endereco)) ? $endereco=" " : $endereco = $this->input->post('endereco');
			(empty($bairro)) ? $bairro=" " : $bairro = $this->input->post('bairro');
				
			$tipo_cliente = $this->input->post('tipo_cliente');
				
			$endereco = array(
					'cod_endereco'=>$this->input->post('cod_endereco'),
					'endereco' =>$endereco,
					'bairro' =>$bairro,
					'estado' =>$this->input->post('estado'),
					'cidade' =>$this->input->post('cidade'),
					'cep' =>$cep,
					'fone_residencial' =>$fone,
					'fone_celular' =>$fone_celular,
					'email' =>$email,
			);
			
			$dados = array(
					//'check_cliente'=>'t',
					'check_fornecedor' => $this->input->post('check_fornecedor'),
					'cod_fornecedor' => $this->input->post('cod_fornecedor'),
					'nome_rsocial' => $this->input->post('nome_rsocial'),
					'cpf_cnpj' => str_replace($caracteres,"", $this->input->post('cpf_cnpj')),
					'id_clifor' => $this->input->post('id_clifor')
			);
							
			if($dados['check_fornecedor'] == '0'){
				$dados['check_fornecedor']='f';
				//$dados['cod_fornecedor'] = null;
			}
						
			if($this->form_validation->run('cliente/alterar_dados_cliente') != FALSE)
			{
// 				print_r($dados);
// 				echo "<br>";
// 				print_r($endereco);
				//alteração no banco
				$dados_alterados = $this->cliente_fornecedor_model->alterar_dados_cliente_fornec($endereco,$dados,$tipo_cliente);
					
				$msg = ($dados_alterados) ? 'Cliente alterado com sucesso!' : 'Erro ao alterar o Cliente';
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
			   ($tipo_cliente == 'fisica') ? redirect('../cliente/consultar_cliente/fisica', 'refresh') : redirect('../cliente/consultar_cliente/juridica', 'refresh');
					
			}
			else
			{
				$data['dados'] = $dados;
				$data['endereco'] = $endereco;
				$data['tipo_cliente'] = $tipo_cliente;
				
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('cliente/altera_cliente_view');
				//if($tipo_cliente == 'fisica') { $this->load->view ( 'cliente/altera_cliente_fisica_view' ); }
				//if($tipo_cliente == 'juridica') { $this->load->view ( 'cliente/altera_cliente_juridica_view' ); }
				$this->load->view ( 'templates/rodape_view' );
			}
	
		}
	
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	
	
	}//fim da alterar_dados_cliente
	
	
	/*
	public function alterar_dados_cliente()
	{
		$retorno = $this->check_sessao ();
		
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_estados = $this->cliente_fornecedor_model->listar_estados();
			$arquivo_css = base_url('css/cliente/cadastro_cliente.css');
		
			$data = array(
					'nome_usuario' =>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_estados'=>$lista_estados,
					//'lista_permissoes'=> $this->cliente_fornecedor_model->listar_permissao()
			);
		
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
						
			$caracteres = array(".","/","-","(",")");
			$cpf = str_replace($caracteres,"", $this->input->post('cpf'));
			$cnpj = str_replace($caracteres,"", $this->input->post('cnpj'));
			$fone = str_replace($caracteres,"", $this->input->post('fone_residencial'));
			$fone_celular = str_replace($caracteres,"", $this->input->post('fone_celular'));
			$cep = str_replace($caracteres,"", $this->input->post('cep'));
			$email = $this->input->post('email');
			
			if(strlen($fone)<10) { $fone=" ";}
			if(strlen($fone_celular)<10) { $fone_celular=" ";}
			if(strlen($cep)<8)($cep=" ");
			if(strlen($email)=='2') $mail=" ";
			
			$dados = array(
					'clifor_tipo_cliente'=>$this->input->post('tipo_cliente'),
					'clifor_id'=>$this->input->post('id'),
					'clifor_pessoa_fisica'=> $this->input->post('pessoa_fisica'),
					'clifor_cpf' => $cpf,
					'clifor_pessoa_juridica' =>" ",
					'clifor_contato' =>" ",
					'clifor_cnpj' => " ",
					'clifor_endereco' =>$this->input->post('endereco'),
					'clifor_bairro' =>$this->input->post('bairro'),
					'clifor_estado' =>$this->input->post('estado'),
					'clifor_cidade' =>$this->input->post('cidade'),
					'clifor_cep' =>$cep,
					'clifor_fone_residencial' =>$fone,
					'clifor_fone_celular' =>$fone_celular,
					'clifor_email' =>$email,
					'clifor_cliente'=>'t',
					'clifor_fornecedor' => $this->input->post('fornecedor'),
					'clifor_cod_fornecedor' => $this->input->post('cod_fornecedor')		
			);
				
			if($this->form_validation->run('cliente/alterar_dados_cliente') != FALSE)
			{
				
				if($dados['clifor_tipo_cliente'] != 'física')
				{
					$dados['clifor_pessoa_fisica'] =" ";
					$dados['clifor_cpf'] =" ";
					$dados['clifor_pessoa_juridica'] = $this->input->post('pessoa_juridica');
					$dados['clifor_cnpj'] = $cnpj;
				}
				
				if($dados['clifor_fornecedor'] != 't')
				{
					$dados['clifor_fornecedor'] = 'f';
					$dados['clifor_cod_fornecedor'] = " ";
				
				}
				
				//alteração no banco
				$dados_alterados = $this->cliente_fornecedor_model->alterar_dados_cliente($dados);
					
				if($dados_alterados)
				{
					print "<script type=\"text/javascript\">
   						alert('Cliente alterado com sucesso!');
   						</script>";
					($dados['clifor_tipo_cliente'] != 'física') ? redirect('../cliente/consultar_cliente/fisica', 'refresh') : redirect('../cliente/consultar_cliente/juridica', 'refresh');
				}
				else
				{
					print "<script type=\"text/javascript\">
   						alert('Erro ao alterar dados do Cliente');
   						</script>";
					
					if($dados['clifor_tipo_cliente'] != 'física'){
						redirect('../cliente/consultar_cliente/fisica', 'refresh');
					}else{
						redirect('../cliente/consultar_cliente/juridica', 'refresh');
					}
				}
					
			}
			else
			{
				$data['dados'] = $dados;
		
				$this->load->view ( 'templates/topo_view',$data);
				$this->load->view ( 'cliente/altera_dados_cliente_view' );
				$this->load->view ( 'templates/rodape_view' );
			}
				
		}
		
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
		
		
	}//fim da alterar_dados_cliente
	
*/


	/*
	function listar_cidades()
	{
		print "<script type=\"text/javascript\">
   				alert('Carregando municípios');
   			   </script>";
		
		redirect('../cliente/cadastrar_cliente/', 'refresh');	
	}
	*/
	
	
	//Validações
	function validar_tipo_cliente($tipo_cliente)
	{
		if($tipo_cliente =='0')
		{
			$this->form_validation->set_message('validar_tipo_cliente', 'O campo Cliente não foi preenchido.');
			return false;
		}
		else
		{
			return true;
		}
	}

	
	function validar_estado($estado)
	{
		if($estado =='0')
		{
			$this->form_validation->set_message('validar_estado', 'O campo Estado não foi preenchido.');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function validar_cidade($cidade)
	{
		if($cidade =='0')
		{
			$this->form_validation->set_message('validar_cidade', 'O campo Cidade não foi preenchido.');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function check_nome_cliente()
	{
		$nome_cliente = $this->input->post('nome_rsocial');
		$tipo_cliente = $this->input->post('tipo_cliente');
		//$msg = ($tipo_cliente == 'fisica') ? 'Nome' : 'Razão Social';
		
		if($nome_cliente=='')
		{
			$this->form_validation->set_message('check_nome_cliente', "O campo Nome / Razão social não foi preenchido");
			return false;
		}
		else
		{
			return true;
		}
	}
	
// 	function check_razao_social()
// 	{
// 		$razao_social = $this->input->post('razao_social');
// 		$tipo_cliente = $this->input->post('tipo_cliente');
	
// 		if($tipo_cliente == 'juridica' && $razao_social=='')
// 		{
// 			$this->form_validation->set_message('check_razao_social', 'O campo Razão social não foi preenchido');
// 			return false;
// 		}
// 		else
// 		{
// 			return true;
// 		}
// 	}
	
// 	function check_contato()
// 	{
// 		$contato = $this->input->post('contato');
// 		$tipo_cliente = $this->input->post('tipo_cliente');
	
// 		if($tipo_cliente == '2' && $contato=='')
// 		{
// 			$this->form_validation->set_message('check_contato', 'O campo Contato não foi preenchido');
// 			return false;
// 		}
// 		else
// 		{
// 			return true;
// 		}
// 	}
	
	function valida_cpf_cnpj($cpf_cnpj)
	{
		$tipo_cliente = $this->input->post('tipo_cliente');
		
		if($tipo_cliente == 'fisica'){
			$cpf = $cpf_cnpj;
			
			if(empty($cpf)) {
					$this->form_validation->set_message('valida_cpf_cnpj', 'O campo Cpf / Cnpj está vazio');
					return false;
				}
				
				// Elimina possivel mascara
				$caracteres = array(".","-");
				$cpf = str_replace($caracteres,"", $cpf);
					
				// Verifica se o numero de digitos informados é igual a 11
				if (strlen($cpf) != 11)
				{
					$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf / Cnpj inválido');
					return false;
				}
				// Verifica se nenhuma das sequências invalidas abaixo
				// foi digitada. Caso afirmativo, retorna falso
				else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' ||
						 $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' ||
						 $cpf == '88888888888' || $cpf == '99999999999')
				{
					$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf / Cnpj inválido');
					return false;
				}
				else
				{
					for ($t = 9; $t < 11; $t++) {
				
						for ($d = 0, $c = 0; $c < $t; $c++) {
							$d += $cpf{$c} * (($t + 1) - $c);
						}
						$d = ((10 * $d) % 11) % 10;
						if ($cpf{$c} != $d) {
							$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf / Cnpj inválido');
							return false;
						}
					}
				
					return true;
				}
				
		}else{
			$cnpj = $cpf_cnpj;
			if($cnpj == ''){
				$this->form_validation->set_message('valida_cpf_cnpj', 'Campo Cpf / Cnpj vazio');
				return false;
			}
				
			$caracteres = array(".","/","-");
			$cnpj = str_replace($caracteres,"", $cnpj);
				
			//Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
			$j = 0;
			for($i = 0; $i < (strlen ( $cnpj )); $i ++) {
				if (is_numeric ( $cnpj [$i] )) {
					$num [$j] = $cnpj [$i];
					$j ++;
				}
			}
			// Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
			if (count ( $num ) != 14) {
				$isCnpjValid = false;
			}
			// Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
			if ($num [0] == 0 && $num [1] == 0 && $num [2] == 0 && $num [3] == 0 && $num [4] == 0 && $num [5] == 0 && $num [6] == 0 && $num [7] == 0 && $num [8] == 0 && $num [9] == 0 && $num [10] == 0 && $num [11] == 0) {
				$isCnpjValid = false;
			} 		// Etapa 4: Calcula e compara o primeiro dígito verificador.
			else {
				$j = 5;
				for($i = 0; $i < 4; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$j = 9;
				for($i = 4; $i < 12; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$resto = $soma % 11;
				if ($resto < 2) {
					$dg = 0;
				} else {
					$dg = 11 - $resto;
				}
				if ($dg != $num [12]) {
					$isCnpjValid = false;
				}
			}
			// Etapa 5: Calcula e compara o segundo dígito verificador.
			if (! isset ( $isCnpjValid )) {
				$j = 6;
				for($i = 0; $i < 5; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$j = 9;
				for($i = 5; $i < 13; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$resto = $soma % 11;
				if ($resto < 2) {
					$dg = 0;
				} else {
					$dg = 11 - $resto;
				}
				if ($dg != $num [13]) {
					$isCnpjValid = false;
				} else {
					$isCnpjValid = true;
				}
			}
			//Trecho usado para depurar erros.
			if($isCnpjValid == false){
				$this->form_validation->set_message('valida_cpf_cnpj', 'Número de Cpf / Cnpj inválido');
				return false;
			}else{
				return true;
			}
			//Etapa 6: Retorna o Resultado em um valor booleano.
			//return $isCnpjValid;
			
		}
	}
	
	
/*	
	function valida_cpf($cpf)
	{
			//$tipo_cliente = $this->input->post('tipo_cliente');	
			//if($tipo_cliente =='fisica')
			//{
				// Verifica se um número foi informado
				if(empty($cpf)) {
					$this->form_validation->set_message('valida_cpf_cnpj', 'O campo Cpf está vazio');
					return false;
				}
				
				// Elimina possivel mascara
				$caracteres = array(".","-");
				$cpf = str_replace($caracteres,"", $cpf);
					
				// Verifica se o numero de digitos informados é igual a 11
				if (strlen($cpf) != 11)
				{
					$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf inválido');
					return false;
				}
				// Verifica se nenhuma das sequências invalidas abaixo
				// foi digitada. Caso afirmativo, retorna falso
				else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' ||
						 $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' ||
						 $cpf == '88888888888' || $cpf == '99999999999')
				{
					$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf inválido');
					return false;
				}
				else
				{
					for ($t = 9; $t < 11; $t++) {
				
						for ($d = 0, $c = 0; $c < $t; $c++) {
							$d += $cpf{$c} * (($t + 1) - $c);
						}
						$d = ((10 * $d) % 11) % 10;
						if ($cpf{$c} != $d) {
							$this->form_validation->set_message('valida_cpf_cnpj', 'Cpf inválido');
							return false;
						}
					}
				
					return true;
				}
			//}	
	}
	
	function valida_cnpj($cnpj)
	{
		$tipo_cliente = $this->input->post('tipo_cliente');
		
		if($tipo_cliente == 'juridica')
		{
			if($cnpj == ''){
				$this->form_validation->set_message('valida_cnpj', 'Campo CNPJ vazio');
				return false;
			}
			
			$caracteres = array(".","/","-");
			$cpf = str_replace($caracteres,"", $cnpj);
			
			//Etapa 1: Cria um array com apenas os digitos numéricos, isso permite receber o cnpj em diferentes formatos como "00.000.000/0000-00", "00000000000000", "00 000 000 0000 00" etc...
			$j = 0;
			for($i = 0; $i < (strlen ( $cnpj )); $i ++) {
				if (is_numeric ( $cnpj [$i] )) {
					$num [$j] = $cnpj [$i];
					$j ++;
				}
			}
			// Etapa 2: Conta os dígitos, um Cnpj válido possui 14 dígitos numéricos.
			if (count ( $num ) != 14) {
				$isCnpjValid = false;
			}
			// Etapa 3: O número 00000000000 embora não seja um cnpj real resultaria um cnpj válido após o calculo dos dígitos verificares e por isso precisa ser filtradas nesta etapa.
			if ($num [0] == 0 && $num [1] == 0 && $num [2] == 0 && $num [3] == 0 && $num [4] == 0 && $num [5] == 0 && $num [6] == 0 && $num [7] == 0 && $num [8] == 0 && $num [9] == 0 && $num [10] == 0 && $num [11] == 0) {
				$isCnpjValid = false;
			} 		// Etapa 4: Calcula e compara o primeiro dígito verificador.
			else {
				$j = 5;
				for($i = 0; $i < 4; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$j = 9;
				for($i = 4; $i < 12; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$resto = $soma % 11;
				if ($resto < 2) {
					$dg = 0;
				} else {
					$dg = 11 - $resto;
				}
				if ($dg != $num [12]) {
					$isCnpjValid = false;
				}
			}
			// Etapa 5: Calcula e compara o segundo dígito verificador.
			if (! isset ( $isCnpjValid )) {
				$j = 6;
				for($i = 0; $i < 5; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$j = 9;
				for($i = 5; $i < 13; $i ++) {
					$multiplica [$i] = $num [$i] * $j;
					$j --;
				}
				$soma = array_sum ( $multiplica );
				$resto = $soma % 11;
				if ($resto < 2) {
					$dg = 0;
				} else {
					$dg = 11 - $resto;
				}
				if ($dg != $num [13]) {
					$isCnpjValid = false;
				} else {
					$isCnpjValid = true;
				}
			}
			//Trecho usado para depurar erros.
			if($isCnpjValid == false){
				$this->form_validation->set_message('valida_cnpj', 'Número de CNPJ inválido');
				return false;
			}else{
				return true;
			}		
			//Etapa 6: Retorna o Resultado em um valor booleano.
			//return $isCnpjValid;
		}
	}
*/	

	
	function carregar_cidades()
	{
		$estado = $this->input->post('estado');
		if($estado !='0' && $estado != ''){
			$lista_cidades = $this->cliente_fornecedor_model->carregar_cidades($estado);
			$nome_cidade = $this->input->post('cidade');
		
			echo "<option value='0'>Escolha uma opção</option>";
			foreach ($lista_cidades as $cidade){
				if($cidade == $nome_cidade){
					echo "<option value='$cidade' selected>".$cidade."</option>";
				}else{
				echo "<option value='$cidade'>".$cidade."</option>";
				}
			}
		}
	}

	
}//fim da class





