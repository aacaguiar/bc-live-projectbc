<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lote extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('lote_model');
		$this->load->model('pedido_model');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->library('pagination');	
	}
	
	public function check_sessao()
	{
		$nome_usuario = $this->session->userdata('nome_usuario');
		$senha = $this->session->userdata('senha');
	
		if (! (empty ($nome_usuario) or empty ($senha)) )
		{
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	
	public function cadastrar_lote()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/lote/cadastro_lote.css');
			$lista_transportadora = $this->lote_model->listar_transportadora();
			$lista_fornecedor = $this->lote_model->listar_fornecedores();
			$lista_cultura = $this->lote_model->listar_cultura();
			$lista_pedido = $this->lote_model->listar_pedido();
			
			$dados = array(
					'transportadora' => $this->input->post('transportadora'),
					'fornecedor' => $this->input->post('fornecedor'),
					'cod_cultura' => $this->input->post('cultura'),
					'cod_variedade'=> $this->input->post('variedade'),
					'sel_posit'=> $this->input->post('sel_posit'),
				);
				
			$check_pedido = $this->input->post('check_pedido');
			if($check_pedido){
				$radio1 = true;
				$radio2 = false;
			}else{
				$radio1 = false;
				$radio2 = true;
			}
			
			$data = array(
					'nome_usuario'			=> $nome_usuario,
					'arquivo_css'			=> $arquivo_css,
					'lista_menu'			=> $lista_menu,
					'lista_transportadora'	=> $lista_transportadora,
					'lista_fornecedor'		=> $lista_fornecedor,
					'lista_cultura'			=> $lista_cultura,
					'lista_pedido'			=> $lista_pedido,
					'nome_transp'			=> $dados['transportadora'],
					'nome_fornec'			=> $dados['fornecedor'],
					'cod_cult_selec'		=> $dados['cod_cultura'],
					'sigla_nomeVar'			=> $dados['cod_variedade'],
					'sigla_nomeVar'			=> $dados['cod_variedade'],
					'sel_posit'				=> $dados['sel_posit'],
					'check_pedido'			=> $check_pedido,
					'num_pedido_selec'		=> $this->input->post('num_pedido'),
					'radio1' 				=> $radio1,
					'radio2' 				=> $radio2
				);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('lote/cadastrar_lote') != FALSE)
			{	
				
				$caractere = strpos($dados['fornecedor'],"-")+1;
				$dados['fornecedor'] = substr($dados['fornecedor'],$caractere);
				
				$caractere = strpos($dados['cod_variedade'],"-")+1;
				$dados['cod_variedade'] = substr($dados['cod_variedade'],$caractere);
				$dados['tipo_mat'] = $this->input->post('tipo_mat');
				$dados['sel_posit'] = $this->input->post('sel_posit');
				$dados['qtde_recebida'] = $this->input->post('quantidade');
				$dados['data_recebimento'] = $this->input->post('data_recebimento');
				$dados['num_lote'] = $this->input->post('lote');
				//$check_pedido = $this->input->post('check_pedido');
				$dados['cod_pedido'] = ($check_pedido) ? $this->input->post('num_pedido') : null ;
				$dados['lote_excluido'] = 'f';
				$dados['lote_concluido'] = 'f';
				$dados['descontaminacao'] = ' ';
				$dados['observacao'] = ' ';
				
				$dados_inseridos = $this->lote_model->cadastrar_lote($dados);
				$msg = ($dados_inseridos) ? "Lote cadastrada com sucesso" : "Erro ao cadastrar Lote";
				print "<script type='text/javascript'>
						 var msg = '$msg';
						 alert(msg);
					   </script>";
				redirect('../lote/cadastrar_lote', 'refresh');	
			}
			else
			{
				$this->load->view('templates/topo_view',$data);
				$this->load->view('lote/cadastro_lote_view');
				$this->load->view('templates/rodape_view');
			}		
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
	
	}//fim Cadastrar_lote
	
	
/*	
	function carregar_lote()
	{
		$fornec = $this->input->post('fonecedor');
		//$cult = $this->input->post('cultura');
		$var = $this->input->post('variedade');
		$ano = $this->input->post('ano');
		
		if($fornec !='0' && $cult != '0' && $var !='0'){
			
			$cod_fornec = $this->lote_model->carregar_codigo_fornec($fornec);
			//$sigla_var = $this->lote_model->carregar_codigo_fornec($fornec);

			echo "<option value='0'>Escolha uma opção</option>";
			foreach ($lista_variedade as $variedade){
				if($variedade == $var){
					echo "<option value='$variedade' selected>".$variedade."</option>";
				}else{
					echo "<option value='$variedade'>".$variedade."</option>";
				}	
			}
		}			
	}
*/	
	
	
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
		
	}//fim da paginação
		
	
	function pesquisar_lote()
	{
		$tipo_pesquisa = $this->input->post('selec_pesq');	
		$this->form_validation->set_error_delimiters('<div class="error">','</div>');
		
		if($this->form_validation->run('lote/pesquisar_lote') != FALSE){
			//pesquisa seletiva
			switch ($tipo_pesquisa){
				case 1: 
					$lote = $this->input->post('pesquisa'); $num_pedido=null; $variedade=null; break;
				case 2:  
					$num_pedido = $this->input->post('pesquisa'); $lote=null; $variedade=null; break;
				case 3:
					$variedade = $this->input->post('pesquisa'); $lote=null; $num_pedido=null; break;
			}	
			$this->consultar_lote($lote, $num_pedido, $variedade, $tipo_pesquisa);
		}else{
			$this->consultar_lote(null,null,null, $tipo_pesquisa);
		}
				
	}//fim do pesquisar lote
	
			
	function consultar_lote($lote=null, $num_pedido=null, $variedade=null, $tipo_pesquisa=null)
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{												
			//paginação
			$limite = 10;
			$inicio = ($this->uri->segment(3) !='') ? $this->uri->segment(3) : 0 ;
			$lista_lote = $this->lote_model->listar_lote( $limite, $inicio, $lote, $num_pedido, $variedade ,$tipo_pesquisa);
			$total_linhas = $this->lote_model->total_linhas_lote();
			$config = $this->paginacao(base_url('lote/consultar_lote/'), $limite, $total_linhas);
	
			$this->pagination->initialize($config);
	
			//cria variáveis
			$permissao 	  = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu   = $this->menu->gerenciar_menu($permissao);
			$arquivo_css  = base_url('css/lote/lista_lote.css');
	
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
					'lista_lote'	=> $lista_lote,
					'total_linhas'	=> $total_linhas,
					'pagination'	=> $this->pagination->create_links(),
					'inicio'		=> $inicio,
					'pag'			=> $pag,
					'total_pag'		=> $total_pag,
					'tipo_pesquisa' => $tipo_pesquisa,
			);
			
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('lote/lista_lote_view');
			$this->load->view ('templates/rodape_view');	
		}
		else
		{
			$this->load->view ( 'erro_acesso' );
		}
		
	}//consultar lote
	
	
	function alterar_lote()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/pedido/cadastro_pedido.css');
			$num_lote = $this->input->post('num_lote');
			$num_pedido = $this->input->post('num_pedido');
			
			if ($num_pedido != 0){
				$radio1 = true;
				$radio2 = false;
			}else{
				$radio1 = false;
				$radio2 = true;
			}
			
			$cod_var = $this->input->post('cod_variedade');
			$total_carac = strlen($num_lote);
			$total_carac_sigla = ($total_carac - 6);
			$siglaVar = substr($num_lote, 0, $total_carac_sigla )."-".$cod_var;
				
			$data = array(
					'nome_usuario' 			=> $nome_usuario,
					'arquivo_css' 			=> $arquivo_css,
					'lista_menu' 			=> $lista_menu,
					'cod_lote' 				=> $this->input->post('cod_lote'),
					'num_lote'	 			=> $num_lote,
					'num_pedido_selec' 		=> $num_pedido,
					'nome_transp' 			=> $this->input->post('transportadora'),
					'nome_fornec' 			=> $this->input->post('fornecedor'),
					'cod_cult_selec' 		=> $this->input->post('cod_cultura'),
					'sigla_nomeVar' 		=> $siglaVar,
					'tipo_mat' 				=> $this->input->post('tipo_mat'),
					'sel_posit' 			=> $this->input->post('sel_posit'),
					'qtde_recebida' 		=> $this->input->post('qtde_recebida'),
					'data_recebimento' 		=> $this->input->post('data_recebimento'),
					'lista_transportadora'  => $this->lote_model->listar_transportadora(),
					'lista_fornecedor' 		=> $this->lote_model->listar_fornecedores(),
					'lista_cultura' 		=> $this->lote_model->listar_cultura(),
					'lista_pedido' 			=> $this->lote_model->listar_pedido(),
					'radio1'				=> $radio1,
					'radio2'				=> $radio2
			);
			
			$this->load->view ('templates/topo_view',$data);
			$this->load->view ('lote/altera_lote_view');
			$this->load->view ('templates/rodape_view');	
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//fim alterar_lote
	
	
	
	public function alterar_dados_lote()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/pedido/cadastro_pedido.css');
			$lista_transportadora = $this->lote_model->listar_transportadora();
			$lista_fornecedor = $this->lote_model->listar_fornecedores();
			$lista_cultura = $this->lote_model->listar_cultura();
			$lista_pedido = $this->lote_model->listar_pedido();
					
			$num_lote = $this->input->post('num_lote');
			//$num_pedido = $this->input->post('num_pedido');
			$check_pedido = $this->input->post('check_pedido');
			
			if($check_pedido == true){
				$num_pedido = $this->input->post('num_pedido');
				$radio1 = true; //radio button label sim
				$radio2 = false; //radio button label não
			}else{
				$radio1 = false;
				$radio2 = true;
			}
			
			$var = $this->input->post('variedade');
			$siglaVar = substr($num_lote,6)."-".$var;
				
			$data = array(
					'nome_usuario' 			=> $nome_usuario,
					'arquivo_css' 			=> $arquivo_css,
					'lista_menu' 			=> $lista_menu,
					'cod_lote' 				=> $this->input->post('cod_lote'),
					'num_lote'	 			=> $num_lote,
					'num_pedido_selec' 		=> $num_pedido,
					'nome_transp' 			=> $this->input->post('transportadora'),
					'nome_fornec' 			=> $this->input->post('fornecedor'),
					'nome_cultura' 			=> $this->input->post('cultura'),
					'sigla_nomeVar' 		=> $siglaVar,
					'qtde_recebida' 		=> $this->input->post('qtde_recebida'),
					'data_recebimento' 		=> $this->input->post('data_recebimento'),
					'lista_transportadora'  => $this->lote_model->listar_transportadora(),
					'lista_fornecedor' 		=> $this->lote_model->listar_fornecedores(),
					'lista_cultura' 		=> $this->lote_model->listar_cultura(),
					'lista_pedido' 			=> $this->lote_model->listar_pedido(),
					'radio1'				=> $radio1,
					'radio2'				=> $radio2
			);
	
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('lote/alterar_dados_lote') != FALSE)
			{	
				$dados['cod_lote'] = $data['cod_lote'];
				$dados['transportadora'] = $data['nome_transp'];
				$dados['fornecedor'] = $data['nome_fornec'];
				$dados['cod_cultura'] = $data['nome_cultura'];
				//$dados['cod_variedade'] = $var;
				
				$caractere = strpos($dados['fornecedor'],"-")+1;
				$dados['fornecedor'] = substr($dados['fornecedor'],$caractere);
				
				$caractere = strpos($var,"-")+1;
				$dados['cod_variedade'] = substr($var,$caractere);
				
				$dados['qtde_recebida'] = $this->input->post('quantidade');
				$dados['data_recebimento'] = $this->input->post('data_recebimento');
				$dados['num_lote'] = $this->input->post('lote');
				$check_pedido = $this->input->post('check_pedido');
				$dados['cod_pedido'] = ($check_pedido) ? $num_pedido : null ;
				
				$dados_alterados = $this->lote_model->alterar_dados_lote($dados);
				$msg = ($dados_alterados) ? "Lote alterado com sucesso" : "Erro ao alterar Lote";
				print "<script type='text/javascript'>
						 var msg = '$msg';
						 alert(msg);
					   </script>";
				redirect('../lote/consultar_lote', 'refresh');	
			}
			else
			{
				$this->load->view('templates/topo_view',$data);
				$this->load->view('lote/altera_lote_view');
				$this->load->view('templates/rodape_view');
			}		
		}
		else
		{
			$this->load->view('erro_acesso');
		}
			
	}//fim da alterar_dados_lote
		

	function excluir_lote()
	{
		$cod_lote = $this->input->post('cod_lote');
		$dados_excluidos = $this->lote_model->excluir_lote($cod_lote);
		$msg = ($dados_excluidos) ? "Lote excluído com sucesso" : "Erro ao excluir Lote";
		print "<script type='text/javascript'> var msg = '$msg'; alert(msg); </script>";
		redirect('../lote/consultar_lote', 'refresh');
	}
	
	function redirecionar_controlar_lote()
	{
		$cultura = $this->input->post('cultura');
		$variedade = $this->input->post('variedade');
		$cod_lote = $this->input->post('cod_lote');
	
		$this->controlar_lote($cultura, $variedade, $cod_lote, null);
	}
	
	/*
	function redirecionar_gerenciar_lote()
	{
		$cultura = $this->input->post('cultura');
		$variedade = $this->input->post('variedade');
		$cod_lote = $this->input->post('cod_lote');
	
		//echo $cultura, $variedade, $cod_lote;
		$this->gerenciar_lote($cultura, $variedade, $cod_lote, null);
	}
	*/

	function gerar_pdf()
	{
		
	}
	
	function controlar_lote ($cultura = null, $variedade = null, $cod_lote = 0, $dados = null)
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao 		= $this->session->userdata('permissao');
			$nome_usuario 	= $this->session->userdata('nome_usuario');
			$lista_menu 	= $this->menu->gerenciar_menu($permissao);
			$arquivo_css 	= base_url('css/lote/controle_lote.css');
			$lista_cultura 	= $this->lote_model->listar_cultura();
			
			$fator_multiplicacao = array('isolamento'  =>'', 'transferencia1'=>'',	'transferencia2'=>'',	'transferencia3'=>'',	'subcultivo1'=>'',
										 'subcultivo2' =>'', 'subcultivo3'=>'',		'subcultivo4'=>'',		'subcultivo5'=>'',		'subcultivo6'=>'',
										 'subcultivo7' =>'', 'subcultivo8'=>'', 	'alongamento'=>'', 		'aplic_meio_liquido'=>'' );					
				
			$data = array(
					'nome_usuario' 	=>	$nome_usuario,
					'arquivo_css'	=> 	$arquivo_css,
					'lista_menu'	=> 	$lista_menu,
					'lista_cultura'	=> 	$lista_cultura,
					'fases_lote'	=>	0,
					'opcao_fase'	=>	'f',
					'dados'			=>	$dados,
					'fator_multiplicacao' => $fator_multiplicacao,
					'texto_descontaminacao' => '',
					'texto_observ' => '' 
			);
				
			$data['cod_cult_selec'] = ($cultura != null) ? $cultura : $this->input->post('cultura');
			$data['cod_var_selec'] 	= ($variedade != null) ? $variedade : $this->input->post('variedade');
			$data['cod_lote'] = ($cod_lote!=0) ? $cod_lote : $this->input->post('cod_lote');
				
			if($data['cod_lote'] != 0 && $data['cod_lote'] != '')
			{
				$fases_lote = $this->lote_model->listar_fase_lote($data['cod_lote']);
				$fator_multiplicacao = $this->lote_model->listar_fator_multiplicacao($data['cod_cult_selec'], $data['cod_var_selec']);
								
				$texto_descontaminacao = $this->lote_model->obter_texto_descontaminacao($data['cod_lote']);
				$texto_observ = $this->lote_model->obter_texto_observ($data['cod_lote']);
				
				$fase = array (	'isolamento'  => 'Isolamento', 	  'transferencia1' => '1º Transferência', 'transferencia2' => '2º Transferência', 'transferencia3' => '3º Transferência',
								'subcultivo1' => '1º Subcultivo', 'subcultivo2'	   => '2º Subcultivo', 	  'subcultivo3'    => '3º Subcultivo', 	  'subcultivo4'	   => '4º Subcultivo', 
								'subcultivo5' => '5º Subcultivo', 'subcultivo6'	   => '6º Subcultivo',	  'subcultivo7'    => '7º Subcultivo',    'subcultivo8'    => '8º Subcultivo', 	
								'alongamento' => 'Alongamento',   'aplic_meio_liquido' => 'Aplic. Meio Líq.'
							  );
				
				$concluido = array('t'=>'sim', 'f'=>'não');
				
				$prazo = array(20=>20, 28=>28, 30=>30);
					
				/* exibição das mensagens de erro */
				$campos = array ('fase' 		   => 'fase', 			 'num_entrada' 		=> 'num_entrada', 		'num_expl_trab'    => 'num_expl_trab', 	  'num_expl_prod'    => 'num_expl_prod',
								 'num_plan' 	   => 'num_plan',		 'taxa_mult'        => 'taxa_mult', 		'diferenca' 	   => 'diferenca', 		  'perda_fungo'      => 'perda_fungo',	  
								 'perda_bacteria'  => 'perda_bacteria',	 'perda_oxidacao'   => 'perda_oxidacao',    'perda_total' 	   => 'perda_total', 	  'pd_fungo_porcent' => 'pd_fungo_porcent', 
								 'pd_bact_porcent' => 'pd_bact_porcent', 'pd_oxid_porcent'  => 'pd_oxid_porcent',   'pd_total_porcent' => 'pd_total_porcent', 'data_entrada' 	 => 'data_entrada',    
								 'data_saida' 	   => 'data_saida', 	 'duracao'  		=> 'duracao',   		'prazo' 		   => 'prazo', 			  'dias_atrasados' 	 => 'dias_atrasados',
								 'concluido'	   => 'concluido'
								);
	
	
				$data['fase'] 		= $fase;
				$data['campos'] 	= $campos;
				$data['fases_lote'] = $fases_lote;
				$data['concluido'] 	= $concluido;
				$data['fator_multiplicacao'] = $fator_multiplicacao;
				$data['prazo'] = $prazo;
				$data['texto_descontaminacao'] = $texto_descontaminacao;
				$data['texto_observ'] = $texto_observ;
				}
	
				$this->load->view('templates/topo_view',$data);
				$this->load->view('lote/controle_lote_view');
				$this->load->view('templates/rodape_view');			
			}
			else
			{
				$this->load->view('erro_acesso');
			}
	
	}//fim do controlar lote
	
		
	function receber_dados_fase_lote()
	{
		
		$dados = array(
				/*'id_gerencia_fase' => $this->input->post('id_gerencia_fase'),*/
				'cod_lote' 			 => $this->input->post('lote'),
				'fase' 				 => $this->input->post('fase'),
				'num_entrada' 		 => $this->input->post('num_entrada'),
				'num_expl_trab' 	 => $this->input->post('num_expl_trab'),
				'num_expl_prod' 	 => $this->input->post('num_expl_prod'),
				'num_plan' 			 => $this->input->post('num_plan'),
				'taxa_mult' 		 => $this->input->post('taxa_mult'),
				'diferenca' 		 => $this->input->post('diferenca'),
				'perda_total' 		 => $this->input->post('perda_total'),
				'pd_total_porcent' 	 => $this->input->post('pd_total_porcent'),
				'data_entrada' 		 => $this->input->post('data_entrada'),
				'data_saida' 		 => $this->input->post('data_saida'),
				'duracao' 			 => $this->input->post('duracao'),
				'prazo' 			 => $this->input->post('prazo'),
				'dias_atrasados' 	 => $this->input->post('dias_atrasados'),
				'concluido' 		 => $this->input->post('concluido'),
				/*'repicador' 		 => $this->input->post('repicador')*/
		);
		
		$valor = $this->input->post('perda_fungo');
		$dados['perda_fungo'] = (empty($valor)) ? 0 : $valor; 
		
		$valor = $this->input->post('perda_bacteria');
		$dados['perda_bacteria'] = (empty($valor)) ? 0 : $valor;
			
		$valor = $this->input->post('perda_oxidacao');
		$dados['perda_oxidacao'] = (empty($valor)) ? 0 : $valor;
		
		$valor = $this->input->post('pd_fungo_porcent');
		if (empty($valor)) {
			$dados['pd_fungo_porcent'] = 0.00;
		}else{
			$indice_final = strlen($valor)-1; //recupera o total de caracteres
			$dados['pd_fungo_porcent'] = substr($valor, 0, $indice_final); //recorta a string sem o %
		}
		
		$valor = $this->input->post('pd_bact_porcent');
		if (empty($valor)) {
			$dados['pd_bact_porcent'] = 0.00;
		}else{
			$indice_final = strlen($valor)-1; //recupera o total de caracteres
			$dados['pd_bact_porcent'] = substr($valor, 0, $indice_final); //recorta a string sem o %
		}
		
		$valor = $this->input->post('pd_oxid_porcent');
		if (empty($valor)) {
			$dados['pd_oxid_porcent'] = 0.00;
		}else{
			$indice_final = strlen($valor)-1; //recupera o total de caracteres
			$dados['pd_oxid_porcent'] = substr($valor, 0, $indice_final); //recorta a string sem o %
		}
	
		$valor = $this->input->post('pd_total_porcent');
		if ($valor == 0) {
			$dados['pd_total_porcent'] = 0.00;
		}else{
			$indice_final = strlen($valor)-1; //recupera o total de caracteres
			$dados['pd_total_porcent'] = substr($valor, 0, $indice_final); //recorta a string sem o %
		}
				
 		//echo "<pre>";
 		//print_r($dados);
 		//echo "</pre>";
		return $dados;
	}
	
	function cadastrar_fase_lote()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$cultura = $this->input->post('c');
			$variedade = $this->input->post('v');
			$cod_lote = $this->input->post('l');
			
			$dados = $this->receber_dados_fase_lote();
						
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('lote/cadastrar_fase_lote') != FALSE)
			{			
				$dados_inseridos = $this->lote_model->cadastrar_fase_lote($dados);
				$msg = ($dados_inseridos) ? "Fase do Lote cadastrada com sucesso" : "Erro ao cadastrar Fase do Lote";
				print "<script type='text/javascript'>
				var msg = '$msg';
				alert(msg);
				</script>";
				//redirect('../lote/gerenciar_lote', 'refresh');
				$this->controlar_lote();
			}
			else
			{
				$this->controlar_lote($cultura, $variedade, $cod_lote, $dados);
			}
		}
		else
		{
			$this->load->view('erro_acesso');
		}
		
	}//fim da cadastrar_fase_lote
		
	
	function atualizar_fase_lote()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$cultura = $this->input->post('c');
			$variedade = $this->input->post('v');
			$cod_lote = $this->input->post('l');
			
			$dados = $this->receber_dados_fase_lote();
			$dados['id_controle_lote'] = $this->input->post('id_fase');		
			
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			if($this->form_validation->run('lote/cadastrar_fase_lote') != FALSE)
			{
				$dados_atualizados = $this->lote_model->atualizar_fase_lote($dados);
				$msg = ($dados_atualizados) ? "Fase do Lote alterada com sucesso" : "Erro ao alterar Fase do Lote";
				print "<script type='text/javascript'>
				var msg = '$msg';
				alert(msg);
				</script>";
				//redirect('../lote/gerenciar_lote', 'refresh');
				$this->controlar_lote();
			}
			else
			{	
				$this->controlar_lote($cultura, $variedade, $cod_lote);
			}
		}
		else
		{
			$this->load->view('erro_acesso');
		}	
	}
	
	function atualizar_observ_lote()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$cod_lote = $this->input->post('cod_lote');
			$texto_observ = $this->input->post('texto_observ');
				
			$retorno = $this->lote_model->atualizar_observ_lote($cod_lote,$texto_observ);
			$msg = ($retorno) ? "Observação sobre o Lote atualizada com sucesso" : "Erro ao atualizar observação sobre o Lote";
			//$dados = array('msg'=>$msg, 'texto_observ'=>$texto_observ);
			//echo json_encode($dados); //passa variáveis em json no formato {'msg': $msg, 'texto_observ': $texto_observ}
			echo $msg;
			
		}
		else{
			$this->load->view('erro_acesso');
		}
	}
		
	function atualizar_descontam_lote()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$cod_lote = $this->input->post('cod_lote');
			$texto_descontam = $this->input->post('texto_descontam');
			
			$retorno = $this->lote_model->atualizar_texto_descontam($cod_lote,$texto_descontam);				
			$msg = ($retorno) ? "Informação de descontaminação atualizada com sucesso" : "Erro ao atualizar informação de descontaminação";
			//$dados = array('msg'=>$msg, 'texto_descontam'=>$texto_descontam);
			//echo json_encode($dados); //passa variáveis em json no formato {'msg': $msg, 'texto_descontam': $texto_descontam}
			echo $msg;
			//echo $outra_variavel; //passando se necessário um 2º parâmetro para função de callback do jquery
		}
		else
		{
			$this->load->view('erro_acesso');
		}	
	}
	
	/*
	 * Carrega variedades da view Cadastro do Lote
	 */
	function carregar_variedade()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != '')
		{
			$lista_variedade = $this->lote_model->carregar_variedade($cod_cultura);
			$sigla_variedade_selec = $this->input->post('sigla_nomeVar');
	
			echo "<option value=''>Escolha uma opção</option>";
			foreach ($lista_variedade as $sigla_variedade => $variedade)
			{	
				if($sigla_variedade_selec == $sigla_variedade){
					echo "<option value='$sigla_variedade' selected>".$variedade."</option>";
				}
				else{
					echo "<option value='$sigla_variedade'>".$variedade."</option>";
				}
			}
		}
	}
	
	/*
	 * Carrega variedades da view Controle do Lote
	 */
	function carregar_var_controle_lote()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != '')
		{
			$lista_variedade = $this->lote_model->carregar_var_controle_lote($cod_cultura);
			$cod_var_selec = $this->input->post('cod_variedade'); /* $varieade_selec é varidade selecionada */
	
			echo "<option value=''>Escolha uma opção</option>";
			foreach ($lista_variedade as $cod_variedade => $nome_variedade) /* $chave é também nome da variedade */
			{
				if($cod_var_selec == $cod_variedade){
					echo "<option value='$cod_variedade' selected>".$nome_variedade."</option>";
				}
				else{
					echo "<option value='$cod_variedade'>".$nome_variedade."</option>";
				}
			}	
		}	
	}
	
	function carregar_lotes()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != ' '){
			$cod_variedade = $this->input->post('cod_variedade');
			
			$cod_lote_selec = $this->input->post('cod_lote');
			$lista_lote = $this->lote_model->carregar_lotes($cod_cultura, $cod_variedade);
			
			echo "<option value=''> Escolha uma opção</option>";
			foreach ($lista_lote as $cod_lote => $num_lote)
			{
				if($cod_lote == $cod_lote_selec){
					echo "<option value='$cod_lote' selected>".$num_lote."</option>";
				}else{
					echo "<option value='$cod_lote'>".$num_lote."</option>";
				}
			}	
		}
	}

	function check_campo_pesquisa($pesquisa)
	{
		$tipo_pesquisa = $this->input->post('selec_pesq');
		if($pesquisa == ''){
			$this->form_validation->set_message('check_campo_pesquisa', 'Campo pesquisa está vazio');
			return false;
		}else if($tipo_pesquisa == ''){
			$this->form_validation->set_message('check_campo_pesquisa', 'Selecione uma opção para pesquisa');
			return false;
		}else{
			return true;
		}
	}
	
// 	function check_transportadora($transportadora)
// 	{
// 		if($transportadora == '0'){
// 			$this->form_validation->set_message('check_transportadora', 'O campo transportadora não foi preenchido');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_fornecedor($fornecedor)
// 	{
// 		if($fornecedor == '0'){
// 			$this->form_validation->set_message('check_fornecedor', 'O campo Fornecedor não foi preenchido');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_cultura($cultura)
// 	{
// 		if($cultura == '0'){
// 			$this->form_validation->set_message('check_cultura', 'O campo Cultura não foi preenchido');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_variedade($variedade)
// 	{
// 		if($variedade == '0'){
// 			$this->form_validation->set_message('check_variedade', 'O campo Variedade não foi preenchido');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_quantidade($quantidade)
// 	{
// 		if($quantidade == ''){
// 			$this->form_validation->set_message('check_quantidade', 'Qtde vazio');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_data($data){
// 		if($data == ''){
// 			$this->form_validation->set_message('check_data', 'Data vazia');
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
		
// 	function check_data_lote($data, $nome_campo)
// 	{
// 		if($data == ''){
// 			$this->form_validation->set_message('check_data_lote', "O campo: <font color=''>$nome_campo</font> não foi preenchido");
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}
	
// 	function check_selecao_lote($opcao, $nome_campo)
// 	{
// 		if($opcao == ''){
// 			$this->form_validation->set_message('check_selecao_lote', "O campo: <font color=''> $nome_campo </font> não foi preenchido");
// 			return false;
// 		}else{
// 			return true;
// 		}
// 	}

	function check_sel_posit($valor, $nome_campo)
	{
		if($valor != 't' && $valor !='f'){
			$this->form_validation->set_message('check_sel_posit', "$nome_campo não foi preenchido");
			return false;
		}else{
			return true; //$this->check_campo_numerico($valor, $nome_campo);
		}
	}
	
	
	function check_campo_vazio($valor, $nome_campo)
	{	
		if($valor == '' || $valor == '0' ){
			$this->form_validation->set_message('check_campo_vazio', "$nome_campo não foi preenchido");
			return false;
		}else{
			 return true; //$this->check_campo_numerico($valor, $nome_campo);
		}
	}
	
	function check_campo_numerico($valor, $nome_campo)
	{
		if(!is_numeric($valor)){
			$this->form_validation->set_message('check_campo_numerico', "$nome_campo aceita somente números");
			return false;
		}else{
			return true;
		}
	}
	
	
}//fim da class








