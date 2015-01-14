<script type="text/javascript" src="<?php echo base_url('js/lote/lista_lote.js');?>"></script>
<script type="text/javascript">
url_alterar_lote = "<?php echo base_url('lote/alterar_lote');?>";
url_excluir_lote = "<?php echo base_url('lote/excluir_lote');?>";
url_redirecionar_ger_lote = "<?php echo base_url('lote/redirecionar_gerenciar_lote');?>";
</script>

<h4 class="text-center"> Consulta de Lotes </h4>

		 <div class="box-pesquisa text-right">
				<form name="form_pesquisa" class="form-inline" method="post" action="<?echo base_url('lote/pesquisar_lote');?>">
					<div class="form-group">
						  
							 <select class="form-control" id="selec_pesq" name="selec_pesq">
							 <option value="">pesquisar por</option>
							 	<?php 
							 		//$selecao = array(1=>'Lote',2=>'Nº do pedido',3=>'Variedade');
							 		$selecao = array(1=>'Lote');
							 		for($i=1; $i<=sizeof($selecao); $i++){
										echo "<option value='$i' ".set_select('selec_pesq',$i,($tipo_pesquisa == $i ? TRUE : FALSE )).">$selecao[$i]</option>";
							 		}
							 	?>
							 </select>
						  	
						    <input type="text" class="form-control ped_field_pesq" id="pesquisa" name="pesquisa" value="<?php echo set_value('pesquisa');?>">
						  	<input type="image" class="btn btn-default" style="width:40px;height:23px;" src="<?php echo base_url('imagens/icones/pesquisa3.png')?>"> 
						  	
						  	<div class="msg-erro-pesq">
								<?php echo form_error('pesquisa'); ?>
							</div>
					</div> 
				</form>
		 </div>	
					
	  	 <div class="panel panel-default">
	  	 
			<div class="panel-heading">
				<div class="panel-title"><strong>Listagem de Lotes:</strong></div>		
			</div>
			
			<div class="panel-body">
			
						<div class="">	
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th> 
								 		<th>Nº Lote</th> 
								 		<th>Nº Ped.</th> 
								 		<th>Transportadora</th> 
								 		<th>Fornecedor</th> 
								 		<th>Cultura</th>
										<th>Variedade</th>
										<th>Tipo mat.</th>
										<th>Sel. posit.</th>
										<th>Qtde. Receb.</th>
										<th>Data Receb.</th>
										<th>Ações</th>
									</tr>	
								</thead>
								
								<tbody>				
								<?
								 for ($i=1; $i<=sizeof($lista_lote); $i++ ){ 
									$num_pedido = ($lista_lote[$i]['num_pedido'] == 0) ? '' : $lista_lote[$i]['num_pedido'];
									
									$campo_sel_posit = ($lista_lote[$i]['sel_posit'] == 't') ? 'sim' : 'não';
									$complet = ( strlen($lista_lote[$i]['tipo_mat']) <= 20 ) ? '' : ' ...';
									$campo_tipo_mat = substr($lista_lote[$i]['tipo_mat'],0,20).$complet;
								?>
								<tr class="texto-pesquisa">
									<form method="post" action="" name="listar" id="<?echo "form".$i;?>"> 
																																														 
										<input type="hidden" name="cod_lote" value="<? echo $lista_lote[$i]['cod_lote'];?>"> 
										<input type="hidden" name="cod_cultura" value="<? echo $lista_lote[$i]['cod_cultura'];?>"> 
										<input type="hidden" name="cod_variedade" value="<? echo $lista_lote[$i]['cod_variedade']; ?>"> 
										
											<td> <? echo $inicio++; ?> </td>
																						
											<td> <input type="hidden" name="num_lote" value="<? echo $lista_lote[$i]['num_lote'];?>"> <? echo $lista_lote[$i]['num_lote'];?> </td>
											
											<td> <input type="hidden" name="num_pedido" value="<? echo $lista_lote[$i]['num_pedido'];?>"> <? echo $num_pedido;?> </td>
											
											<td> <input type="hidden" name="transportadora" value="<? echo $lista_lote[$i]['transportadora'];?>"> <? echo $lista_lote[$i]['transportadora'];?> </td>
											
											<td> <input type="hidden" name="fornecedor" value="<? echo $lista_lote[$i]['fornecedor'];?>"> <? echo $lista_lote[$i]['fornecedor'];?> </td>
											
											<td> <input type="hidden" name="cultura" value="<? echo $lista_lote[$i]['cultura'];?>"> <? echo $lista_lote[$i]['cultura'];?> </td>
											
											<td> <input type="hidden" name="variedade" value="<? echo $lista_lote[$i]['variedade'];?>"> <? echo $lista_lote[$i]['variedade'];?> </td>
											
											<td> <input type="hidden" name="tipo_mat" value="<? echo $lista_lote[$i]['tipo_mat'];?>"> <? echo $campo_tipo_mat;?> </td>
											
											<td> <input type="hidden" name="sel_posit" value="<? echo $lista_lote[$i]['sel_posit'];?>"> <? echo $campo_sel_posit;?> </td>
											   
											<td> <input type="hidden" name="qtde_recebida" value="<? echo $lista_lote[$i]['qtde_recebida'];?>"><? echo $lista_lote[$i]['qtde_recebida'];?></td>
											
											<td> <input type="hidden" name="data_recebimento" value="<? echo $lista_lote[$i]['data_recebimento'];?>"><? echo $lista_lote[$i]['data_recebimento'];?></td>
																				  
										  	<td style="width:45px;">
										  		<!-- <input type="image" src="<?php //echo base_url('imagens/icones/align_right.png')?>" onMouseOver="this.title='Gerenciar Lote'" onClick="gerenciar_lote(<?//echo $i;?>)" name="gerenciar" class="btn-editar"> -->
										  		
										  		<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_lote(<?echo $i;?>)">
  													<span class="glyphicon glyphicon-pencil" style=""> </span>
												</button>	
												
												<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_lote(<?echo $i;?>)">
  													<span class="glyphicon glyphicon-trash" style=""> </span>
												</button>
												
										 	 </td>
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


