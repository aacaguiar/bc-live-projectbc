<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"> </script>
<script src="<?php echo base_url('js/producao/controle_producao.js');?>"> </script>

<script>
url_listar_controle_prod = "<?php echo base_url('producao/listar_controle_prod');?>";
url_alt_controle_prod = "<?php echo base_url('producao/alterar_controle_prod');?>";
url_excl_controle_prod = "<?php echo base_url('producao/excluir_controle_prod');?>";
url_consultar_controle_prod = "<?php echo base_url('producao/consultar_controle_prod');?>";

window.onload = function() {
	//carregar_variedade();
	//carregar_lotes();
};

</script>

<h4 class="text-center"> Consultar Controle da produção </h4> 

<div class="box-consultar-cont">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<span class="panel-title"> <strong> Preencha os dados abaixo: </strong> </span> 							
			</div>
			
			<div class="panel-body">

				<table>
					<thead>
						<tr>
							<form class="form-inline form_lote" id="form_filtragem" method=post action="<?php base_url('producao/consultar_controle_prod')?>">
								<th> 
									<label>Ano:</label>					
									<input type="text" class="form-control" id="filt_ano" name="filt_ano" size="10" value="<?php echo $ano?>"> 
								</th>
								
								<th> 	
									<label>Semana:</label> 										
										<select class="form-control" id="filt_sem" name="filt_sem" onChange="enviar()">
										<?php if ($semana1 != 0) { ?>
										 	<optgroup label="<?php echo "$dia_sem1/12/$ano - $ano_prox";?>">
										    	<option value="<?php echo $semana1; ?>"> <?php echo $semana1; ?> </option>
										  	</optgroup>
										<?php } ?>
										  <optgroup label="<?php echo $ano ?>">
										    <option value='0'> todos </option> 
												<? 
													for ($num_sem; $num_sem>=1; $num_sem--) { 
													$selected = ($semana_selec == $num_sem) ? 'selected' : '';	
													echo "<option value='$num_sem' $selected > $num_sem </option>";
													}
												?>	
										  </optgroup>
											
										</select>	 	
								</th>
								
								<th> 
									<label>Cultura:</label>
										<select class="form-control" id="filt_cult" name="filt_cult">
											<option value='0'>todos</option>
											<? foreach ($lista_cultura as $cod_cultura => $valor){
											 	echo "<option value=$cod_cultura ".set_select('cultura',$cod_cultura,($cult_selec == $cod_cultura ? TRUE : FALSE )).">$valor</option>";
												}
											?>
										</select>	
								</th>
								
								<th> 
									<label>Variedade:</label>											
										<div class="sel-var">
											<select class="form-control" id="filt_var" name="filt_var">
												<option value='0'> todos </option>
												<? foreach ($lista_variedade as $cod_variedade => $valor){
												 	echo "<option value=$cod_variedade ".set_select('variedade',$cod_variedade,($var_selec == $cod_variedade ? TRUE : FALSE ))."> $valor </option>";
													}
												?>
											</select>	 
										</div>		
								 </th>
											
							</form>
						</tr>						
					</thead>														
				</table>
				
				<div class="box-et-prod" > 							
					<table class="table table-hover table-bordered tab-et-lote"  id="tab_et_prod">
						<thead>
							<tr>
								<th colspan="6" >  <h4> Informações do Lote</h4> </th>
								<th colspan="13" > <h4> Informações da etapa anterior </h4> </th>
								<th colspan="10" > <h4> Informações da etapa atual </h4> </th>
								<th colspan="4" > <h4> Análise inicial </h4> </th>
								<th rowspan="2" > <h5> &nbspAções&nbsp  </h5> </th>
							</tr>
							
							<tr>
								<th > linha </th>
								<th > Ano </th>
								<th > Semana </th>
								<th > Cultura </th>
								<th > Variedade </th>
								<th > Lote </th>
								<!-- etapa anterior -->
								<th > Repic.&nbspanterior  </th>
								<th > Data anterior </th>
								<th > Nº expl.<br> prod. </th>
								<th > Perd p/<br> fungo </th> 
								<th > Perd p/<br> bact </th> 
								<th > Perd p/<br> oxid </th> 
								<th > Total<br> perdas </th> 
								<th > Nº frasco<br> trab. </th> 
								<th > Nº Expl.<br> frasco<br> trab. </th>
								<th > Nº Total<br>Expl.<br> trab. </th>
								<th > Tam. Expl. </th>
								<th > Contam.<br>lote </th>
								<th > Tipo<br>meio </th>
								<!-- etapa atual -->
								<th > Repic.&nbspatual</th>
								<th > Data atual </th>
								<th > Nº Pote<br>prod. </th>
								<th > Nº Expl.<br>Pote </th> 
								<th > Subtotal1 </th> 
								<th > Nº Frasco<br>prod. </th>  
								<th > Nº Expl.<br>Frasco<br> </th>
								<th > subtotal2 </th> 
								<th > Nº quebr. </th>
								<th > Total<br>expl.<br>prod.</th>
								<!-- Análise Inicial -->
								<th > Fase</th>
								<th > Cód. Fase </th>
								<th > Fator<br>Conver. </th>
								<th > Pontos<br>Repic. </th> 
							</tr>						
						</thead>
						
						<tbody class="x">
							<?php
								if($info_lote != ''){
									for($i = 1; $i <= sizeof($info_lote); $i++) { 
							?>
											
							<tr id="<?echo $i;?>" >
							<form method="post" action="" name="controle_prod" id="<? echo "form".$i;?>"> 
											
								<input type="hidden" name="id" value="<? echo $info_lote[$i]['id'];?>"> 
											
								<!-- filtros -->
								<input type="hidden" name="filt_ano" value="<? echo $info_lote[$i]['filt_ano'];?>"> 
								<input type="hidden" name="filt_sem" value="<? echo $info_lote[$i]['filt_sem'];?>"> 
								<input type="hidden" name="filt_cult" value="<? //echo $info_lote[$i]['filt_cult'];?>"> 
								<input type="hidden" name="filt_var" value="<? //echo $info_lote[$i]['filt_var'];?>"> 
								<!-- <input type="hidden" name="cod_cultura" value="<? //echo $info_lote[$i]['cod_cultura'];?>">
								<input type="hidden" name="cod_variedade" value="<? //echo $info_lote[$i]['cod_variedade'];?>">
								<input type="hidden" name="cod_lote" value="<? //echo $info_lote[$i]['cod_lote'];?>"> 
								<input type="hidden" name="cod_repic_ant" value="<? //echo $info_lote[$i]['cod_repic_ant'];?>">
								<input type="hidden" name="cod_repic_atual" value="<? //echo $info_lote[$i]['cod_repic_atual'];?>"> -->
								
								<td> <? echo ++$inicio;?> </td>
								
								<!-- Informações do Lote  -->
								
								<td> <input type=hidden name="ano" value="<? echo $info_lote[$i]['ano'];?>"> <? echo $info_lote[$i]['ano'];?> </td>
									
								<td> <input type=hidden name="semana" value="<? echo $info_lote[$i]['semana'];?>"> <? echo $info_lote[$i]['semana'];?> </td>
								
								<td> <input type=hidden name="cod_cultura" value="<? echo $info_lote[$i]['cod_cultura'];?>"> <? echo $info_lote[$i]['cultura'];?> </td>
																					
								<td> <input type=hidden name="cod_variedade" value="<? echo $info_lote[$i]['cod_variedade'];?>"> <? echo $info_lote[$i]['variedade'];?> </td>						
								
								<td> <input type=hidden name="cod_lote" value="<? echo $info_lote[$i]['cod_lote'];?>"> <? echo $info_lote[$i]['lote'];?> </td>										
								
								<!-- Et. Anterior  -->
								
								<td> <input type=hidden name="cod_repic_ant" value="<? echo $info_lote[$i]['cod_repic_ant'];?>"> <? echo $info_lote[$i]['repic_ant'];?> </td>
									
								<td> <input type=hidden name="data_anterior" value="<? echo $info_lote[$i]['data_anterior'];?>"> <? echo $info_lote[$i]['data_anterior'];?> </td>
								
								<td> <input type=hidden name="num_expl_prod" value="<? echo $info_lote[$i]['num_expl_prod'];?>"> <? echo $info_lote[$i]['num_expl_prod'];?> </td>
								
								<td> <input type=hidden name="pd_fungo" value="<? echo $info_lote[$i]['pd_fungo'];?>"> <? echo $info_lote[$i]['pd_fungo'];?> </td>
														
								<td> <input type=hidden name="pd_bacteria" value="<? echo $info_lote[$i]['pd_bacteria'];?>"> <? echo $info_lote[$i]['pd_bacteria'];?> </td>
								
								<td> <input type=hidden name="pd_oxidacao" value="<? echo $info_lote[$i]['pd_oxidacao'];?>"> <? echo $info_lote[$i]['pd_oxidacao'];?> </td>
								
								<td> <input type=hidden name="total_perdas" value="<? echo $info_lote[$i]['total_perdas'];?>"> <? echo $info_lote[$i]['total_perdas'];?> </td>
								
								<td> <input type=hidden name="num_fr_trab" value="<? echo $info_lote[$i]['num_fr_trab'];?>"> <? echo $info_lote[$i]['num_fr_trab'];?> </td>														
								
								<td> <input type=hidden name="num_expl_fr_trab" value="<? echo $info_lote[$i]['num_expl_fr_trab'];?>"> <? echo $info_lote[$i]['num_expl_fr_trab'];?> </td>
								
								<td> <input type=hidden name="num_total_expl_trab" value="<? echo $info_lote[$i]['num_total_expl_trab'];?>"> <? echo $info_lote[$i]['num_total_expl_trab'];?> </td>
								
								<td> <input type=hidden name="tamanho_expl" value="<? echo $info_lote[$i]['tamanho_expl'];?>"> <? echo $info_lote[$i]['tamanho_expl'];?> </td>	
								
								<td> <input type=hidden name="contaminacao" value="<? echo $info_lote[$i]['contaminacao'];?>"> <? echo $info_lote[$i]['contaminacao'];?> </td>
								
								<td> <input type=hidden name="tipo_meio" value="<? echo $info_lote[$i]['tipo_meio'];?>"> <? echo $info_lote[$i]['tipo_meio'];?> </td>								
																								
								<!-- Et. Atual  -->
								
								<td> <input type=hidden name="cod_repic_atual" value="<? echo $info_lote[$i]['cod_repic_atual'];?>"> <? echo $info_lote[$i]['repic_atual'];?> </td>
								
								<td> <input type=hidden name="data_atual" value="<? echo $info_lote[$i]['data_atual'];?>"> <? echo $info_lote[$i]['data_atual'];?> </td>
								
								<td> <input type=hidden name="num_pote_prod" value="<? echo $info_lote[$i]['num_pote_prod'];?>"> <? echo $info_lote[$i]['num_pote_prod'];?> </td>
								
								<td> <input type=hidden name="num_expl_pote" value="<? echo $info_lote[$i]['num_expl_pote'];?>"> <? echo $info_lote[$i]['num_expl_pote'];?> </td>
								
								<td> <input type=hidden name="subtotal1" value="<? echo $info_lote[$i]['subtotal1'];?>"> <? echo $info_lote[$i]['subtotal1'];?> </td>
								
								<td> <input type=hidden name="num_fr_prod" value="<? echo $info_lote[$i]['num_fr_prod'];?>"> <? echo $info_lote[$i]['num_fr_prod'];?> </td>
								
								<td> <input type=hidden name="num_expl_fr" value="<? echo $info_lote[$i]['num_expl_fr'];?>"> <? echo $info_lote[$i]['num_expl_fr'];?> </td>
																
								<td> <input type=hidden name="subtotal2" value="<? echo $info_lote[$i]['subtotal2'];?>"> <? echo $info_lote[$i]['subtotal2'];?> </td>
								
								<td> <input type=hidden name="num_quebrado" value="<? echo $info_lote[$i]['num_quebrado'];?>"> <? echo $info_lote[$i]['num_quebrado'];?> </td>
								
								<td> <input type=hidden name="total_expl_prod" value="<? echo $info_lote[$i]['total_expl_prod'];?>"> <? echo $info_lote[$i]['total_expl_prod'];?> </td>
								
								<!-- Análise Inicial -->
							
								<td> <input type=hidden name="id_fase" value="<? echo $info_lote[$i]['id_fase'];?>"> <? echo $info_lote[$i]['fase'];?> </td>
																
								<td> <input type=hidden name="cod_fase" value="<? echo $info_lote[$i]['cod_fase'];?>"> <? echo $info_lote[$i]['cod_fase'];?> </td>
								
								<td> <input type=hidden name="fator_conversao" value="<? echo $info_lote[$i]['fator_conversao'];?>"> <? echo $info_lote[$i]['fator_conversao'];?> </td>
								
								<td> <input type=hidden name="pontos_repic" value="<? echo $info_lote[$i]['pontos_repic'];?>"> <? echo $info_lote[$i]['pontos_repic'];?> </td>
								
								
								<!-- campo chave p/ form_validation retornar falso -->
								<input type="hidden" name="campo_oculto" value=''>																												
																																														
								<td style='width:45px;'>  		
	  								<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_controle_prod(<?php echo $i;?>)">
  													<span class="glyphicon glyphicon-pencil" style=""> </span>
									</button>	
									
									<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_controle_prod(<? echo $i;?>)">
  													<span class="glyphicon glyphicon-trash" style=""> </span>
									</button>			
								</td>
								
							</form>
							</tr>
							<?php 
								}// fim do for
							}//if
							?>
						</tbody>									
					</table>
									
				</div>

					<!-- panel default  $info_lote[$i]['lote']-->													
			</div> <!-- fim panel-body -->
			
			<div class="panel-footer"> 
				<?php 
					if ($pag!='') {
					echo "<small> <p> <b>Página:</b> $pag de $total_pag de $total_linhas registros</small> </p>";
					if ($pagination!=''){
						echo "<ul class='pagination pag2'> $pagination </ul>";
						//echo $pagination ;
					}
				}
				?>
			</div>	
	</div><!-- Fim Panel -->
</div>



