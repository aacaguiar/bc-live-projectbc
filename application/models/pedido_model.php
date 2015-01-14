<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido_model extends CI_Model
{	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	
	function cadastrar_pedido($dados, $data_entrega ,$qtde_ent_parcial, $check_endereco, $endereco)
	{
		//start transaction
		$this->db->trans_begin();					
		$this->db->insert('pedidos', $dados);		
		$this->db->select_max('cod_pedido');
		$sql_cod_pedido = $this->db->get('pedidos');	
		$linha = $sql_cod_pedido->row_array();
		$cod_pedido = $linha['cod_pedido'];
				
		if($check_endereco=="end_novo"){			
			$endereco['cod_end_entrega'] = $linha['cod_pedido'];
			$this->db->insert('novo_end_entrega', $endereco);
		}
		
		for($i=1; $i<=$dados['qtde_entrega']; $i++){
			$campos = array(
					/*'id_entrega' =>$cod_data_entrega,*/
					'num_entrega'=>$i,
					'data_entrega'=>$data_entrega[$i],
					'qtde_parcial'=>$qtde_ent_parcial[$i],
					'entrega_concluida'=>'f',
					'cod_pedido'=>$cod_pedido	
			);
			$this->db->insert('datas_entregas',$campos);
		}
			
		//status transaction
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
		
		
	}//fim do cadastrar pedido
	
	
	public function alterar_dados_pedido($dados,$data_entrega,$qtde_ent_parcial,$check_endereco,$endereco)
	{
		$this->db->trans_begin();
			
				$this->db->where('cod_pedido', $dados['cod_pedido']);
				$this->db->update('pedidos', $dados);								
				if($check_endereco=="end_novo"){			
					$this->db->where('cod_pedido', $dados['cod_pedido']);
					$this->db->update('novo_end_entrega', $endereco);
				}			
				for($i=1;$i<=$dados['qtde_entrega'];$i++){
					$campos = array(
							'num_entrega'=>$i,
							'data_entrega'=>$data_entrega[$i],
							'qtde_parcial'=>$qtde_ent_parcial[$i]
					);				
					$this->db->where('cod_pedido',$dados['cod_pedido']);
					$this->db->where('num_entrega', $i);
					$this->db->update('datas_entregas', $campos);
				}
				
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
	
	function inserir_datas_entregas($dados2,$data_entrega,$qtde_ent_parcial)
	{	
		//start transaction
		$this->db->trans_begin();
			for($i=1;$i<=$dados2['aumentar_entregas'];$i++){
				$a = ++$dados2['num_entregas_anterior'];
				$campos = array(
					'cod_data_entrega'=>$dados2['cod_pedido'],
					'num_entrega'=>$a,
					'data_entrega'=>$data_entrega[$a],
					'qtde_parcial'=>$qtde_ent_parcial[$a]
				);
				$this->db->insert('datas_entregas',$campos);
			}
		//status transaction
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function deletar_datas_entregas($dados2,$data_entrega,$qtde_ent_parcial)
	{
		//start transaction
		$this->db->trans_begin();
		for($i=1;$i<=$dados2['diminuir_entregas'];$i++)
		{
			$a=$dados2['num_entregas_anterior']--;
			$this->db->delete('datas_entregas',array('cod_data_entrega'=>$dados2['cod_pedido'],'num_entrega'=>$a));
		}
		//status transaction
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}

	function total_linhas_pedido()
	{
		$this->db->where('pedido_excluido', 'f');
		$this->db->from('pedidos');
		$total_linhas = $this->db->count_all_results();
		return $total_linhas;
	}
	
	function listar_pedido($limite = 0, $inicio = 0, $cliente = null, $pedido = null, $tipo_pesquisa = null)
	{
		if($cliente != null){
			$this->db->select('id_clifor');
			$this->db->from('cliente_fornec');
			$this->db->where('nome_rsocial ilike', $cliente.'%');
			$consulta_id_cliente = $this->db->get();
			
			if ($consulta_id_cliente->num_rows() > 0){
				$linha = $consulta_id_cliente->row_array();
				$id_clifor = $linha['id_clifor'];
			}else{
				$id_clifor = null;
			}
		}
		
			$this->db->select('*');
			$this->db->from('pedidos');
			$this->db->where('pedido_excluido','f');
			$this->db->order_by("cod_pedido", "asc");
			
			switch ($tipo_pesquisa)
			{
				case "cliente":
					$this->db->where('id_clifor', $id_clifor); break;
					
				case "pedido": 
					$this->db->where('cod_pedido', $pedido); break;
				default: 
					$cliente = null; $pedido = null; $tipo_pesquisa = null; break;
			}
		
			//$this->db->order_by("p.nome", "asc");	
			if($limite > 0)
				$this->db->limit($limite, $inicio);
				
			$sql_lista_pedido = $this->db->get();
		
		if ($sql_lista_pedido->num_rows() > 0)
		{	
			$i = 0;
			foreach ($sql_lista_pedido->result_array() as $row)
			{
				$registro[$i]= array(
						'cod_pedido'	=> $row['cod_pedido'],
						'id_clifor'		=> $row['id_clifor'],
						'check_pf'		=> $row['check_pf'],
						/*'cliente'		=> $row['cliente'],*/
						'cod_cultura'	=> $row['cod_cultura'],
						'cod_variedade'	=> $row['cod_variedade'],
						'fase_entrega'	=> $row['fase_entrega'],
						'qtde_pedido'	=> $row['qtde_pedido'],
						'frq_entrega'	=> $row['frq_entrega'],
						'qtde_entrega'	=> $row['qtde_entrega'],
						'cod_endereco'	=> $row['cod_endereco'],
						'end_atual'		=> $row['end_atual'],
						'end_novo'		=> $row['end_novo'],
						'status_pedido'	=> $row['status_pedido'],
						'data_pedido'	=> $row['data_pedido'],
						'vl_muda'		=> $row['vl_muda'],
						'vl_total'		=> $row['vl_total'],
						'forma_pagto'	=> $row['forma_pagto']
				);
				
				//recupera o cliente
				$this->db->select('nome_rsocial');
				$this->db->where('id_clifor', $registro[$i]['id_clifor']);
				$query = $this->db->get('cliente_fornec');
				$linha = $query->row_array();
				$registro[$i]['cliente'] = $linha['nome_rsocial'];
								
				//recupera cultura	
				$this->db->select('nome_cultura');
				$this->db->where('cod_cultura', $registro[$i]['cod_cultura']);
				$query = $this->db->get('cultura');
				$linha = $query->row_array();
				$registro[$i]['cultura'] = $linha['nome_cultura'];
				
				//recupera variedade
				$this->db->select('nome_variedade');
				$this->db->where('cod_variedade', $registro[$i]['cod_variedade']);
				$query = $this->db->get('variedade');
				$linha = $query->row_array();
				$registro[$i]['variedade'] = $linha['nome_variedade'];
				
				//recupera endereco
				if($registro[$i]['end_atual']='t'){
					$sql_endereco = $this->db->get_where('endereco', array('cod_endereco' => $registro[$i]['id_clifor']));
				}else{
					$sql_endereco = $this->db->get_where('novo_ende_entrega', array('cod_endereco' => $registro[$i]['cod_pedido']));
				}
					$linha = $sql_endereco->row_array();
					$endereco[$i] = array(
							'endereco'=>$linha['endereco'],
							'bairro'=>$linha['bairro'],
							'estado'=>$linha['estado'],
							'cidade'=>$linha['cidade'],
							'cep'=>$linha['cep']
						);
				$i++;
			}
			
		}else{
			$registro = array();
			$endereco = array();
			return array('registro'=>$registro,'endereco'=>$endereco);
		}
		
		return array('registro'=>$registro,'endereco'=>$endereco);
	
	}//fim listar_pedido
	
	
	function excluir_pedido($cod_pedido)
	{
		$this->db->trans_begin();
			$this->db->where('cod_pedido',$cod_pedido);
			$this->db->update('pedidos', array('pedido_excluido'=>'t'));
		//status transaction
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			$this->db->trans_commit();
			return true;
		}
		
	}
		
	public function listar_estados()
	{
		$this->db->select('es_nome');
		$this->db->from('estados');
		$sql_listar_estados = $this->db->get();
			
		foreach ($sql_listar_estados->result_array() as $linha)
		{
			//$es_id = $linha['es_id'];
			$nome_estado = $linha['es_nome'];
			$lista_estados[$nome_estado] = $nome_estado;
		}
		return $lista_estados;
	}
	
	public function listar_cultura()
	{
		$sql_lista_cultura = $this->db->get('cultura');
		foreach ($sql_lista_cultura->result_array() as $linha)
		{
			//$nome_cultura = $linha['cult_nome_cultura'];
			//$indice = $linha['cult_cod_cultura'].'-'.$linha['cult_nome_cultura'];
			$lista_cultura[ $linha['cod_cultura']] = $linha['nome_cultura'];
		}
		return $lista_cultura;
	}

	function carregar_variedade($cod_cultura)
	{
		$this->db->select('cod_variedade,nome_variedade');
		$this->db->from('variedade');
		$this->db->where('cod_cultura',$cod_cultura);
		$sql_lista_variedade = $this->db->get();
	
		foreach ($sql_lista_variedade->result_array() as $linha)
		{
			$lista_variedade[$linha['cod_variedade']] = $linha['nome_variedade'];
		}
		return $lista_variedade;
	}
	
	
	function carregar_cliente($check_pf)
	{
			$this->db->select('id_clifor, nome_rsocial');
			$this->db->from('cliente_fornec');
			$this->db->where('check_pf', $check_pf);
			$this->db->order_by("nome_rsocial", "asc");
				
			$sql_lista_cliente = $this->db->get();
			
			foreach ($sql_lista_cliente->result_array() as $linha){
				$lista_cliente[$linha['id_clifor']] = $linha['nome_rsocial'];
			}
			
		
// 		if($tipo_cliente=='juridica')
// 		{
// 			$this->db->select('cod_pes_juridica, razao_social');
// 			$this->db->from('pessoa_juridica');
// 			$this->db->order_by("razao_social", "asc");
				
// 			$sql_lista_cliente = $this->db->get();
			
// 			foreach ($sql_lista_cliente->result_array() as $linha){
// 				$lista_cliente[$linha['cod_pes_juridica']] = $linha['razao_social'];
// 			}
// 		}
		
		return $lista_cliente;
	}
	
	/*
	function end_entrega_atual($cod_cliente)
	{
		$query = $this->db->get_where('endereco', array('cod_endereco' => $cod_cliente));
		if ($query->num_rows() > 0){
			$linha = $query->row_array();
			$endereco = array(
				'endereco'=>$linha['endereco'],
				'bairro'=>$linha['bairro'],
				'estado'=>$linha['estado'],
				'cidade'=>$linha['cidade'],
				'cep'=>$linha['cep']
			);
		}		
		return $endereco;
	}
	*/
	
	function carregar_cidades($opcao_estado)
	{
		$this->db->select('ci_nome');
		$this->db->from('cidades');
		$this->db->where('ci_nome_estado',$opcao_estado);
		$this->db->order_by("ci_nome", "asc");
		$sql_lista_cidade = $this->db->get();
	
		foreach ($sql_lista_cidade->result_array() as $linha)
		{
			//$cod_cidade = $linha['ci_cod_cidade'];
			$nome_cidade = $linha['ci_nome'];
			$lista_cidades[$nome_cidade] = $nome_cidade;
		}
		return $lista_cidades;
	}
	
	
	function novo_end_entrega($cod_pedido)
	{
		$query = $this->db->get_where('novo_end_entrega', array('cod_end_entrega' => $cod_pedido));
		if ($query->num_rows() > 0){
			$linha = $query->row_array();
			$endereco = array(
					'endereco'=>$linha['endereco'],
					'bairro'=>$linha['bairro'],
					'estado'=>$linha['estado'],
					'cidade'=>$linha['cidade'],
					'cep'=>$linha['cep']
			);
		}
		return $endereco;
	}
	
	function listar_datas_entregas($cod_pedido)
	{
		$this->db->select('*');
		$this->db->from('datas_entregas');
		$this->db->where('cod_pedido',$cod_pedido);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0){
			$total_linhas = $query->num_rows();
			foreach ($query->result_array() as $linha){
				$indice = $linha['num_entrega'];
				$datas_ent[$indice] 	= $linha['data_entrega'];
				$qtde_ent[$indice] 		= $linha['qtde_parcial'];
				$ent_concluida[$indice] = $linha['entrega_concluida'];
			}
			for( $i=30; $i > $total_linhas; $i-- ){
				$datas_entregas[$i] = '';
				$qtde_ent_parcial[$i] = '';
			}	
		}
		//$data_entrega=array(1=>'01/02/2014');
		return array('datas_entregas'=>$datas_ent, 'qtde_ent_parcial'=>$qtde_ent, 'ent_concluida'=>$ent_concluida);
	}
		
	public function carregar_endereco($cod_id/*,$opcao_cliente*/)
	{
		/*
		 if($opcao_cliente=='fisica'){
		$sql_endereco = $this->db->query("SELECT * FROM endereco where cod_endereco =
				(select cod_endereco from pessoa_fisica where cod_pes_fisica = '$cod_id')");
		}
		
		if($opcao_cliente=='juridica'){
		$sql_endereco = $this->db->query("SELECT * FROM endereco where cod_endereco =
				(select cod_endereco from pessoa_juridica where cod_pes_juridica = '$cod_id')");
		}
		*/
		
		$sql_endereco = $this->db->get_where('endereco', array('cod_endereco' => $cod_id));
		
		if ($sql_endereco->num_rows() > 0)
		{
			$linha = $sql_endereco->row_array();	
			$endereco_cliente = array(
							'cod_endereco'=>$linha['cod_endereco'],
							'endereco'=>$linha['endereco'],
							'bairro'=>$linha['bairro'],
							'estado'=>$linha['estado'],
							'cidade'=>$linha['cidade'],
			 				'cep'=>$linha['cep']
							);
		}
		return $endereco_cliente;
	}
	

	function listar_fase_entrega()
	{
		$sql_lista_fase = $this->db->get('fase_entrega');
		
		//$lista_fase_entrega = array();
		foreach ($sql_lista_fase->result_array() as $linha)
		{
			$lista_fase_entrega[$linha['cod_fase']] = $linha['nome_fase_entrega'];
		}
		
		return $lista_fase_entrega;
	}
	
	
	
	
}//fim da class















