<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Producao extends CI_Controller
{
	public static $filtros_selecao;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('producao_model');
		$this->load->model('cultura_model');
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

	function obter_cod_fase_fator()
	{
		$this->input->post('fase');
		$cod_fase_fator = $this->producao_model->obter_cod_fase_fator();
	}
	
	//obter campos do formulário cadastro controle da prod
	function obter_campos($campos_form = array())
	{
		foreach ($campos_form as $valor){
			$dados[$valor] = $this->input->post($valor);
		}
		return $dados;
	}
	
	function cadastrar_controle_prod()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_repic = $this->producao_model->listar_repicador();
			$lista_cultura = $this->producao_model->listar_cultura();
			$fase_controle_prod = $this->producao_model->listar_fase();
			$arquivo_css = base_url('css/producao/cadastro_cont_prod.css');
			
			//$num_semana = date("W", strtotime( date("m/d/Y")) );//ex: semana 30
			//semana
			$num_semana = date("W", strtotime(date("m/d/Y"))); //retorna o número da semana
			if(date("m")==12 && $num_semana == 01 )
			{
				$semana1 = 1;  
				$ano_prox = date("Y")+1;  
				$dia_anterior = date("d");
				while($num_semana == 01)
				{
					$dia_anterior--;
					//retorna o número da semana com um dia anterior até achar o maior nº da semana diferente de 01
					$num_semana = date("W", strtotime(date("m/$dia_anterior/Y")));
					$dia_sem1 = $dia_anterior+1;
				}
			}
			
			$data = array(
					'nome_usuario'   => $nome_usuario,
					'lista_menu' 	 => $lista_menu,
					'arquivo_css' 	 => $arquivo_css,
					'num_semana' 	 => $num_semana,
					'ano'			 => date("Y"),
					'lista_cultura'  => $lista_cultura,
					/*'lista_fase'	 => $lista_fase,*/
					'lista_repic'	 => $lista_repic,
					'lista_fase'	 => $fase_controle_prod['lista_fase'],
					'cod_fase_fator' => $fase_controle_prod['cod_fase_fator'],
					'semana1'			=> (isset($semana1)) ? $semana1 : 0,
					'ano_prox'			=> (isset($ano_prox)) ? $ano_prox : 0,
					'dia_sem1'			=> (isset($dia_sem1)) ? $dia_sem1 : 0,
			);
			
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run('producao/cadastrar_info_lote') != FALSE)
			{
				$campos = array('ano',				  'semana', 		 'cod_cultura',			 'cod_variedade',		 'cod_lote',
				 /*et-anterior*/'cod_repic_ant',	  'data_anterior',   'num_expl_prod',		 'pd_fungo',			 'pd_bacteria',	 'pd_oxidacao',	
								'total_perdas',	  	  'num_fr_trab', 	 'num_expl_fr_trab', 	 'num_total_expl_trab',  'tamanho_expl', 'contaminacao', 'tipo_meio',          
					/*et-atual*/'cod_repic_atual', 	  'data_atual',	 	 'num_pote_prod', 	 	 'num_expl_pote', 	 	 'subtotal1',	 'num_fr_prod',  'num_expl_fr',
								'subtotal2',	  	  'num_quebrado',    'total_expl_prod',		 'id_fase',				 'pontos_repic'
								);
				
				$dados = $this->obter_campos($campos);
				
				//formatando a data dos campos data_anterior e data_atual
				$dados['data_anterior'] = str_replace("/", "-", $dados['data_anterior']);
				$dados['data_atual'] = str_replace("/", "-", $dados['data_atual']);
				
				//inserindo no banco de dados
				$dados_inseridos = $this->producao_model->cadastrar_controle_prod($dados);
				$msg = ($dados_inseridos) ? "Cadastrado com sucesso" : "Erro ao cadastrar etapa de produção";
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
				
				redirect('../producao/cadastrar_controle_prod', 'refresh');								
// 				echo "<pre>";
// 				echo print_r($dados);
// 				echo "</pre>";
	
			}
			else 
			{
				//obtém os dados e retorna para a view, se não houver campo vazio;
				$data['cod_cult_selec'] = $this->input->post('cod_cultura');
				$data['cod_var_selec'] = $this->input->post('cod_variedade');
				$data['cod_lote_selec'] = $this->input->post('cod_lote');
			
				$data['num_sem_selec'] = $this->input->post('num_sem_selec');
				$data['cod_repic_ant'] = $this->input->post('cod_repic_ant');
				$data['cod_repic_atual'] = $this->input->post('cod_repic_selec');
				
				//campos chaves. Não são inseridos no banco.
				$data['campo_oculto'] = 1;
				$data['metodo'] = 'cadastrar';
				$data['id'] = 1;
			
				$this->load->view ('templates/topo_view',$data);
				$this->load->view ('producao/cadastrar_controle_prod_view');
				$this->load->view ('templates/rodape_view');
			}
								
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
		
	}
	
	
	function paginacao($url, $limite, $total_linhas)
	{
		//paginação
		$config['base_url'] = $url;/*endereço base*/
		$config['total_rows'] = $total_linhas;/*nº linhas paginadas*/
		$config['per_page'] = $limite;/*registros por página*/
		$config['num_links'] = 5;
	
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li> <a href="'.$url.'">';
		$config['cur_tag_close'] = '</a></li>';
			
		$config['prev_link'] = '&laquo;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '&raquo;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
	
		return $config;
	}
		
	
	function consultar_controle_prod($ano=0, $sem=0)
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			//ano
			if( $this->input->post('filt_ano') != '' ){
				$filtros['filt_ano'] = $this->input->post('filt_ano');
			}else{
				if($ano !='' && $ano>0){
					$filtros['filt_ano'] = $ano;
				}else{
					$filtros['filt_ano'] = date("Y");
				}
			}
				
			//semana
			$num_semana = date("W", strtotime(date("m/d/Y"))); //retorna o número da semana
			if(date("m")==12 && $num_semana == 01 )
			{
				$semana1 = 1;  $ano_prox = date("Y")+1;  $dia_anterior = date("d");
				while($num_semana == 01)
				{
					$dia_anterior--;
					//retorna o número da semana com um dia anterior até achar o maior nº da semana diferente de 01
					$num_semana = date("W", strtotime(date("m/$dia_anterior/Y")));
					$filtros['filt_sem'] = $num_semana;
					$dia_sem1 = $dia_anterior+1;
				}
			}
			
			// verifica se o campo select semana foi modificado ou se nº da semana foi passado por parâmetro na url
			if( $this->input->post('filt_sem') != '' )
			{
				$filtros['filt_sem'] = $this->input->post('filt_sem');	
			}
			else if($sem !='' && $sem>0)
			{
				$filtros['filt_sem'] = $sem;
			}
			

			//paginação
			//$config['base_url'] = base_url('producao/consultar_controle_prod/'.$ano.'/'.$sem);
			$config['uri_segment'] = 5;
			$config['base_url'] = base_url('producao/consultar_controle_prod/'.$filtros['filt_ano'].'/'.$filtros['filt_sem']);
			$config['total_rows'] = $this->producao_model->total_linhas_controle_prod($filtros['filt_ano'], $filtros['filt_sem']);
			$config['per_page'] = 20; //qtde de registros por página
			$qtde = $config['per_page'];
			
			//altera o início da paginação se o form for submetido
			if( $this->input->post('filt_sem') != ''){
				$inicio = 0;
			}else{
				$inicio = ( $this->uri->segment(5) !='') ? $this->uri->segment(5) : 0 ;
			}
			
	
			$this->pagination->initialize($config);
				
			//variáveis de sessão
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/producao/consultar_cont_prod.css');
			$lista_cultura = $this->producao_model->listar_cultura();
			 
			//enumera as linhas e o total de páginas
			$inicio;
			if($inicio<20){
				$pag=1;
			}else{
				$pag=(int)($inicio/20);
				$pag++;
			}
			
			$total_linhas = $config['total_rows'];
			$total_pag = ($total_linhas<20) ? 1 : ($total_linhas/20);
			$total_pag = (is_float($total_pag)) ? (int)++$total_pag : $total_pag;
		
			//variáveis de dados
			$data = array(
					'nome_usuario' 		=> $nome_usuario,
					'arquivo_css'		=> $arquivo_css,
					'lista_menu'		=> $lista_menu,
					'num_semana' 		=> date("W", strtotime(date("m/d/Y")) ),
					'info_lote'			=> $this->producao_model->listar_controle_prod($qtde, $inicio, $filtros),
					'pagination'		=> $this->pagination->create_links(),
					'ano'				=> $filtros['filt_ano'],
					'semana_selec'		=> $filtros['filt_sem'],
					'num_sem' 			=> $num_semana,
					'linhas'			=> $config['total_rows'],
					'lista_cultura'		=> $lista_cultura,
					'inicio'			=> $inicio,
					'pag'				=> $pag,
					'total_pag'			=> $total_pag,
					'total_linhas'		=> $total_linhas,
					'semana1'			=> (isset($semana1)) ? $semana1 : 0,
					'ano_prox'			=> (isset($ano_prox)) ? $ano_prox : 0,
					'dia_sem1'			=> (isset($dia_sem1)) ? $dia_sem1 : 0,
					
			);
	
			$this->load->view('templates/topo_view',$data);
			$this->load->view('producao/consultar_controle_prod_view');
			$this->load->view('templates/rodape_view');
		}
		else
		{
			$this->load->view('erro_acesso');
		}
	}
	
	
	
	function alterar_controle_prod()
	{
		$retorno = $this->check_sessao();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$lista_repic = $this->producao_model->listar_repicador();
			$lista_cultura = $this->producao_model->listar_cultura();
			$arquivo_css = base_url('css/producao/cadastro_cont_prod.css');
			$fase_controle_prod = $this->producao_model->listar_fase();
			
			//semana
			$num_semana = date("W", strtotime(date("m/d/Y"))); //retorna o número da semana
			if(date("m")==12 && $num_semana == 01 )
			{
				$semana1 = 1;
			 	$ano_prox = date("Y")+1;
			 	$dia_anterior = date("d");
				while($num_semana == 01)
				{
					$dia_anterior--;
					$num_semana = date("W", strtotime(date("m/$dia_anterior/Y")));
					$filtros['filt_sem'] = $num_semana;
					$dia_sem1 = $dia_anterior+1;
				}
			}

			$data = array(
					'id'			 => $this->input->post('id'),
					'ano' 			 => $this->input->post('ano'),
					'cod_cult_selec' => $this->input->post('cod_cultura'),
					'cod_var_selec'  => $this->input->post('cod_variedade'),
					'cod_lote_selec' => $this->input->post('cod_lote'),
					'nome_usuario' 	 => $nome_usuario,
					'lista_menu' 	 => $lista_menu,
					'arquivo_css' 	 => $arquivo_css,
					'num_semana'	 => $num_semana,
					'lista_cultura'  => $lista_cultura,
					'lista_repic'	 => $lista_repic,
					'lista_fase'	 => $fase_controle_prod['lista_fase'],
					'cod_fase_fator' => $fase_controle_prod['cod_fase_fator'],
			);			

			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if($this->form_validation->run('producao/cadastrar_info_lote') != FALSE)
			{
				$campos = array('id', 'ano',			  'semana', 		 'cod_cultura',			 'cod_variedade',		 'cod_lote',
					/*et-anterior*/	  'cod_repic_ant',	  'data_anterior',   'num_expl_prod',		 'pd_fungo',			 'pd_bacteria',	 'pd_oxidacao',
									  'total_perdas',	  'num_fr_trab', 	 'num_expl_fr_trab', 	 'num_total_expl_trab',  'tamanho_expl', 'contaminacao', 'tipo_meio',
					/*et-atual*/	  'cod_repic_atual',  'data_atual',	 	 'num_pote_prod', 	 	 'num_expl_pote', 	 	 'subtotal1',	 'num_fr_prod',  'num_expl_fr',
									  'subtotal2',	  	  'num_quebrado',    'total_expl_prod',		 'id_fase',				 'pontos_repic'
				);
								
				$dados = $this->obter_campos($campos);
				
				//formatando a data dos campos data_anterior e data_atual
				$dados['data_anterior'] = str_replace("/", "-", $dados['data_anterior']);
				$dados['data_atual'] = str_replace("/", "-", $dados['data_atual']);
				
				$dados_inseridos = $this->producao_model->alterar_controle_prod($dados);
				$msg = ($dados_inseridos) ? 'Informações alterada com sucesso!' : 'Erro ao alterar o Informações';
				print "<script type=\"text/javascript\"> alert('$msg'); </script>";
				redirect('../producao/consultar_controle_prod/', 'refresh');
			}
			else 
			{
				//campos chaves
				$data['campo_oculto'] = 1;
				$data['metodo'] = 'alterar';
				
				//os campos do form na view consultar são passados via post automaticamente para view cadastrar controle prod
				$this->load->view('templates/topo_view', $data);
				$this->load->view('producao/cadastrar_controle_prod_view');
				$this->load->view('templates/rodape_view');
			}
				
// 			$this->load->view('templates/topo_view',$data);
// 			$this->load->view('producao/altera_controle_prod_view');
// 			$this->load->view('templates/rodape_view');
			
		}
		else
		{
			$this->load->view ('erro_acesso');
		}
	
	}//fim alterar_pedido
	
	
	function excluir_controle_prod()
	{
		$id = $this->input->post('id');
		$dados_excluídos = $this->producao_model->excluir_controle_prod($id);
		
		$msg = ($dados_excluídos) ? "Dados do Controle da produção excluídos com sucesso" : "Erro ao excluir dados do controle da produção";
		print "<script type=\"text/javascript\"> alert('$msg'); </script>";
		
 		$ano = $this->input->post('filt_ano');
 		$sem = $this->input->post('filt_sem');
 		//$cult = $this->input->post('filt_cult');
 		//$var = $this->input->post('filt_var');
// 		$lote = $this->input->post('cod_lote');
		
		redirect('../producao/consultar_controle_prod', 'refresh');
		
	}
		
	/*
	 * Funções anterior para controlar produção
	 */
// 	function controlar_producao($filtros=null, $info_lote=array(), $campos=null, $dados=null)
// 	{
// 		$retorno = $this->check_sessao();
// 		if ($retorno)
// 		{
// 			$permissao = $this->session->userdata('permissao');
// 			$nome_usuario = $this->session->userdata('nome_usuario');
// 			$lista_menu = $this->menu->gerenciar_menu($permissao);
// 			$arquivo_css = base_url('css/producao/controle_producao.css');
// 			$lista_cultura = $this->producao_model->listar_cultura();
// 			$lista_variedade = $this->producao_model->listar_variedade();
// 			$lista_lote = $this->producao_model->listar_lote();
// 			$lista_repic = $this->producao_model->listar_repicador();
			
// 			$data_atual = date("m/d/Y"); //mês, dia, ano
// 			$num_semana = date("W", strtotime($data_atual));//ex: semana 30
			
// 			$data = array(
// 					'nome_usuario' 		=> $nome_usuario,
// 					'arquivo_css'		=> $arquivo_css,
// 					'lista_menu'		=> $lista_menu,
// 					'lista_cultura'		=> $lista_cultura,
// 					'lista_variedade'	=> $lista_variedade,
// 					'lista_lote'		=> $lista_lote,
// 					'num_semana' 		=> $num_semana,
// 					'semana_selec'		=> $filtros['filt_sem'],/* filtrar os dados */
// 					'cult_selec'		=> $filtros['filt_cult'],/* filtrar os dados */
// 					'var_selec'			=> $filtros['filt_var'],/* filtrar os dados */
// 					'lote_selec'		=> $filtros['filt_lote'],/* filtrar os dados */
// 					'lista_repic'		=> $lista_repic,
// 					'campos'			=> $campos,
// 				);
			
// 			//$data['info_lote'] = ($info_lote != null) ? $info_lote : null;
// 			$data['info_lote'] = (empty($info_lote)) ? array() : $info_lote;
// 			$data['ano'] = ($filtros['filt_ano']!=null && $filtros['filt_ano']!='') ? $filtros['filt_ano'] : date("Y");
// 			$data['dados'] = ($dados != null) ? $dados : null;
						
// 			$this->load->view('templates/topo_view',$data);
// 			$this->load->view('producao/controle_producao_view');
// 			$this->load->view('templates/rodape_view');
// 		}
// 		else
// 		{
// 			$this->load->view('erro_acesso');
// 		}
// 	}

	
// 	//tela antiga controle da produção
// 	function obter_campos_filtros($campos_filtros = array())
// 	{
// 		foreach ($campos_filtros as $valor){
// 			$campos[$valor] = $this->input->post($valor);
// 		}
// 		return $campos;
// 	}
		
	
// 	//tela antiga controle da produção
// 	function listar_controle_producao($campos=null, $dados=null)
// 	{
// 		$retorno = $this->check_sessao();
// 		if ($retorno)
// 		{	
// 			$campos_filtros = array('filt_ano', 'filt_sem', 'filt_cult', 'filt_var', 'filt_lote');
// 			$filtros_selecionados = $this->obter_campos( $campos_filtros );
			
// 			//if($filtros['filt_sem']!=0 || $filtros['filt_cult']!=0 || $filtros['variedade']!=0)
// 			//{
// 				$info_lote = $this->producao_model->listar_info_lote( $filtros_selecionados );
// 				$this->controlar_producao( $filtros_selecionados, $info_lote, $campos, $dados );
				
// 			//}else{
// 			//	redirect(base_url('producao/controlar_producao'));
// 				//$this->controlar_producao();
// 			//}	
// 		}
// 		else
// 		{
// 			$this->load->view('erro_acesso');
// 		}
			
// 	}//fim do controlar produção semana
	
	
// 	function cadastrar_controle_prod()
// 	{
// 		$retorno = $this->check_sessao ();
// 		if ($retorno)
// 		{	
// 			$campos = array('ano',				  'semana', 		 'cod_cultura',			 'cod_variedade',		 'cod_lote',
// 			 /*et-anterior*/'cod_repic_et_ant',	  'data_anterior',   'num_expl_prod',		 'pd_fungo',			 'pd_bacteria',	 'pd_oxidacao',	
// 							'total_perda',	  	  'num_frasco_trab', 'num_expl_frasco_trab', 'num_total_expl_trab',  'tamanho_expl', 'contaminacao', 'tipo_meio',          
// 				/*et-atual*/'cod_repic_et_atual', 'data_atual',	 	 'num_frasco_pote_prod', 'num_expl_frasco_pote', 'subtotal1',	 'total_frasco_pote_prod', 
// 							'subtotal2',	  	  'num_quebrado',    'total_expl_prod'
// 			);

// 			$dados = $this->obter_campos($campos);
			
// 			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
// 			if($this->form_validation->run('producao/cadastrar_controle_prod')!= FALSE)
// 			{	
// // 				$dados_inseridos = $this->producao_model->cadastrar_controle_prod($dados);
// // 				$msg = ($dados_inseridos) ? "Cadastrado com sucesso" : "Erro ao cadastrar etapa de produção";
// // 				print "<script type='text/javascript'>
// // 				var msg = '$msg';
// // 				alert(msg);
// // 				</script>";
// // 				//redirect('../lote/gerenciar_lote', 'refresh');
// // 				$this->listar_controle_producao(null, null);
								
// 			}else{
				
// 				//redirect(base_url('producao/controlar_producao'));
// 				$this->listar_controle_producao($campos, $dados);
// 				//echo "não passou";
// 			}
// 		}else{
// 			$this->load->view('erro_acesso');
// 		}
// 	}
	
	
	/*
	 * Carrega variedades da view Controle da Produção
	*/
// 	function carregar_variedade()
// 	{	
// 		//echo "<option value='asdasdad'> asdasdsa </option>";
// 		$cod_cultura = $this->input->post('cod_cultura');
				
// 		if($cod_cultura !='0' && $cod_cultura != ''){
// 			$lista_variedade = $this->producao_model->carregar_variedade($cod_cultura);
// 			$cod_var = $this->input->post('cod_variedade');

// 			echo "<option value='0'>Escolha uma opção</option>";
// 			foreach ($lista_variedade as $cod => $nome_variedade){
// 				if($cod == $cod_var){
// 					echo "<option value='$cod' selected>".$nome_variedade."</option>";
// 				}else{
// 					echo "<option value='$cod'>".$nome_variedade."</option>";
// 				}	
// 			}
// 		}			
// 	}
	
	
	//chamada via javascript
	function carregar_variedade()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != '')
		{
			$lista_variedade = $this->producao_model->carregar_variedade($cod_cultura);
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
	
	//chamada via jquery, teste
	function carregar_var_jquery()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != '')
		{
			$lista_variedade = $this->producao_model->carregar_variedade($cod_cultura);
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
	
	//chamada via javascript
	function carregar_lotes()
	{
		$cod_cultura = $this->input->post('cod_cultura');
		if($cod_cultura !='0' && $cod_cultura != ' '){
			$cod_variedade = $this->input->post('cod_variedade');
				
			$cod_lote_selec = $this->input->post('cod_lote');
			$lista_lote = $this->producao_model->carregar_lotes($cod_cultura, $cod_variedade);
				
			echo "<option value=''> Escolha uma opção </option>";
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
	
	
	//validações
	function check_campo_vazio($valor, $nome_campo)
	{
		if($valor == ''){
			$this->form_validation->set_message('check_campo_vazio', "Erro: <font color='000'> $nome_campo </font> não foi preenchido");
			return false;
		}else{
			return true; //$this->check_campo_numerico($valor, $nome_campo);
		}
	}
	
	function check_campo_numerico($valor, $nome_campo)
	{
		if(!is_numeric($valor)){
			$this->form_validation->set_message('check_campo_numerico', "O campo: <font color='000'> $nome_campo </font> aceita somente números");
			return false;
		}else{
			return true;
		}
	}
	
	function check_selecao($opcao, $nome_campo)
	{
		if($opcao == 0){
			$this->form_validation->set_message('check_selecao', "O campo: <font color='000'> $nome_campo </font> não foi preenchido");
			return false;
		}else{
			return true;
		}
	}
	
		
	
	
}//fim da class




