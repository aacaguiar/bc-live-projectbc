<script type="text/javascript" src="<?php echo base_url('js/cultura/cultura.js')?>"></script>
<script type="text/javascript">
url_listar_culturas = "<?echo base_url('cultura/exibir_cultura');?>";
</script>
<h4 class="text-center"> Cadastrar Cultura </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Preencha os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">	
				<form name="cadastro_cliente" method="post" action="<?php echo base_url('cultura/cadastrar_cultura');?>"> 
					
					<div class="form-group">
						<label for="pessoa_fisica">Nome da Cultura:</label> 
						<div class="form-inline">
							<input type="text" class="form-control" id="nome_cult" name="nome_cult"  size="40" value="<?php echo set_value('nome_cult')?>">
						</div>
					</div>
					
					<div class="msg-erro-cadastro">
						<?php echo form_error('nome_cult'); ?>
					</div>
																																																						
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>


