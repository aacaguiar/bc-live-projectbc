<h4 class="text-center"> Alterar Variedade </h4> 

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Altere os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">	
				<form name="alterar_var" method="post" action="<?php echo base_url('cultura/alterar_dados_variedade');?>"> 
					<input type="hidden" name="cod_variedade" value="<?echo $cod_variedade?>">
					<input type="hidden" name="nome_cultura" value="<?echo $nome_cultura?>">
					
					<div class="form-group">
						<h4>Cultura: <?echo $nome_cultura?></h4> <a style="float:right;margin-top:-20px;" href="<?echo base_url('cultura/consultar_variedade')?>">voltar</a>
					</div>
					
					<table>
						<tr>
							<td>
								<label for="nome_var">Nome da variedade:</label>
								<input type='text' class='form-control' size="50" name='nome_variedade' value='<?echo $nome_variedade?>'>
								
							</td>
							<td>
								<label for="nome_sigla">Sigla:</label>
								<input type='text' class='form-control maiuscula' size="10" name='sigla_variedade' value='<?echo $sigla_variedade?>'>
							</td>
						</tr>
						<tr>
							<td>
								<div class="msg-erro-cadastro">
									<? echo form_error('nome_variedade');?>
								</div>
							</td>
							<td>
								<div class="msg-erro-cadastro">
									<? echo form_error('sigla_variedade');?>
								</div>
							</td>			
						</tr> 
					</table>
																																																						
					<input type="submit" class="btn btn-default" style="margin-top:20px;" value="Alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>



