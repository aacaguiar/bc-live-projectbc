<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"> </script>
<script src="<?php echo base_url('js/producao/controle_producao.js');?>"> </script>

<script>
url_carregar_var = "<?php echo base_url('producao/carregar_variedade')?>";
url_carregar_lotes = "<?php echo base_url('producao/carregar_lotes');?>";

cod_lote_selec = "<?php echo $cod_lote_selec ?>";
//cod_var_selec = "<?php //echo $cod_var_selec ?>";

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
				<form class="form-horizontal" name="cadastro_pedido" id="cadastro_pedido" method="post" action="<?php echo base_url('producao/cadastrar_controle_prod');?>">
				
					<div class="page-header">
					  Informações do Lote 
					</div>
				
						<div class="form-group">
						    <label for="ano" class="col-sm-3 control-label"> Ano </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" id="ano" name="ano" value="<?php echo $ano; ?>">
						     	<div class="msg-erro"> <? echo form_error('ano'); ?> </div> 
						    </div>
					    </div>
					   
						<div class="form-group">
						    <label for="semana" class="col-sm-3 control-label"> Semana </label>
						    <div class="col-sm-9">
						      	<select class="form-control" name="semana">
									<option value=''> selecione a semana </option> 
									<? $cont = $num_semana;
										for ($cont; $cont>=1; $cont--) { 
										echo "<option value=$cont ".set_select('semana', $cont, ($num_sem_selec == $cont ? TRUE : FALSE ))."> $cont </option>";
										}
									?>	
							  	</select>	
							  	<div class="msg-erro"> <? echo form_error('semana'); ?> </div> 
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
								<div class="msg-erro"> <? echo form_error('cod_cultura'); ?> </div> 		
						    </div>
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
								<div class="msg-erro"> <? echo form_error('cod_variedade'); ?> </div> 	
						    </div>
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
								<div class="msg-erro"> <? echo form_error('cod_lote'); ?> </div> 			
						    </div>
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
						     	<div class="msg-erro"> <? echo form_error('cod_repic_ant'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="data_anterior" class="col-sm-3 control-label"> Data anterior </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" id="data_anterior" name="data_anterior" value="<?php echo set_value('data_anterior'); ?>">
						     	<div class="msg-erro"> <? echo form_error('data_anterior'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="num_expl_prod" class="col-sm-3 control-label"> Nº Expl. produzidos </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="num_expl_prod" value="<?php echo set_value('num_expl_prod'); ?>">
						     	<div class="msg-erro"> <? echo form_error('num_expl_prod'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_fungo" class="col-sm-3 control-label"> Perda p/ fungo </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="pd_fungo" value="<?php echo set_value('pd_fungo'); ?>">
						     	<div class="msg-erro"> <? echo form_error('pd_fungo'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_bacteria" class="col-sm-3 control-label"> Perda p/ bacteria </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="pd_bacteria" value="<?php echo set_value('pd_bacteria'); ?>">
						     	<div class="msg-erro"> <? echo form_error('pd_bacteria'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="pd_oxidacao" class="col-sm-3 control-label"> Perda p/ Oxidação </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="pd_oxidacao" value="<?php echo set_value('pd_oxidacao'); ?>">
						     	<div class="msg-erro"> <? echo form_error('pd_oxidacao'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="total_perdas" class="col-sm-3 control-label"> Total de Perdas </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="total_perdas">
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="num_fr_trab" class="col-sm-3 control-label"> Nº Frasco trabalhado </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="num_fr_trab" value="<?php echo set_value('num_fr_trab'); ?>">
						     	<div class="msg-erro"> <? echo form_error('num_fr_trab'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="num_expl_fr_trab" class="col-sm-3 control-label"> Nº Expl. Frasco Trab. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="num_expl_fr_trab" value="<?php echo set_value('num_expl_fr_trab'); ?>">
						     	<div class="msg-erro"> <? echo form_error('num_expl_fr_trab'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="num_total_expl_trab" class="col-sm-3 control-label"> Nº Total Expl. Trab. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="num_total_expl_trab" value="<?php echo set_value('num_total_expl_trab'); ?>">
						     	<div class="msg-erro"> <? echo form_error('num_total_expl_trab'); ?> </div> 
						    </div>
					    </div>
					    
					       <div class="form-group">
						    <label for="tamanho_expl" class="col-sm-3 control-label"> Tam Expl. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="tamanho_expl" value="<?php echo set_value('tamanho_expl'); ?>">
						     	<div class="msg-erro"> <? echo form_error('tamanho_expl'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="contaminacao" class="col-sm-3 control-label"> Contaminação Lote. </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="contaminacao" value="<?php echo set_value('contaminacao'); ?>">
						     	<div class="msg-erro"> <? echo form_error('contaminacao'); ?> </div> 
						    </div>
					    </div>
					    
					    <div class="form-group">
						    <label for="tipo_meio" class="col-sm-3 control-label"> Tipo de meio </label>
						    <div class="col-sm-9">
						    	<input type="text" class="form-control" name="tipo_meio" value="<?php echo set_value('tipo_meio'); ?>">
						     	<div class="msg-erro"> <? echo form_error('tipo_meio'); ?> </div> 
						    </div>
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
					     	<div class="msg-erro"> <? echo form_error('cod_repic_atual'); ?> </div> 
					    </div>
					</div>
					    
				    <div class="form-group">
					    <label for="data_atual" class="col-sm-3 control-label"> Data atual </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" id="data_atual" name="data_atual" value="<?php echo set_value('data_atual'); ?>">
					     	<div class="msg-erro"> <? echo form_error('data_atual'); ?> </div> 
					    </div>
				    </div>
				    
				    <div class="form-group">
					    <label for="num_fr_pote_prod" class="col-sm-3 control-label"> Nº Frasco/pote produzidos. </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="num_fr_pote_prod" value="<?php echo set_value('num_fr_pote_prod'); ?>">
					     	<div class="msg-erro"> <? echo form_error('num_fr_pote_prod'); ?> </div> 
					    </div>
					</div>
					    
					<div class="form-group">
					    <label for="num_expl_fr_pote" class="col-sm-3 control-label"> Nº Expl. Frasco/pote </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="num_expl_fr_pote" value="<?php echo set_value('num_expl_fr_pote'); ?>">
					     	<div class="msg-erro"> <? echo form_error('num_expl_fr_pote'); ?> </div> 
					    </div>
					</div>
					
					<div class="form-group">
					    <label for="subtotal1" class="col-sm-3 control-label"> Subtotal1 </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="subtotal1" value="<?php echo set_value('subtotal1'); ?>">
					     	<div class="msg-erro"> <? echo form_error('subtotal1'); ?> </div> 
					    </div>
					</div>
					    
			     	<div class="form-group">
					    <label for="total_fr_pote_prod" class="col-sm-3 control-label"> Nº Total Frasco/pote Prod. </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="total_fr_pote_prod" value="<?php echo set_value('total_fr_pote_prod'); ?>">
					     	<div class="msg-erro"> <? echo form_error('total_fr_pote_prod'); ?> </div> 
					    </div>
			   	 	</div>
							
					<div class="form-group">
					    <label for="subtotal2" class="col-sm-3 control-label"> Subtotal2. </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="subtotal2" value="<?php echo set_value('subtotal2'); ?>">
					     	<div class="msg-erro"> <? echo form_error('subtotal2'); ?> </div> 
					    </div>
					</div>
					    
					<div class="form-group">
					    <label for="num_quebrado" class="col-sm-3 control-label"> Nº Queb. </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="num_quebrado" value="<?php echo set_value('num_quebrado'); ?>">
					     	<div class="msg-erro"> <? echo form_error('num_quebrado'); ?> </div> 
					    </div>
					</div>
					
					<div class="form-group">
					    <label for="total_expl_prod" class="col-sm-3 control-label"> Nº Expl. Produzidos </label>
					    <div class="col-sm-9">
					    	<input type="text" class="form-control" name="total_expl_prod" value="<?php echo set_value('total_expl_prod'); ?>">
					     	<div class="msg-erro"> <? echo form_error('total_expl_prod'); ?> </div> 
					    </div>
					</div>
					    			
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">
					
				</form>
		
		</div> <!-- fim panel-body -->
		
		<div class="panel-footer"> </div>
			
	</div><!-- Fim Panel -->
</div>



