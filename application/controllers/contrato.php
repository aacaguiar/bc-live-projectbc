<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrato extends CI_Controller
{
	var $nome_mes;
	var $ano;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('session');
		$this->load->library('menu');
		$this->load->library('encrypt');
		$this->load->library('form_validation');
		//$this->load->library('upload');
		$this->load->model('contrato_model');
		
		setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese"); //configura data no formato brasileiro
		$this->nome_mes = strftime( "%B", strtotime(date('F')) ); //obtém o nome do mês corrente.
		$this->ano = date("Y");
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
	
	
	public function enviar_contrato($erro = '')
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/contrato/contrato.css');
	
			$data = array(
					'nome_usuario' 	=> $nome_usuario,
					'arquivo_css'	=> $arquivo_css,
					'lista_menu'	=> $lista_menu
			);
			
			
			if ($this->nome_mes == utf8_decode('março')){
				$this->nome_mes = 'marco';
			}
		
			if( !file_exists(getcwd().'\files_upload\contratos\\'.$this->ano) ){
										
				mkdir(getcwd().'\files_upload\contratos\\'.$this->ano);
				mkdir(getcwd().'\files_upload\contratos\\'.$this->ano.'\\'.$this->nome_mes);
				
			}else if( !file_exists(getcwd().'\files_upload\contratos\\'.$this->ano.'\\'.$this->nome_mes) ){
				mkdir(getcwd().'\files_upload\contratos\\'.$this->ano.'\\'.$this->nome_mes);
			}
			
			$data['erro'] = ($erro) ? $erro : ''; //verifica se $erro == ''
			$this->load->view('templates/topo_view', $data);
			$this->load->view('contrato/upload_contrato_view');
			$this->load->view('templates/rodape_view');
			
		}
		else
		{
			$this->load->view('erro_acesso');
		}
	}
	
	/*
	 * Evitando que o arquivo seja renomeado
	 * alterado a função _prep_filename na library Upload.php
	 * retirado o underscore $filename .= '.'.$part.'_'; p/ $filename .= '.'.$part;
	*/
	public function salvar_contrato()
	{
		$config['upload_path'] = getcwd().'\files_upload\contratos\\'.$this->ano.'\\'.$this->nome_mes;
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '2048';
		$config['max_width']  = '0';
		$config['max_height']  = '0';
	
		$this->load->library('upload', $config);
	
		$nome_arq_orig =  $_FILES['arquivo_cont']['name']; //obtém nome do arquivo
		$nome_arq_format =  str_replace(' ', '_', $nome_arq_orig); //substitui espaços p/ _ no nome do arquivo
		
		if($nome_arq_orig == '')
		{
			$erro = "O arquivo não foi selecionado";
			$this->enviar_contrato($erro);
		}
		else 
		{
			if( $_FILES['arquivo_cont']['size'] == 0 ) //obtém o tamanho do arquivo e retorna zero se for maior que 2mb - php.ini
			{
				$erro = "O arquivo : <font color='black'> $nome_arq_orig </font> excede o tamanho máximo para envio que é de 2mb";
				$this->enviar_contrato($erro);
			}
			else
			{
				if (file_exists( $config['upload_path'].'\\'.$nome_arq_format )) 
				{
					$erro = "Já existe um arquivo com esse nome : <font color='black'> $nome_arq_orig </font>"; //Renomeie o arquivo e tente novamente.";
					$this->enviar_contrato($erro);
				}
				else
				{
					$this->upload->do_upload('arquivo_cont');
					print "<script type=\"text/javascript\"> alert('Contrato enviado com sucesso'); </script>";
					redirect('../contrato/enviar_contrato/', 'refresh');
				}
			}	
		}
		
	}//fim da função salvar_contrato
	
	public function obter_arquivos($ano)
	{
	
		$nome_mes = array('janeiro','fevereiro','marco','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
		array_unshift($nome_mes,0);//coloca 0 no índice 0;
		
		//se ano for atual recebe nº do mês atual se não recebe 12
		$total_meses = ( $ano == date("Y") ) ? date('n') : 12 ;
		
		for($i=1; $i <= $total_meses; $i++)
		{		
			//verifica se existe o dir ano e o dir nome do mês(janeiro, fevereiro etc).
			if ( file_exists(getcwd().'\files_upload\contratos\\'.$ano.'\\'.$nome_mes[$i]) )
			{
				/*
				 * Obtém o path do caminho: diretório ano\nome do mês
				 * Faz um loop para obter a lista dos nomes dos arquivos somente nessa pasta do mês
				 */ 
				$diretorio = dir( getcwd().'\files_upload\contratos\\'.$ano.'\\'.$nome_mes[$i]);
				
				//echo $nome_mes[$i];echo "<br>";
				$dir_nome_mes[$i] = array();
				while($arquivo = $diretorio->read())
				{
					if($arquivo != '.' && $arquivo !='..')
					{
						array_push($dir_nome_mes[$i], $arquivo);
					}
				}
					$diretorio->close();
			}
			else
			{
				$dir_nome_mes[$i] = array();//echo utf8_decode("diretório não existe $nome_mes[$i]");
				//echo "<br>";
			}		
		}
		
		//print_r($pasta_mes);
		return $dir_nome_mes;
				
	}
	
	public function exibir_contrato()
	{
		$retorno = $this->check_sessao ();
		if ($retorno)
		{
			$permissao = $this->session->userdata('permissao');
			$nome_usuario = $this->session->userdata('nome_usuario');
			$lista_menu = $this->menu->gerenciar_menu($permissao);
			$arquivo_css = base_url('css/contrato/contrato.css');
	
			$data = array(
					'nome_usuario' 	=> $nome_usuario,
					'arquivo_css'	=> $arquivo_css,
					'lista_menu'	=> $lista_menu
			);
			
			$this->form_validation->set_error_delimiters('<div class="error">','</div>');
			
			if( $this->form_validation->run('contrato/exibir_contrato') != FALSE ){				
				
				$data['ano'] = $this->input->post('ano');
				echo $data['ano'];
			}else{
				//verifica se ano é vazio ao iniciar função, se sim, pega ano atual
				$data['ano'] = date("Y");
			}	
									
				$data['dir_nome_mes'] = $this->obter_arquivos( $data['ano'] );
				$data['num_mes'] = ( $data['ano'] == date("Y") ) ? date("n") : 12 ;
				
				$nome_mes = array('janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
				array_unshift($nome_mes,0);//coloca 0 no índice 0;
				$data['nome_mes'] = $nome_mes;
				
				$this->load->view('templates/topo_view', $data);
				$this->load->view('contrato/contrato_view');
				$this->load->view('templates/rodape_view');	
		}
		else
		{
			$this->load->view('erro_acesso');
		}
	}
	
	
	function carregar_contrato()
	{
		$meses_ano = array('janeiro','fevereiro','março','abril','maio','junho','julho','agosto','setembro','outubro','novembro','dezembro');
		array_unshift($meses_ano,0); //coloca 0 no índice 0;
		
		//obtém o nº do mês-nomeDoArquivo no formato ex: 1-nomeDoArquivo e converte para um array separando mês do arquivo
		$id = explode('-', $this->input->post('id')); 
		$ano = $this->input->post('ano');
		
		$nome_mes = $meses_ano[$id[0]]; //$id[0] obtém o número do mês
		$arquivo = $id[1]; //$id[1] obtém o nome do arquivo.
				
		$data = array(
			'url' => "http://10.1.1.90/bioclone/files_upload/contratos/$ano/$nome_mes/$arquivo"	
		);
		
		echo $this->load->view('contrato/abrir_contrato', $data);
		
	}
	
	
	function check_ano($ano)
	{	
		if($ano == ''){
			$this->form_validation->set_message('check_ano', 'Digite o ano para pesquisar');
			return false;
		}else {
			return true;
		}
	}
	
		
}//fim da class





