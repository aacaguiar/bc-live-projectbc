<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Repicagem_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function cadastrar_repicador($dados)
	{
		$this->db->trans_begin();
			$this->db->insert('repicador',$dados);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
				
	function check_repicador_existe($repicador, $id_repicador)
	{
		//condição usada no alterar_repicador_view, precisa do id
		if(!empty($id_repicador)){
			$this->db->select('id_repicador, repicador');
			//$this->db->where('id_repicador', $id_repicador);
			$this->db->where('repicador ilike', $repicador);
			$query = $this->db->get('repicador');
			if($query->num_rows()>0){
				$linha = $query->row_array();
				if($id_repicador == $linha['id_repicador']) {
					return false;
				}else{
					return true;
				}
			}else{
				return false;
			}
		}
		else //condição usada no cadastrar_repicador_view
		{
			$this->db->select('repicador');
			$this->db->where('repicador ilike', $repicador);
			$query = $this->db->get('repicador');
			if($query->num_rows()>0){
				return true;
			}else{
				return false;
			}
		}	
	}
	
	//listar repicadores
	function listar_repicadores($inicio=0, $limite=0)
	{
		$this->db->order_by("repicador", "asc");
		if($limite > 0){
			$this->db->limit($limite,$inicio);
		}
		$query = $this->db->get('repicador');
		$i=1;
		foreach ($query->result_array() as $linha)
		{					
			$lista_repicadores[$i] = array(
									'id_repicador' => $linha['id_repicador'],
									'repicador' => $linha['repicador'],
									'ativo' => $linha['ativo']);
			$i++;
		}
		return $lista_repicadores;
	}
	
	function listar_selec_repicadores()
	{
		$this->db->order_by("repicador", "asc");
		$query = $this->db->get_where('repicador', array('ativo' => 't') );
	
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $linha){
				$lista_repicadores[$linha['id_repicador']] = $linha['repicador'];
			}
			return $lista_repicadores;
		}else{
			return array();
		}
	}
	
	function lista_prod_semanal($ano, $num_semana)
	{
		//$this->db->order_by("id_repicador", "asc");
		$query = $this->db->get_where('producao_semanal', array('ano' =>$ano, 'num_semana'=> $num_semana) );
		/*
		$str = $this->db->last_query();
		echo $str;
		break;
		*/
		
		if ($query->num_rows() > 0)
		{
			$i=1;
			foreach ($query->result_array() as $linha){
				$lista_prod_semanal[$i] = array(
										'id_prod_semanal' 	=> $linha['id_prod_semanal'],
										'id_repicador'		=> $linha['id_repicador'],
										'total_expl_prod' 	=> $linha['total_expl_prod'],
										'media_tx_mult'		=> $linha['media_tx_mult'],
										'pontuacao'			=> $linha['pontuacao'],
										'producao'			=> $linha['producao'],
										'ano'				=> $linha['ano'],
										'num_semana'		=> $linha['num_semana']
										);
					$i++;
				/*
				$query = $this->db->get_where('repicador', array('id_repicador' =>$lista_prod_semanal[$i]['id_repicador']) );
				if($query->num_rows() > 0){
					$linha = $query->row_array();
					$lista_prod_semanal[$i]['repicador'] = $linha['repicador'];
				}
				*/	
			}
			return $lista_prod_semanal;			
		}
		else
		{
			return array();
		}
		
	}
		
	function cadastrar_prod_semanal($dados)
	{
		$this->db->trans_begin();
		$this->db->insert('producao_semanal',$dados);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function alterar_dados_repicador($dados, $id_repicador)
	{
		$this->db->trans_begin();
		$this->db->where('id_repicador', $id_repicador);
		$this->db->update('repicador', $dados);
			
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


