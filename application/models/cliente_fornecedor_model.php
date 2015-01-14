<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cliente_fornecedor_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		
	public function gerar_cod_fornec()
	{
		$this->db->select_max('cod_fornecedor');
		$sql_get_cod = $this->db->get('cliente_fornec');
		$linha = $sql_get_cod->row_array();
		return $linha['cod_fornecedor']+1;
	}
	
	
// 	public function cadastra_cliente($endereco, $dados )
// 	{
// 		$retorno = $this->db->insert('cliente_fornec', $dados);
// // 		$str = $this->db->last_query();
// // 		echo $str;
// // 		break;
		
// 		if($retorno)
// 		{
// 			$this->db->select_max('id_clifor');
// 			$sql_get_id = $this->db->get('cliente_fornec');
// 			$linha = $sql_get_id->row_array();
// 			$endereco['cod_endereco'] = $linha['id_clifor'];
// 			$resposta = $this->db->insert('endereco', $endereco);
// 		}
		
// 		return $resposta;
	
// 	}//fim do cadastrar cliente
	
	
	function excluir_cliente_fornec($id_clifor)
	{
		$this->db->trans_begin();
		$this->db->delete('cliente_fornec', array('id_clifor' => $id_clifor));
		$this->db->delete('endereco', array('cod_endereco' => $id_clifor));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
			return true;
		}
	}
	
// 	public function cadastra_fornecedor($endereco, $dados)
// 	{
// 		$retorno = $this->db->insert('cliente_fornec', $dados);
// 		if($retorno)
// 		{
// 			$this->db->select_max('id_clifor');
// 			$sql_get_id = $this->db->get('cliente_fornec');
// 			$linha = $sql_get_id->row_array();
// 			$endereco['cod_endereco'] = $linha['id_clifor'];
// 			$resposta = $this->db->insert('endereco', $endereco);
// 		}
		
// 		return $resposta;		
		
// 	}//fim do cadastrar fornecedor
	
	public function cadastrar_cliente_fornec($endereco, $dados)
	{
		$retorno = $this->db->insert('cliente_fornec', $dados);
		
		if($retorno)
		{
			$this->db->select_max('id_clifor');
			$sql_get_id = $this->db->get('cliente_fornec');
			$linha = $sql_get_id->row_array();
			$endereco['cod_endereco'] = $linha['id_clifor'];
			$resposta = $this->db->insert('endereco', $endereco);
		}
	
		return $resposta;
	
	}//fim do cadastrar fornecedor
		
	function obter_total_linhas($opcao, $check_tipo)
	{
		if($opcao == 'fisica'){
			$this->db->where('check_pf','t');
		}else{ /* pessoa juridica */
			$this->db->where('check_pf','f');
		}
		$this->db->where($check_tipo,'t');
		$this->db->from('cliente_fornec');
		$total_linhas = $this->db->count_all_results();
		return $total_linhas;
	}
		
	
	public function alterar_dados_cliente_fornec($endereco, $dados)
	{
		//print_r($dados);
		$this->db->trans_begin();
		$this->db->where('id_clifor', $dados['id_clifor']);
		$this->db->update('cliente_fornec', $dados);
		$this->db->where('cod_endereco', $endereco['cod_endereco']);
		$this->db->update('endereco', $endereco);
			
		if (!$this->db->trans_status()){
    		$this->db->trans_rollback();
    		return false;
		}
		else{
    		$this->db->trans_commit();
    		return true;
		}	
				
	}//fim alterar dados cliente
			
	function listar_cliente_fornec($limite=0, $inicio=0, $opcao, $check_tipo)
	{
		$registro = array();
		$check_pf = ($opcao=="fisica") ? 't' : 'f';
	
		$this->db->select('*');
		$this->db->from('cliente_fornec cf');
		$this->db->join('endereco e', "cf.id_clifor = e.cod_endereco and $check_tipo = 't' and cf.check_pf='$check_pf' ");
		$this->db->order_by("cf.nome_rsocial", "asc");
	
		if($limite > 0)
			$this->db->limit($limite,$inicio);
	
		$sql_lista_cliente = $this->db->get();
		$i = 0;
	
		foreach ($sql_lista_cliente->result_array() as $row)
		{
			$registro[$i]= array(
					'id_clifor'=>$row['id_clifor'],
					'nome_rsocial'=>$row['nome_rsocial'],
					'cpf_cnpj'=>$row['cpf_cnpj'],
					'check_fornecedor'=>$row['check_fornecedor'],
					'cod_fornecedor'=>$row['cod_fornecedor'],
					'cod_endereco'=>$row['cod_endereco'],
					'endereco'=>$row['endereco'],
					'bairro'=>$row['bairro'],
					'estado'=>$row['estado'],
					'cidade'=>$row['cidade'],
					'cep'=>$row['cep'],
					'fone_residencial'=>$row['fone_residencial'],
					'fone_celular'=>$row['fone_celular'],
					'email'=>$row['email'],
			);
			$i++;
		}
	
		return $registro;
	
	}//fim listar_cliente	
	
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
	

	
}//fim da class




