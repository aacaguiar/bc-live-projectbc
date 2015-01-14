<script type="text/javascript">

</script>
<h4 class="text-center"> Armazenar Contrato </h4>

<div class="box-upload">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"> <strong> Clique no botão selecionar arquivo: </strong> </span>
			</div>
			<div class="panel-body">	
			
				<form name="salvar_cont" class="box-form" method="post" enctype="multipart/form-data" action="<?php echo base_url('contrato/salvar_contrato');?>"> 
				
					<div class="form-group">
				    	<input type="file" name="arquivo_cont">
				  	</div>
				  
				  	<div class="msg-erro-envio">
						<?php echo $erro ?>
					</div>
																																																						
					<input type="submit" class="btn btn-default" style="margin-top:20px;" value="Enviar">
				</form>
				
			</div> <!-- fim panel-body -->
			
			<div class="panel-footer"> </div>
			
		</div> <!-- Fim Panel -->
</div>


