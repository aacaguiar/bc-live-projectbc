<h4 class="text-center"> Alterar Repicador </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Altere os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">	
				<form name="cadastro_repicador" method="post" action="<?php echo base_url('repicagem/alterar_dados_repicador');?>">
				 
					<input type="hidden" name="id_repicador" value="<? echo $id_repicador?>">
					
					<div class="form-group">
						<label for="repicador">Nome do Repicador(a):</label> 
						<input type="text" class="form-control" name="repicador" size="40" value="<?php echo $repicador?>">
					</div>
					
					<div class="msg-erro-cadastro">
						<?php echo form_error('repicador'); ?>
					</div>
					
					<div class="form-group" >
						<label for="ativo">Ativo:</label> 
						<div class="form-inline" style="margin-top:-2px;">
							<div class="radio">
								<label for="Sim">Sim</label> 
							    	<input type="radio" name="ativo" value='t' <?php echo ($ativo == 't') ? 'checked' : ''?> >
								</label>
							</div>
							<div class="radio" style="margin-left:10px;">
								<label for="Não">Não</label> 
							    	<input type="radio" name="ativo" value='f' <?php echo ($ativo != 't') ? 'checked' : ''?> >
								</label>
							</div>
						</div>
						
					</div>					
																																																																	
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>



