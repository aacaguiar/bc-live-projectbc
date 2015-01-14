<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"></script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"></script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"></script>
<script src="<?php echo base_url('js/pedido/pedido.js');?>"></script>

<script type="text/javascript">
	url_carregar_endereco = "<?php echo base_url('pedido/carregar_endereco');?>";
	url_apagar_endereco = "<?php echo base_url('pedido/apagar_endereco');?>";
	url_carregar_cidade = "<?php echo base_url('pedido/carregar_cidades')?>";
	url_carregar_variedade = "<?php echo base_url('pedido/carregar_variedade')?>";
	url_carregar_cliente = "<?php echo base_url('pedido/carregar_cliente')?>";
	url_carregar_data = "<?php echo base_url('pedido/carregar_datas')?>";
	end_selecionado = "<? echo $end_selec ?>";
	
	function x(){
		listar_cliente();
		carregar_variedade();
		selecionar_endereco();
		carregar_datas2();
		carregar_cidade();
	}
	window.onload = function (){
		x();
	};		
</script>

	<h4 class="text-center"> Alteração do Pedido </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"> <strong> Alteração os dados abaixo: </strong> </span>
			</div>
			<div class="panel-body">
				<form name="cadastro_pedido" id="cadastro_pedido" method="post" action="<?php echo base_url('pedido/alterar_dados_pedido');?>">
					<input type="hidden" name="num_pedido" value="<?echo $cod_pedido;?>">
					<input type="hidden" name="num_entregas_anterior" value="<?echo $num_ent_anterior;?>">
				
					<label for="tipo_cliente">Cliente:</label> 
					<a href="<?php echo base_url('pedido/listar_pedido')?>" class="link-cli-novo">voltar</a> 
					
					<div class="form-inline">
						<div class="radio">
    						<input type="radio" value='fisica' id="pes_fisica" name="tipo_cliente" <?php echo set_radio('tipo_cliente', 'fisica', ($cliente_selec == "fisica" ? TRUE : FALSE ));?> onChange="listar_cliente()"> <label>Pessoa Física</label>	 
 					 	</div>
 					 	
 					 	<div class="radio" style="margin-left:20px">
    						<input type="radio" value='juridica' id="pes_juridica" name="tipo_cliente" <?php echo set_radio('tipo_cliente', 'juridica', ($cliente_selec == "juridica" ? TRUE : FALSE ));?> onChange="listar_cliente();"> <label>Pessoa Jurídica</label>	 
 					 	</div>
					</div>
				
					<div class="form-group">		
						<div class="select-cadastro-cli">
							<select class="form-control" id="cod_cliente" name="cod_cliente" onChange="carregar_endereco();">
								<option value='0'>Selecione uma opção</option>
									<? if($cod_selec !='0') { ?>
										<option value="<? echo $cod_selec; ?>" <? echo set_select('cod_cliente',"$cod_selec",($cod_selec !='0' ? TRUE : FALSE ));?>> </option>
									<? } ?>		
							</select>	 
						</div>
					</div>
						
					<div class="msg-erro-cadastro-cli" style="width:324px;">
						<? echo form_error('cod_cliente'); ?>
					</div>					
								
					<div class="form-group">
						<label for="tipo_cliente">Cultura:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" id="cultura" name="cultura" onChange="carregar_variedade();">
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_cultura as $cod_cultura => $nome_cultura) { ?>
								<option value="<? echo $cod_cultura; ?>" <? echo set_select('cultura', $cod_cultura, ($cultura_selec == $cod_cultura ? TRUE : FALSE ));?>><? echo $nome_cultura;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-nome">
						<? echo form_error('cultura'); ?>
					</div>
					
					<div class="form-group">
						<label for="tipo_cliente">Variedade:</label>
			
						<div class="select-cadastro-cli">
							<select class="form-control" id="variedade" name="variedade">
								<option value="0">Selecione uma opção</option>
								<? if($variedade_selec !='0') { ?>
									<option value="<? echo $variedade_selec; ?>" <? echo set_select('variedade',$variedade_selec,($variedade_selec !='0' ? TRUE : FALSE ));?>> </option>
								<? } ?>				
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-nome">
						<? echo form_error('variedade'); ?>
					</div>
					
					<div class="form-group">
						<label for="fase_muda">Fase para entrega:</label>
			
						<div class="select-cadastro-cli">
							<select class="form-control" id="fase_muda" name="fase_muda">
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_fase_entrega as $cod_fase => $nome_fase) { ?>
								<option value="<? echo $nome_fase; ?>" <? echo set_select('fase_muda',$nome_fase,($fase_selec == $nome_fase ? TRUE : FALSE ));?>><? echo $nome_fase;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
				
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('fase_muda'); ?>
					</div>
					
					<div class="alinhar_dt_qtde">
						<div class="dt_ped"> 
							<div class="form-group">
								<label for="data_pedido">Data do pedido:</label> 
								<input type="text" class="form-control"  id="data_pedido" name="data_pedido" size="15" value="<? echo $data_pedido;?>">
							</div>
							
							<div class="msg-erro-cadastro-cli">
								<? echo form_error('data_pedido'); ?>
							</div>
						</div>	
						
						<div class="qtde_ped">
							<div class="form-group">
								<label for="qtde_total">Qtde total do pedido:</label>
								<div class="form-inline">
									<input type="text" class="form-control"  id="qtde_pedido" name="qtde_pedido" size="15" value="<? echo $qtde_pedido?>">
									<small> <font color=#CC8080>Obs:somente números</font> </small>
								</div>
							</div>
							
							<div class="msg-erro-cadastro-cli">
								<? echo form_error('qtde_pedido'); ?>
							</div>
						</div>
					</div>
					
					<div class="alinhar_vl_tot">
						<div class="vl_muda"> 
							<div class="form-group">
								<label for="valor_muda">Valor da Muda:</label> 
								<input type="text" class="form-control"  id="vl_muda" name="vl_muda" size="15" maxlength="4" value="<? echo $vl_muda ?>">
							</div>
							
							<div class="msg-erro-cadastro-cli">
								<? echo form_error('vl_muda'); ?>
							</div>
						</div>	
						
						<div class="vl_total">
							<div class="form-group">
								<label for="total">Total:</label>
								<input type="text" readonly class="form-control"  id="vl_total" name="vl_total" size="15" value="<? echo $vl_total ?>">
							</div>
							
							<div class="msg-erro-cadastro-cli">
								<? echo form_error('vl_total'); ?>
							</div>
						</div>
					</div>
					
					<div class="forma_pagto">
						<div class="form-group">
							<label for="forma_pagto"> Forma de pagto: </label>
							<input type="text" class="form-control" id="fr_pagto" name="forma_pagto" size="50" value="<? echo $forma_pagto ?>">
						</div>
						
						<div class="msg-erro-cadastro-cli">
							<? echo form_error('forma_pagto'); ?>
						</div>
					</div> 	
				 	
					<div class="form-group">
						<label for="pessoa_juridica"> Frequência da entrega: </label> 
						<input type="text" class="form-control" id="frq_entrega" name="frq_entrega" size="50" placeholder="Ex: semanal, mensal etc." value="<?echo $frq_entrega;?>">
					</div>
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('frq_entrega'); ?>
					</div>
					
					<div class="form-group">
						<label> Qtde de entregas: </label>
						<div class="select-cadastro-cli">
							<select class="form-control" id="qtde_entrega" name="qtde_entrega" style="width:170px" onchange="carregar_datas2()">
								<option value="0"> Selecione a opção </option>
								<? foreach ($qtde_entrega as $num_entrega => $valor) { ?>
								<option value="<? echo $num_entrega; ?>" <? echo set_select('qtde_entrega',$num_entrega,($qtde_entrega_selec == $num_entrega ? TRUE : FALSE ));?>> <? echo $valor;?> </option>
								<? } ?>
							</select>	 
						</div>
					</div>
						
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('qtde_entrega'); ?>
					</div>	
					
					<div class="form-inline" style="width:700px;">										
						<div id="box_datas" class="box_datas" style='margin-top:10px;'>
							<? for ($i=1; $i<=30; $i++) { ?>
								<!-- <label id='<? echo 'label_entrega'.$i?>' class="label-entrega"> <? echo $i.'º entrega'?> </label> -->
								<input type='text' readonly class='label-entrega' id='<?echo 'label_entrega'.$i?>' value='<?echo $i.'º entrega'?>'>
								<input type='text' class='campo-data' size='10' name='data_entrega[<?echo $i?>]' id='<?echo 'data_entrega'.$i?>' value='<? echo (isset($data_selec[$i])) ? $data_selec[$i] : '' ?>'>
								<!-- <label id='<? echo 'label_qtde_ent'.$i?>' class="label-qtde-ent"> Qtde: </label> -->
								<input type='text' readonly class='label-qtde-ent' id='<?echo 'label_qtde_ent'.$i?>' value='Qtde:'>
								<input type='text' class='campo-qtde-ent' size='10' name='qtde_ent_parcial[<?echo $i?>]' id='<?echo 'qtde_ent_parcial'.$i?>' value='<?echo (isset($qtde_ent_parcial[$i])) ? $qtde_ent_parcial[$i] : ''?>'>		
							<?}?> 
						</div>
					</div> 
					
					<div class="msg-erro-cadastro-cli">
						<? echo form_error('data_entrega'); ?>
					</div>
														
					<div class="titulo-entrega">
  						Endereço para entrega:
  						<hr style="height:2px;background:#E0E0E0">
					</div>
					
					<div class="form-group">
						<div class="checkbox">
    						<input type="radio" value="end_atual" id="check_end_atual" name="check_endereco" onChange="endereco_atual();"><label>Endereço atual</label>	 
 					 	</div>
 					 	
					</div>
					
					<div class="form-group">
						<div id="endereco_atual"></div>
					</div>
					
					<div class="form-group">
						<div class="checkbox">
    						<input type="radio" value="end_novo" id="check_novo_end" name="check_endereco" onChange="novo_endereco();"><label>Outro endereço</label>	 
						</div>
					</div>
					
					
					<div id="box-endereco" style="display:none">
					
					<div class="form-group">
						<label for="endereco">Endereço:</label> 
						<input type="text" class="form-control" id="endereco" name="endereco" size="75" value="<?php echo $end_novo['endereco']?>">
					</div>
						 
					<div class="msg-erro-cadastro-cli" id="erro-end">
						<?php echo form_error('endereco'); ?>
					</div>
					
					<div class="form-group">
						<label for="bairro">Bairro:</label> 
						<input type="text" class="form-control" id="bairro" name="bairro" size="75" value="<?php echo $end_novo['bairro']?>">
					</div>
					
					 
					<div class="msg-erro-cadastro-cli" id="erro-bairro">
						<?php echo form_error('bairro'); ?>
					</div>
					
					
					<div class="form-group">
						<label for="estado">Estado:</label>
											 
						<div class="select-cadastro-cli">
							<select class="form-control"  id="estado" name="estado" onChange="carregar_cidade();">
								<option value='0'>Selecione uma opção</option>
									<?php
										foreach ($lista_estados as $estado) {
											if( $end_novo['estado'] == $estado){
												echo "<option value='$estado' selected=\"selected\">".$estado."</option>";
											}else{
												echo "<option value='$estado'>".$estado."</option>";
											}	
										}	
									?>								
							</select>	 
						</div>
					</div>
					
				 																															
				<div class="msg-erro-cadastro-cli" id="erro-estado" style="width:324px;">
					<?php echo form_error('estado'); ?>
				</div>
				
				
				<div class="form-group">
					<label for="cidade">Cidade:</label>	
					<div class="select-cadastro-cli">
						<select class="form-control" id="cidade" name="cidade">
							<option value="0">Selecione uma opção</option> 
							<? if($end_novo['cidade'] && $end_novo['cidade']) { 
								echo '<option value='.$end_novo['cidade'].' selected>'.$end_novo['cidade'].'</option>';
								} 
							?>						
						</select>	  
					</div>
				</div>
				
						
				<div class="msg-erro-cadastro-cli" id="erro-cidade" style="width:324px;">
					<?php echo form_error('cidade'); ?>
				</div>
				
				
				<div class="form-group">
					<label for="cep">Cep:</label> 
					<input type="text" class="form-control" id="cep" name="cep" size="25" value="<?php echo $end_novo['cep']?>">
				</div>
			
			 		
				<div class="msg-erro-cadastro-cli" id="erro-cep" style="width:324px;">
					<?php echo form_error('cep'); ?>
				</div>
				
				</div>
				
				<hr style="height:2px;background:#E0E0E0">
				<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar"> 
				<input type="button" class="btn btn-default" style="margin-top:20px;float:right" value="Finalizar pedido" onclick="location.href='<?echo base_url('pedido/finalizar_pedido') ?>' "> 				
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>

