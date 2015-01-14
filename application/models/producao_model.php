<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producao_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	
	//view Cadastro info do lote
	public function listar_cultura()
	{
		$this->db->order_by("nome_cultura", "asc");
		$sql_lista_cultura = $this->db->get('cultura');
		
		foreach ($sql_lista_cultura->result_array() as $linha)
		{
			$lista_cultura[ $linha['cod_cultura'] ] = $linha['nome_cultura'];
		}
		return $lista_cultura;
	}
	
	//view Cadastro controle da produção
	public function listar_fase()
	{
		$sql_lista_fase = $this->db->get('fase_fat_conversao');
		foreach ($sql_lista_fase->result_array() as $linha){
			$lista_fase[$linha['id']] = $linha['fase'];
				
			$cod_fase_fator[$linha['id']] = array(
					'cod_fase'			=> $linha['cod_fase'],
					'fator_conversao' 	=> $linha['fator_conversao'],
			);
		}
		return array('lista_fase'=>$lista_fase, 'cod_fase_fator'=>$cod_fase_fator);
	}
	
// 	public function obter_cod_fase_fator($id)
// 	{
// 		$query = $this->db->get_where('fase_controle_prod', array('id' => $id));
// 		$linha = $query->row_array(); 
// 		$cod_fase_fator = array( $linha['cod_fase'], $linha['fator_multiplicacao'] );
// 		return $cod_fase_fator;
// 	}
		
	
	//chamada javascript pela cultura p/carregar as variedades na view cadastro de info lote
	function carregar_variedade($cod_cultura)
	{
		$this->db->select('cod_variedade, nome_variedade');
		$this->db->from('variedade');
		$this->db->where('cod_cultura',$cod_cultura);
		$sql_lista_variedade = $this->db->get();
	
		foreach ($sql_lista_variedade->result_array() as $linha)
		{
			$lista_variedade[$linha['cod_variedade']] = $linha['nome_variedade'];
		}
		return $lista_variedade;
	}
	
		
	//lista lotes da view controle da produção
	function listar_lote()
	{
		$this->db->select('cod_lote, num_lote');
		$this->db->from('lote');
		$this->db->order_by("num_lote", "asc");
		$sql_lista_lote = $this->db->get();
		foreach ($sql_lista_lote->result_array() as $linha){
			$lista_lote[$linha['cod_lote']] = $linha['num_lote'];
		}
		return $lista_lote;
	}
	
	
	//chamada via javascript pela selec variedade da view cadastro info lote
	public function carregar_lotes($cod_cultura, $cod_variedade)
	{
		//$this->db->select('title, content, date');
		//$query = $this->db->get_where('mytable', array('id' => $id), $limit, $offset);
		$sql_lista_lote = $this->db->get_where('lote', array('cod_cultura'=> $cod_cultura, 'cod_variedade'=> $cod_variedade, 'lote_excluido'=>'f', 'lote_concluido'=>'f') );
		foreach ($sql_lista_lote->result_array() as $linha)
		{
			$cod_lote = $linha['cod_lote'];
			$lista_lote[$cod_lote] = $linha['num_lote'];
		}
		return $lista_lote;
	}
	
	
	//lista repicador da view cadastro info lote
	function listar_repicador()
	{
		$query = $this->db->get('repicador');
		foreach ($query->result_array() as $linha)
		{
			$id = $linha['id_repicador'];
			$lista_repic[$id] = $linha['repicador'];
		}
		return $lista_repic;
	}
	
	//inserir no banco o cadastro de info lote
	public function cadastrar_controle_prod($campos)
	{
		$this->db->trans_begin();
			$this->db->insert('controle_producao', $campos);
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
// 		echo $this->db->last_query();
// 		exit();
	}
	
	public function excluir_controle_prod($id)
	{
		$this->db->trans_begin();
			$this->db->delete('controle_producao', array('id' => $id) );
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	//alterar os dados na view alterar_controle da produção
	public function alterar_controle_prod($dados)
	{
		$this->db->trans_begin();
				
			$this->db->where('id', $dados['id']);
			$this->db->update('controle_producao', $dados);
					
			//status transaction
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				return false;
			}
			else{
				$this->db->trans_commit();
				return true;
			}
		
		
	}//fim alterar dados pedido
	
	function carregar_etapas($num_semana ,$limite=0, $inicio=0)
	{

		$this->db->select('*');
		$this->db->from('pedidos');
		$this->db->where('cod_pedido !=', 0);
		
		if($limite > 0){
			$this->db->limit($limite,$inicio);
		}
		
		$sql_lista = $this->db->get();
		$total = $this->db->affected_rows();
		
//		echo $this->db->last_query();
//		exit();	

		if($total!=0)
		{
			$i=1;
			foreach ($sql_lista->result_array() as $linha)
			{
				$lista[$i] = array(
						'nome'					=> $linha['cod_pedido'],
						/*'ano' 	  			=> $linha['ano'],
						'semana'  				=> $linha['semana'],
						'cod_cultura'			=> $linha['cod_cultura'],
						'cod_variedade'			=> $linha['cod_variedade'],
						'cod_lote'				=> $linha['cod_lote']*/
					);
				
				$i++;
			}
		}
		else
		{
			$lista = array();
		}
		
		return $lista;
			
	}
	
	function total_linhas_controle_prod($ano, $semana)
	{
		//$this->db->select('*');
		$this->db->where('ano', $ano);
		$this->db->where('semana', $semana);
		$this->db->from('controle_producao');
		//$query = $this->db->get();
		//$total_linhas =
		return $this->db->count_all_results();
	}
			
		
	//view controle da produção
	function listar_controle_prod($qtde, $inicio, $filtros)
	{
				
// 		$query = $this->db->query('SELECT * from controle_producao 
// 									where ano='.$filtros['filt_ano'].' and '. 
// 									/*' CASE WHEN '.$filtros['filt_sem'].'!=0 THEN semana='.$filtros['filt_sem'].' else semana!='.$filtros['filt_sem'].' end and'.*/
// 									'CASE WHEN '.$filtros['filt_sem'].'!=0 THEN semana='.$filtros['filt_sem'].' else semana!=0 end and '.
// 									'CASE WHEN '.$filtros['filt_cult'].'!=0 THEN cod_cultura='.$filtros['filt_cult'].' else cod_cultura!=0 end and '.
// 									'CASE WHEN '.$filtros['filt_var'].'!=0 THEN cod_variedade='.$filtros['filt_var'].' else cod_variedade!=0 end'
									
// 		);

		$ano = $filtros['filt_ano'];
		$sem = $filtros['filt_sem'];
//		$cult = $filtros['filt_cult'];
//		$var = $filtros['filt_var'];
			
// 		$this->db->select('*');
// 		$this->db->from('controle_producao');	
// 		$this->db->where("ano = '$ano' and CASE WHEN $sem!=0 THEN semana=$sem else semana!=0 end and 
// 						 CASE WHEN $cult!=0 THEN cod_cultura=$cult else cod_cultura!=0 end and 
// 						 CASE WHEN $var!=0 THEN cod_variedade=$var else cod_variedade!=0 end ");
// 		if($limite > 0){
// 			$this->db->limit($limite, $inicio);
// 		}		
// 		$query = $this->db->get();
				
		$query = $this->db->query("SELECT * FROM controle_producao WHERE ano=$ano and semana=$sem ORDER BY cod_cultura LIMIT $qtde OFFSET $inicio;");
		
		//echo $this->db->last_query();
		//exit();
		
		if ($query->num_rows() > 0)
		{
			$i=1;
			foreach ($query->result_array() as $linha)
			{
				$sql = $this->db->query( 'select nome_cultura from cultura where cod_cultura ='.$linha['cod_cultura'] );
				$linha_cult = $sql->row_array(); //$linha_cult['nome_cultura'];
				
				$sql = $this->db->query( 'select nome_variedade from variedade where cod_variedade ='.$linha['cod_variedade'] );
				$linha_var = $sql->row_array(); //$linha_var['nome_variedade'];
				
				$sql = $this->db->query( 'select num_lote from lote where cod_lote ='.$linha['cod_lote'] );
				$linha_lote = $sql->row_array(); //$linha_lote['num_lote'];
				
				$sql = $this->db->query( 'select repicador from repicador where id_repicador ='.$linha['cod_repic_ant'] );
				$linha_repic_ant = $sql->row_array(); //$linha_repic_ant['repicador'];
				
				$sql = $this->db->query( 'select repicador from repicador where id_repicador ='.$linha['cod_repic_atual'] );
				$linha_repic_atual = $sql->row_array(); //$linha_repic_atual['repicador'];
				
				$sql = $this->db->get_where('fase_fat_conversao', array('id' => $linha['id_fase']));
				$linha_fase_fat = $sql->row_array(); //$linha_repic_atual['repicador'];
								
				$registro[$i] = array(
						/* filtros */
						'filt_ano'				=> $filtros['filt_ano'],
						'filt_sem'				=> $filtros['filt_sem'],
						/*'filt_cult'				=> $filtros['filt_cult'],
						'filt_var'				=> $filtros['filt_var'],*/
						/*info lote*/
						'id'					=> $linha['id'],
						'ano' 	  				=> $linha['ano'],
						'semana'  				=> $linha['semana'],
						'cultura' 				=> $linha_cult['nome_cultura'],
						'variedade' 			=> $linha_var['nome_variedade'],
						'lote'					=> $linha_lote['num_lote'],
						'cod_cultura'			=> $linha['cod_cultura'],
						'cod_variedade'			=> $linha['cod_variedade'],
						'cod_lote'				=> $linha['cod_lote'],
						/*etapa anterior*/
						'cod_repic_ant'			=> $linha['cod_repic_ant'],
						'repic_ant'				=> $linha_repic_ant['repicador'],
						'data_anterior' 		=> $linha['data_anterior'],
						'num_expl_prod' 		=> $linha['num_expl_prod'],
						'pd_fungo' 				=> $linha['pd_fungo'],
						'pd_bacteria' 			=> $linha['pd_bacteria'],
						'pd_oxidacao' 			=> $linha['pd_oxidacao'],
						'total_perdas' 			=> $linha['total_perdas'],
						'num_fr_trab' 			=> $linha['num_fr_trab'],
						'num_expl_fr_trab' 		=> $linha['num_expl_fr_trab'],
						'num_total_expl_trab' 	=> $linha['num_total_expl_trab'],
						'tamanho_expl' 			=> $linha['tamanho_expl'],
						'contaminacao' 			=> $linha['contaminacao'],
						'tipo_meio' 			=> $linha['tipo_meio'],
						/*etapa atual*/
						'cod_repic_atual'		=> $linha['cod_repic_atual'],
						'repic_atual'			=> $linha_repic_atual['repicador'],
						'data_atual' 			=> $linha['data_atual'],
						'num_pote_prod'			=> $linha['num_pote_prod'],
						'num_expl_pote' 		=> $linha['num_expl_pote'],
						'subtotal1' 			=> $linha['subtotal1'],
						'num_fr_prod' 			=> $linha['num_fr_prod'],
						'num_expl_fr' 			=> $linha['num_expl_fr'],
						'subtotal2' 			=> $linha['subtotal2'],
						'num_quebrado' 			=> $linha['num_quebrado'],
						'total_expl_prod' 		=> $linha['total_expl_prod'],
						/*Análise inicial*/
						'id_fase' 				=> $linha['id_fase'],
						'fase' 					=> $linha_fase_fat['fase'],
						'cod_fase' 				=> $linha_fase_fat['cod_fase'],
						'fator_conversao' 		=> $linha_fase_fat['fator_conversao'],
						'pontos_repic' 			=> $linha['pontos_repic'],
						
					);
				
				$i++;
			}
		}
		else 
		{
			$registro = array();
		}
		
		return $registro;
	}
	
	
	
	//lista variedades da view controle da produção
	function listar_variedade()
	{
		$this->db->select('cod_variedade, nome_variedade');
		$this->db->from('variedade');
		$this->db->order_by("nome_variedade", "asc");
		$sql_lista_variedade = $this->db->get();
		foreach ($sql_lista_variedade->result_array() as $linha){
			$lista_variedade[$linha['cod_variedade']] = $linha['nome_variedade'];
		}
		return $lista_variedade;
	}
	
}//fim da class






















