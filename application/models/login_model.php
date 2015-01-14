<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function verifica_usuario($usuario)
	{
		$consulta_user = $this->db->get_where('usuario',array('us_usuario'=>$usuario));
		if($consulta_user->num_rows > 0)
		{
			
			$this->db->select('us_ativo');
			$this->db->from('usuario');
			$this->db->where('us_usuario', $usuario);
			$consulta_ativo = $this->db->get();
			//$sql = $this->db->last_query();
		 	//echo $sql;
			$linha = $consulta_ativo->row();
			
			if($linha->us_ativo == 't'){
				return 't';
			}else{
				return 'f';		
			}
			//return true;
		}
		else 
		{
			return false;
		}
	}
	
	function verifica_senha($usuario,$senha)
	{
		$consulta_user = $this->db->get_where('usuario',array('us_usuario'=>$usuario));
		if($consulta_user->num_rows > 0)
		{
			$this->db->select('us_senha');
			$this->db->from('usuario');
			$this->db->where('us_usuario',$usuario);
			$consulta = $this->db->get();
			$linha = $consulta->row();
			
			//$sql = $this->db->last_query();
		 	//echo $sql;
		 
			//print_r($senha);
			
			if(($senha) == $linha->us_senha)
			{
				return true;
			}
			else
			{
				return false;
			}
		
		}		
		
	}
	
	function retorna_dados_sessao($usuario,$senha)
	{
		$sql_dados_usuario = $this->db->get_where('usuario', array('us_usuario' => $usuario,'us_senha'=>$senha) );
		
		if ($sql_dados_usuario->num_rows() > 0)
		{
			foreach ($sql_dados_usuario->result() as $linha)
			{
				$sessao_usuario = array(
								'cod_usuario'	=> $linha->us_cod_usuario,
								'nome'			=> $linha->us_nome,
								'nome_usuario'	=> $linha->us_usuario,
								'senha'			=> $linha->us_senha,
								'email'			=> $linha->us_email,
								'ativo'			=> $linha->us_ativo,
								'permissao'		=> $linha->pe_cod_permissao
							);
				
			
			}
			
			return $sessao_usuario;
		}	
 	}	
 	
 	function redefinir_senha_usuario($nome_usuario, $senha)
 	{
 		$dados = array('us_senha'=>$senha);
 		$this->db->where('us_usuario', $nome_usuario);
 		$retorno =  $this->db->update('usuario', $dados);
 		return $retorno;
 		//$sql = $this->db->last_query();
 		//echo $sql;
 	}
 	
 	

	

}//fim da class


