<script src="<?php echo base_url('js/cultura/cultura.js');?>"></script>
<script type="text/javascript">
	//qtde_var = "<?echo $qtde_var_selec;?>";
window.onload = function (){
	listar_campos_var();
}		

</script>
<h4 class="text-center"> Cadastrar Variedade </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Preencha os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">
				<form name="cadastro_variedade" id="cadastro_variedade" method="post" action="<?php echo base_url('cultura/cadastrar_variedade');?>">					
					<div class="form-group">
						<label for="tipo_cliente">Cultura:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" style="width:250px;" id="cultura" name="cultura">
								<option value="0">Selecione uma opção</option>
								<? foreach ($lista_cultura as $cod_cultura => $nome_cultura) { ?>
								<option value="<? echo $cod_cultura; ?>" <? echo set_select('cultura',"$cod_cultura",($cultura_selec == "$nome_cultura" ? TRUE : FALSE ));?>><? echo $nome_cultura;?></option>
								<? } ?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro">
						<? echo form_error('cultura'); ?>
					</div>
					
					<div class="form-group">
						<label for="qtde_var">Qtde de variedades adicionar:</label>		
						<div class="select-cadastro-cli">
							<select class="form-control" style="width:250px" id=qtde_var name="qtde_var" onChange="listar_campos_var()">
								<option value="0"> Selecione uma opção </option>
								<? foreach ($qtde_var_adicionar as $valor) { ?>
								<option value="<? echo $valor; ?>" <? echo set_select('qtde_var',$valor,($qtde_var_selec == $valor ? TRUE : FALSE ));?>> <? echo $valor;?> </option>
								<? } ?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro">
						<? echo form_error('qtde_var'); ?>
					</div>
					
					<table>
						<? for ($i=1; $i<=10; $i++) { ?>
						<tr style="display:none" id="<?echo "linha-campo".$i;?>">
							<td>
								<label for="nome_var">Nome da variedade:</label>
								<input type='text' class='form-control' size="50" name='nome_var[<?echo $i?>]' id='<?echo 'nome_var'.$i?>' value='<?echo $nome_var[$i]?>'>
								
							</td>
							<td>
								<label for="nome_sigla">Sigla:</label>
								<input type='text' class='form-control maiuscula' size="10" name='nome_sigla[<?echo $i?>]' id='<?echo 'nome_sigla'.$i?>' value='<?echo $nome_sigla[$i]?>'>
							</td>
						</tr>
						<tr style="display:none" id="<?echo "linha-erro".$i;?>">
							<td>
								<div class="msg-erro-cadastro" id='<?echo 'erro-var'.$i?>'>
									<? echo form_error('nome_var['.$i.']');?>
								</div>
							</td>
							<td>
								<div class="msg-erro-cadastro" id='<?echo 'erro-sigla'.$i?>'>
									<? echo form_error('nome_sigla['.$i.']');?>
								</div>
							</td>			
						</tr>
						<?}?> 
					</table>
													
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">	
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
</div>


