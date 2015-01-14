<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function cadastra_usuario($dados)
	{
		//print_r($dados);
		$dados['us_senha'] = $dados['us_senha'];
		$retorno = $this->db->insert('usuario', $dados);
		return $retorno;
	}
	
	function excluir_usuario($cod_usuario)
	{
		$this->db->trans_begin();
		$this->db->where('us_cod_usuario', $cod_usuario);
		$this->db->delete('usuario');
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	function total_linhas_usuario()
	{
		//$this->db->where('pedido_excluido', 'f');
		//$this->db->from('pedidos');
		$total_linhas = 10;
		//$total_linhas = $this->db->count_all_results();
		return $total_linhas;
	}
	
	function pesquisar_usuario()
	{
		$lista_usuario = array();
		$sql_lista_user = $this->db->get('usuario');
		$i = 0;
		foreach ($sql_lista_user->result_array() as $row)
		{	
				$registro[$i]= array(
						'cod_usuario'=>$row['us_cod_usuario'],
						'nome'=>$row['us_nome'],
						'login'=>$row['us_usuario'],
						'senha'=>$row['us_senha'],
						'email'=>$row['us_email'],
						'ativo'=>$row['us_ativo'],
						'permissao'=>$row['pe_cod_permissao']
				);
				
				if($registro[$i]['ativo']=='t'){
					$registro[$i]['ativo']='Sim';
				}else {
					$registro[$i]['ativo']='Não';
				}			
			$i++; 
		}
		
		return $registro;
		//$var = sizeof($registro);
		//print_r($var);
		
	}
	function listar_usuario($limite = 0, $inicio = 0, $nome = null, $email = null, $tipo_pesquisa = null)
	{
			
		switch ($tipo_pesquisa)
		{
			case "nome":
				if($nome != null){
					$this->db->select('*');
					$this->db->from('pedidos');
					$this->db->where('us_nome', $nome);
					$sql_lista_pedido = $this->db->get();
					break;
				}		
			case "email":
					if($email != null){
						$this->db->select('*');
						$this->db->from('pedidos');
						$this->db->where('us_email', $email);
						$sql_lista_pedido = $this->db->get();
					break;
				}		
			default:
				$nome = null; $email = null; $tipo_pesquisa = null;
				$sql_lista_user = $this->db->get('usuario');
				break;
				
		}
		
		if($limite > 0)
			$this->db->limit($limite, $inicio);
	
		
	
		if ($sql_lista_pedido->num_rows() > 0)
		{
			$i = 0;
		foreach ($sql_lista_user->result_array() as $row)
		{
			$registro[$i]= array(
					'cod_usuario'=>$row['us_cod_usuario'],
					'nome'=>$row['us_nome'],
					'login'=>$row['us_usuario'],
					'senha'=>$row['us_senha'],
					'email'=>$row['us_email'],
					'ativo'=>$row['us_ativo'],
					'permissao'=>$row['pe_cod_permissao']
			);
		
			if($registro[$i]['ativo']=='t'){
				$registro[$i]['ativo']='Sim';
			}else {
				$registro[$i]['ativo']='Não';
			}
			$i++;
		}
				
		}else{
			
			  return $registro;
		}
	
		return $registro;
	
	}//fim listar_pedido
	
	function listar_permissao()
	{
		//$lista_permissao = array();
		//$registros = array();
		$sql_lista_permissao = $this->db->get('permissao');
		
		foreach ($sql_lista_permissao->result_array() as $linha)
		{
			
			$i = $linha['pe_nivel_permissao'];
			$valor = $linha['pe_tipo_permissao'];
			$lista_permissao[$i] = "$valor";		
		}
		
		return $lista_permissao;
		//print_r($registro);
	}
	
	function alterar_senha_usuario($cod_usuario, $dados)
	{
		$this->db->where('us_cod_usuario', $cod_usuario);
		$retorno =  $this->db->update('usuario', $dados);
		return $retorno;
		 //$sql = $this->db->last_query();
		 //echo $sql;
	}
	
	function alterar_dados_usuario($dados)
	{
				
		$this->db->where('us_cod_usuario', $dados['us_cod_usuario']);
		$retorno = $this->db->update('usuario', $dados);
		return $retorno;
	}
	
	
	function verifica_usuario($cod_usuario,$login)
	{
		$consulta_user = $this->db->get_where('usuario',array('us_usuario'=>$login));
		if($consulta_user->num_rows > 0 )
		{
			//return false; //usuário já existe	
			$linha = $consulta_user->row();
			if($linha->us_cod_usuario == $cod_usuario)
			{
				return true;
			}
			else
			{
				return false; //usuário já existe
			}
				
		}
		else
		{
			return true;
		}
	}
	
	function verifica_senha_existe($cod_usuario,$senha_atual)
	{
		$consulta_user = $this->db->get_where('usuario',array('us_cod_usuario'=>$cod_usuario));
		if($consulta_user->num_rows > 0)
		{
			$this->db->select('us_senha');
			$this->db->from('usuario');
			$this->db->where('us_cod_usuario',$cod_usuario);
			$consulta = $this->db->get();
			$linha = $consulta->row();
				
			//$senha = sha1($senha);
			//echo $linha->us_senha;
				
			if($senha_atual == $linha->us_senha)
			{
				
				return true;	
			}
			else
			{
				return false;
			}
	
		}
	
	}
	
}






