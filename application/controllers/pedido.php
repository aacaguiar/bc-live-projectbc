<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('pedido_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->library('pagination');
		//parse_str($_SERVER['QUERY_STRING'],$_GET);
	}
	
	public function check_sessao()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) ){
			return true;
		}
		else{
			return false;
		}					
	}
	
	function cadastrar_pedido()
	{	
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			//$lista_cliente = $this->pedido_model->listar_cliente();
			$lista_estados = $this->pedido_model->listar_estados();
			$lista_fase_entrega = $this->pedido_model->listar_fase_entrega();
			$lista_cultura = $this->pedido_model->listar_cultura();
			$arquivo_css = base_url('css/pedido/cadastro_pedido.css');

			$qtde_entrega = array (1=>'1x',2=>'2x',3=>'3x',4=>'4x',5=>'5x',6=>'6x',7=>'7x',8=>'8x',9=>'9x',10=>'10x',11=>'11x',12=>'12x',
								   13=>'13x',14=>'14x',15=>'15x',16=>'16x',17=>'17x',18=>'18x',19=>'19x',20=>'20x',21=>'21x',22=>'22x',
								   23=>'23x',24=>'24x',25=>'25x',26=>'26x',27=>'27x',28=>'28x',29=>'29x',30=>'30x');
				
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css'=> $arquivo_css,
					'lista_menu'=> $lista_menu,
					'lista_estados'=> $lista_estados,
					'lista_fase_entrega'=> $lista_fase_entrega,
					'qtde_entrega'=> $qtde_entrega,
					'lista_cultura' => $lista_cultura
			);
				
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
				
			if($this->form_validation->run('pedido/cadastrar_pedido') != FALSE)
			{	
				 $dados = array(
				 		//'cli_id'=>'DEFAULT',	
				 		'id_clifor' 		=> $this->input->post('cod_cliente'),
				 		'cod_cultura' 		=> $this->input->post('cultura'),
				 		'cod_variedade' 	=> $this->input->post('variedade'),
				 		'fase_entrega' 		=> $this->input->post('fase_muda'),
				 		'qtde_pedido' 		=> $this->input->post('qtde_pedido'),
				 		'data_pedido' 		=> $this->input->post('data_pedido'),
				 		'vl_muda' 			=> $this->input->post('vl_muda'),
				 		'vl_total' 			=> $this->input->post('vl_total'),
				 		'forma_pagto' 		=> $this->input->post('forma_pagto'),
				 		'frq_entrega' 		=> $this->input->post('frq_entrega'),
				 		'qtde_entrega' 		=> $this->input->post('qtde_entrega'),
				 		'cod_endereco' 		=> 0,
				 		'status_pedido' 	=> 1,
				 		'pedido_excluido'	=> 'f',
				 		'cod_lote'=>null
				 );
				 
				 $dados['data_pedido'] = str_replace("/", "-", $dados['data_pedido']);
				 $data_entrega = $this->input->post('data_entrega');
				 $qtde_ent_parcial = $this->input->post('qtde_ent_parcial');
				 $dados['check_pf'] = ( $this->input->post('tipo_cliente') == 'fisica' ) ? 't' : 'f';
				 
				 for($i=1;$i<=$dados['qtde_entrega'];$i++){
				 	$data_entrega[$i]=str_replace("/", "-", $data_entrega[$i]);
				 }
				 			 
				 $check_endereco = $this->input->post('check_endereco');
				 if($check_endereco=="end_atual"){
				 	$dados['end_atual']='t';
				 	$dados['end_novo']='f';
				 	$endereco=null;
				 }else{
				 	$dados['end_atual']='f';
				 	$dados['end_novo']='t';
				 	
				 	$caracteres = array(".","-");
				 	$cep = str_replace($caracteres,"", $this->input->post('cep'));
				 	
				 	$bairro = $this->input->post('bairro');
				 	$bairro = ( empty($bairro) ) ? " " :  $this->input->post('bairro');
				 	
				 	$endereco = array(
				 		'endereco' =>$this->input->post('endereco'),
				 		'bairro' =>$bairro,
				 		'estado' =>$this->input->post('estado'),
				 		'cidade' =>$this->input->post('cidade'),
				 		'cep' =>$cep,
				 	);
				 }
				 				 			 				 								 
				$dados_inseridos = $this->pedido_model->cadastrar_pedido($dados,$data_entrega,$qtde_ent_parcial,$check_endereco,$endereco);
				$msg = ($dados_inseridos) ? 'Pedido cadastrado com sucesso!' : 'Erro ao cadastrar o Pedido';
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
				redirect('../pedido/cadastrar_pedido/', 'refresh');
				
			}
			else
			{		
				$data['estado_selec'] = $this->input->post('estado');	
				$data['cidade_selec'] = $this->input->post('cidade');
				$data['fase_selec'] = $this->input->post('fase_muda');
				$data['qtde_selec'] = $this->input->post('qtde_entrega');
				$data['cliente_selec'] = $this->input->post('tipo_cliente');
				$data['cod_selec'] = $this->input->post('cod_cliente');
				$data['cultura_selec'] = $this->input->post('cultura');
				$data['variedade_selec'] = $this->input->post('variedade');
				$data['qtde_selec'] = $this->input->post('qtde_entrega');
				$data['end_selec'] = $this->input->post('check_endereco');
				$data['data_selec'] = $this->input->post('data_entrega'); 
				$data['qtde_ent_parcial'] = $this->input->post('qtde_ent_parcial');
				
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('pedido/cadastro_pedido_view');
				$this->load->view ('templates/rodape_view');
			}
		}
	
		else{
			$this->load->view ('erro_acesso');
		}

		
	}//fim do cadastrar
		
	function paginacao($url, $limite, $total_linhas)
	{
		//paginação
		$config['base_url'] = $url;/*endereço base*/
		$config['total_rows'] = $total_linhas;/*nº linhas paginadas*/
		$config['per_page'] = $limite;/*registros por página*/
		$config['num_links'] = 5;
	
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li><a href="'.$url.'">';
		$config['cur_tag_close'] = '</a></li>';
			
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
	
	
		return $config;
	}
		
	function pesquisar_pedido()
	{
		$tipo_pesquisa = $this->input->post('selec_pesq');	
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		if($this->form_validation->run('pedido/pesquisar_pedido') != FALSE){
			//pesquisa seletiva
			switch ($tipo_pesquisa){
				case "cliente": 
					$cliente = $this->input->post('pesquisa'); $pedido=null; break;
				case "pedido":  
					$pedido  = $this->input->post('pesquisa'); $cliente=null; break;
			}	
			$this->listar_pedido($cliente, $pedido, $tipo_pesquisa);
		}else{
			$this->listar_pedido(null,null,$tipo_pesquisa);
		}		
	}
	
	function listar_pedido($cliente=null, $pedido=null, $tipo_pesquisa=null)
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{												
			//paginação
			$limite = 10;
			$inicio = ($this->uri->segment(3) !='') ? $this->uri->segment(3) : 0 ;
			$lista_pedido = $this->pedido_model->listar_pedido($limite, $inicio, $cliente, $pedido, $tipo_pesquisa);
			$total_linhas = $this->pedido_model->total_linhas_pedido();
			$config = $this->paginacao(base_url('pedido/listar_pedido/'), $limite, $total_linhas);
	
			$this->pagination->initialize($config);
	
			//cria variáveis
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/pedido/lista_pedido.css');
	
			$inicio++;
			if($inicio<10){
				$pag=1;
			}else{
				$pag=(int)($inicio/10);
				$pag++;
			}
			
			$total_pag = ($total_linhas<10) ? 1 : ($total_linhas/10);
			$total_pag = (is_float($total_pag)) ? (int)++$total_pag : $total_pag;
	
			$data = array(
					'nome_usuario'	=> $nome_usuario,
					'arquivo_css'	=> $arquivo_css,
					'lista_menu'	=> $lista_menu,
					'lista_pedido'	=> $lista_pedido['registro'],
					'endereco'		=> $lista_pedido['endereco'],
					'total_linhas'	=> $total_linhas,
					'pagination'	=> $this->pagination->create_links(),
					'inicio'		=> $inicio,
					'pag'			=> $pag,
					'total_pag'		=> $total_pag,
					'tipo_pesquisa' => $tipo_pesquisa,
					/*'valor_digitado' => $this->input->post('pesquisa')*/
			);
			
			$this->load->view('templates/topo_view',$data);
			$this->load->view('pedido/lista_pedido_view');
			$this->load->view('templates/rodape_view');	
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	}
	
		
	function alterar_pedido()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$permissao 			= $this->session->userdata('permissao');
			$nome_usuario 		= $this->session->userdata('nome_usuario');
			$lista_menu 		= $this->menu->gerenciar_menu($permissao);
			$lista_estados 		= $this->pedido_model->listar_estados();
			$lista_fase_entrega = $this->pedido_model->listar_fase_entrega();
			$lista_cultura 		= $this->pedido_model->listar_cultura();
			$arquivo_css 		= base_url('css/pedido/cadastro_pedido.css');

			$qtde_entrega = array (1=>'1x',2=>'2x',3=>'3x',4=>'4x',5=>'5x',6=>'6x',7=>'7x',8=>'8x',9=>'9x',10=>'10x',11=>'11x',12=>'12x',
								   13=>'13x',14=>'14x',15=>'15x',16=>'16x',17=>'17x',18=>'18x',19=>'19x',20=>'20x',21=>'21x',22=>'22x',
								   23=>'23x',24=>'24x',25=>'25x',26=>'26x',27=>'27x',28=>'28x',29=>'29x',30=>'30x');
				
			$data = array(
					'nome_usuario' 		=> $nome_usuario,
					'arquivo_css'		=> $arquivo_css,
					'lista_menu'		=> $lista_menu,
					'lista_estados'		=> $lista_estados,
					'lista_fase_entrega'=> $lista_fase_entrega,
					'qtde_entrega'		=> $qtde_entrega,
					'lista_cultura' 	=> $lista_cultura,		
			);
			
			$data['cod_pedido'] 		= $this->input->post('num_pedido');
			//$data['cliente_selec'] 	= $this->input->post('check_pf');
			$data['cod_selec'] 			= $this->input->post('id_clifor');
			$data['cultura_selec'] 		= $this->input->post('cod_cultura');
			$data['variedade_selec'] 	= $this->input->post('cod_variedade');
			$data['fase_selec'] 		= $this->input->post('fase_entrega');	
			$data['qtde_pedido'] 		= $this->input->post('qtde_pedido');
			$data['frq_entrega'] 		= $this->input->post('frq_entrega');
			$data['qtde_entrega_selec'] = $this->input->post('qtde_entrega');
			$data['end_selec'] 			= $this->input->post('check_endereco');
			$data['data_pedido'] 		= $this->input->post('data_pedido');
			$data['vl_muda'] 			= $this->input->post('vl_muda');
			$data['vl_total'] 			= $this->input->post('vl_total');
			$data['forma_pagto'] 		= $this->input->post('forma_pagto');
			$data['num_ent_anterior'] 	= $this->input->post('qtde_entrega'); //nº de entregas anterior caso aumente/diminua
			$data['cliente_selec'] 		= ($this->input->post('check_pf') == 't') ? 'fisica' : 'juridica';
								
			if($this->input->post('end_atual')=='t'){
				$data['end_selec']='end_atual';	
				$data['end_novo'] = array('endereco'=>'','bairro'=>'','estado'=>'','cidade'=>'','cep'=>'');
			}
			
			if($this->input->post('end_novo')=='t'){
				$data['end_selec']='end_novo';
				$data['end_novo'] = $this->pedido_model->novo_end_entrega($data['cod_pedido']);
			}
			
			$end_novo = $this->input->post('end_novo');
			if(empty($end_novo)){
				$data['end_novo'] = array('endereco'=>'','bairro'=>'','estado'=>'','cidade'=>'','cep'=>'');
			}
		
			if($data['cod_pedido']!='' && $data['cod_pedido']!=0){
				$table_entregas = $this->pedido_model->listar_datas_entregas($data['cod_pedido']);
				$data['data_selec']	= $table_entregas['datas_entregas'];
				$data['qtde_ent_parcial'] = $table_entregas['qtde_ent_parcial'];
				$data['ent_concluida'] = $table_entregas['ent_concluida'];
			}else {
				$data['data_selec']	= '';
				$data['qtde_ent_parcial'] = '';
			}
					
			$this->load->view('templates/topo_view',$data);
			$this->load->view('pedido/altera_pedido_view'); 
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//fim alterar_pedido
	
	
	public function alterar_dados_pedido()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_estados = $this->pedido_model->listar_estados();
			$lista_fase_entrega = $this->pedido_model->listar_fase_entrega();
			$lista_cultura = $this->pedido_model->listar_cultura();
			$arquivo_css = base_url('css/pedido/cadastro_pedido.css');

			$qtde_entrega = array (1=>'1x',2=>'2x',3=>'3x',4=>'4x',5=>'5x',6=>'6x',7=>'7x',8=>'8x',9=>'9x',10=>'10x',11=>'11x',12=>'12x',
								   13=>'13x',14=>'14x',15=>'15x',16=>'16x',17=>'17x',18=>'18x',19=>'19x',20=>'20x',21=>'21x',22=>'22x',
								   23=>'23x',24=>'24x',25=>'25x',26=>'26x',27=>'27x',28=>'28x',29=>'29x',30=>'30x');
				
			$data = array(
					'nome_usuario' => $nome_usuario,
					'arquivo_css'=> $arquivo_css,
					'lista_menu'=> $lista_menu,
					'lista_estados'=> $lista_estados,
					'lista_fase_entrega'=> $lista_fase_entrega,
					'qtde_entrega'=> $qtde_entrega,
					'lista_cultura' => $lista_cultura
			);
	
			/*
			 * status pedido:
			 * 1-aberto, 2-fechado
			 */		
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('pedido/cadastrar_pedido') != FALSE)
			{
				$dados = array(
						//'cli_id'=>'DEFAULT',
						'cod_pedido'	=> $this->input->post('num_pedido'),
						/*'tipo_cliente'	=> $this->input->post('tipo_cliente'),*/
						'id_clifor'		=> $this->input->post('cod_cliente'),
						'cod_cultura'	=> $this->input->post('cultura'),
						'cod_variedade'	=> $this->input->post('variedade'),
						'fase_entrega'	=> $this->input->post('fase_muda'),
						'qtde_pedido'	=> $this->input->post('qtde_pedido'),
						'data_pedido'	=> $this->input->post('data_pedido'),
						'vl_muda'		=> $this->input->post('vl_muda'),
						'vl_total'		=> $this->input->post('vl_total'),
						'frq_entrega'	=> $this->input->post('frq_entrega'),
						'qtde_entrega'	=> $this->input->post('qtde_entrega'),
						'cod_endereco'	=> 0,
						'status_pedido'	=> 1,
				);
				
				 $data_entrega=$this->input->post('data_entrega');
				 $qtde_ent_parcial=$this->input->post('qtde_ent_parcial');
				 $dados['check_pf'] = ( $this->input->post('tipo_cliente') == 'fisica' ) ? 't' : 'f';
				 
				 //verifica se qtde entregas aumentou/diminuiu
				 $num_entregas_anterior = $this->input->post('num_entregas_anterior');	 
				 if($dados['qtde_entrega']>$num_entregas_anterior){
				 	$this->inserir_datas_entregas($data_entrega, $qtde_ent_parcial);
				 }
				 else { /*if($dados['qtde_entrega']<$num_entregas_anterior)*/
				 	$this->deletar_datas_entregas($data_entrega, $qtde_ent_parcial);
				 }
											 
				 $check_endereco = $this->input->post('check_endereco');
				 if($check_endereco=="end_atual"){
				 	$dados['end_atual'] = 't';
				 	$dados['end_novo'] = 'f';
				 	$endereco=null;
				 }else{
				 	$dados['end_atual'] = 'f';
				 	$dados['end_novo'] = 't';
				 	
				 	$caracteres = array(".", "-");
				 	$cep = str_replace($caracteres,"", $this->input->post('cep'));
				 	
				 	$bairro = $this->input->post('bairro');
				 	$bairro = (empty($bairro)) ? " " : $this->input->post('bairro');
				 	
				 	$endereco = array(
				 		'endereco' => $this->input->post('endereco'),
				 		'bairro' => $bairro,
				 		'estado' => $this->input->post('estado'),
				 		'cidade' => $this->input->post('cidade'),
				 		'cep' => $cep,
				 	);
				 }
				 				 			 				 								 
				$dados_inseridos = $this->pedido_model->alterar_dados_pedido($dados, $data_entrega, $qtde_ent_parcial, $check_endereco, $endereco);
				$msg = ($dados_inseridos) ? 'Pedido alterado com sucesso!' : 'Erro ao alterar o Pedido';
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
				redirect('../pedido/listar_pedido/', 'refresh');
					
			}
			else
			{
				$data['cod_pedido'] = $this->input->post('num_pedido');
				$data['cliente_selec'] = $this->input->post('tipo_cliente');
				$data['cod_selec'] = $this->input->post('cod_cliente');
				$data['cultura_selec'] = $this->input->post('cultura');
				$data['variedade_selec'] = $this->input->post('variedade');
				$data['fase_selec'] = $this->input->post('fase_muda');
				$data['qtde_pedido'] = $this->input->post('qtde_pedido');
				$data['vl_muda'] = $this->input->post('vl_muda');
				$data['vl_total'] = $this->input->post('vl_total');
				$data['data_pedido'] = $this->input->post('data_pedido');
				$data['frq_entrega'] = $this->input->post('frq_entrega');
				$data['qtde_entrega_selec'] = $this->input->post('qtde_entrega');			
				$data['end_selec'] = $this->input->post('check_endereco');
				$data['data_selec'] = $this->input->post('data_entrega');
				$data['qtde_ent_parcial'] = $this->input->post('qtde_ent_parcial');
				$data['estado_selec'] = $this->input->post('estado');
				$data['cidade_selec'] = $this->input->post('cidade');			
				//mº de entregas anterior caso aumente/diminua
				$data['num_ent_anterior'] = $this->input->post('num_entregas_anterior');
				$data['end_novo']=array(
						'endereco'=>$this->input->post('endereco'),
						'bairro'=>$this->input->post('bairro'),
						'cep'=>$this->input->post('cep')
				);
				$this->load->view('templates/topo_view',$data);
				$this->load->view('pedido/altera_pedido_view');
				$this->load->view('templates/rodape_view');
			}
		}
		else
		{
			$this->load->view('erro_acesso');
		}
	}//fim da alterar_dados_pedido
	
	function excluir_pedido()
	{
		$cod_pedido = $this->input->post('num_pedido');
		$pedido_excluido = $this->pedido_model->excluir_pedido($cod_pedido);
		
		if($pedido_excluido){
			print "<script type=\"text/javascript\">
   						alert('Pedido excluído com sucesso!');
   						</script>";
		
			redirect('../pedido/listar_pedido/', 'refresh');
		}
		else{
			print "<script type=\"text/javascript\">
   						alert('Erro ao excluir o Pedido');
   						</script>";
		
			redirect('../pedido/listar_pedido/', 'refresh');
		}	
	}
	
	
	function inserir_datas_entregas($data_entrega,$qtde_ent_parcial)
	{	
		$num_entregas_anterior = $this->input->post('num_entregas_anterior');
		$aumentar_entregas = $this->input->post('qtde_entrega')-$num_entregas_anterior;
		if($aumentar_entregas){
			$dados2=array(
				 'cod_pedido'=>$this->input->post('num_pedido'),
				 'num_entregas_anterior'=>$num_entregas_anterior,
				 'aumentar_entregas'=>$aumentar_entregas
			);
		}
		$dados_inseridos = $this->pedido_model->inserir_datas_entregas($dados2,$data_entrega,$qtde_ent_parcial);
		if(!$dados_inseridos){
			print "<script type=\"text/javascript\">
   						alert('Erro ao alterar datas do Pedido');
   						</script>";
			redirect('../pedido/listar_pedido/','refresh');
		}	
	}
	
	function deletar_datas_entregas($data_entrega,$qtde_ent_parcial)
	{
		$num_entregas_anterior = $this->input->post('num_entregas_anterior');
		$diminuir_entregas = $num_entregas_anterior-$this->input->post('qtde_entrega');
		if($diminuir_entregas){
			$dados2=array(
					'cod_pedido'=>$this->input->post('num_pedido'),
					'num_entregas_anterior'=>$num_entregas_anterior,
					'diminuir_entregas'=>$diminuir_entregas
			);
		}
		$dados_deletados = $this->pedido_model->deletar_datas_entregas($dados2,$data_entrega,$qtde_ent_parcial);
		if(!$dados_deletados){
			print "<script type=\"text/javascript\">
   						alert('Erro ao excluir datas do Pedido');
   						</script>";
			redirect('../pedido/listar_pedido/','refresh');
		}
	}
	
	
	function carregar_endereco()
	{
		$cod_id = $this->input->post('cod_id');
		//$opcao_cliente = $this->input->post('opcao_cliente');
		$endereco_cliente = $this->pedido_model->carregar_endereco($cod_id/*, $opcao_cliente*/);
			echo "<div class='info-endereco' style='width:360px'>".
				 "Endereço: ".$endereco_cliente['endereco']."<br>".
				 "Bairro: ".$endereco_cliente['bairro']."<br>".
				 "Estado: ".$endereco_cliente['estado']."<br>".
				 "Cidade: ".$endereco_cliente['cidade']."<br>".
				 "Cep: ".$endereco_cliente['cep']."<br>".
				 "</div>";
	}
	
	function apagar_endereco()
	{
		echo " ";	
	}

	function carregar_variedade()
	{
		$cod_cultura = $this->input->post('cultura');		
		if($cod_cultura !='0' && $cod_cultura != ' '){
			$lista_variedade = $this->pedido_model->carregar_variedade($cod_cultura);
			$cod_var = $this->input->post('variedade');

			echo "<option value='0'>Escolha uma opção</option>";
			foreach ($lista_variedade as $cod => $nome_variedade){
				if($cod == $cod_var){
					echo "<option value='$cod' selected>".$nome_variedade."</option>";
				}else{
					echo "<option value='$cod'>".$nome_variedade."</option>";
				}	
			}
		}			
	}

	function carregar_cliente()
	{
		$tipo_cliente = $this->input->post('tipo_cliente');
		$cod_cliente = $this->input->post('cod_cliente');
		
		if($tipo_cliente !='0' && $tipo_cliente != '')
		{
			$check_pf = ($tipo_cliente == 'fisica') ? 't' : 'f'; 
			$lista_cliente = $this->pedido_model->carregar_cliente($check_pf);
						
			echo "<option value='0'>Escolha uma opção</option>";
			foreach ($lista_cliente as $id_clifor => $nome_rsocial){
				if($id_clifor == $cod_cliente){
					echo "<option value='$id_clifor' selected>".$nome_rsocial."</option>";
				}else{
					echo "<option value='$id_clifor'>".$nome_rsocial."</option>";
				}
			}
		}
	}
	
	
	function carregar_cidades()
	{
		$estado = $this->input->post('estado');
		if($estado !='0' && $estado != ''){
			$lista_cidades = $this->pedido_model->carregar_cidades($estado);
			$nome_cidade = $this->input->post('cidade');
	
			echo "<option value='0'>Escolha uma opção</option>";
			foreach ($lista_cidades as $cidade){
				if($cidade == $nome_cidade){
					echo "<option value='$cidade' selected>".$cidade."</option>";
				}else{
				echo "<option value='$cidade'>".$cidade."</option>";
				}
				}
		}
	}
	
	
	function carregar_datas()
	{
		$qtde_entrega = $this->input->post('qtde_entrega');
		//$cod_cliente = $this->input->post('cod_cliente');
		if($qtde_entrega !='0' && $qtde_entrega != '')
		{	
			//echo "<table>";		
					//echo "<tr>";
						for ($i=1; $i<=$qtde_entrega; $i++){
							$valor = set_value("data_entrega[$i]");
							if($i<10){
								echo "<label><small>&nbsp 0".$i."º entrega &nbsp</small></label>";
							}else{
								echo "<label><small>&nbsp ".$i."º entrega &nbsp</small></label>";
							}			
							echo "<input type='text' class='form-control' style='margin-top:2px;' 
													 size='8' name='data_entrega['$i']' id='data_entrega[1]' value='$valor'>";
							//echo "&nbsp";	
							if($i==3 || $i==6 || $i==9 || $i==12 || $i==15 || $i==18 || $i==21 || $i==24 || $i==27 ){
								echo "<br>";
							}	
							//echo "<td>$input[$i] </td>";							
						}
					//echo "</tr>";
				//echo "</table>";
		}else{
			echo " ";
		}
	}
	
	function check_cod_cliente($cod_cliente){
		if($cod_cliente == '0'){
			$this->form_validation->set_message('check_cod_cliente', 'Cliente não foi preenchido');
			return false;
		}else{
			return true;
		}
	}
	
	function check_cultura($cultura){
		if($cultura == '0'){
			$this->form_validation->set_message('check_cultura', 'Cultura não foi preenchido');
			return false;
		}else{
			return true;
		}
	}
	
	function check_variedade($variedade){
		if($variedade == '0'){
			$this->form_validation->set_message('check_variedade', 'Variedade não foi preenchido');
			return false;
		}else{
			return true;
		}
	}
	
	function check_qtde_pedido($quantidade){
		if($quantidade==''){
			$this->form_validation->set_message('check_qtde_pedido', 'Qtde vazio');
			return false;
		}else{
			return $this->valid_vl_numerico($quantidade, 'check_qtde_pedido');
		}
	}
	
	function check_vl_muda($quantidade){
		if($quantidade==''){
			$this->form_validation->set_message('check_vl_muda', 'Valor da muda vazio');
			return false;
		}else{
			return $this->valid_vl_numerico($quantidade, 'check_vl_muda');
		}
	}
	
	function valid_vl_numerico($quantidade, $nome_funcao){
		if(is_numeric($quantidade))
		{
			if($quantidade==0){
				$this->form_validation->set_message($nome_funcao, 'Digite um número válido');
				return false;
			}else{
				switch ($nome_funcao)
				{
					case 'check_vl_muda':
						return (strpos($quantidade,'.')!= false ) ? true : true;
					break;
						
					case 'check_qtde_pedido':
						if(strpos($quantidade,'.') === false){
							return true;
						}else{
							$this->form_validation->set_message($nome_funcao, 'Somente números');
							return false;
						}
					break;
				}
			}

// 			else if(strpos($quantidade,'.') === false){
// 					return true;
// 				}else{
// 					$this->form_validation->set_message($nome_funcao, 'Somente números');
// 					return false;
// 			}
		}
		else{
			$this->form_validation->set_message($nome_funcao, 'Somente números');
			return false;
		}
	}
	
	function check_data_pedido($data_pedido){
		if($data_pedido == ''){
			$this->form_validation->set_message('check_data_pedido', 'Data do pedido vazio');
			return false;
		}else{
			return true;
		}
	}
	
	function check_vazio($valor, $campo){
		if($valor == ''){
			$this->form_validation->set_message('check_vazio', "$campo vazio");
			return false;
		}else{
			return true;
		}
	}
	
	function check_qtde_entrega($qtde_entrega){
		if($qtde_entrega == '0'){
			$this->form_validation->set_message('check_qtde_entrega', 'Quantidade de entregas vazio');
			return false;
		}else{
			return true;
		}
	}
	
	function check_box_datas(){
		$qtde_entregas = $this->input->post('qtde_entrega');
		$data_entrega = $this->input->post('data_entrega');
		$qtde_ent_parcial = $this->input->post('qtde_ent_parcial');
		
		if($qtde_entregas!="0")
		{
			for($i=1;$i<=$qtde_entregas;$i++)
			{
				if($data_entrega[$i]=='' || $qtde_ent_parcial[$i]==''){
					$this->form_validation->set_message('check_box_datas', 'Existem datas ou Qtde de entregas vazios');
					$retorno=false;
					break;
				}else{
					$retorno=true;
				}
			}
			return $retorno;
		}
		
	}
	
	function check_total_pedido(){
		$qtde_entregas = $this->input->post('qtde_entrega');
		$qtde_pedido = $this->input->post('qtde_pedido');
		$qtde_ent_parcial = $this->input->post('qtde_ent_parcial');
		$soma_qtde_parcial=0;
		for($i=1;$i<=$qtde_entregas;$i++){
			$soma_qtde_parcial += $qtde_ent_parcial[$i];
		}
		if($soma_qtde_parcial>$qtde_pedido){
			$this->form_validation->set_message('check_total_pedido', 'Obs: A soma das Qtde parciais é maior que Qtde total do pedido.');
			return false;
		}else if($soma_qtde_parcial<$qtde_pedido){
			$this->form_validation->set_message('check_total_pedido', 'Obs: A soma das Qtde parciais é menor que Qtde total do pedido.');
			return false;
		}else{
			return true;
		}
	}
	
	function check_endereco($endereco){
		$check_endereco = $this->input->post('check_endereco');
		if($endereco == '' && $check_endereco =='end_novo'){
			$this->form_validation->set_message('check_endereco', 'Campo endereco vazio');
			return false;
		}else{
			return true;
		}
	}
	
	function check_bairro($bairro){
		$check_endereco = $this->input->post('check_endereco');
		if($bairro == '' && $check_endereco =='end_novo'){
			$this->form_validation->set_message('check_bairro', 'Campo bairro vazio');
			return false;
		}else{
			return true;
		}
	}
	
	function check_cep($cep){
		$check_endereco = $this->input->post('check_endereco');
		if($cep == '' && $check_endereco =='end_novo'){
			$this->form_validation->set_message('check_cep', 'Campo Cep vazio');
			return false;
		}else{
			return true;
		}
	}
	
	function check_estado($estado){
		$check_endereco = $this->input->post('check_endereco');
		if($estado =='0' && $check_endereco =='end_novo'){
			$this->form_validation->set_message('check_estado', 'O campo Estado não foi preenchido.');
			return false;
		}
		else{
			return true;
		}
	}
	
	function check_cidade($cidade){
		$check_endereco = $this->input->post('check_endereco');
		if($cidade =='0' && $check_endereco =='end_novo'){
			$this->form_validation->set_message('check_cidade', 'O campo Cidade não foi preenchido.');
			return false;
		}
		else{
			return true;
		}
	}
	
	function check_fase_muda($fase_muda){
		if($fase_muda == '0'){
			$this->form_validation->set_message('check_fase_muda', 'Fase para entrega não foi preenchido');
			return false;
		}else{
			return true;
		}
	}
	
	function check_campo_pesquisa($pesquisa)
	{
		$tipo_pesquisa = $this->input->post('selec_pesq');
		if($pesquisa == ''){
			$this->form_validation->set_message('check_campo_pesquisa', 'Campo pesquisa está vazio');
			return false;
		}else if($tipo_pesquisa == '0'){
			$this->form_validation->set_message('check_campo_pesquisa', 'Selecione uma opção para pesquisa');
			return false;
		}else{
			switch ($tipo_pesquisa)
			{
				case 'cliente':	
					$retorno = (is_numeric($pesquisa)) ? true : false;
					(!$retorno) ? $retorno = true : $this->form_validation->set_message('check_campo_pesquisa', 'Cliente não exste, digite somente texto');
					break;
				
				case 'pedido':
					$retorno = (is_numeric($pesquisa)) ? true : false;
					($retorno) ? $retorno = true : $this->form_validation->set_message('check_campo_pesquisa', 'Pedido não exste, digite somente números');
					break;
			}
			return $retorno;
		}
	}
	
	
}//fim da class


