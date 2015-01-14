<script type="text/javascript" src="<?php echo base_url('js/pedido/lista_pedido.js');?>"> </script>
<script type="text/javascript">
url_alterar_pedido = "<?php echo base_url('pedido/alterar_pedido');?>";
url_excluir_pedido = "<?php echo base_url('pedido/excluir_pedido');?>";
</script>

	<h4 class="text-center">Consulta de Pedidos</h4> 

				<div class="box-pesquisa text-right">
					<form name="form_pesquisa" class="form-inline" method="post" action="<? echo base_url('pedido/pesquisar_pedido');?>">
						  <div class="form-group">
						  
							 <select class="form-control" id="selec_pesq" name="selec_pesq">
							 <option value="0"> pesquisar por </option>
							 	<?php 
							 		$selecao = array(1=>'cliente',2=>'pedido');
							 		for($i=1; $i<=2; $i++){
										$selected = ($tipo_pesquisa == $selecao[$i]) ? 'selected' : '';
							 			echo "<option value='$selecao[$i]' $selected> $selecao[$i] </option>";
							 		}
							 	?> 
							 </select>
						  	
						    <input type="text" class="form-control campo_pesq" id="pesquisa" name="pesquisa" value="<?php echo set_value('pesquisa');?>">
						  	<!-- 
						  	<input type="image" class="btn btn-default" style="width:40px;height:23px;" src="<?php //echo base_url('imagens/icones/pesquisa3.png')?>"> 
						  	-->
						  	<button type="submit" class="btn btn-default" style="height:23px;">
							  <span class="glyphicon glyphicon-search"> </span>
							</button>
							
						  	<div class="msg-erro-pesq">
								<?php echo form_error('pesquisa'); ?>
							</div>
						 </div> 
					</form>
				</div>	

												
	  	 <div class="panel panel-default">
	  	 
			<div class="panel-heading">
				<div class="panel-title"> <strong> Listagem de Pedidos: </strong> </div>	 		
			</div>
			
			<div class="panel-body">
			
						<div class="">	
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 		<th>Nº Ped.</th>
										<th>Cliente</th>
										<th>Cultura</th>
										<th>Variedade</th>
										<th>Fase/Entrega</th>
										<th>Qtde.<br> Pedido</th>
										<th>Muda (R$)</th>
										<th>Total (R$)</th>
										<!-- <th>Forma<br>pagto</th> -->
										<th>Frq. Entrega</th>
										<th>Qtde.<br> Entregas</th>
										<th>Data <br> Pedido</th>
										<th>Ações</th>
									</tr>	
								</thead>
								
								<tbody>				
								<?
								 
								 for ($i=0; $i<sizeof($lista_pedido); $i++ ){ 
									$qtde_formatado = number_format($lista_pedido[$i]['qtde_pedido'], 0,'','.');
									$vl_tot_format = number_format($lista_pedido[$i]['vl_total'], 0,'','.');
									
									//$complet = ( strlen($lista_pedido[$i]['cliente'])<=20 ) ? '' : ' ...';
									//$nome_curto = substr($lista_pedido[$i]['cliente'], 0, 20).$complet;
								?>
								<tr class="texto-pesquisa">
									<form method="post" action="" name="listar" id="<?echo "form".$i;?>"> 
																															 
										<!-- <input type="hidden" name="cod_pedido" value="<? //echo $lista_pedido[$i]['cod_pedido'];?>"> --> 
										<input type="hidden" name="check_pf" value="<? echo $lista_pedido[$i]['check_pf'];?>">  
										<input type="hidden" name="end_atual" value="<? echo $lista_pedido[$i]['end_atual'];?>"> 
										<input type="hidden" name="end_novo" value="<? echo $lista_pedido[$i]['end_novo'];?>">
										<input type="hidden" name="forma_pagto" value="<? echo $lista_pedido[$i]['forma_pagto'];?>">  
										
											<td> <? echo $inicio++; ?> </td>
																						
											<td> <input type="hidden" name="num_pedido" value="<? echo $lista_pedido[$i]['cod_pedido'];?>"> <? echo $lista_pedido[$i]['cod_pedido'];?> </td>
											
											<td> <input type="hidden" name="id_clifor" value="<? echo $lista_pedido[$i]['id_clifor'];?>"> <? echo $lista_pedido[$i]['cliente']; //$lista_pedido[$i]['cliente']?> </td>
											
											<td> <input type="hidden" name="cod_cultura" value="<? echo $lista_pedido[$i]['cod_cultura'];?>"> <? echo $lista_pedido[$i]['cultura'];?> </td>
											
											<td> <input type="hidden" name="cod_variedade" value="<? echo $lista_pedido[$i]['cod_variedade'];?>"> <? echo $lista_pedido[$i]['variedade'];?> </td>
											
											<td> <input type="hidden" name="fase_entrega" value="<? echo $lista_pedido[$i]['fase_entrega'];?>"> <? echo $lista_pedido[$i]['fase_entrega'];?> </td>
											
											<td> <input type="hidden" name="qtde_pedido" value="<? echo $lista_pedido[$i]['qtde_pedido'];?>"> <? echo $qtde_formatado;?> </td>
											
											<td> <input type="hidden" name="vl_muda" value="<? echo $lista_pedido[$i]['vl_muda'];?>"> <? echo $lista_pedido[$i]['vl_muda'];?> </td>
											
											<td> <input type="hidden" name="vl_total" value="<? echo $lista_pedido[$i]['vl_total'];?>"> <? echo $vl_tot_format;?> </td>
<!-- 											
											<td> <input type="hidden" name="forma_pagto" value="<? //echo $lista_pedido[$i]['forma_pagto'];?>"> <? //echo $lista_pedido[$i]['forma_pagto'];?> </td>
-->										   
											<td> <input type="hidden" name="frq_entrega" value="<? echo $lista_pedido[$i]['frq_entrega'];?>"> <? echo $lista_pedido[$i]['frq_entrega'];?></td>
											
											<td> <input  type="hidden" name="qtde_entrega" value="<?echo $lista_pedido[$i]['qtde_entrega'];?>">
												<a style="cursor:pointer" onClick='mostrar_entregas(<?echo 'form'.$i;?>)'> <?echo $lista_pedido[$i]['qtde_entrega'];?> </a>
											</td>
											
											<td> <input type="hidden" name="data_pedido" value="<? echo $lista_pedido[$i]['data_pedido'];?>"> <? echo $lista_pedido[$i]['data_pedido'];?> </td> 
											
											<!-- <td> <input type="hidden" name="fornecedor" value="<? //echo $lista_pedido[$i]['cod_fornecedor'];?>"> <? //echo $lista_pedido[$i]['cod_fornecedor'];?> </td> -->  
										  
										  	<td style="width:45px;">
										  		
				  								<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_pedido(<? echo $i;?>)">
  													<span class="glyphicon glyphicon-pencil" style=""> </span>
												</button>	
												
												<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_pedido(<? echo $i;?>)">
  													<span class="glyphicon glyphicon-trash" style=""> </span>
												</button>	
  											
										 	 </td>
										  	<!--  
											<td> <input type="submit" name="editar" value="editar" class="btn-editar-pesquisa-user"> </td>
										 	-->
									</form>
								</tr>
								<? }?>	
							</tbody>	
						</table>
					</div><!--  fim do table-responsive -->
			  </div>
			  <div class="panel-footer">
			  <?php 
			    if ($pag!='') {
					echo "<small> <p> <b>Página:</b> $pag de $total_pag de $total_linhas registros</small> </p>";
					if ($pagination!=''){
						echo "<ul class='pagination pag2'> $pagination </ul>";
					}
				}
				?>
			</div>			
		</div><!-- fim do panel -->

