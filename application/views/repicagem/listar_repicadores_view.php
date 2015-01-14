<script src="<?php echo base_url('js/repicagem/lista_repicador.js')?>"></script>
<script>
url_alterar_repicador = "<?echo base_url('repicagem/alterar_repicador');?>";
url_excluir_repicador = "<?echo base_url('repicagem/excluir_repicador');?>";
</script>

<h4 class="text-center"> Listagem de Repicadores </h4>

<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Repicadores Cadastradas:</strong></span>
			</div>
			<div class="panel-body">				
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 		<th>Nome do repicador</th>
										<th>Ativo</th> 
										<th>Ações</th>
									</tr>	
								</thead>
								
								<tbody>				
								<?	for($i = 1; $i <= sizeof($lista_repicadores); $i++) { ?>
								<tr class="texto-celula">
									<form method="post" action="" id="<?echo "form".$i;?>" >
										<input type="hidden" name="id_repicador" value="<? echo $lista_repicadores[$i]['id_repicador'];?>">
										
										<td> 
											<?echo $inicio++;?> 
										</td> 
										
										<td> 
											<input type="hidden" name="repicador" value="<? echo $lista_repicadores[$i]['repicador'];?>"> <? echo $lista_repicadores[$i]['repicador'];?> 
										</td>
										
										<td> 
											<?php ?>
											<input type="hidden" name="ativo" value="<? echo $lista_repicadores[$i]['ativo'];?>"> <? echo ($lista_repicadores[$i]['ativo'] == 't') ? 'sim' : 'não';?> 
										</td> 
							
										<td style='width:45px;'>
										
										<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_repicador(<?echo $i;?>)">
  											<span class="glyphicon glyphicon-pencil"> </span>
										</button>	
												
										<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_repicador(<?echo $i;?>,<?php echo $lista_repicadores[$i]['repicador']?>)">
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



