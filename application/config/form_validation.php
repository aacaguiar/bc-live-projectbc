<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
		/*PEDIDO*/
		'pedido/cadastrar_pedido' => array(
				array('field' => 'cod_cliente',		'label' => '',	'rules' => 'trim|callback_check_cod_cliente'),
				array('field' => 'cultura',			'label' => '',	'rules' => 'trim|callback_check_cultura'),
				array('field' => 'variedade',		'label' => '',	'rules' => 'trim|callback_check_variedade'),
				array('field' => 'fase_muda',		'label' => '',	'rules' => 'trim|callback_check_fase_muda'),
				array('field' => 'qtde_pedido',		'label' => '',	'rules' => 'trim|callback_check_qtde_pedido'),
				array('field' => 'vl_muda',			'label' => '',	'rules' => 'trim|callback_check_vl_muda'),
				array('field' => 'forma_pagto',		'label' => '',	'rules' => 'trim|callback_check_vazio[Forma pagto]'),
				array('field' => 'data_pedido',		'label' => '',	'rules' => 'trim|callback_check_data_pedido'),
				array('field' => 'frq_entrega',		'label' => '',	'rules' => 'trim|callback_check_vazio[Freq. de Entrega]'),
				array('field' => 'qtde_entrega',	'label' => '',	'rules' => 'trim|callback_check_qtde_entrega'),
				array('field' => 'data_entrega',	'label' => '',	'rules' => 'callback_check_box_datas|callback_check_total_pedido'),
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim|callback_check_endereco'),
				//array('field' => 'bairro',		'label' => '',	'rules' => 'trim|callback_check_bairro'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_check_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_check_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim|callback_check_cep'),
				array('field' => 'tipo_cliente',	'label' => '',	'rules' => 'trim'),	
		),
		'pedido/alterar_dados_pedido' => array(
				array('field' => 'cod_cliente',		'label' => '',	'rules' => 'trim|callback_check_cod_cliente'),
				array('field' => 'cultura',			'label' => '',	'rules' => 'trim|callback_check_cultura'),
				array('field' => 'variedade',		'label' => '',	'rules' => 'trim|callback_check_variedade'),
				array('field' => 'fase_muda',		'label' => '',	'rules' => 'trim|callback_check_fase_muda'),
				array('field' => 'qtde_pedido',		'label' => '',	'rules' => 'trim|callback_check_qtde_pedido'),
				array('field' => 'vl_muda',			'label' => '',	'rules' => 'trim|callback_check_vl_muda'),
				array('field' => 'data_pedido',		'label' => '',	'rules' => 'trim|callback_check_data_pedido'),
				array('field' => 'frq_entrega',		'label' => '',	'rules' => 'trim|callback_check_frq_entrega'),
				array('field' => 'qtde_entrega',	'label' => '',	'rules' => 'trim|callback_check_qtde_entrega'),
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim|callback_check_endereco'),
				//array('field' => 'bairro',		'label' => '',	'rules' => 'trim|callback_check_bairro'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_check_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_check_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim|callback_check_cep'),
				array('field' => 'tipo_cliente',	'label' => '',	'rules' => 'trim'),
		),
		'pedido/pesquisar_pedido' => array(
				array('field' => 'pesquisa',		'label' => '',	'rules' => 'trim|callback_check_campo_pesquisa'),
				//array('field' => 'selec_pesq',		'label' => '',	'rules' => ''),
		),
		/*LOGIN*/
		'login/verificar_login' => array(
				array('field' => 'usuario',		'label' => 'Usuário',	'rules' => 'trim|callback_verifica_usuario'),
				array('field' => 'senha',		'label' => 'Senha',		'rules' => 'trim|callback_verifica_senha')
		),
		'login/redefinir_senha' => array(
				array('field' => 'usuario',		'label' => 'Usuário',	'rules' => 'trim|callback_verifica_usuario'),
				/*array('field' => 'senha',		'label' => 'Senha',		'rules' => 'trim|callback_verifica_senha')*/
		),
		/*USUÁRIO*/
		'usuario/cadastrar_usuario' => array(
				array('field' => 'nome',		'label' => 'Nome',		'rules' => 'trim'),
				array('field' => 'login',		'label' => 'Login',		'rules' => 'trim|callback_verifica_usuario'),
				array('field' => 'senha',		'label' => 'Senha',		'rules' => 'trim|'),
				array('field' => 'email',		'label' => 'Email',		'rules' => 'trim|valid_email'),
				array('field' => 'permissao',	'label' => 'Permissao',	'rules' => 'trim|callback_verifica_escolha_permissao')
		),
		'usuario/alterar_dados_usuario' => array(
				array('field' => 'nome',	'label' => 'Nome',	'rules' => 'trim'),
				array('field' => 'login',	'label' => 'Login',	'rules' => 'trim|callback_verifica_usuario'),
				array('field' => 'senha',	'label' => 'Senha',	'rules' => 'trim'),
				array('field' => 'email',	'label' => 'Email',	'rules' => 'trim|valid_email')
		),
		'usuario/alterar_senha_usuario' => array(
				array('field' => 'senha_atual',		'label' => '',	'rules' => 'trim|callback_verifica_senha_existe' ),
				array('field' => 'nova_senha',		'label' => '',	'rules' => 'trim'),
				array('field' => 'confirma_senha',	'label' => '',	'rules' => 'trim|callback_confirma_senha'),
				
		),
		/*CLIENTE*/
		'cliente/cadastrar_cliente' => array(
				array('field' => 'tipo_cliente',	'label' => '',	'rules' => 'trim|callback_validar_tipo_cliente'),
				array('field' => 'cod_fornecedor',	'label' => '',	'rules' => 'trim'),
				array('field' => 'check_fornecedor','label' => '',	'rules' => 'trim'),
				array('field' => 'nome_rsocial',	'label' => '',	'rules' => 'trim|callback_check_nome_cliente'),
				array('field' => 'cpf_cnpj',		'label' => '',	'rules' => 'trim|callback_valida_cpf_cnpj'),
				/*array('field' => 'razao_social',	'label' => '',	'rules' => 'trim|callback_check_razao_social'),*/
				/*array('field' => 'contato',		'label' => '',	'rules' => 'trim|callback_check_contato'),*/
				/*array('field' => 'cnpj',			'label' => '',	'rules' => 'trim|callback_valida_cnpj'),*/
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim'),
				array('field' => 'bairro',			'label' => '',	'rules' => 'trim'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_validar_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_validar_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim'),
				array('field' => 'fone_residencial','label' => '',	'rules' => 'trim'),
				array('field' => 'fone_celular',	'label' => '',	'rules' => 'trim'),
				array('field' => 'municipio',		'label' => '',	'rules' => 'trim'),
				array('field' => 'email',			'label' => '',	'rules' => 'trim'),	
		),
		'cliente/alterar_dados_cliente' => array(
				//array('field' => 'tipo_cliente',	'label' => '',	'rules' => 'trim|callback_validar_tipo_cliente'),
				array('field' => 'cod_fornecedor',	'label' => '',	'rules' => 'trim'),
				array('field' => 'check_fornecedor','label' => '',	'rules' => 'trim'),
				array('field' => 'nome_rsocial',	'label' => '',	'rules' => 'trim|callback_check_nome_cliente'),
				array('field' => 'cpf_cnpj',		'label' => '',	'rules' => 'trim|callback_valida_cpf_cnpj'),
				/*array('field' => 'razao_social',	'label' => '',	'rules' => 'trim|callback_check_razao_social'),*/
				//array('field' => 'contato',		'label' => '',	'rules' => 'trim|callback_check_contato'),
				/*array('field' => 'cnpj',			'label' => '',	'rules' => 'trim|callback_valida_cpf_cnpj'),*/
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim'),
				array('field' => 'bairro',			'label' => '',	'rules' => 'trim'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_validar_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_validar_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim'),
				array('field' => 'fone_residencial','label' => '',	'rules' => 'trim'),
				array('field' => 'fone_celular',	'label' => '',	'rules' => 'trim'),
				array('field' => 'municipio',		'label' => '',	'rules' => 'trim'),
				array('field' => 'email',			'label' => '',	'rules' => 'trim'),
		),
		/*FORNECEDOR*/
		'fornecedor/cadastrar_fornecedor' => array(
				array('field' => 'tipo_fornecedor',	'label' => '',	'rules' => 'trim|callback_validar_tipo_fornecedor'),
				/*array('field' => 'nome',			'label' => '',	'rules' => 'trim|callback_check_nome_fornecedor'),
				array('field' => 'cpf',				'label' => '',	'rules' => 'trim|callback_valida_cpf'),
				array('field' => 'razao_social',	'label' => '',	'rules' => 'trim|callback_check_razao_social'),*/
				array('field' => 'nome_rsocial',	'label' => '',	'rules' => 'trim|callback_check_nome_fornecedor'),
				array('field' => 'cpf_cnpj',		'label' => '',	'rules' => 'trim|callback_valida_cpf_cnpj'),
				//array('field' => 'contato',		'label' => '',	'rules' => 'trim|callback_check_contato'),
				/*array('field' => 'cnpj',			'label' => '',	'rules' => 'trim|callback_valida_cnpj'),*/
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim'),
				array('field' => 'bairro',			'label' => '',	'rules' => 'trim'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_validar_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_validar_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim'),
				array('field' => 'fone_residencial','label' => '',	'rules' => 'trim'),
				array('field' => 'fone_celular',	'label' => '',	'rules' => 'trim'),
				array('field' => 'municipio',		'label' => '',	'rules' => 'trim'),
				array('field' => 'email',			'label' => '',	'rules' => 'trim'),
		),
		'fornecedor/alterar_dados_fornecedor' => array(
				array('field' => 'tipo_fornecedor',	'label' => '',	'rules' => 'trim|callback_validar_tipo_fornecedor'),
				/*array('field' => 'nome',			'label' => '',	'rules' => 'trim|callback_check_nome_fornecedor'),
				array('field' => 'cpf',				'label' => '',	'rules' => 'trim|callback_valida_cpf'),
				array('field' => 'razao_social',	'label' => '',	'rules' => 'trim|callback_check_razao_social'),*/
				array('field' => 'nome_rsocial',	'label' => '',	'rules' => 'trim|callback_check_nome_fornecedor'),
				array('field' => 'cpf_cnpj',		'label' => '',	'rules' => 'trim|callback_valida_cpf_cnpj'),
				//array('field' => 'contato',		'label' => '',	'rules' => 'trim|callback_check_contato'),
				/*array('field' => 'cnpj',			'label' => '',	'rules' => 'trim|callback_valida_cnpj'),*/
				array('field' => 'endereco',		'label' => '',	'rules' => 'trim'),
				array('field' => 'bairro',			'label' => '',	'rules' => 'trim'),
				array('field' => 'estado',			'label' => '',	'rules' => 'trim|callback_validar_estado'),
				array('field' => 'cidade',			'label' => '',	'rules' => 'trim|callback_validar_cidade'),
				array('field' => 'cep',				'label' => '',	'rules' => 'trim'),
				array('field' => 'fone_residencial','label' => '',	'rules' => 'trim'),
				array('field' => 'fone_celular',	'label' => '',	'rules' => 'trim'),
				array('field' => 'municipio',		'label' => '',	'rules' => 'trim'),
				array('field' => 'email',			'label' => '',	'rules' => 'trim'),
		),
		/*LOTE*/
		'lote/cadastrar_lote' => array(
				array('field' => 'transportadora',	'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Transportadora]'),
				array('field' => 'fornecedor',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Fornecedor]'),
				array('field' => 'cultura',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Cultura]'),
				array('field' => 'variedade',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Variedade]'),
				array('field' => 'quantidade',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Qtde]'),
				/*array('field' => 'perda',			'label' => '',	'rules' => 'trim|'),*/
				/*array('field' => 'total_obtido',	'label' => '',	'rules' => 'trim'),*/
				array('field' => 'data_recebimento','label' => '',	'rules' => 'trim|callback_check_campo_vazio[Data]'),
				array('field' => 'lote',			'label' => '',	'rules' => 'trim'),
				array('field' => 'check_pedido',	'label' => '',	'rules' => 'trim'),
				array('field' => 'sel_posit',		'label' => '',	'rules' => 'trim|callback_check_sel_posit[Seleção Positiva]'),
				array('field' => 'tipo_mat',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Tipo de material]'),
				
		),
		'lote/pesquisar_lote' => array(
				array('field' => 'pesquisa',		'label' => '',	'rules' => 'trim|callback_check_campo_pesquisa'),
				array('field' => 'selec_pesq',		'label' => '',	'rules' => ''),
		),
		'lote/atualizar_descontam_lote' => array(
				array('field' => 'texto_descontam',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio'),
				//array('field' => 'selec_pesq',		'label' => '',	'rules' => ''),
		),
		'lote/atualizar_observ_lote' => array(
				array('field' => 'texto_observ',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio'),
				//array('field' => 'selec_pesq',		'label' => '',	'rules' => ''),
		),
		'lote/alterar_dados_lote' => array(
				array('field' => 'transportadora',	'label' => '',	'rules' => 'trim|callback_check_transportadora'),
				array('field' => 'fornecedor',		'label' => '',	'rules' => 'trim|callback_check_fornecedor'),
				array('field' => 'cultura',			'label' => '',	'rules' => 'trim|callback_check_cultura'),
				array('field' => 'variedade',		'label' => '',	'rules' => 'trim|callback_check_variedade'),
				array('field' => 'quantidade',		'label' => '',	'rules' => 'trim|callback_check_quantidade'),
				//array('field' => 'perda',			'label' => '',	'rules' => 'trim|'),
				//array('field' => 'total_obtido',	'label' => '',	'rules' => 'trim'),
				array('field' => 'data_recebimento','label' => '',	'rules' => 'trim|callback_check_data'),
				array('field' => 'lote',			'label' => '',	'rules' => 'trim'),
				array('field' => 'check_pedido',	'label' => '',	'rules' => 'trim'),
		),
		'lote/gerenciar_lote' => array(
				array('field' => 'cultura',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[cultura]'),
				
				array('field' => 'variedade',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[variedade]'),
				
				array('field' => 'lote',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[lote]')
		),
		'lote/cadastrar_fase_lote' => array(
				array('field' => 'cultura',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[cultura]'),
				
				array('field' => 'variedade',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[variedade]'),
				
				array('field' => 'lote',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[lote]'),
				
				array('field' => 'fase',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Fase]'),
				
				array('field' => 'num_entrada',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Nº de entrada]|callback_check_campo_numerico[Nº de entrada]'),
				
				array('field' => 'num_expl_trab',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Nº Expl. Trab.]|callback_check_campo_numerico[Nº Expl. Trab.]'),
				
				array('field' => 'num_expl_prod',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Nº Expl. Prod.]|callback_check_campo_numerico[Nº Expl. Prod.]'),
				
				array('field' => 'num_plan',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Nº Plan.]'),
												
				/*array('field' => 'taxa_mult',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[TX Mult.]|callback_check_campo_numerico[TX Mult.]'),
				
				array('field' => 'diferenca',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Diferença]'),*/
				
				/*array('field' => 'perda_fungo',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda p/ Fungo]'),
				
				array('field' => 'perda_bacteria',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda P/ Bact.]'),
				
				array('field' => 'perda_oxidacao',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda P/ Oxid. ]'),*/
				
				/*array('field' => 'perda_total',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda Total.]'),
				
				array('field' => 'pd_fungo_porcent',	'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda P/ Fungo (porcentagem)]'),
				
				array('field' => 'pd_bact_porcent',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda P/ Bactéria (porcentagem)]'),
				
				array('field' => 'pd_oxid_porcent',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda P/ Oxid (porcentagem)]'),
			
				array('field' => 'pd_total_porcent',	'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Perda Total (porcentagem)]'),*/
				
				array('field' => 'data_entrada',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Data Entrada ]'),
				
				array('field' => 'data_saida',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Data saída]'),
				
				array('field' => 'duracao',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Duração]'),
				
				array('field' => 'prazo',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Prazo]'),
				
				array('field' => 'dias_atrasados',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Atraso(dias)]'),
				
				array('field' => 'concluido',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Concluído]'),
				
				/*array('field' => 'repicador',				'label' => '',	'rules' => 'trim|')	*/
		),
		/*CULTURA*/
		'cultura/cadastrar_cultura' => array(
				array('field' => 'nome_cult',	'label' => '',	'rules' => 'trim|callback_check_nome_cultura')
		),
		'cultura/cadastrar_variedade' => array(
				array('field' => 'cultura',			'label' => '',	'rules' => 'callback_check_nome_cultura'),
				array('field' => 'qtde_var',		'label' => '',	'rules' => 'callback_check_qtde_var'),
				array('field' => 'nome_var[1]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[1]'),
				array('field' => 'nome_var[2]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[2]'),
				array('field' => 'nome_var[3]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[3]'),
				array('field' => 'nome_var[4]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[4]'),
				array('field' => 'nome_var[5]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[5]'),
				array('field' => 'nome_var[6]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[6]'),
				array('field' => 'nome_var[7]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[7]'),
				array('field' => 'nome_var[8]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[8]'),
				array('field' => 'nome_var[9]',		'label' => '',	'rules' => 'trim|callback_check_nome_variedade[9]'),
				array('field' => 'nome_var[10]',	'label' => '',	'rules' => 'trim|callback_check_nome_variedade[10]'),
				array('field' => 'nome_sigla[1]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[1]'),
				array('field' => 'nome_sigla[2]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[2]'),
				array('field' => 'nome_sigla[3]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[3]'),
				array('field' => 'nome_sigla[4]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[4]'),
				array('field' => 'nome_sigla[5]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[5]'),
				array('field' => 'nome_sigla[6]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[6]'),
				array('field' => 'nome_sigla[7]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[7]'),
				array('field' => 'nome_sigla[8]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[8]'),
				array('field' => 'nome_sigla[9]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[9]'),
				array('field' => 'nome_sigla[10]',	'label' => '',	'rules' => 'callback_check_sigla_variedade[10]')					
				//array('field' => 'nome_var['.$b.']',	'label' => '',	'rules' => 'callback_check_nome_variedade['.$b.']'),
				//array('field' => 'nome_sigla',	'label' => '',	'rules' => 'callback_check_sigla_variedade'),
		),
		'cultura/alterar_dados_variedade' => array(
				//array('field' => 'cod_variedade',	'label' => '',	'rules' => 'trim|callback_check_nome_cultura'),
				array('field' => 'nome_variedade',	'label' => '',	'rules' => 'trim|callback_check_nome_var'),
				array('field' => 'sigla_variedade',	'label' => '',	'rules' => 'trim|callback_check_sigla_var')
		),
		'cultura/alterar_dados_cultura' => array(
				array('field' => 'nome_cultura',	'label' => '',	'rules' => 'trim|callback_check_nome_cultura')
		),
		/*REPICADOR*/
		'repicagem/cadastrar_repicador' => array(
				array('field' => 'repicador',	'label' => '',	'rules' => 'trim|callback_check_nome_repicador|callback_check_repicador_existe')
		),
		'repicagem/cadastrar_prod_semanal' => array(
				array('field' => 'repicador',		'label' => '',	'rules' => 'trim|callback_check_selecao_repicador[repicador]'),
				array('field' => 'total_expl_prod',	'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Total expl. produzido]'),
				array('field' => 'media_tx_mult',	'label' => '',	'rules' => 'trim|callback_check_campo_vazio[média tx multiplicação]'),
				array('field' => 'pontuacao',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[pontuação]'),
				array('field' => 'producao',		'label' => '',	'rules' => 'trim|callback_check_campo_vazio[produção]')	
		),
		/*PRODUÇÃO*/
		'producao/cadastrar_info_lote' => array(
				/*info lote*/
				array('field' => 'ano',						'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Ano]'),
				array('field' => 'semana',					'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Semana]'),
				array('field' => 'cod_cultura',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Cultura]'),
				array('field' => 'cod_variedade',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Variedade]'),
				array('field' => 'cod_lote',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Lote]'),
				/*etapa anterior*/
				array('field' => 'cod_repic_ant',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Repicador]'),
				array('field' => 'data_anterior',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Data anterior]'),
				array('field' => 'num_expl_prod',			'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[nº Expl. Prod.]'),
				array('field' => 'pd_fungo',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Perda p/ fungo]'),
				array('field' => 'pd_bacteria',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Perda p/ bactéria]'),
				array('field' => 'pd_oxidacao',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Perda p/ oxidação]'),
				array('field' => 'total_perdas',			'label' => '',	'rules' => 'trim|integer'),
				array('field' => 'num_fr_trab',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº frasco Trab.]'),
				array('field' => 'num_expl_fr_trab',		'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº Expl. frasco trab.]'),
				array('field' => 'num_total_expl_trab',		'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº total expl.]'),
				array('field' => 'tamanho_expl',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Tam. expl.]'),
				array('field' => 'contaminacao',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[contaminacao]'),
				array('field' => 'tipo_meio',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Tipo de meio]'),
				/*etapa atual*/
				array('field' => 'cod_repic_atual',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[Recip. atual]'),
				array('field' => 'data_atual',				'label' => '',	'rules' => 'trim|callback_check_campo_vazio[data atual]'),
				array('field' => 'num_pote_prod',			'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº pote prod.]'),
				array('field' => 'num_expl_pote',			'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº Expl. no pote]'),
				array('field' => 'subtotal1',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[subtotal1]'),
				array('field' => 'num_fr_prod',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº frasco prod.]'),
				array('field' => 'num_expl_fr',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Nº Expl. no frasco]'),
				array('field' => 'subtotal2',				'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[subtotal2]'),
				array('field' => 'num_quebrado',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[num_quebrado]'),
				array('field' => 'total_expl_prod',			'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Total expl. prod.]'),
				array('field' => 'campo_oculto',			'label' => '',	'rules' => 'trim|callback_check_campo_vazio[campo oculto]'),
				/* análise inicial */
				array('field' => 'id_fase',					'label' => '',	'rules' => 'trim|integer|callback_check_campo_vazio[Fase]'),
				array('field' => 'cod_fase',				'label' => '',	'rules' => 'trim|integer'),
				array('field' => 'fator_conversao',			'label' => '',	'rules' => 'trim|numeric|callback_check_campo_vazio[fator Conversão]'),
				array('field' => 'pontos_repic',			'label' => '',	'rules' => 'trim|numeric|callback_check_campo_vazio[Pontos Repic.]'),
				
		),
		/*contrato*/
		'contrato/exibir_contrato' => array(
				array('field' => 'ano',	'label' => '',	'rules' => 'trim|callback_check_ano')
		),
		
		
);//FIM DO ARQUIVO
		






		
