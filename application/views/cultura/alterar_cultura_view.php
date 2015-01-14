<h4 class="text-center"> Alterar Cultura </h4> 

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Altere os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">	
				<form name="cadastro_cliente" method="post" action="<?php echo base_url('cultura/alterar_dados_cultura');?>"> 
				<input type="hidden" name="cod_cultura" value="<?echo $cod_cultura;?>">
					<div class="form-group">
						<label for="pessoa_fisica">Nome da Cultura:</label> 
						<div class="form-inline">
							<input type="text" class="form-control" id="nome_cultura" name="nome_cultura"  size="40" value="<? echo $nome_cultura;?>">
							<!-- 
							<div class="check_cult">
								<input type="checkbox" class="checkbox" id="lista_var" name="lista_var" onChange="exibir_culturas()"> <small>Culturas cadastradas</small>
							</div>
							-->
						</div>
					</div>
					
					<div class="msg-erro-cadastro">
						<?php echo form_error('nome_cultura'); ?>
					</div>
																																																						
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>
