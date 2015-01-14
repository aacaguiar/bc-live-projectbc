<script src="<?php echo base_url('js/cultura/cultura.js')?>"></script>
<script>
url_carregar_variedade = "<?echo base_url('cultura/carregar_variedade')?>";
url_alterar_variedade = "<?echo base_url('cultura/alterar_variedade');?>";
url_excluir_variedade = "<?echo base_url('cultura/excluir_variedade');?>";

window.onload = function (){
	//carregar_variedade();
};	
</script>

<h4 class="text-center"> Consulta de Variedade </h4>

		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Escolha uma Cultura para visualizar as variedades:</strong></span>
			</div>
			<div class="panel-body">				
					<div class="form-group">
						<label for="cultura">Cultura:</label>
						<form method="post" action="<?echo base_url('cultura/consultar_variedade');?>" id="form_cult">
							<select class="form-control" style="width:250px;" id="cultura" name="cultura" onChange="enviar()">
								<option value=0>Selecione uma opção</option>
								<? foreach ($lista_cultura as $cod_cultura => $nome_cultura) { ?>
								<option value="<? echo $cod_cultura; ?>" <? echo set_select('cultura',"$cod_cultura",($cultura_selec == "$cod_cultura" ? TRUE : FALSE ));?>><? echo $nome_cultura;?></option>
								<? } ?>
							</select>
						</form>	 
					</div>
					
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 		<th style="width:400px">Nome da Variedade</th>
										<th>Sigla</th>
										<th>Ações</th>
									</tr>	
								</thead>
								
								<tbody>				
								<?	if ($lista_variedade != '') {
										for($i = 1; $i <= sizeof($lista_variedade); $i++) {
								?>
								<tr class="texto-celula">
									<form method="post" action="" id="<?echo "form".$i;?>" >
										
										<input type="hidden" name="nome_cultura" id="<?echo "nome_cultura".$i;?>" value="">
										<input type="hidden" name="cod_variedade" value="<? echo $lista_variedade[$i]['cod_variedade'];?>">
										
										<td> 
											<?echo $inicio++;?> 
										</td> 
										
										<td> 
											<input type="hidden" name="nome_variedade" value="<? echo $lista_variedade[$i]['nome_variedade'];?>"> <? echo $lista_variedade[$i]['nome_variedade'];?> 
										</td>
										
										<td> 
											<input type="hidden" name="sigla_variedade" value="<? echo $lista_variedade[$i]['sigla_variedade'];?>"> <? echo $lista_variedade[$i]['sigla_variedade'];?> 
										</td>
							
										<td style='width:45px;'>
											<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_variedade(<? echo $i;?>)">
  												<span class="glyphicon glyphicon-pencil"> </span>
											</button>	
												
											<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_variedade(<? echo $i;?>)">
  												<span class="glyphicon glyphicon-trash"> </span>
											</button>
										<!-- 
											<input type="image" class="btn-editar"  src="<?php //echo base_url('imagens/icones/Pencil2.png')?>" onMouseOver="this.title='Editar'" onClick="alt_variedade(<?//echo $i;?>)" name="editar"> 
											<input type="image"	class="btn-excluir" src="<?php //echo base_url('imagens/icones/Trash-icon.png')?>" onMouseOver="this.title='Excluir'" onClick="exc_variedade(<?//echo $i;?>)" name="excluir">  
										-->
										</td>	
									</form>
								</tr>
								<?	}
								  } 
								?>
								</tbody>
							</table>																											
			</div><!-- fim panel-body -->
		<div class="panel-footer">
				<? 
				if ($pag!='') {
					echo "<small> <p> <b>Página:</b> $pag de $total_pag de $total_linhas registros</small> </p>";
					if ($pagination!=''){
						echo "<ul class='pagination pag2'> $pagination </ul>";
					}
				}
				?>
		</div>
</div><!-- Fim Panel -->








