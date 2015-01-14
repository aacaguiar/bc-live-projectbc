<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Entregas_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
// 	public function listar_entregas($mes, $dias_mes, $ano)
// 	{
		
// 		$this->db->select('distinct(data_entrega)');
// 		$this->db->where('data_entrega >=', '01/'.$mes.'/'.$ano."'");
// 		$this->db->where('data_entrega <=', "'".$dias_mes.'/'.$mes.'/'.$ano."'");
// 		$query = $this->db->get('datas_entregas');

// // 		$this->db->select('id_entrega, num_entrega, data_entrega, qtde_parcial, entrega_concluida, cod_pedido');
// // 		$this->db->where('data_entrega >=', '01/'.$mes.'/'.$ano."'");
// // 		$this->db->where('data_entrega <=', "'".$dias_mes.'/'.$mes.'/'.$ano."'");
// // 		$this->db->where('p.cod_pedido = dt.cod_pedido');
// // 		$this->db->where('p.cod_lote = l.cod_lote');
// // 		$this->db->from('datas_entregas de, pedidos p, lote l');
// // 		$query = $this->db->get('datas_entregas');
				
// 		if ($query->num_rows() > 0)
// 		{
// 			$i=1;
// 			foreach ($query->result_array() as $linha)
// 			{
// 				$dia[$i]['data_entrega'] = $linha['data_entrega'];
				
// // 				$this->db->select('*');
// // 				$this->db->where('data_entrega =', $linha['data_entrega']);
// // 				$new_query = $this->db->get('datas_entregas');

// 				$this->db->select('id_entrega, num_entrega, data_entrega, qtde_parcial, entrega_concluida, de.cod_pedido, 
// 									l.num_lote, cf.nome_rsocial, v.nome_variedade');
// 				$this->db->from('datas_entregas de, pedidos p, lote l, cliente_fornec cf, variedade v');
// 				$this->db->where('data_entrega =', $linha['data_entrega']);
// 				$this->db->where('p.cod_pedido = de.cod_pedido');
// 				$this->db->where('p.cod_lote = l.cod_lote');
// 				$this->db->where('p.id_clifor = cf.id_clifor');
// 				$this->db->where('l.cod_variedade = v.cod_variedade');
// 				$new_query = $this->db->get();
				
// 				$cnt=1;
// 				foreach ($new_query->result_array() as $new_linha)
// 				{
// 					$dia[$i][$cnt] = array(
// 							'id_entrega' 		=> $new_linha['id_entrega'],
// 							'num_entrega'		=> $new_linha['num_entrega'],
// 							'data_entrega'		=> $new_linha['data_entrega'],
// 							'qtde_parcial'		=> $new_linha['qtde_parcial'],
// 							'ent_concluida'		=> $new_linha['entrega_concluida'],
// 							'cod_pedido'		=> $new_linha['cod_pedido'],
// 							'num_lote'			=> $new_linha['num_lote'],
// 							'nome_rsocial'		=> $new_linha['nome_rsocial'],
// 							'variedade'			=> $new_linha['nome_variedade'],
// 					);
									
// 					$cnt++;
// 				}
				
// 				//$dia[$i]['regist'] = $registro; 
// 				$dia[$i]['total'] = $cnt-1;
				
// 				$i++;
// 			}
			
// 			//$tot_entregas = $i-1;
// 			return array('dia'=>$dia, 'tot_entregas'=>$i-1);
// 		}
// 		else
// 		{
// 			return array();
// 		}
						
// 	}
	
	public function listar_entregas($mes, $dias_mes, $ano)
	{
	
		$this->db->select('id_entrega, num_entrega, data_entrega, qtde_parcial, entrega_concluida, de.cod_pedido, 
 						  l.num_lote, cf.nome_rsocial, v.nome_variedade');
		
		$this->db->from('datas_entregas de, pedidos p, lote l, cliente_fornec cf, variedade v');
		
		$this->db->where('data_entrega >=', '01/'.$mes.'/'.$ano."'");
 		$this->db->where('data_entrega <=', "'".$dias_mes.'/'.$mes.'/'.$ano."'");
 		
 		$this->db->where('p.cod_pedido = de.cod_pedido');
 		$this->db->where("p.pedido_excluido = 'f' ");
 		$this->db->where('p.cod_lote = l.cod_lote');
		$this->db->where('p.id_clifor = cf.id_clifor');
		$this->db->where('l.cod_variedade = v.cod_variedade');
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		//exit();
		
		if ($query->num_rows() > 0)
		{
			$i=1;
			foreach ($query->result_array() as $new_linha)
			{
				$entregas[$i] = array(
						'id_entrega' 		=> $new_linha['id_entrega'],
						'num_entrega'		=> $new_linha['num_entrega'],
						'data_entrega'		=> $new_linha['data_entrega'],
						'qtde_parcial'		=> $new_linha['qtde_parcial'],
						'ent_concluida'		=> $new_linha['entrega_concluida'],
						'cod_pedido'		=> $new_linha['cod_pedido'],
						'num_lote'			=> $new_linha['num_lote'],
						'nome_rsocial'		=> $new_linha['nome_rsocial'],
						'variedade'			=> $new_linha['nome_variedade']
				);
													
				$i++;
			}
				
			//$tot_entregas = $i-1;
			return array('entregas'=>$entregas, 'tot_entregas'=>$i-1);	
		}
		else
		{
			return array('entregas'=>0, 'tot_entregas'=>0);
		}
	
	}//fim do listar_entregas
	
	
	function concluir_ent_parcial($id)
	{
		$this->db->trans_begin();
		
			$this->db->where('id_entrega', $id);
			$this->db->update('datas_entregas', array('entrega_concluida'=>'t') );
				
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
		
	}
	
	
}//fim da class



