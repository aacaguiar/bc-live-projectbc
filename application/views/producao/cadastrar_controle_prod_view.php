<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"> </script>
<script src="<?php echo base_url('js/producao/controle_producao.js');?>"> </script>

<script>
url_carregar_var = "<?php echo base_url('producao/carregar_variedade')?>";
url_carregar_lotes = "<?php echo base_url('producao/carregar_lotes');?>";
cod_lote_selec = "<?php echo $cod_lote_selec ?>";

<?php
$obj = json_encode($cod_fase_fator);
echo "var cod_fase_fator = ".$obj.";\n";
?>

window.onload = function (){
	carregar_variedade();
	carregar_lotes();
};

</script>

<h4 class="text-center"> <?php echo ($metodo == 'cadastrar') ? 'Controle da Produção (Cadastrar dados)' : 'Controle da Produção (Alterar dados)'?> </h4> 

<div class="box-cadastrar-cont">
	<div class="panel panel-default" >
		
		<div class="panel-heading">
			<span class="panel-title"> <strong> Preencha os dados abaixo: </strong> </span> 							
		</div>
			
		<div class="panel-body">
				
				<?php $url = ($metodo == 'cadastrar') ? base_url('producao/cadastrar_controle_prod') : base_url('producao/alterar_controle_prod') ; ?>
				<form class="form-horizontal" name="cadastro_pedido" id="cadastro_pedido" method="post" action="<?php echo $url; ?>">
				
					<!-- campos chaves -->
					<input type="hidden" name="campo_oculto" value="<?php echo $campo_oculto ?>">
					<input type="hidden" name="id" value="<?php echo $id ?>">
					
					<div class="page-header">
					  Informações do Lote 
					</div>
				
						<div class="form-group">
						    <label for="ano" class="col-sm-3 control-label"> Ano </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" id="ano" name="ano" value="<?php echo $ano; ?>">
						    </div>
						    <div class="msg-erro"> <? echo form_error('ano'); ?> </div> 
					    </div>
					   
						<div class="form-group">
						    <label for="semana" class="col-sm-3 control-label"> Semana </label>
						    <div class="col-sm-9">
						      	<select class="form-control" name="semana">
						      	
						      		<?php if ($semana1 != 0) { ?>
										<optgroup label="<?php echo "$dia_sem1/12/$ano - $ano_prox";?>">
										    <option> <?php echo $semana1; ?> </option>
										 </optgroup>
									<?php } ?>
										
									 <optgroup label="<?php echo $ano ?>">
										<!-- <option value=''> selecione a semana </option> -->
											<?php $cont = $num_semana;
												for ($cont; $cont>=1; $cont--) { 
												echo "<option value=$cont ".set_select('semana', $cont, ($num_sem_selec == $cont ? TRUE : FALSE ))."> $cont </option>";
												}
											?>	
									 </optgroup>
							  	</select>	 
						    </div>
						    
					   	 </div>
					   	 
					   	 <div class="form-group">
						    <label for="cultura" class="col-sm-3 control-label"> Cultura </label>
						    <div class="col-sm-9">
						   		<select class="form-control" id="cultura" name="cod_cultura" onChange="carregar_variedade();">
									<option value=''>Selecione a cultura</option>
									<? foreach ($lista_cultura as $cod_cultura => $valor){
									 	echo "<option value=$cod_cultura ".set_select('cod_cultura',$cod_cultura,($cod_cult_selec == $cod_cultura ? TRUE : FALSE ))."> $valor </option>";
									}?>
								</select> 		
						    </div>
						    <div class="msg-erro"> <? echo form_error('cod_cultura'); ?> </div>
					   	 </div>
					   	 
					   	 <div class="form-group">
						    <label for="semana" class="col-sm-3 control-label"> Variedade </label>
						    <div class="col-sm-9">
						    	 <select class="form-control" id="variedade" name="cod_variedade" onchange="carregar_lotes();">
									<option value=''>Selecione a variedade</option>
									<? if($cod_var_selec !=''){ 
										echo "<option value='$cod_var_selec' ".set_select('cod_variedade', $cod_var_selec,($cod_var_selec !='' ? TRUE : FALSE ))."> </option>"; 
										}
									?>
								</select>	
						    </div>
						    <div class="msg-erro"> <? echo form_error('cod_variedade'); ?> </div> 
					   	 </div>
					   	 
					   	 <div class="form-group">
						    <label for="lote" class="col-sm-3 control-label"> Lote </label>
						    <div class="col-sm-9">
						    	<select class="form-control" id="lote" name="cod_lote">
									<option value=''>Selecione o lote</option>
									<? if($cod_lote_selec != 0) { ?>
										<option value="<?echo $cod_lote_selec;?>" <?echo set_select('cod_lote',$cod_lote_selec,($cod_lote_selec != 0 ? TRUE : FALSE ));?>> </option>
									<? } ?>		
								</select>			
						    </div>
						    <div class="msg-erro"> <? echo form_error('cod_lote'); ?> </div> 
					   	 </div>
					
					<div class="page-header">
					  Informações da etapa anterior 
					</div>
					
						<div class="form-group">
						    <label for="repic_ant" class="col-sm-3 control-label"> Repicador(a) anterior </label>
						    <div class="col-sm-9">
						    	<select class="form-control" name="cod_repic_ant">
									<option value=''> Selecione o repicador</option>
									<? 
										foreach ($lista_repic as $id => $valor){
									 	echo "<option value= $id ".set_select('cod_repic_ant', $id, ($cod_repic_ant == $id ? TRUE : FALSE ))."> $valor </option>";
									 	}
									 ?>
								</select> 
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('cod_repic_ant'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="data_anterior" class="col-sm-3 control-label"> Data anterior </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" id="data_anterior" name="data_anterior" value="<?php echo set_value('data_anterior'); ?>"> 
						    </div>
						    <div class="msg-erro"> <? echo form_error('data_anterior'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="num_expl_prod" class="col-sm-3 control-label campo_calc"> Nº Expl. produzidos </label>
						    <div class="col-sm-9">
						    	<input id="num_expl_prod" readonly type="text" class="form-control" name="num_expl_prod" value="<?php echo set_value('num_expl_prod'); ?>">
						     	 <div class="obs_calc"> Obs: Total de perdas + Nº Total Expl. Trab.</div>
						    </div>
						    <div class="msg-erro"> <? echo form_error('num_expl_prod'); ?> </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_fungo" class="col-sm-3 control-label"> Perda p/ fungo </label>
						    <div class="col-sm-9">
						    	<input id="pd_fungo" type="text" class="form-control" name="pd_fungo" value="<?php echo set_value('pd_fungo'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('pd_fungo'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_bacteria" class="col-sm-3 control-label"> Perda p/ bacteria </label>
						    <div class="col-sm-9">
						    	<input id="pd_bact" type="text" class="form-control" name="pd_bacteria" value="<?php echo set_value('pd_bacteria'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('pd_bacteria'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_oxidacao" class="col-sm-3 control-label"> Perda p/ Oxidação </label>
						    <div class="col-sm-9">
						    	<input id="pd_oxid" type="text" class="form-control" name="pd_oxidacao" value="<?php echo set_value('pd_oxidacao'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('pd_oxidacao'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="total_perdas" class="col-sm-3 control-label campo_calc"> Total de Perdas </label>
						    <div class="col-sm-9">
						    	<input id="pd_total" readonly type="text" class="form-control" name="total_perdas" value="<?php echo set_value('total_perdas'); ?>">
						    	<div class="obs_calc"> Obs: Perdas p/ Fungo + Bacteria + Oxidação</div>
						    </div>
						    <div class="msg-erro"> <? echo form_error('total_perdas'); ?> </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="num_fr_trab" class="col-sm-3 control-label"> Nº Frasco trabalhado </label>
						    <div class="col-sm-9">
						    	<input id="num_fr_trab" type="text" class="form-control" name="num_fr_trab" value="<?php echo set_value('num_fr_trab'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('num_fr_trab'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="num_expl_fr_trab" class="col-sm-3 control-label"> Nº Expl. Frasco Trab. </label>
						    <div class="col-sm-9">
						    	<input id="num_expl_fr_trab" type="text" class="form-control" name="num_expl_fr_trab" value="<?php echo set_value('num_expl_fr_trab'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('num_expl_fr_trab'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="num_total_expl_trab" class="col-sm-3 control-label campo_calc"> Nº Total Expl. Trab. </label>
						    <div class="col-sm-9">
						    	<input id="num_total_expl_trab" type="text" readonly class="form-control" name="num_total_expl_trab" value="<?php echo set_value('num_total_expl_trab'); ?>">
						     	<div class="obs_calc"> Obs: ( Nº Frasco trab. *  Nº Expl. Frasco Trab.) - Total de Perdas</div>
						    </div>
						    <div class="msg-erro"> <? echo form_error('num_total_expl_trab'); ?> </div> 
					    </div>
					    
					       <div class="form-group">
						    <label for="tamanho_expl" class="col-sm-3 control-label"> Tam Expl. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="tamanho_expl" value="<?php echo set_value('tamanho_expl'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('tamanho_expl'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="contaminacao" class="col-sm-3 control-label"> Contaminação Lote. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="contaminacao" value="<?php echo set_value('contaminacao'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('contaminacao'); ?> </div> 
					    </div>
					    
					    <div class="form-group">
						    <label for="tipo_meio" class="col-sm-3 control-label"> Tipo de meio </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="tipo_meio" value="<?php echo set_value('tipo_meio'); ?>">
						     	
						    </div>
						    <div class="msg-erro"> <? echo form_error('tipo_meio'); ?> </div> 
					    </div>
					   
					<div class="page-header">
					  Informações da etapa atual
					</div>
					 
					<div class="form-group">
					    <label for="cod_repic_atual" class="col-sm-3 control-label"> Repicador(a) atual </label>
					    <div class="col-sm-9">
					    	<select class="form-control" name="cod_repic_atual">
								<option value=''> Selecione o repicador</option>
								<? 
									foreach ($lista_repic as $id => $valor){
								 	echo "<option value= $id ".set_select('cod_repic_atual', $id, ($cod_repic_atual == $id ? TRUE : FALSE ))."> $valor </option>";
								 	}
								 ?>
							</select> 
					    </div>
					    <div class="msg-erro"> <? echo form_error('cod_repic_atual'); ?> </div> 
					</div>
					    
				    <div class="form-group">
					    <label for="data_atual" class="col-sm-3 control-label"> Data atual </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" id="data_atual" name="data_atual" value="<?php echo set_value('data_atual'); ?>">
					     	
					    </div>
					    <div class="msg-erro"> <? echo form_error('data_atual'); ?> </div> 
				    </div>
				    
				    <div class="form-group">
					    <label for="num_pote_prod" class="col-sm-3 control-label"> Nº Pote produzidos </label>
					    <div class="col-sm-9">
					    	<input id="num_pote_prod" type="text" class="form-control" name="num_pote_prod" value="<?php echo set_value('num_pote_prod'); ?>">
					     	
					    </div>
					    <div class="msg-erro"> <? echo form_error('num_pote_prod'); ?> </div> 
					</div>
					    
					<div class="form-group">
					    <label for="num_expl_pote" class="col-sm-3 control-label"> Nº Expl. no pote </label>
					    <div class="col-sm-9">
					    	<input id="num_expl_pote" type="text" class="form-control" name="num_expl_pote" value="<?php echo set_value('num_expl_pote'); ?>">
					     	
					    </div>
					    <div class="msg-erro"> <? echo form_error('num_expl_pote'); ?> </div> 
					</div>
					
					<div class="form-group">
					    <label for="subtotal1" class="col-sm-3 control-label campo_calc"> Subtotal1 </label>
					    <div class="col-sm-9">
					    	<input id="subtotal1" readonly type="text" class="form-control" name="subtotal1" value="<?php echo set_value('subtotal1'); ?>">
					     	 <div class="obs_calc"> Obs: Nº pote prod. *  Nº Expl. no pote</div>
					    </div>
					    <div class="msg-erro"> <? echo form_error('subtotal1'); ?> </div>
					</div>
					    
			     	<div class="form-group">
					    <label for="num_fr_prod" class="col-sm-3 control-label"> Nº Frasco Produzidos </label>
					    <div class="col-sm-9">
					    	<input id="num_fr_prod" type="text" class="form-control" name="num_fr_prod" value="<?php echo set_value('num_fr_prod'); ?>">
					     	
					    </div>
					    <div class="msg-erro"> <? echo form_error('num_fr_prod'); ?> </div> 
			   	 	</div>
			   	 	
			   	 	<div class="form-group">
					    <label for="num_expl_fr" class="col-sm-3 control-label"> Nº Expl. no Frasco </label>
					    <div class="col-sm-9">
					    	<input id="num_expl_fr" type="text" class="form-control" name="num_expl_fr" value="<?php echo set_value('num_expl_fr'); ?>">
					     	
					    </div>
					    <div class="msg-erro"> <? echo form_error('num_expl_fr'); ?> </div> 
			   	 	</div>
							
					<div class="form-group">
					    <label for="subtotal2" class="col-sm-3 control-label campo_calc"> Subtotal2. </label>
					    <div class="col-sm-9">
					    	<input id="subtotal2" readonly type="text" class="form-control" name="subtotal2" value="<?php echo set_value('subtotal2'); ?>">
					    	<div class="obs_calc"> Obs: Nº Frasco prod. *  Nº Expl. no Frasco </div>
					    </div>
					    <div class="msg-erro"> <? echo form_error('subtotal2'); ?> </div> 
					</div>
					    
					<div class="form-group">
					    <label for="num_quebrado" class="col-sm-3 control-label campo_calc"> Nº Queb. </label>
					    <div class="col-sm-9">
					    	<input id="num_queb" type="text" class="form-control" name="num_quebrado" value="<?php echo set_value('num_quebrado'); ?>">	
					    </div>
					    <div class="msg-erro"> <? echo form_error('num_quebrado'); ?> </div> 
					</div>
					
					<div class="form-group">
					    <label for="total_expl_prod" class="col-sm-3 control-label campo_calc"> Total Expl. Produzidos </label>
					    <div class="col-sm-9">
					    	<input id="total_expl_prod" readonly type="text" class="form-control" name="total_expl_prod" value="<?php echo set_value('total_expl_prod'); ?>"> 	
					    	<div class="obs_calc"> Obs: Subtotal1 + Subtotal2 + Nº queb. </div>
					    </div>
					    <div class="msg-erro"> <? echo form_error('total_expl_prod'); ?> </div> 
					</div>
					  
					<div class="page-header">
					  Análise Inicial
					</div>
					 
					<div class="form-group">
					    <label for="fase" class="col-sm-3 control-label"> Fase </label>
					    <div class="col-sm-9">
					    	<select class="form-control" name="id_fase" id="id_fase">
								<option value=''>Selecione a fase</option>
								<? 
									foreach ($lista_fase as $id => $valor){
								 	echo "<option value= $id ".set_select('id_fase', $id, ($id_fase_selec == $id ? TRUE : FALSE ))."> $valor </option>";
								 	}
								 ?>
							</select> 
					    </div>
					    <div class="msg-erro"> <? echo form_error('id_fase'); ?> </div> 
					</div>
					
					<div class="form-group">
					    <label for="cod_fase" class="col-sm-3 control-label campo_calc"> Cód. Fase </label>
					    <div class="col-sm-9">
					    	<input id="cod_fase" readonly type="text" class="form-control" name="cod_fase" value="<?php echo set_value('cod_fase'); ?>"> 	
					    </div>
					    <div class="msg-erro"> <? echo form_error('cod_fase'); ?> </div> 
					</div>
					
					<div class="form-group">
					    <label for="fator_conversao" class="col-sm-3 control-label campo_calc"> Fator Conversão </label>
					    <div class="col-sm-9">
					    	<input id="fator_conversao" type="text" class="form-control" name="fator_conversao" value="<?php echo set_value('fator_conversao'); ?>"> 	
					    </div>
					    <div class="msg-erro"> <? echo form_error('fator_conversao'); ?> </div> 
					</div>
					
					<div class="form-group">
					    <label for="pontos_repic" class="col-sm-3 control-label campo_calc"> Pontos do Repicador </label>
					    <div class="col-sm-9">
					    	<input id="pontos_repic" readonly type="text" class="form-control" name="pontos_repic" value="<?php echo set_value('pontos_repic'); ?>"> 	
					    	<div class="obs_calc"> Obs: Nº total de Expl. prod. * Fator conversão </div>
					    </div>
					    <div class="msg-erro"> <? echo form_error('pontos_repic'); ?> </div> 
					</div>
					   	   			
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="<?php echo ($metodo == 'cadastrar') ? 'Cadastrar' : 'Alterar' ?>">              
				
				</form>
		
		</div> <!-- fim panel-body -->
		
		<div class="panel-footer"> </div>
			
	</div><!-- Fim Panel -->
</div>



