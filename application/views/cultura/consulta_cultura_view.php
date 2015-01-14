<script src="<?php echo base_url('js/cultura/cultura.js')?>"></script>
<script>
url_alterar_cultura = "<?echo base_url('cultura/alterar_cultura');?>";
url_excluir_cultura = "<?echo base_url('cultura/excluir_cultura');?>";
</script>

<h4 class="text-center"> Consulta de Culturas </h4>

<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Listagem das Culturas Cadastradas:</strong></span>
			</div>
			<div class="panel-body">				
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 		<th>Nome da Cultura</th>
										<th>Qtde. Variedades</th> 
										<th>Ações</th>
									</tr>	
								</thead>
								
								<tbody>				
								<?	for($i = 1; $i <= sizeof($lista_cultura); $i++) { ?>
								<tr class="texto-celula">
									<form method="post" action="" id="<?echo "form".$i;?>" >
										<input type="hidden" name="cod_cultura" value="<? echo $lista_cultura[$i]['cod_cultura'];?>">
										
										<td> 
											<?echo $inicio++;?> 
										</td> 
										
										<td> 
											<input type="hidden" name="nome_cultura" value="<? echo $lista_cultura[$i]['cultura'];?>"> <? echo $lista_cultura[$i]['cultura'];?> 
										</td>
										
										<td> 
											<input type="hidden" name="qtde_var" value="<? echo $lista_cultura[$i]['qtde_var'];?>"> <? echo $lista_cultura[$i]['qtde_var'];?> 
										</td> 
							
										<td style='width:45px;'>
										
										<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_cultura(<?echo $i;?>)">
  											<span class="glyphicon glyphicon-pencil"> </span>
										</button>	
												
										<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_cultura(<?echo $i;?>)">
  											<span class="glyphicon glyphicon-trash"> </span>
										</button>
										
										</td>	
									</form>
								</tr>
								<? } ?>
								</tbody>
							</table>																											
			</div><!-- fim panel-body -->
		<div class="panel-footer">
				<? 
				if ($pag!='') {
					echo "<small><b>Página:</b> $pag de $total_pag <br><b>Total de registros:</b> $total_linhas</small>";
					if ($pagination!=''){
						echo "<ul class='pagination pag2'> $pagination </ul>";
					}
				}
				?>
				
		</div>
</div><!-- Fim Panel -->


