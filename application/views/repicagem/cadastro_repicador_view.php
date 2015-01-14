<h4 class="text-center"> Cadastrar Repicador </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Preencha os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">	
				<form name="cadastro_repicador" method="post" action="<?php echo base_url('repicagem/cadastrar_repicador');?>"> 
					
					<div class="form-group">
						<label for="repicador">Nome do Repicador(a):</label> 
						<div class="form-inline">
							<input type="text" class="form-control" name="repicador"  size="40" value="<?php echo set_value('repicador')?>">
						</div>
					</div>
					
					<div class="msg-erro-cadastro">
						<?php echo form_error('repicador'); ?>
					</div>
																																																						
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>


