<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->model('usuario_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
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
	
	public function index()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) )
		{
			$data = array('nome_usuario' =>$nome_usuario, 'arquivo_css'=>'');	
			$this->load->view ( 'templates/topo_view',$data);
			$this->load->view ( 'templates/corpo_view' );
			$this->load->view ( 'templates/rodape_view' );
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	}
	
	public function cadastrar_usuario()
	{
		
		$retorno = $this->check_sessao ();	
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			
			$arquivo_css = base_url('css/usuario/cadastro_usuario.css');
			
			$data = array(
					'nome_usuario' =>$nome_usuario,
					'arquivo_css'=>$arquivo_css,
					'lista_menu'=>$lista_menu,
					'lista_permissoes'=> $this->usuario_model->listar_permissao()
					);
			
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run('usuario/cadastrar_usuario') != FALSE)
			{
				$nome = $this->input->post('nome');
				$login = $this->input->post('login');
				$senha = $this->encrypt->sha1($this->input->post('senha'));
				$email = $this->input->post('email');
				$ativo = $this->input->post('ativo');
				$permissao = $this->input->post('permissao');
					
				$dados = array(
						//'us_cod_usuario'=>'DEFAULT',
						'us_nome' =>$nome,
						'us_usuario' =>$login,
						'us_senha' =>$senha,
						'us_email' =>$email,
						'us_ativo' =>$ativo,
						'pe_cod_permissao'=>$permissao);
					
				$dados_inseridos = $this->usuario_model->cadastra_usuario($dados);
		 		
				if($dados_inseridos)
				{
					print "<script type=\"text/javascript\">
   						alert('Usuário cadastrado com sucesso!');
   						</script>";
						
					redirect('../usuario/cadastrar_usuario/', 'refresh');
				}
				else
				{
					print "<script type=\"text/javascript\">
   						alert('Erro ao cadastrar o usuário');
   						</script>";
			
					redirect('../usuario/cadastrar_usuario/', 'refresh');
				}
			
			}
			else
			{
				$data['permissao'] = $this->input->post('permissao');
							
				$this->load->view ( 'templates/topo_view',$data);
				$this->load->view ( 'usuario/cadastro_usuario_view' );
				$this->load->view ( 'templates/rodape_view' );
			}
		}
		
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
		
	}//fim function
	
	
	function excluir_usuario()
	{
		$retorno = $this->check_sessao();
		
		if ($retorno)
		{
			$cod_usuario = $this->input->post('cod_usuario');
							
			$dados_excluidos = $this->usuario_model->excluir_usuario($cod_usuario);
				
			if($dados_excluidos){
				print "<script type=\"text/javascript\">
   						alert('Usuário excluído com sucesso!');
   						</script>";
				redirect('../usuario/pesquisar_usuario', 'refresh');
			}else{
				print "<script type=\"text/javascript\">
   						alert('Erro ao excluir o Usuário');
   						</script>";
				redirect('../usuario/pesquisar_usuario', 'refresh');
			}
			
			
				
		}
		else{
			$this->load->view ('erro_acesso');
		}
	}
	
	
	public function pesquisar_usuario()
	{
		$retorno = $this->check_sessao();
		
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/usuario/pesquisa_usuario.css');
		
			$lista_usuarios = $this->usuario_model->pesquisar_usuario();
			
			
			$data = array(
					'nome_usuario' 	=>$nome_usuario,
					'arquivo_css'	=>$arquivo_css,
					'lista_menu'	=>$lista_menu,
					'lista_usuarios'=>$lista_usuarios
			);
				
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('usuario/pesquisa_usuario_view');
			$this->load->view ('templates/rodape_view');
		
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	}
	
	
	public function alterar_usuario()
	{
		
		$retorno = $this->check_sessao();
		
		if ($retorno) 
		{	
			$permissao	= $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/usuario/altera_dados_usuario.css');
			
			$data = array('nome_usuario' =>$nome_usuario,'arquivo_css'=>$arquivo_css,'lista_menu'=>$lista_menu);
				
			$dados = array(
					'us_cod_usuario'=> $this->input->post('cod_usuario'),
					'us_nome' 		=> $this->input->post('nome'),
					'us_usuario' 	=> $this->input->post('login'),
					'us_senha' 		=> $this->input->post('senha'),
					'us_email' 		=> $this->input->post('email'),
					'us_ativo' 		=> $this->input->post('ativo'),
					'pe_cod_permissao'	=> $this->input->post('permissao')
				);
				
			$data['dados'] = $dados;
			$data['lista_permissoes'] = $this->usuario_model->listar_permissao();
			
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('usuario/altera_dados_usuario_view');
			$this->load->view ('templates/rodape_view');
		} 
		else 
		{
			$this->load->view ('erro_acesso');
		}
		
	}
	
	public function alterar_dados_usuario()
	{
		$retorno = $this->check_sessao ();
		
		if ($retorno)
		{		
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/usuario/altera_dados_usuario.css');
				
			$data = array('nome_usuario' =>$nome_usuario,'arquivo_css'=>$arquivo_css,'lista_menu'=>$lista_menu);
						
			if($this->form_validation->run('usuario/alterar_dados_usuario') != FALSE)
			{
				
				$dados = array(
						'us_cod_usuario'=> $this->input->post('cod_usuario'),
						'us_nome' 		=> $this->input->post('nome'),
						'us_usuario' 	=> $this->input->post('login'),
						//'us_senha' 		=> $this->encrypt->sha1($this->input->post('senha')),
						'us_senha' 		=> trim($this->input->post('senha')),
						'us_email' 		=> $this->input->post('email'),
						'us_ativo' 		=> $this->input->post('ativo'),
						'pe_cod_permissao'	=> $this->input->post('permissao')
				);
				
				if($dados['us_senha']=="******"){
					$dados['us_senha']=$this->input->post('senha_atual');
				}else{
					$dados['us_senha'] = $this->encrypt->sha1(trim($this->input->post('senha')));
				}
				
				$data['dados'] = $dados;
				$dados_alterados = $this->usuario_model->alterar_dados_usuario($dados);
				
				if($dados_alterados)
				{
					print "<script type=\"text/javascript\">
   						alert('Dados alterados com sucesso!');
   						</script>";
					
					redirect('../usuario/pesquisar_usuario/', 'refresh');
				}
				else
				{
						print "<script type=\"text/javascript\">
   						alert('Erro ao alterar dados do usuário');
   						</script>";
							
						redirect('../usuario/pesquisar_usuario/', 'refresh');
				}
										
			}
			else
			{
				$dados = array(
						'us_cod_usuario'=> $this->input->post('cod_usuario'),
						'us_nome' 		=> $this->input->post('nome'),
						'us_usuario' 	=> $this->input->post('login'),
						'us_senha' 		=> $this->input->post('senha'),
						'us_email' 		=> $this->input->post('email'),
						'us_ativo' 		=> $this->input->post('ativo'),
						'pe_cod_permissao'	=> $this->input->post('permissao')
				);
					
				$data['dados'] = $dados;
				$data['lista_permissoes'] = $this->usuario_model->listar_permissao();
				
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('usuario/altera_dados_usuario_view');
				$this->load->view ('templates/rodape_view' );
			}
		
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	}
	
	
	function alterar_senha_usuario()
	{
		$retorno = $this->check_sessao ();
		
		if ($retorno)
		{
			//$senha_atual  =	$this->session->userdata('senha');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$permissao	  =	$this->session->userdata('permissao');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/usuario/altera_senha.css');
			
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css' => $arquivo_css,
					'lista_menu' => $lista_menu,
					//'senha_atual' => $senha_atual
					);
			
			if($this->form_validation->run('usuario/alterar_senha_usuario') != FALSE)
			{
				$cod_usuario = $this->session->userdata('cod_usuario');
				//$senha_atual = $this->input->post('senha_atual');
				$nova_senha = sha1($this->input->post('nova_senha'));
				$confirma_senha = $this->input->post('confirma_senha');
						
				$dados = array(
						'us_senha' => $nova_senha						
						);
			
				$dados_alterados = $this->usuario_model->alterar_senha_usuario($cod_usuario,$dados);
				
				if($dados_alterados)
				{
					print "<script type=\"text/javascript\">
   						alert('Senha alterada com sucesso!');
   						</script>";
						
					redirect('../usuario/alterar_senha_usuario/', 'refresh');
				}
				else
				{
					print "<script type=\"text/javascript\">
   						alert('Erro ao alterar Senha do usuário');
   						</script>";
						
					redirect('../usuario/alterar_senha_usuario/', 'refresh');
				}
			
			}
			else 
			{
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('usuario/altera_senha_view');
				$this->load->view ('templates/rodape_view');
			}
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
		
	}
		
	/*
	 * Funções de Validação do form Login. Validação campo usuário.
	 */
	public function verifica_usuario($login)
	{
		$cod_usuario = $this->input->post('cod_usuario');
		$retorno_user = $this->usuario_model->verifica_usuario($cod_usuario,$login);
		if($retorno_user == false)
		{
			$this->form_validation->set_message('verifica_usuario', 'Este nome de Login já existe');
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function verifica_senha_existe($senha_atual)
	{
		$cod_usuario = $this->session->userdata('cod_usuario');
		$senha_atual = $this->encrypt->sha1($senha_atual);
		
		$retorno_pass = $this->usuario_model->verifica_senha_existe($cod_usuario,$senha_atual);
		if($retorno_pass == false)
		{
			$this->form_validation->set_message('verifica_senha_existe', 'A Senha Atual está incorreta.');
			return false;
		}
		else 
		{
			return true;
		}	
	}
	
	public function confirma_senha($confirma_senha)
	{
		$nova_atual = $this->input->post('nova_senha');
		
		if($nova_atual != $confirma_senha)
		{
			$this->form_validation->set_message('confirma_senha', 'A nova senha difere da digitada no campo \'Confirme a senha\'.');
			return false;
		}
		else
		{
			return true;
		}
	}

	public function verifica_escolha_permissao()
	{
		$permissao = $this->input->post('permissao');
		//print_r($permissao);
		if($permissao == "0")
		{
			$this->form_validation->set_message('verifica_escolha_permissao', 'Escolha o nível de acesso para este usuário.');
			return false;
		}
		else
		{
			return true;
		}
		
	}
	
}//fim da class


