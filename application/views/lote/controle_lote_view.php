<link rel="stylesheet" href="<?php echo base_url('js/calendario/themes/jquery.ui.all.css');?>">
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>
<script src="<?php echo base_url('js/calendario/ui/jquery.ui.datepicker.js');?>"> </script>
<script src="<?php echo base_url('js/lote/controlar_lote.js');?>"> </script>

<script>
url_carregar_var_controle_lote = "<?php echo base_url('lote/carregar_var_controle_lote')?>";
url_carregar_lotes = "<?php echo base_url('lote/carregar_lotes')?>";
url_cadastrar_fase_lote = "<?php echo base_url('lote/cadastrar_fase_lote')?>";
url_atualizar_fase_lote = "<?php echo base_url('lote/atualizar_fase_lote')?>";
url_gerar_pdf = "<?php echo base_url('lote/gerar_pdf')?>";
url_atualizar_descontam_lote = "<?php echo base_url('lote/atualizar_descontam_lote')?>";
url_atualizar_observ_lote = "<?php echo base_url('lote/atualizar_observ_lote')?>";

cod_lote_selec = "<?php echo $cod_lote?>";
num_total = "<?php echo sizeof($fases_lote)+1; ?>";
texto_descontam = "<?php echo $texto_descontaminacao; ?>";
texto_observ = "<?php echo $texto_observ; ?>";

//array fator multiplicação
var fator_multiplicacao = {
	isolamento : 	 "<?php echo $fator_multiplicacao['isolamento']?>",
	transferencia1 : "<?php echo $fator_multiplicacao['transferencia1']?>",
	transferencia2 : "<?php echo $fator_multiplicacao['transferencia2']?>",
	transferencia3 : "<?php echo $fator_multiplicacao['transferencia3']?>",
	subcultivo1 : 	 "<?php echo $fator_multiplicacao['subcultivo1']?>",
	subcultivo2 : 	 "<?php echo $fator_multiplicacao['subcultivo2']?>",
	subcultivo3 : 	 "<?php echo $fator_multiplicacao['subcultivo3']?>",
	subcultivo4 : 	 "<?php echo $fator_multiplicacao['subcultivo4']?>", 
	subcultivo5 : 	 "<?php echo $fator_multiplicacao['subcultivo5']?>",
	subcultivo6 : 	 "<?php echo $fator_multiplicacao['subcultivo6']?>",
	subcultivo7 : 	 "<?php echo $fator_multiplicacao['subcultivo7']?>",
	subcultivo8 : 	 "<?php echo $fator_multiplicacao['subcultivo8']?>",
	alongamento : 	 "<?php echo $fator_multiplicacao['alongamento']?>",
	aplic_meio_liquido : 	 "<?php echo $fator_multiplicacao['aplic_meio_liquido']?>"
	};
	

window.onload = function (){
	carregar_variedade();
	carregar_lotes();
};
</script>

<h4 class="text-center"> Controle do Lote </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default" >
			<div class="panel-heading">
				<span class="panel-title"> <strong>Preencha os dados abaixo: </strong> </span> 
								
			</div>
			<div class="panel-body" style="margin-left:-50px;">
					
				<form class="form-inline form_lote" id="form1" method="post" action="<?php echo base_url('lote/controlar_lote')?>">
					
					<div class="form-group">
						<label for="cultura">Cultura:</label>
					
						<div class="selecao">
							<select class="form-control" id="cultura" name="cultura" onChange="carregar_variedade();">
								<option value=''>Selecione uma opção</option>
								<? foreach ($lista_cultura as $cod_cultura => $valor){
								 	echo "<option value=$cod_cultura ".set_select('cultura',$cod_cultura,($cod_cult_selec == $cod_cultura ? TRUE : FALSE )).">$valor</option>";
								}?>
							</select>	 
						</div>	
						
						<div class="msg-erro-cadastro">
							<?echo form_error('cultura'); ?>
						</div>		
					</div>
					
					<div class="form-group">
						<label for="variedade">Variedade:</label> 
						
						<div class="selecao">
							<select class="form-control" id="variedade" name="variedade" onchange="carregar_lotes();">
								<option value=''>Selecione uma opção</option>
								<? if($cod_var_selec !=''){ 
									echo "<option value='$cod_var_selec' ".set_select('variedade',$cod_var_selec,($cod_var_selec !='' ? TRUE : FALSE ))."> </option>"; }
								?>
							</select>	 
						</div>
						
						<div class="msg-erro-cadastro" >
							<?echo form_error('variedade'); ?>
						</div>		
					</div>
										
					<div class="form-group">
						<label for="lote">Nº Lote:</label> 
						
						<div class="selecao">
							<select class="form-control" id="lote" name="cod_lote" onchange="enviar_form1();">
								<option value=''>Selecione uma opção</option>
								<? if($cod_lote != 0) { ?>
									<option value="<?echo $cod_lote;?>" <?echo set_select('cod_lote',$cod_lote,($cod_lote != 0 ? TRUE : FALSE ));?>> </option>
								<? } ?>		
							</select>	 
						</div>
						
						<div class="msg-erro-cadastro">
							<?echo form_error('lote'); ?>
						</div>	
					</div>
					
				<!-- Checkbox Descontaminação e Observação --> 				 				
					<div>
						<input type="checkbox" id="check_descontam" name="check_descontam"> <label> Descontaminação </label>
	 				</div>
	 				
	 				<div id="descontaminacao">							
						<textarea id="texto_descontam" name="texto_descontam" value="" class="form-control" rows="2" cols="80"> </textarea>
						<button type="button" class="btn btn-default btn-salvar" id="btn_descontam">Salvar</button>
					</div>
					
					<div>
						<input type="checkbox" id="check_observ" name="check_observ"> <label> Observação </label>
	 				</div>
	 				
	 				<div id="observacao">							
						<textarea id="texto_observ" name="texto_observ" value="" class="form-control" rows="2" cols="80"> </textarea>
						<button type="button" class="btn btn-default btn-observ" id="btn_observ">Salvar</button>
					</div>	
								
				</form>		
					
				<div class="box-fase-lote" > 							
					<table class="table tab-ger-lote" id="tab_ger_lote">
						<thead>
							<tr>
								<th> Fase </th>
								<th> Nº de entrada </th>
								<th> Nº Expl. Trab.</th>
								<th> Nº Expl. Prod.</th>
								<th> Nº Plan.</th>
								<th class="col-destaque"> TX Mult.</th>
								<th class="col-destaque"> Diferença</th>
								<th> Perda p/ Fungo </th>
								<th> Perda P/ Bact. </th>
								<th> Perda P/ Oxid. </th>
								<th class="col-destaque"> Perda Total. </th>
								<th class="col-destaque"> Perda P/ Fungo<br>( % ) </th>
								<th class="col-destaque"> Perda P/ Bactéria<br>( % ) </th>
								<th class="col-destaque"> Perda P/ Oxid<br>( % ) </th>
								<th class="col-destaque"> Perda Total.<br>( % ) </th>
								<th> Data Entrada </th>
								<th> Data Saída </th>
								<th class="col-destaque"> Duração </th>
								<th> Prazo </th>
								<th class="col-destaque"> Atraso (dias)</th>
								<th> Concluído </th>
								<th> Ações </th> 
							</tr>						
						</thead>
						
						<tbody>
							<?php
								if ($fases_lote != 0) { 
									for($i = 1; $i <= sizeof($fases_lote)+1; $i++) { 
										$id = ($i == sizeof($fases_lote)+1 ) ? 'cad_fase_lote' : 'linha'.$i ;
							?>
											
							<tr id="<?echo $id;?>">
							<form class="form-inline" name="controle_lote" id="<?echo 'controle_lote'.$i?>" method="post" action=""> 
														
								<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['id_controle_lote'] : ''; ?> 
								<input type="hidden" name="id_fase" value="<?php echo $valor;?>">
								
								<input type="hidden" name="c" value="<?php echo $cod_cult_selec;?>">
								<input type="hidden" name="v" value="<?php echo $cod_var_selec;?>">
								<input type="hidden" name="l" value="<?php echo $cod_lote;?>">
								<select style="display:none" id="cultura" name="cultura"> <option value="<? echo $cod_cult_selec?>" selected> </option> </select>
								<select style="display:none" id="variedade" name="variedade"> <option value="<? echo $cod_var_selec?>" selected> </option> </select>
								<select style="display:none" id="lote" name="lote"> <option value="<? echo $cod_lote?>" selected> </option> </select>	 
														
								<td>
									
									<select class="select-fase" name="fase"  id="<?echo 'fase'.$i?>">
										<option value=''>Selecione</option>
										<?	if($fases_lote[$i]['fase']){
												foreach ($fase as $chave => $nome_fase){
													echo ($fases_lote[$i]['fase'] == $chave) ? "<option value='$chave' selected>".$nome_fase."</option>" : "<option value='$chave'>".$nome_fase."</option>"; 
												}
											}else{
												foreach ($fase as $chave => $nome_fase){
													echo "<option value='$chave' ".set_select('fase',$chave,($dados['fase'] == $chave ? TRUE : FALSE )).">$nome_fase</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['num_entrada'] : $dados['num_entrada']; ?>  
									<input class="form-control" type="text" name="num_entrada"  id="<?echo 'num_entrada'.$i?>" maxlength="7" value="<? echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['num_expl_trab'] : $dados['num_expl_trab']; ?> 
									<input class="form-control" maxlength="7" type="text" name="num_expl_trab" id="<?echo 'num_expl_trab'.$i?>" value="<? echo $valor?>">
								</td>
																
								<td>
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['num_expl_prod'] : $dados['num_expl_prod']; ?>  
									<input class="form-control"  maxlength="7" type="text" name="num_expl_prod" id="<?echo 'num_expl_prod'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td>
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['num_plan'] : $dados['num_plan']; ?>  
									<input class="form-control" readonly="true" type="text" name="num_plan" id="<?echo 'num_plan'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['taxa_mult'] : $dados['taxa_mult']; ?> 
									<input class="form-control" readonly="true" type="text" name="taxa_mult" id="<?echo 'taxa_mult'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['diferenca'] : $dados['diferenca']; ?> 
									<input class="form-control col-size"  readonly="true" type="text" name="diferenca" id="<?echo 'diferenca'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['perda_fungo'] : $dados['perda_fungo']; ?>
									<input class="form-control" type="text" name="perda_fungo" id="<?echo 'perda_fungo'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['perda_bacteria'] : $dados['perda_bacteria']; ?>
									<input class="form-control" type="text" name="perda_bacteria" id="<?echo 'perda_bacteria'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['perda_oxidacao'] : $dados['perda_oxidacao']; ?>
									<input class="form-control" type="text" name="perda_oxidacao" id="<?echo 'perda_oxidacao'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['perda_total'] : $dados['perda_total']; ?>
									<input class="form-control"  readonly="true" type="text" name="perda_total" id="<?echo 'perda_total'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['pd_fungo_porcent']." %" : $dados['pd_fungo_porcent']; ?>
									<input class="form-control" readonly="true"  maxlength="7" type="text" name="pd_fungo_porcent" id="<?echo 'pd_fungo_porcent'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['pd_bact_porcent']." %" : $dados['pd_bact_porcent']; ?>
									<input class="form-control"  readonly="true" type="text" name="pd_bact_porcent" id="<?echo 'pd_bact_porcent'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['pd_oxid_porcent']." %" : $dados['pd_oxid_porcent']; ?>
									<input class="form-control"  readonly="true" type="text" name="pd_oxid_porcent" id="<?echo 'pd_oxid_porcent'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['pd_total_porcent']." %" : $dados['pd_total_porcent']; ?>
									<input class="form-control" readonly="true" type="text" name="pd_total_porcent" id="<?echo 'pd_total_porcent'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['data_entrada'] : $dados['data_entrada']; ?>
									<input class="form-control col-size"  maxlength="10" type="text" name="data_entrada" id="<?echo 'data_entrada'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['data_saida'] : $dados['data_saida']; ?>
									<input class="form-control col-size"  maxlength="10" type="text" name="data_saida" id="<?echo 'data_saida'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['duracao'] : $dados['duracao']; ?>
									<input class="form-control" readonly="true" type="text" name="duracao" id="<?echo 'duracao'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? //$valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['prazo'] : $dados['prazo']; ?>
									<!-- <input class="form-control recuo " type="text" name='prazo' id="<? //echo 'prazo'.$i ?>" value="<? //echo $valor ?>"> -->
									<select class="select-prazo" name="prazo"  id="<?echo 'prazo'.$i?>">
										<option value=''>Selecione</option>
										<?	if($fases_lote[$i]['prazo']){
												foreach ($prazo as $chave => $valor){
													echo ($fases_lote[$i]['prazo'] == $chave) ? "<option value='$chave' selected>".$valor."</option>" : "<option value='$chave'>".$valor."</option>";
												}
											}else{
												foreach ($prazo as $chave => $valor){
													echo "<option value='$chave' ".set_select('prazo',$chave,($dados['prazo'] == $chave ? TRUE : FALSE )).">$valor</option>";
												}
											}
										?>
									</select>
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['dias_atrasados'] : $dados['dias_atrasados']; ?>
									<input class="form-control" size="4" type="text" name="dias_atrasados" id="<?echo 'dias_atrasados'.$i?>" value="<?echo $valor?>">
								</td>
								
								<td> 
									<? //$valor = ($i <= sizeof($fases_lote)) ? $fases_lote[$i]['concluido'] : $dados['concluido']; ?>
									<select class="select-concluido" name="concluido"  id="<?echo 'concluido'.$i?>">
										<option value=''>Selecione</option>
										<?	if($fases_lote[$i]['concluido']){
											foreach ($concluido as $chave => $valor){
												echo ($fases_lote[$i]['concluido'] == $chave) ? "<option value='$chave' selected>".$valor."</option>" : "<option value='$chave'>".$valor."</option>";
											}

											}else{
												foreach ($concluido as $chave => $valor){
													echo "<option value='$chave' ".set_select('concluido',$chave,($dados['concluido'] == $chave ? TRUE : FALSE )).">$valor</option>";
												}
											}
										?>
									</select>
									<!-- 
									<input class="form-control recuo col-size" size="4" type="text" name="concluido" id="<?//echo 'concluido'.$i?>" value="<?//echo $valor?>">
									-->
								</td>
															
								<td>								  			
									 <!-- <input type="submit" class="btn btn-default btn-lote" name="cadastar_lote" value="cadastrar"> -->
									<div class="comandos">
									<?php if ($i <= sizeof($fases_lote)) { ?>
									
  										<span class="glyphicon glyphicon-pencil btn-editar" onMouseOver="this.title='Habilita/Desabilita para edição'" id="<?echo "edita_".$i?>"> </span> 
  										<span class="glyphicon glyphicon-ok btn-atualiza" onMouseOver="this.title='Atualizar fase'" onClick="atualizar_fase(<?echo $i?>)" id="<?echo "atualiza_".$i?>"> </span>
									
										<!-- 
										<image src="<?php //echo base_url('imagens/icones/before_change.png')?>" onMouseOver="this.title='Atualizar fase'" onClick="atualizar_fase(<?//echo $i?>)" class="btn-atualiza" id="<?//echo "atualiza_".$i?>"> 								  			
										<image src="<?php //echo base_url('imagens/icones/Pencil2.png')?>" onMouseOver="this.title='Habilita/Desabilita para edição'" class="btn-editar" id="<?//echo "edita_".$i?>">
										-->
										<!-- <input type="image" src="<?php //echo base_url('imagens/icones/Trash-icon.png')?>" onMouseOver="this.title='Excluir'" onClick="exc_linha(<?//echo $i;?>)" name="excluir" class="btn-excluir"> -->
									<?php } else { ?>
									
									<button type="button" class="btn btn-default btn-lote" onMouseOver="this.title='Cadastrar fase'" onClick="cadastrar_fase(<?echo $i?>)">
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
				
					
					<!-- Fator multiplicação -->
					<div id="box_fator_mult">Fator de Multiplicação</div>
					<div id="panel">
						<table class="fator-mult">
							<tr>
								<th> isolam. </th>
								<th> 1º transf. </th>							
								<th> 2º transf. </th>
								<th> 3º transf. </th>
								<th> 1º sub. </th>
								<th> 2º sub. </th>
								<th> 3º sub. </th>
								<th> 4º sub. </th>
								<th> 5º sub. </th>
								<th> 6º sub. </th>
								<th> 7º sub. </th>
								<th> 8º sub. </th>
								<th> along. </th>
								<th> aplic m. líq. </th>
							</tr>
							<tr class="recuo">
								<td> <?php echo $fator_multiplicacao['isolamento']?> </td>
								<td> <?php echo $fator_multiplicacao['transferencia1']?> </td>
								<td> <?php echo $fator_multiplicacao['transferencia2']?> </td>
								<td> <?php echo $fator_multiplicacao['transferencia3']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo1']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo2']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo3']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo4']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo5']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo6']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo7']?> </td>
								<td> <?php echo $fator_multiplicacao['subcultivo8']?> </td>
								<td> <?php echo $fator_multiplicacao['alongamento']?> </td>
								<td> <?php echo $fator_multiplicacao['aplic_meio_liquido']?> </td>
							</tr>
						</table>
					</div>				
				</div>
			
					<div class="box-erro">
						<?php
							if ($fases_lote != 0) {
								foreach ($campos as $valor){
								//echo "<div class='msg-erro-cadastro'>";
								echo "<div class='msg-erro-cadastro'>".form_error($valor)."</div>";
								//echo "</div>";
								} 
							}
						?>
					</div>
									
				</div> <!-- fim panel-body -->
			<div class="panel-footer"> </div>
			
		</div> <!-- Fim Panel -->
	</div>



