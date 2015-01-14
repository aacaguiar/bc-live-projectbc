<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
class Menu 
{
	function menu_pedido($permissao)
	{
		$cadastrar = "<li> <a href=".base_url('pedido/cadastrar_pedido')."> <span> Cadastrar </span> </a> </li>";
		$consultar = "<li> <a href=".base_url('pedido/listar_pedido')."> <span> Consultar </span> </a> </li>";
		
		switch ($permissao)
		{
			case 1: $pedido = $cadastrar.$consultar; break;	
			case 2: $pedido = $cadastrar.$consultar; break;
			case 3: $pedido = $cadastrar.$consultar; break;
			case 4: $pedido = $cadastrar.$consultar; break;
			case 5:	$pedido = $cadastrar.$consultar; break;	
			case 6: $pedido = $consultar; break;
		}
	
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Pedido <b class='caret'> </b>
												</a> <ul class='dropdown-menu'>".$pedido."</ul>
						  </li>";
	}
	
	function menu_cliente($permissao)
	{		
		$cadastrar = "<li> <a href=".base_url('cliente/cadastrar_cliente')."> <span> Novo </span> </a> </li>";
		$pessoa_fisica = "<li> <a href=".base_url('cliente/consultar_cliente/fisica')."> <span>Consultar Pes.Física</span> </a> </li>";
		$pessoa_juridica = "<li> <a href=".base_url('cliente/consultar_cliente/juridica')."> <span>Consultar Pes.Jurídica</span> </a> </li>";				 			 					
		
		switch ($permissao)
		{
			case 1: $cliente = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;	
			case 2: $cliente = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;
			case 3:	$cliente = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;
			case 4:	$cliente = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;
			case 5: $cliente = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;
			case 6: $cliente = $pessoa_fisica.$pessoa_juridica; break;
		}
	
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Cliente <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$cliente."</ul>
						 </li>";
	}
	
	function menu_fornecedor($permissao)
	{
		$cadastrar = "<li><a href=".base_url('fornecedor/cadastrar_fornecedor')."> <span> Novo </span></a> </li>";
		$pessoa_fisica = "<li> <a href=".base_url('fornecedor/consultar_fornecedor/fisica')."> <span>Consultar Pes.Física</span> </a> </li>";
		$pessoa_juridica = "<li> <a href=".base_url('fornecedor/consultar_fornecedor/juridica')."> <span>Consultar Pes.Jurídica</span> </a> </li>";
	
		switch ($permissao)
		{
			case 1: $fornecedor = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;				
			case 2: $fornecedor = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;
			case 3: $fornecedor = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;		
			case 4:$fornecedor = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;	 	
			case 5: $fornecedor = "$cadastrar"."$pessoa_fisica"."$pessoa_juridica"; break;			
			case 6: $fornecedor = $pessoa_fisica.$pessoa_juridica; break;
		}
	
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Fornecedor <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$fornecedor."</ul>
						 </li>";
	}

	function menu_cultura($permissao)
	{
	
		$cadastrar_cult = "<li> <a href=".base_url('cultura/cadastrar_cultura')."> <span> Cadastrar Cultura </span></a> </li>";
		$consultar_cult = "<li> <a href=".base_url('cultura/consultar_cultura')."> <span> Consultar Cultura </span></a> </li>";
		$cadastrar_var = "<li> <a href=".base_url('cultura/cadastrar_variedade')."> <span> Cadastrar Variedade</span></a> </li>";
		$consultar_var = "<li> <a href=".base_url('cultura/consultar_variedade')."> <span> Consultar Variedade. </span> </a> </li>";
	
		switch ($permissao)
		{
			case 1: $cultura = $cadastrar_cult.$consultar_cult.$cadastrar_var.$consultar_var; break;		
			case 2: $cultura = $cadastrar_cult.$consultar_cult.$cadastrar_var.$consultar_var; break;
			case 3: $cultura = $cadastrar_cult.$consultar_cult.$cadastrar_var.$consultar_var; break;				
			case 4: $cultura = $cadastrar_cult.$consultar_cult.$cadastrar_var.$consultar_var; break;			
			case 5: $cultura = $cadastrar_cult.$consultar_cult.$cadastrar_var.$consultar_var; break;			
			case 6: $cultura = $consultar_var; break;
		}
	
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Produto <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$cultura."</ul>
						  </li>";
	}
	
	
	function menu_producao($permissao)
	{
		$planejamento = "<li> <a href=".base_url('producao/planejar_lote')."> <span> Planejamento do lote </span> </a> </li>";
		//$producao = "<li> <a href=".base_url('producao/controlar_producao')."> <span> Controle da produção </span></a> </li>";
		
		$control_producao  = "<li class='dropdown-submenu'> <a data-toggle='dropdown' href=''> Controle da produção </a>
							  	<ul class='dropdown-menu'>
									<li> <a href=".base_url('producao/cadastrar_controle_prod')."> <span> Cadastrar </span> </a> </li>
									<li> <a href=".base_url('producao/consultar_controle_prod')."> <span> Consultar </span> </a> </li>
									
							  	</ul>
							 </li>";
		
		$lote  = "<li class='dropdown-submenu'> <a data-toggle='dropdown' href=''> Lotes </a>
				  	<ul class='dropdown-menu'>
						<li> <a href=".base_url('lote/cadastrar_lote')."> <span> Cadastrar Lote</span> </a> </li>
						<li> <a href=".base_url('lote/consultar_lote')."> <span> Consultar Lote</span> </a> </li>
						<li> <a href=".base_url('lote/controlar_lote')."> <span> Controle do Lote</span> </a> </li>
				  	</ul>
				 </li>";
		
		$repicagem  = "<li class='dropdown-submenu'> <a data-toggle='dropdown' href=''> Repicagem </a>
						  	<ul class='dropdown-menu'>
								<li> <a href=".base_url('repicagem/indicador_prod_semanal')."> <span> Produção semanal </span> </a> </li>
								<li> <a href=".base_url('repicagem/indicador_prod_mensal')."> <span> Produção mensal </span> </a> </li>
								<li> <a href=".base_url('repicagem/cadastrar_repicador')."> <span> Cadastrar repicador(a) </span> </a> </li>
								<li> <a href=".base_url('repicagem/listar_repicadores')."> <span> Listar repicadores </span> </a> </li>
								<li> <a href=''> <span> Qualidade</span> </a> </li>
							</ul>
							
					  	 </li> ";
	
		$sala_crescimento = "<li> <a href=".base_url('lote/sala_crescimento')."> <span> Sala de crescimento </span> </a> </li>";		
		$meio_cultura = "<li> <a href=".base_url('lote/meio_cultura')."> <span> Meio de cultura </span> </a> </li>";	
		$fator_multiplicacao = "<li> <a href=".base_url('lote/fator_multiplicacao')."> <span> Fator multiplicação </span> </a> </li>";
				
		switch ($permissao)
		{
			case 1:	$producao = $planejamento.$control_producao.$lote.$repicagem.$sala_crescimento.$meio_cultura.$fator_multiplicacao; break;		
			case 2:	$producao = $planejamento.$control_producao.$lote.$repicagem.$sala_crescimento.$meio_cultura.$fator_multiplicacao; break;
			case 3:	$producao = $planejamento.$control_producao.$lote.$repicagem.$sala_crescimento.$meio_cultura.$fator_multiplicacao; break;		
			case 4:	$producao = $planejamento.$control_producao.$lote.$repicagem.$sala_crescimento.$meio_cultura.$fator_multiplicacao; break;		
			case 5:	$producao = $planejamento.$control_producao.$lote.$repicagem.$sala_crescimento.$meio_cultura.$fator_multiplicacao; break;		
			case 6: //$producao = $pesquisar; break;
		}
	
		//return $sub_menu="<li><a href='#'><img src='".base_url('imagens/icones/mixture.png')."' class='icone-menu'> <span>Produção</span></a><ul>".$producao."</ul></li>";
		  return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Produção <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$producao."</ul>
						  </li>";
	}
	
	
	function menu_entregas($permissao)
	{
		$consultar = "<li> <a href=". base_url('entregas/consultar_entrega')."> <span>Consultar</span></a> </li>";
			
		switch ($permissao) 
		{
			case 1 : $entregas = $consultar; break;	
			case 2 : $entregas = $consultar; break;
			case 3 : $entregas = $consultar; break;
			case 4 : $entregas = $consultar; break;
			case 5 : $entregas = $consultar; break;
			case 6 : $entregas = $consultar; break;
		}
	
		//return $sub_menu="<li><a href='#'> <img src='".base_url('imagens/icones/lorry_go.png')."' class='icone-menu'><span>Entregas</span></a><ul>".$entregas."</ul></li>";
		 return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Entregas <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$entregas."</ul>
						  </li>";
	
	}
	
	function menu_documentos($permissao)
	{
		$url = base_url();
	
		$etiquetas_ident_lotes = "<li> <a href='".$url."documentos/imprimir_etiq_ident_lotes'> <span> Etiquetas identif. Lotes </span> </a> </li>";
		$planilha_ident_lotes = "<li> <a href='".$url."documentos/imprimir_plan_ident_lotes'> <span> planilha ident. Lotes </span> </a> </li>";
		$tab_controle_estufas = "<li> <a href='".$url."documentos/imprimir_tab_controle_estufas'> <span> planilha ident. L </span> </a> </li>";
		
		switch ($permissao)
		{
			case 1:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;
			case 2:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;
			case 3:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;		
			case 4:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;		
			case 5:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;		
			case 6:$documento = $etiquetas_ident_lotes.$planilha_ident_lotes.$tab_controle_estufas; break;
		}
	
		//return $sub_menu="<li class='has-sub'><a href='#'> <img src='".base_url('imagens/icones/notepad-icon.png')."' class='icone-menu'> <span>Pedido</span></a><ul>".$pedido."</ul></li>";
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Documentos <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$documento."</ul>
						  </li>";
	}
	
	function menu_usuario($permissao) 
	{
		$url = base_url();
		
		$cadastrar = "<li> <a href=".base_url('usuario/cadastrar_usuario')."> <span>Cadastrar</span></a> </li>";
		$pesquisar = "<li> <a href=".base_url('usuario/pesquisar_usuario')."> <span>Pesquisar</span></a> </li>";
		$alterar = "<li> <a href=".base_url('usuario/alterar_senha_usuario')."> <span>Alterar Senha</span></a> </li>";
		
		switch ($permissao) 
		{
			case 1 : $usuario = $cadastrar . $pesquisar . $alterar; break;	
			case 2 : $usuario = $alterar; break;
			case 3 : $usuario = $alterar; break;
			case 4 : $usuario = $alterar; break;
			case 5 : $usuario = $alterar; break;
			case 6 : $usuario = $alterar; break;
		}

		//return $sub_menu="<li><a href='#'> <img src='".base_url('imagens/icones/users-go-icon.png')."' class='icone-menu' style='height:20px'> <span>Usuário</span></a><ul>".$usuario."</ul></li>";
		 return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Usuário <b class='caret'></b>		 
												</a> <ul class='dropdown-menu'>".$usuario."</ul>
						  </li>";
	}
	
	function menu_ajuda($permissao)
	{		
		$cultura_variedade = "<li><a href='' onClick=\"window.open('".base_url('ajuda/exibir_catalogo')."','','width=820,height=550')\">Cultura & Variedade</a> </li>";
		//$x = "<li><a href='' onClick=\"window.open('', 'new', 'width=300,height=150')\">Cultura & Variedade</a> </li>"; 
		//$pesquisar = "<li><a href='".$url."usuario/pesquisar_usuario'> <span>Pesquisar</span></a> </li>";
		//$alterar = "<li><a href='".$url."usuario/alterar_senha_usuario'> <span>Alterar Senha</span></a> </li>";
		
		switch ($permissao)
		{
			case 1: $ajuda = $cultura_variedade; break;			
			case 2: $ajuda = $cultura_variedade; break;	
			case 3: $ajuda = $cultura_variedade; break;		
			case 4: $ajuda = $cultura_variedade; break;		
			case 5: $ajuda = $cultura_variedade; break;	
			case 6: $ajuda = $cultura_variedade; break;
		}
		
		//return $sub_menu="<li><a href=''><span>Ajuda</span></a><ul>".$ajuda."</ul></li>";
		  return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Ajuda <b class='caret'></b>
												  </a> <ul class='dropdown-menu'>".$ajuda."</ul>
						  </li>";
	}
	
	function menu_contrato($permissao)
	{
		$enviar = "<li> <a href=".base_url('contrato/enviar_contrato')."> <span> Enviar contrato </span> </a> </li>";
		$listar = "<li> <a href=".base_url('contrato/exibir_contrato')."> <span> Exibir contratos </span> </a> </li>";
	
		switch ($permissao)
		{
			case 1: $contrato = $enviar.$listar; break;
			case 2: $contrato = $enviar.$listar; break;
			case 3: $contrato = $enviar.$listar; break;
			//case 4: $upload = $enviar.$listar; break;
			//case 5: $upload = $enviar.$listar; break;
			//case 6: $upload = $enviar.$listar; break;
			
		}
	
		//return $sub_menu="<li class='has-sub'><a href='#'> <img src='".base_url('imagens/icones/notepad-icon.png')."' class='icone-menu'> <span>Pedido</span></a><ul>".$pedido."</ul></li>";
		return $sub_menu="<li class='dropdown'> <a href='#' class='dropdown-toggle' data-toggle='dropdown'> Contratos <b class='caret'></b>
												</a> <ul class='dropdown-menu'>".$contrato."</ul>
						  </li>";
	}
	
	/*
	 * Permissões:
	* 1:Administrador
	* 2:Diretor
	* 3:Financeiro
	* 4:Supervisor
	* 5:Coordenador Técnico
	* 6:Coordenador de Produção
	*/
	
	function gerenciar_menu($permissao) 
	{
		switch ($permissao) 
		{
			case 1 :
				return  $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						$this->menu_cultura($permissao),
						$this->menu_producao($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_contrato($permissao),
						$this->menu_usuario($permissao)
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
						
						);
				break;
			case 2:
				return $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_contrato($permissao),
						$this->menu_usuario($permissao)
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
						
				);
				break;
			case 3:
				return $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						$this->menu_cultura($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_contrato($permissao),
						$this->menu_usuario($permissao)
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
						
						);
				break;
			case 4:
				return $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_usuario($permissao),
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
						);
				break;
			case 5:
				return $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_usuario($permissao),
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
						);
				break;
			case 6:
					return $menu_formatado = array (
						$this->menu_pedido($permissao),
						$this->menu_cliente($permissao),
						$this->menu_fornecedor($permissao),
						//$this->menu_rizoma($permissao),
						//$this->menu_subcultivo($permissao),
						$this->menu_entregas($permissao),
						$this->menu_usuario($permissao),
						//$this->menu_documentos($permissao),
						//$this->menu_ajuda($permissao),
					);
				break;
					
		}
	}
	
	
}//fim da class

?>

