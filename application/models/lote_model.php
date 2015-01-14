<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lote_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function listar_transportadora()
	{
		$this->db->select('nome_transportadora');
		$this->db->from('transportadora');
		$sql_listar_transportadora = $this->db->get();
			
		foreach ($sql_listar_transportadora->result_array() as $linha)
		{
			//$cod_transportadora = $linha['cod_transportadora'];
			$nome_transp = $linha['nome_transportadora'];
			$lista_transp[$nome_transp] = $nome_transp;
		}
		return $lista_transp;
	}
	
	public function listar_fornecedores()
	{
		$this->db->query('SELECT cod_fornecedor as cod, nome as fornecedor, \'f\' as tipo_fornecedor FROM pessoa_fisica where check_fornecedor=\'t\'');
		$join1 = $this->db->last_query();
		
		$this->db->query('select cod_fornecedor as cod, razao_social as fornecedor,\'j\' as tipo_fornecedor from pessoa_juridica  where check_fornecedor=\'t\' ');
		$join2 = $this->db->last_query();
		
		$listagem_fornecedor = $this->db->query($join1.' UNION '.$join2.' ORDER BY fornecedor');
		
		foreach ($listagem_fornecedor->result_array() as $linha){
			$nome_fornecedor = $linha['fornecedor'];
			//$cod_fornecedor = $linha['cod'];
			$cod_fornecedor = $linha['cod'].'-'.$nome_fornecedor;
			
			$lista_fornecedor[$cod_fornecedor] = $nome_fornecedor;
		}
		return $lista_fornecedor;
	}
	
/*
	public function listar_fornecedores()
	{
		$sql = "select clifor_pessoa_fisica as fornecedor from cliente_fornecedor where clifor_fornecedor = 't' and clifor_pessoa_fisica !=' ' 
				union
				select clifor_pessoa_juridica from cliente_fornecedor where clifor_fornecedor = 't' and clifor_pessoa_juridica !=' ' 
				order by fornecedor";
		
		$listagem_fornecedor = $this->db->query($sql);
		foreach ($listagem_fornecedor->result_array() as $linha)
		{
			$nome_fornecedor = $linha['fornecedor'];
			$lista_fornecedor[$nome_fornecedor] = $nome_fornecedor;
		}
		return $lista_fornecedor;
	}
*/
		
	/*
	 * Select Cultura da view Cadastrar Lote
	 */
	public function listar_cultura()
	{	
		$sql_lista_cultura = $this->db->get('cultura');
		foreach ($sql_lista_cultura->result_array() as $linha)
		{
			//$nome_cultura = $linha['nome_cultura'];
			//$cod_cultura = $linha['cod_cultura'];
			$lista_cultura[ $linha['cod_cultura'] ] = $linha['nome_cultura'];
		}
		return $lista_cultura;
	}
	
	
	//tela controle do lote: select dos lotes
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
	
	
	public function cadastrar_fase_lote($dados)
	{
		$this->db->trans_begin();
		
		$retorno = $this->db->insert('controle_lotes', $dados);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	public function obter_texto_descontaminacao($cod_lote)
	{
		$query = $this->db->get_where('lote', array('cod_lote' => $cod_lote));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();			$row = $row['descontaminacao'];
		}else{
			$row = '';
		}
		return $row;
	}
	
	public function obter_texto_observ($cod_lote)
	{
		$query = $this->db->get_where('lote', array('cod_lote' => $cod_lote));
		if ($query->num_rows() > 0) {
			$row = $query->row_array();
			$row = $row['observacao'];
		}else{
			$row = '';
		}
		return $row;
	}
	
	public function atualizar_texto_descontam($cod_lote, $texto_descontam)
	{
		$this->db->trans_begin();
			$this->db->where('cod_lote', $cod_lote);
			$this->db->update('lote', array( 'descontaminacao'=>$texto_descontam ) );
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		} 
	}
	
	public function atualizar_observ_lote($cod_lote, $texto_obs)
	{
		$this->db->trans_begin();
		$this->db->where('cod_lote', $cod_lote);
		$this->db->update('lote', array( 'observacao'=>$texto_obs ) );
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	public function listar_fase_lote($cod_lote)
	{
		$this->db->order_by("data_entrada", "asc");
		$query = $this->db->get_where('controle_lotes', array('cod_lote' => $cod_lote));
		$i=1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$registro[$i] = array(
						'id_controle_lote'	=> $row['id_controle_lote'],
						'fase'			 	=> $row['fase'],
						'num_entrada' 		=> $row['num_entrada'],
						'num_expl_trab' 	=> $row['num_expl_trab'],
						'num_expl_prod'		=> $row['num_expl_prod'],
						'num_plan' 			=> $row['num_plan'],
						'taxa_mult' 		=> $row['taxa_mult'],
						'diferenca' 		=> $row['diferenca'],
						'perda_fungo' 		=> $row['perda_fungo'],
						'perda_bacteria' 	=> $row['perda_bacteria'],
						'perda_oxidacao' 	=> $row['perda_oxidacao'],
						'perda_total' 		=> $row['perda_total'],
						'pd_fungo_porcent' 	=> $row['pd_fungo_porcent'],
						'pd_bact_porcent' 	=> $row['pd_bact_porcent'],
						'pd_oxid_porcent' 	=> $row['pd_oxid_porcent'],
						'pd_total_porcent' 	=> $row['pd_total_porcent'],
						'data_entrada' 		=> $row['data_entrada'],
						'data_saida' 		=> $row['data_saida'],
						'duracao' 			=> $row['duracao'],
						'prazo' 			=> $row['prazo'],
						'dias_atrasados' 	=> $row['dias_atrasados'],
						'concluido' 		=> $row['concluido'],
						'cod_lote' 			=> $row['cod_lote'],
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
	
	
	/*
	public function listar_fase_lote($cod_lote)
	{		
		$this->db->order_by("data_inicio", "asc"); 	
		$query = $this->db->get_where('gerencia_fase_lote', array('cod_lote' => $cod_lote));
		$i=1;
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$registro[$i]= array(
						'id_gerencia_fase'=>$row['id_gerencia_fase'],
						'cod_lote'=>$row['cod_lote'],
						'data_inicio' => $row['data_inicio'],
						'meio' => $row['meio'],
						'fase' => $row['fase'],
						'num_expl_util' => $row['num_expl_util'],
						'data_prep_meio' => $row['data_prep_meio'],
						'tipo_frasco' => $row['tipo_frasco'],
						'qtde_vidro' => $row['qtde_vidro'],
						'expl_vidro' => $row['expl_vidro'],
						'num_total_expl' => $row['num_total_expl'],
						'perda_fungo' => $row['perda_fungo'],
						'perda_bacteria' => $row['perda_bacteria'],
						'perda_fung_bact' => $row['perda_fung_bact'],
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
	*/
	
	
	function atualizar_fase_lote($dados)
	{
		$this->db->trans_begin();
		
			$this->db->where('id_controle_lote', $dados['id_controle_lote']);
			$this->db->update('controle_lotes', $dados);
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	/*
	 * Carrega variedades da view cadastro de Lote
	 */
	function carregar_variedade($cod_cultura)
	{
		$this->db->select('cod_variedade, nome_variedade, sigla_variedade');
		$this->db->from('variedade');
		$this->db->where('cod_cultura',$cod_cultura);
		$sql_lista_variedade = $this->db->get();
		
		foreach ($sql_lista_variedade->result_array() as $linha)
		{
			$sigla_variedade = $linha['sigla_variedade']."-".$linha['cod_variedade'];
			$lista_variedade[$sigla_variedade] = $linha['nome_variedade'];
		}
		return $lista_variedade;
	}
	
	/*
	 * Carregar variedades da view Gerenciar Lote
	 */
	function carregar_var_controle_lote($cod_cultura)
	{
		$this->db->select('cod_variedade, nome_variedade');
		$this->db->from('variedade');
		//$this->db->where('nome_cultura',$nome_cultura);
		$this->db->where('cod_cultura',$cod_cultura);
		$sql_lista_variedade = $this->db->get();
	
		foreach ($sql_lista_variedade->result_array() as $linha)
		{
			$lista_variedade[$linha['cod_variedade']] = $linha['nome_variedade'];
		}
		return $lista_variedade;
	}
	
	
	function listar_fator_multiplicacao($cod_cultura, $cod_variedade)
	{
		$query = $this->db->get_where('fator_multiplicacao', array('cod_variedade' => $cod_variedade));
		
		if ($query->num_rows() > 0)
		{
			$linha = $query->row_array();
		}
		else
		{
			$query = $this->db->get_where('fator_multiplicacao', array('cod_cultura' => $cod_cultura));
			$linha = $query->row_array();
		}
		
		$registro = array(
					'isolamento'		 => $linha['isolamento'],
					'transferencia1'	 => $linha['transferencia1'],
					'transferencia2'	 => $linha['transferencia2'],
					'transferencia3'	 => $linha['transferencia3'],
					'subcultivo1'		 => $linha['subcultivo1'],
					'subcultivo2'		 => $linha['subcultivo2'],
					'subcultivo3'		 => $linha['subcultivo3'],
					'subcultivo4'		 => $linha['subcultivo4'],
					'subcultivo5'		 => $linha['subcultivo5'],
					'subcultivo6'		 => $linha['subcultivo6'],
					'subcultivo7'		 => $linha['subcultivo7'],
					'subcultivo8'		 => $linha['subcultivo8'],
					'alongamento'		 => $linha['alongamento'],
					'aplic_meio_liquido' => $linha['aplic_meio_liquido'],
			);
		
		return $registro;
	}

	function cadastrar_lote($dados)
	{
		$this->db->trans_begin();
			$retorno = $this->db->insert('lote', $dados);
			if($dados['cod_pedido'] != null){
				$this->db->select_max('cod_lote');
				$query = $this->db->get('lote');
				$linha = $query->row_array();
				$retorno = $this->associar_lote_pedido($dados['cod_pedido'],$linha['cod_lote']);
			}
		if($retorno == FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	//atualiza o cód do lote na tab pedido
	function associar_lote_pedido($cod_pedido, $cod_lote)
	{
		$this->db->trans_begin();
			
			$this->db->where('cod_pedido', $cod_pedido);
			$this->db->update('pedido', array('cod_lote'=>$cod_lote));
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	
	function alterar_dados_lote($dados)
	{
		$this->db->trans_begin();
		//recupera o código do pedido
			$this->db->select('cod_pedido');
			$this->db->where('cod_lote', $dados['cod_lote']);
			$query = $this->db->get('lote');
			$linha = $query->row_array();
		
			$this->db->where('cod_lote', $dados['cod_lote']);
			$this->db->update('lote', $dados);
			
			//$linha['cod_pedido'] é o pedido recuperado;
			if($dados['cod_pedido'] != $linha['cod_pedido']){
				$this->associar_lote_pedido($linha['cod_pedido'], null); //apaga o cod_lote associado anteriormente.
				$this->associar_lote_pedido($dados['cod_pedido'],$dados['cod_lote']);
			}
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	
	function excluir_lote($cod_lote)
	{
		$this->db->trans_begin();
		
			$dados = array('lote_excluido'=>'t');
			$this->db->where('cod_lote', $cod_lote);
			$this->db->update('lote', $dados);
			
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
		
	}
	
	function listar_pedido()
	{
		$this->db->select('cod_pedido');
		$this->db->where('pedido_excluido','f');
		$this->db->order_by("cod_pedido", "asc");
		$sql_pedido = $this->db->get('pedido');
		foreach ($sql_pedido->result_array() as $linha)
		{
			$lista_pedido[$linha['cod_pedido']]=$linha['cod_pedido'];
		}
		return $lista_pedido;
	}
	
	function total_linhas_lote($ano, $lote)
	{
		$this->db->where('data_recebimento >=', "$ano-01-01");
		$this->db->where('data_recebimento <=', "$ano-12-31");
		$this->db->where('lote_excluido', 'f');
		
		if( $lote == 0){
			$this->db->where('num_lote !=', '');
		}else{
			$this->db->where('num_lote', $lote );
		}
		
		$query = $this->db->get('lote');
		return $query->num_rows();
	}
	
	//recuperar a litagem de data_recebimento do lote, extraindo o ano
	function lista_anos_cadastrados_lote()
	{
		$query = $this->db->query('SELECT DISTINCT ( EXTRACT(YEAR FROM data_recebimento) ) as ano from lote order by ano desc limit 10');
		$i=1;
		foreach ($query->result_array() as $linha){
			$lista_anos[$i] = $linha['ano'];
			$i++;
		}
		return $lista_anos;
	}
	
	//listar lotes por ano na view consultar lote
	function carregar_lotes_ano($filt_ano)
	{
		$this->db->select('cod_lote, num_lote');
		$this->db->where('data_recebimento >=', "$ano-01-01");
		$this->db->where('data_recebimento <=', "$ano-12-31");
		$this->db->where('lote_excluido', 'f');
		$query = $this->db->get('lote');
		
		foreach ($query->result_array() as $linha)
		{
			$lista_lote_ano[$linha['cod_lote']] = $linha['num_lote'];
		}
		
		return $lista_lote_ano;
	}
		
	
	//tela consultar lotes
	function listar_lote($qtde = 0, $inicio = 0, $ano, $lote)
	{
// 			$this->db->select('*');
// 			$this->db->from('lote');
// 			$this->db->where('lote_excluido','f');
			
// 			switch ($tipo_pesquisa)
// 			{
// 				case 1: $this->db->where('num_lote ilike',$lote.'%'); break;
// 				case 2: $this->db->where('num_pedido', $num_pedido); break;
// 				case 3: $this->db->where('variedade ilike', $variedade.'%'); break;
// 				default: $lote = null; $num_pedido = null; $variedade = null; $tipo_pesquisa = null; break;
// 			}
			
// 			$this->db->order_by("data_recebimento", "desc");

		$this->db->where('data_recebimento >=', "$ano-01-01");
		$this->db->where('data_recebimento <=', "$ano-12-31");
		$this->db->where('lote_excluido', 'f');

		if( $lote == 0){
			$this->db->where('num_lote !=', '');
		}else{
			$this->db->where('num_lote', $lote );
		}
		
		if($qtde > 0){
			$this->db->limit($qtde, $inicio);
		}
			
		$sql_lista_lote = $this->db->get('lote');
		
		if ($sql_lista_lote->num_rows() > 0)
		{	
			$i = 1;
			$registro = array();
			foreach ($sql_lista_lote->result_array() as $row)
			{
				$registro[$i] = array(
						'cod_lote'			=> $row['cod_lote'],
						'transportadora'	=> $row['transportadora'],
						'fornecedor'		=> $row['fornecedor'],
						'qtde_recebida'		=> $row['qtde_recebida'],
						'data_recebimento'	=> $row['data_recebimento'],
						'num_lote'			=> $row['num_lote'],
						'num_pedido'		=> $row['cod_pedido'],
						'cod_cultura'		=> $row['cod_cultura'],
						'cod_variedade'		=> $row['cod_variedade'],
						'tipo_mat'			=> $row['tipo_mat'],
						'sel_posit'			=> $row['sel_posit'],
				);
				
				// recupera o nome da cultura, variedade
				
				$query = $this->db->query('select c.nome_cultura, v.nome_variedade 
				   					 	   from cultura as c, variedade as v 
				   						   where v.cod_variedade = '.$row['cod_variedade'].' and c.cod_cultura = '.$row['cod_cultura'] );
				
// 				$str = $this->db->last_query();
// 				echo $str;
// 				exit();
				
				if ($query->num_rows() > 0){
					$linha = $query->row_array(); 
					$registro[$i]['cultura']   = $linha['nome_cultura'];
					$registro[$i]['variedade'] = $linha['nome_variedade'];
				}
								   
				$i++;
			}
			
		}else{
			$registro = array();
			//return $registro;
		}
		
		return $registro;
	
	}//fim listar_lote
	
	function carregar_codigo_fornec($nome)
	{
		$this->db->select('cod_fornecedor');
		$this->db->from('pessoa_fisica');
		$this->db->where('nome',$nome);
		$resultado = $this->db->get();
		
		if($resultado->num_rows() < 0){
			$this->db->select('cod_fornecedor');
			$this->db->from('pessoa_juridica');
			$this->db->where('razao_social',$nome);	
			$retorno = $this->db->get();

			if ($retorno->num_rows() > 0){
				$linha = $retorno->row_array(); 
				$cod_fornecedor= $linha['cod_fornecedor'];
			}
		}
			
		return $cod_fornecedor;
	}
	
	
}//fim da class






