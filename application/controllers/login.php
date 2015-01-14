<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('login_model');
		$this->load->library('encrypt');
		$this->load->library('email');
	}
	
	public function _remap($metodo)
	{
		if($metodo != 'redefinir_senha'){
			$this->verificar_login();
		}else{
			$this->redefinir_senha();
		}
	}
	
	public function index()
	{
		$this->load->view('login_view');
	}
	
	public function verificar_login()
	{
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				
		if($this->form_validation->run('login/verificar_login') != FALSE)
		{
			//echo "usuário e senha passaram no teste";
			$this->iniciar_sessao();
			redirect('../pagina_inicial');
		}
		else 
		{
			$this->load->view('login_view');
		}
	}
	
	//Funções de Validação do form Login. Validação campo usuário.
	public function verifica_usuario($usuario)
	{
		$retorno_user = $this->login_model->verifica_usuario($usuario);
		if($retorno_user){
			return $this->check_usuario_inativo($retorno_user);
		}
		if($retorno_user == false)
		{
			$this->form_validation->set_message('verifica_usuario', 'Nome de Usuário incorreto ou não existe');
			return false;
		}
	}
	
	function check_usuario_inativo($retorno_user)
	{
		if($retorno_user == 'f'){
			$this->form_validation->set_message('verifica_usuario', 'Nome de Usuário inativo');
			return false;
		}else{
			return true;
		}
	}
	
	//validação campo senha
	public function verifica_senha($senha)
	{
		$usuario = $this->input->post('usuario');
		$senha = $this->encrypt->sha1($senha);
		$retorno_pass = $this->login_model->verifica_senha($usuario,$senha);
		
		if($retorno_pass == false)
		{
			$this->form_validation->set_message('verifica_senha', 'Senha inválida');
			return false;
		}
		else 
		{
			return true;
		}
	}
	
	public function iniciar_sessao()
	{	
		$usuario = $this->input->post('usuario');
		$senha = $this->input->post('senha');
		$senha = $this->encrypt->sha1($senha);
		
		$sessao_usuario = $this->login_model->retorna_dados_sessao($usuario,$senha);
		
		//print_r($sessao_usuario);
		$this->session->set_userdata($sessao_usuario);
		//$nome_usuario = $this->session->userdata('nome_usuario');
		//var_dump($nome_usuario);	
	}
	
	public function fechar_sessao()
	{
		$array_items = array('nome_usuario' => '', 'senha' => '');
		$this->session->unset_userdata($array_items);
		$this->session->sess_destroy();
		$this->index();
	}
	
	public function redefinir_senha()
	{
		$usuario = $this->input->post('usuario');
		//$this->verifica_usuario($usuario);
		
		if($this->form_validation->run('login/redefinir_senha')!= FALSE){
			$query = $this->db->get_where('usuario', array('us_usuario' => $usuario));
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row_array();
				$senha = sha1(123456);
				//$senha2 = geraSenha(15, true, true, true);
				//echo senha2;
				$dados = array('us_senha'=>$senha);
				$this->db->where('us_usuario', $usuario);
				$retorno = $this->db->update('usuario', $dados);

				if ($retorno=true)
				{
					$this->email->from('bioclonebiofabrica@gmail.com','Sistem Bioclone');
					$this->email->to($row['us_email']);
					$this->email->subject('Redefinição de senha do sistema Bioclone');
					$body = "<html>
								<head>
								</head>
								<body>
									<b> sua nova senha é: 123456 <br> 
									  Após acessar o sistema o usuário poderá alterá-la no MENU -> USUÁRIO -> ALTERAR SENHA 
									</b>
								</body>
						     </html>";
					
					//$this->email->message("Eu posso agora enviar email do CodeIgniter usando o Gmail como meu servidor!");
					$this->email->message($body);
					$retorno = $this->email->send();
					
					if($retorno){
						$email = $row['us_email'];
						print "<script type='text/javascript'>
							 	var email = '$email';
   								alert('SUA NOVA SENHA FOI ENVIADA PARA: $email');
   							  </script>";
						
						redirect(base_url());
					}else{
						echo "erro ao enviar email";
					}
					
				}else{
					echo "Erro ao alterar senha do usuário";
				}				
			}
			
		}else {
			$this->load->view('login_view');
		}
	}
	
	
}//fim da class



