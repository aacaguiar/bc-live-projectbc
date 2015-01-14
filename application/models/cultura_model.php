<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cultura_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function cadastrar_cultura($dados)
	{
		$this->db->trans_begin();
			$this->db->insert('cultura',$dados);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function cadastrar_variedade($dados,$qtde_var)
	{
		$this->db->trans_begin();
		for($i=1;$i<=$qtde_var;$i++)
		{
			$this->db->insert('variedade',$dados[$i]);
		}
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}

	//consultar variedade e cadastrar variedade
	function listar_cultura()
	{
		$sql_lista_cultura = $this->db->get('cultura');
		foreach ($sql_lista_cultura->result_array() as $linha)
		{
			$lista_cultura[$linha['cod_cultura']] = $linha['nome_cultura'];
		}
		return $lista_cultura;
	}
	
	//consultar culturas
	function listar_cultura2()
	{
		$this->db->order_by("nome_cultura", "asc");
		$query = $this->db->get('cultura');
		$i=1;
		foreach ($query->result_array() as $linha)
		{
			//$lista_cultura[$i] = array('cod_cultura'=>$linha['cod_cultura'],'cultura'=>$linha['nome_cultura']);		
			$this->db->where('cod_cultura',$linha['cod_cultura']);
			$this->db->from('variedade');
			$qtde_var = $this->db->count_all_results();
			
			$lista_cultura[$i] = array('cod_cultura'=>$linha['cod_cultura'],'cultura'=>$linha['nome_cultura'],'qtde_var'=>$qtde_var);
			$i++;
		}
		return $lista_cultura;
	}
				
	function check_cultura_existe($cultura)
	{
		$this->db->select('nome_cultura');
		$this->db->where('nome_cultura ilike', $cultura);
		$query = $this->db->get('cultura');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}	
	}
	
	//Cadastro da Variedade
	function check_variedade_existe($variedade)
	{
		$this->db->select('nome_variedade');
		$this->db->where('nome_variedade ilike', $variedade);
		$query = $this->db->get('variedade');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}	
	}
		
	//Cadastro da Sigla
	function check_sigla_existe($sigla)
	{
		$this->db->select('sigla_variedade');
		$this->db->where('sigla_variedade ilike', $sigla);
		$query = $this->db->get('variedade');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	//Alteção de Variedade
	function check_nome_var($variedade, $cod)
	{
		$this->db->select('nome_variedade');
		$this->db->where('nome_variedade ilike', $variedade);
		$this->db->where('cod_variedade !=', $cod);
		$query = $this->db->get('variedade');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	//Alteração da Sigla
	function check_sigla_var($sigla, $cod)
	{
		$this->db->select('sigla_variedade');
		$this->db->where('sigla_variedade ilike', $sigla);
		$this->db->where('cod_variedade !=', $cod);
		$query = $this->db->get('variedade');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	
	function total_linhas_carregar_var($cod_cultura)
	{
		$this->db->where('cod_cultura',$cod_cultura);
		$this->db->from('variedade');
		$total_linhas = $this->db->count_all_results();
		return $total_linhas;
	}
		
	function carregar_variedade($cod_cultura,$limite=0,$inicio=0)
	{		
		$this->db->select('*');
		$this->db->from('variedade');
		$this->db->where('cod_cultura',$cod_cultura);
		$this->db->order_by("nome_variedade", "asc");
		
		if($limite > 0){
			$this->db->limit($limite,$inicio);
		}
		
		$sql_lista_variedade = $this->db->get();
		$total = $this->db->affected_rows();
		
		if($total!=0){
			$i=1;
			foreach ($sql_lista_variedade->result_array() as $linha)
			{
				$lista_variedade[$i]=array(
						'cod_variedade'=>$linha['cod_variedade'],
						'nome_variedade'=>$linha['nome_variedade'],
						'sigla_variedade'=>$linha['sigla_variedade']
				);
				$i++;
			}
		}else{
			$lista_variedade = array();
		}
		
		return $lista_variedade;
	}
	
	function alterar_dados_variedade($dados)
	{
		$this->db->trans_begin();	
		$this->db->where('cod_variedade', $dados['cod_variedade']);
		$this->db->update('variedade', $dados); 
			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function alterar_dados_cultura($dados)
	{
		$this->db->trans_begin();
		$this->db->where('cod_cultura', $dados['cod_cultura']);
		$this->db->update('cultura', $dados);
			
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	function excluir_variedade($cod_variedade)
	{
		$this->db->trans_begin();
		$this->db->delete('variedade', array('cod_variedade' => $cod_variedade));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function excluir_cultura($cod_cultura)
	{
		$this->db->trans_begin();
		$this->db->delete('cultura', array('cod_cultura' => $cod_cultura));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
}//fim da class

