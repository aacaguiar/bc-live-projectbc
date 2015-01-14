<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"> </script>
<script src="<?php echo base_url('js/producao/controle_producao.js');?>"> </script>

<script>
var url_carregar_var = "<?php echo base_url('producao/carregar_variedade');?>";
var url_carregar_lotes = "<?php echo base_url('producao/carregar_lotes');?>";
var url_listar_controle_prod = "<?php echo base_url('producao/listar_controle_producao');?>";
var url_control_prod_lote = "<?php echo base_url('producao/controlar_producao_lote');?>";
var url_cad_prod = "<?php echo base_url('producao/cadastrar_controle_prod');?>";
var num_total = "<?php echo sizeof($info_lote)+1; ?>";

window.onload = function (){
	//carregar_variedade();
	//carregar_lotes();
};
</script>

<h4 class="text-center"> Controle da produção </h4> 

<div class="box-cont-prod">
		<div class="panel panel-default" >
		
			<div class="panel-heading">
				<span class="panel-title"> <strong> Preencha os dados abaixo: </strong> </span> 							
			</div>
			
			<div class="panel-body">

				<table class="filt-prod">
					<thead>
						<tr>
							<form class="form-inline form_lote" id="form1" method="post" action="">
								<th> 
									<label>Ano:</label>						
									<input type="text" class="form-control" id="filt_ano" name="filt_ano" size="10" value="<?php echo $ano?>"> 
								</th>
								
								<th> 	
									<label>Semana:</label> 										
										<select class="form-control" id="filt_sem" name="filt_sem">
											<option value='0'> todos </option> 
											<? $cont = $num_semana;
												for ($cont; $cont>=1; $cont--) { 
												$selected = ($semana_selec == $cont) ? 'selected' : '';	
												echo "<option value='$cont' $selected > $cont </option>";
												}
											?>	
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
												 	echo "<option value=$cod_variedade ".set_select('variedade',$cod_variedade,($var_selec == $cod_variedade ? TRUE : FALSE )).">$valor</option>";
													}
												?>
											</select>	 
										</div>		
								 </th>
								 
								<th> 
									<label>Lote:</label>											
										<div class="">
											<select class="form-control" id="filt_lote" name="filt_lote">
												<option value='0'>todos</option>
												<? foreach ($lista_lote as $cod_lote => $valor){
												 	echo "<option value=$cod_lote ".set_select('filt_lote',$cod_lote,($lote_selec == $cod_lote ? TRUE : FALSE )).">$valor</option>";
													}
												?>		
											</select>	 
										</div>			
								</th>			
							</form>
						</tr>						
					</thead>														
				</table>
				
				
				<div class="box-etapa-prod" > 							
					<table class="table tab-et-prod"  id="tab_et_prod">
						<thead>
							<tr>
								<th colspan="6" class="tit-colspan1"> <h6>Informações do Lote</h6> </th>
								<th colspan="13" class="tit-colspan2"> <h6> Informações da etapa anterior </h6> </th>
								<th colspan="9" class="tit-colspan3"> <h6> Informações da etapa atual </h6> </th>
								<th rowspan="2" class="tit-colspan3"> <h6> Ações </h6> </th>
							</tr>
							
							<tr>
								<th> linha </th>
								<th> Ano </th>
								<th> Semana </th>
								<th> Cultura </th>
								<th> Variedade </th>
								<th> Lote </th>
								<!-- etapa anterior -->
								<th class="tit-colspan2"> Repic.<br>anterior </th>
								<th class="tit-colspan2"> Data<br> anterior </th>
								<th class="tit-colspan2"> Nº expl.<br> prod. </th>
								<th class="tit-colspan2"> Perd p/<br> fungo </th> 
								<th class="tit-colspan2"> Perd p/<br> bact </th> 
								<th class="tit-colspan2"> Perd p/<br> oxid </th> 
								<th class="tit-colspan2"> Total<br> perdas </th> 
								<th class="tit-colspan2"> Nº frasco<br> trab. </th> 
								<th class="tit-colspan2"> Nº Expl.<br> frasco<br> trab. </th>
								<th class="tit-colspan2"> Nº Total<br>Expl.<br> trab. </th>
								<th class="tit-colspan2"> Tam. Expl. </th>
								<th class="tit-colspan2"> Contam.<br>lote </th>
								<th class="tit-colspan2"> Tipo<br>meio </th>
								<!-- etapa atual -->
								<th class="tit-colspan3"> Repic.<br> atual</th>
								<th class="tit-colspan3"> Data<br> atual </th>
								<th class="tit-colspan3"> Nº Frasco/<br>Pote<br>prod. </th>
								<th class="tit-colspan3"> Nº Expl<br>Frasco/<br>Pote </th> 
								<th class="tit-colspan3"> Subtotal1 </th> 
								<th class="tit-colspan3"> Nº Total<br>Frasco/<br>Pote<br>prod. </th>  
								<th class="tit-colspan3"> subtotal2 </th> 
								<th class="tit-colspan3"> Nº quebr. </th>
								<th class="tit-colspan3"> Total<br>expl.<br>prod.</th>
							</tr>						
						</thead>
						
						<tbody>
							<?php
								if (sizeof($info_lote)>0){ 
									for($i = 1; $i <= sizeof($info_lote)+1; $i++) { 
										$id = ($i == sizeof($info_lote)+1 ) ? 'cad_producao' : 'linha'.$i ;
							?>
											
							<tr id="<?echo $id;?>">
							<form class="form-inline" name="controle_prod" id="<?echo 'controle_prod'.$i?>" method="post" action=""> 
														
								<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['id'] : ''; ?> 
								<input type="hidden" name="id" value="<?php echo $valor;?>">
								
								<!-- 
								<input type="hidden" name="sem" value="<?php //echo $semana_selec;?>">
								<input type="hidden" name="cult" value="<?php //echo $cult_selec;?>">
								<input type="hidden" name="var" value="<?php //echo $var_selec;?>">
								<input type="hidden" name="lt" value="<?php //echo $lote_selec;?>">
								-->
								<input type="hidden" name="filt_ano"  value="<?php echo $ano?>"> 
								<select style="display:none" name="filt_sem"> <option value="<? echo $semana_selec?>" selected> </option> </select>
								<select style="display:none" name="filt_cult"> <option value="<? echo $cult_selec?>" selected> </option> </select>
								<select style="display:none" name="filt_var"> <option value="<? echo $var_selec?>" selected> </option> </select>
								<select style="display:none" name="filt_lote"> <option value="<? echo $lote_selec?>" selected> </option> </select>	 
								<?php //echo $campos['campo_ano'];?>
								<td>
								
								</td>
								
								<td>
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['ano'] : $dados['ano']; ?>
									<input type="text" name="ano" size="3" id="<?php echo 'ano'.$i?>" value="<?php echo $valor?>">
								</td>
															
								<td>
									<select class="form-control" name="semana"  id="<?echo 'semana'.$i?>">
										<option value='0'>todos</option>
										<? $cont = $num_semana;
											if($info_lote[$i]['num_semana']){
												for($cont; $cont>=1; $cont--){
													echo ($info_lote[$i]['num_semana'] == $cont) ? "<option value='$cont' selected>".$cont."</option>" : "<option value='$cont'>".$cont."</option>"; 
												}
											}else{
												for($cont; $cont>=1; $cont--){	
													echo ($dados['semana'] == $cont) ? "<option value=$cont selected>".$cont."</option>" : "<option value=$cont>".$cont."</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td>
									<select class="form-control" name="cod_cultura"  id="<?echo 'cod_cultura'.$i?>">
										<option value='0'>todos</option>
										<? 	if($info_lote[$i]['cultura']){
												foreach ($lista_cultura as $cod_cultura => $valor){
													echo ($info_lote[$i]['cod_cultura'] == $cod_cultura) ? "<option value='$cod_cultura' selected>".$valor."</option>" : "<option value='$cod_cultura'>".$valor."</option>"; 
												}
											}else{
												foreach ($lista_cultura as $cod_cultura => $valor){
													echo ($dados['cod_cultura'] == $cod_cultura) ? "<option value=$cod_cultura selected>".$valor."</option>" : "<option value=$cod_cultura>".$valor."</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td>
									<div class="sel-var">
										<select class="form-control" name="cod_variedade"  id="<?echo 'cod_variedade'.$i?>">
											<option value='0'>todos</option>
											<? 	if($info_lote[$i]['variedade']){
													foreach ($lista_variedade as $cod_variedade => $valor){
														echo ($info_lote[$i]['cod_variedade'] == $cod_variedade) ? "<option value='$cod_variedade' selected>".$valor."</option>" : "<option value='$cod_variedade'>".$valor."</option>"; 
													}
												}else{
													foreach ($lista_variedade as $cod_variedade => $valor){
														echo ($dados['cod_variedade'] == $cod_variedade) ? "<option value=$cod_variedade selected>".$valor."</option>" : "<option value=$cod_variedade>".$valor."</option>";
													}
												}
											?>
										</select>
									</div>
								</td>
								
								<td>
									<select class="form-control" name="cod_lote"  id="<?echo 'cod_lote'.$i?>">
										<option value='0'>todos</option>
										<? 	if($info_lote[$i]['lote']){
												foreach ($lista_lote as $cod_lote => $valor){
													echo ($info_lote[$i]['cod_lote'] == $cod_lote) ? "<option value='$cod_lote' selected>".$valor."</option>" : "<option value='$cod_lote'>".$valor."</option>"; 
												}
											}else{
												foreach ($lista_lote as $cod_lote => $valor){
													echo ($dados['cod_lote'] == $cod_lote) ? "<option value=$cod_lote selected>".$valor."</option>" : "<option value=$cod_lote>".$valor."</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td> 
									<select class="form-control" name="cod_repic_et_ant"  id="<?echo 'cod_repic_et_ant'.$i?>">
										<option value='0'>todos</option>
										<? 	if($info_lote[$i]['cod_repic_et_ant']){
												foreach ($lista_repic as $id_repic => $valor){
													echo ($info_lote[$i]['cod_repic_et_ant'] == $id_repic) ? "<option value='$id_repic' selected>".$valor."</option>" : "<option value='$id_repic'>".$valor."</option>"; 
												}
											}else{
												foreach ($lista_repic as $id_repic => $valor){
													echo ($dados['cod_repic_et_ant'] == $id_repic) ? "<option value=$id_repic selected>".$valor."</option>" : "<option value=$id_repic>".$valor."</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['data_anterior'] : $dados['data_anterior']; ?> 
									<input class="form-control dt" type="text" name="data_anterior" id="<?echo 'data_anterior'.$i?>" value="<? echo $valor?>">
								</td>
																
								<td>
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_expl_prod'] : $dados['num_expl_prod']; ?>  
									<input class="form-control tam1" type="text" name="num_expl_prod" id="<?echo 'num_expl_prod'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td>
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['pd_fungo'] : $dados['pd_fungo']; ?>  
									<input class="form-control tam1" type="text" name="pd_fungo" id="<?echo 'pd_fungo'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['pd_bacteria'] : $dados['pd_bacteria']; ?> 
									<input class="form-control tam1" type="text" name="pd_bacteria" id="<?echo 'pd_bacteria'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['pd_oxidacao'] : $dados['pd_oxidacao']; ?> 
									<input class="form-control tam1" type="text" name="pd_oxidacao" id="<?echo 'pd_oxidacao'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['total_perda'] : $dados['total_perda']; ?>
									<input class="form-control tam1" type="text" name="total_perda" id="<?echo 'total_perda'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_fr_trab'] : $dados['num_frasco_trab']; ?>
									<input class="form-control tam1" type="text" name="num_frasco_trab" id="<?echo 'num_frasco_trab'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_expl_fr_trab'] : $dados['num_expl_frasco_trab']; ?>
									<input class="form-control tam1" type="text" name="num_expl_frasco_trab" id="<?echo 'num_expl_frasco_trab'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_total_expl_trab'] : $dados['num_total_expl_trab']; ?>
									<input class="form-control tam1" type="text" name="num_total_expl_trab" id="<?echo 'num_total_expl_trab'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['tamanho_expl'] : $dados['tamanho_expl']; ?>
									<input class="form-control tam1" type="text" name="tamanho_expl" id="<?echo 'tamanho_expl'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['contaminacao'] : $dados['contaminacao']; ?>
									<input class="form-control tam1" type="text" name="contaminacao" id="<?echo 'contaminacao'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['tipo_meio'] : $dados['tipo_meio']; ?>
									<input class="form-control tam1" type="text" name="tipo_meio" id="<?echo 'tipo_meio'.$i?>" value="<?echo $valor?>">
								</td>
								
								<!-- Et. Atual  -->
								<td> 
									<select class="form-control" name="cod_repic_et_atual"  id="<?echo 'cod_repic_et_atual'.$i?>">
										<option value='0'>todos</option>
										<? 	if($info_lote[$i]['cod_repic_et_atual']){
												foreach ($lista_repic as $id_repic => $valor){
													echo ($info_lote[$i]['cod_repic_et_atual'] == $id_repic) ? "<option value='$id_repic' selected>".$valor."</option>" : "<option value='$id_repic'>".$valor."</option>"; 
												}
											}else{
												foreach ($lista_repic as $id_repic => $valor){
													echo ($dados['repic_atual'] == $id_repic) ? "<option value=$id_repic selected>".$valor."</option>" : "<option value=$id_repic>".$valor."</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['data_atual'] : $dados['data_atual']; ?>
									<input class="form-control dt" type="text" name="data_atual" id="<?echo 'data_atual'.$i?>" value="<?echo $valor?>">
								</td>
																
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_fr_pote_prod'] : $dados['num_frasco_pote_prod']; ?>
									<input class="form-control tam1" type="text" name="num_frasco_pote_prod" id="<?echo 'num_frasco_pote_prod'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_expl_fr_pote'] : $dados['num_expl_frasco_pote']; ?>
									<input class="form-control tam1" type="text" name="num_expl_frasco_pote" id="<?echo 'num_expl_frasco_pote'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['subtotal1'] : $dados['subtotal1']; ?>
									<input class="form-control tam1" type="text" name="subtotal1" id="<?echo 'subtotal1'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['total_fr_pote_prod'] : $dados['total_frasco_pote_prod']; ?>
									<input class="form-control tam1" type="text" name="total_frasco_pote_prod" id="<?echo 'total_frasco_pote_prod'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['subtotal2'] : $dados['subtotal2']; ?>
									<input class="form-control tam1" type="text" name="subtotal2" id="<?echo 'subtotal2'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['num_quebrado'] : $dados['num_quebrado']; ?>
									<input class="form-control tam1" type="text" name="num_quebrado" id="<?echo 'num_quebrado'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($info_lote)) ? $info_lote[$i]['total_expl_prod'] : $dados['total_expl_prod']; ?>
									<input class="form-control tam1" type="text" name="total_expl_prod" id="<?echo 'total_expl_prod'.$i?>" value="<?echo $valor?>">
								</td>
																																							
								<td>								  			
									 <!-- <input type="submit" class="btn btn-default btn-lote" name="cadastar_lote" value="cadastrar"> -->
									<div class="comandos">
									<?php if ($i <= sizeof($info_lote)) { ?>
									
  										<span class="glyphicon glyphicon-pencil btn-editar" onMouseOver="this.title='Habilita/Desabilita para edição'" > </span> 
  										<span class="glyphicon glyphicon-ok btn-atualiza" onMouseOver="this.title='Atualizar etapa produção'" > </span>
				
									<?php } else { ?>
									
									<button type="button" class="btn btn-default btn-prod" onMouseOver="this.title='Cadastrar etapa produção'" id="btn_cad_prod" >
  											<span class="glyphicon glyphicon-floppy-open"> </span>
									</button>
									
									<?php } ?>
									</div>
								</td>
								
							</form>
							</tr>
							<?php 
								}// fim do for
							 } //fim do if 
							?>
						</tbody>									
					</table>
					
					<div class="box-erro">
						<?php
								if(sizeof($dados)>0){
									foreach ($campos as $valor){
									//echo "<div class='msg-erro-cadastro'>";
									echo "<div class='msg-erro-cadastro'>".form_error($valor)."</div>";
									//echo $chave.'=>'.$valor.'<br>';
									//echo "</div>";
									}
								} 
						?>
					</div>
				
				</div>

					<!-- panel default  $info_lote[$i]['lote']-->													
			</div> <!-- fim panel-body -->
		<div class="panel-footer"> </div>	
	</div><!-- Fim Panel -->
</div>



