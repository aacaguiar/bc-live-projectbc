<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"></script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"></script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"></script>
<script src="<?php echo base_url('js/lote/lote.js');?>"></script>

<script>
url_carregar_variedade = "<?php echo base_url('lote/carregar_variedade')?>";
url_carregar_lote = "<?php echo base_url('lote/carregar_lote')?>";
url_cadastrar_lote = "<?php echo base_url('lote/cadastrar_lote')?>";
url_imagem_catalogo = "<?php echo base_url('imagens/catalogo_cultura_variedade.png') ?>";
window.onload = function(){
	carregar_variedade();
	on_off_pedido();
};

</script>
<h4 class="text-center"> Alterar Lote </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Altere os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">
				<form name="alterar_lote" method="post" action="<? echo base_url('lote/alterar_dados_lote');?>">
				<input type="hidden" name="cod_lote" value="<?echo $cod_lote;?>" >
				
				<a style="cursor:pointer" class="link-cli-novo" onclick="exibir_mapa_var()">siglas cultura & variedades</a>
				
					<div class="form-group">
						<label for="tipo_cliente">Transportadora:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" id="transportadora" name="transportadora"> 
							
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_transportadora as $cod=>$valor) { ?>
								<option value="<? echo $valor; ?>" <? echo set_select('transportadora',"$valor",($nome_transp == "$valor" ? TRUE : FALSE ));?>><? echo $valor;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
						
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('transportadora'); ?>
					</div>
										
					<div class="form-group">
						<label for="tipo_cliente">Fornecedor:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" id="fornecedor" name="fornecedor" onchange="gerar_lote()">
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_fornecedor as $cod=>$valor) { ?>
								<option value="<? echo $cod; ?>" <? echo set_select('fornecedor',"$cod",($nome_fornec == "$valor" ? TRUE : FALSE ));?>><? echo $valor;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('fornecedor'); ?>
					</div>
					
					<div class="form-group">
						<label for="tipo_cliente">Cultura:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" id="cultura" name="cultura" onChange="carregar_variedade();">
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_cultura as $cod_cultura => $valor) { ?>
								<option value="<? echo $cod_cultura; ?>" <? echo set_select('cultura',$cod_cultura,($cod_cult_selec == $cod_cultura ? TRUE : FALSE ));?>><? echo $valor;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('cultura'); ?>
					</div>
					
					<div class="form-group">
						<label for="tipo_cliente">Variedade:</label>
						
						<div class="select-cadastro-cli">
							<select class="form-control" id="variedade" name="variedade" onchange="gerar_lote();">
								<option value="0">Selecione uma opção</option>
								<? if($sigla_nomeVar !='0') { ?>
									<option value="<? echo $sigla_nomeVar; ?>" <?echo set_select('variedade',$sigla_nomeVar,($sigla_nomeVar !='0' ? TRUE : FALSE ));?>> </option>
								<? } ?>
									
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('variedade'); ?>
					</div>
					
					<div class="form-group">
						<label for="cpf">Tipo de material:</label> 
						<input type="text" class="form-control" name="tipo_mat" size="50" value="<? echo $tipo_mat;?>">
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('tipo_mat'); ?>
					</div>
					
					<div class="form-group">
						<label>Seleção positiva </label> 
					</div>	
					
					<div class="form-inline">					
						<div class="checkbox">
    						<input type="radio" value="t" name="sel_posit" <?php echo set_radio('sel_posit', 't', ($sel_posit == 't') ? true : false);?> > <label> Sim </label>	 
 					 	</div>
 					 	
 					 	<div class="checkbox" style="margin-left:10px">
    						<input type="radio" value="f" name="sel_posit" <?php echo set_radio('sel_posit', 'f', ($sel_posit == 'f') ? true : false);?> > <label> Não </label>	 
 					 	</div>
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('sel_posit'); ?>
					</div>
					
					<div class="form-group">
						<label for="cpf">Quantidade:</label> 
						<input type="text" class="form-control" id="quantidade" name="quantidade" size="10" value="<? echo $qtde_recebida;?>">
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-cpf" style="width:110px;">
						<? echo form_error('quantidade'); ?>
					</div>
										
					<div class="form-group">
						<label for="pessoa_juridica">Data de recebimento:</label> 
						<input type="text" class="form-control"  id="data_recebimento" name="data_recebimento" size="15" value="<? echo $data_recebimento;?>">
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-rsocial" style="width:140px;">
						<? echo form_error('data_recebimento'); ?>
					</div>
					
					<div class="form-group">
						<label for="lote" onClick="gerar_lote()">Lote: <br> <small>(sigla da variedade + semana + ano + cód.Fornecedor.)</small></label> 
						<input type="text" class="form-control" id="lote" name="lote" size="15" value="<? echo $num_lote;?>">		
					</div>
					
					<div class="msg-erro-cadastro-cli" style="width:140px;">
						<? echo form_error('lote'); ?>
					</div>
					
					<div class="form-group">
						<label> Associar o Lote a um pedido cadastrado</label> 
					</div>
					<div class="form-inline">
						<div class="checkbox">
    						<input type="radio" value="true" id="radio1" name="check_pedido" onClick="on_off_pedido()" <?php echo set_radio('check_pedido', 'true', $radio1); ?>> <label> Sim </label>	 
 					 	</div>
 					 	<div class="checkbox" style="margin-left:10px">
    						<input type="radio" value="false" id="radio2" name="check_pedido" onClick="on_off_pedido()" <?php echo set_radio('check_pedido', 'false', $radio2); ?>> <label> Não </label>	 
 					 	</div>
					</div>
					
					<div class="form-group">		
						<div class="select-cadastro-cli">
							<select class="form-control" style="margin-top:10px;width:140px;" size="7" id="num_pedido" name="num_pedido" disabled>
								<option value='0'>Nº do Pedido</option>
								<?php 
									foreach ($lista_pedido as $num_pedido){
										echo ($num_pedido_selec == $num_pedido) ? "<option value='$num_pedido' selected> $num_pedido </option>" : "<option value='$num_pedido'> $num_pedido </option>" ;	
									}
								?>	
							</select>	 
						</div>
					</div>
						
					<div class="msg-erro-cadastro-cli" style="width:324px;">
						<? echo form_error('cod_cliente'); ?>
					</div>			
					
																														
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>


