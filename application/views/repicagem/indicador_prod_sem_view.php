<script src="<?php echo base_url('js/repicagem/producao_semanal.js');?>"> </script>
<script src="<?php //echo base_url('js/calendario/ui/jquery.ui.core.js');?>"> </script>
<script src="<?php //echo base_url('js/calendario/ui/jquery.ui.widget.js');?>"> </script>

<script>
url_cadastrar_prod_semanal = "<?php echo base_url('repicagem/cadastrar_prod_semanal')?>";
num_total = "<?php echo sizeof($lista_prod_semanal)+1; ?>";
</script>

<h4 class="text-center"> Controle da Repicagem (indicadores semanais) </h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default" >
			<div class="panel-heading">
				<span class="panel-title"> <strong> Preencha os dados abaixo: </strong> </span> 
								<?php echo $num_semana_selec."-".$num_semana."-".$ano;?>
			</div>
			<div class="panel-body" style="margin-left:-50px;">
					
				<form class="form-inline" id="form1" method="post" action="<?php echo base_url('repicagem/indicador_prod_semanal')?>">
					
					<div class="form-group">
						<label for="Ano">Ano:</label> <br>					
						<input type="text" class="form-control" id="ano" name="ano" size="10" value="<?php echo $ano?>">
						
						<div class="msg-erro-cadastro">
							<?echo form_error('ano'); ?>
						</div>		
					</div>
					
					<div class="form-group">
						<label for="Semana">Semana:</label> 
						
						<div class="">
							<select class="form-control selecao-sem" name="semana" onchange="enviar_form1();">
								<option value=''>Nº da semana</option>
								<? for($num_semana; $num_semana>=1; $num_semana--) { 
									$selected = ($num_semana_selec == $num_semana ) ? 'selected' : '';	
									echo "<option value='$num_semana' $selected > $num_semana </option>";
									}
								?>	
							</select>	 
						</div>
						
						<div class="msg-erro-cadastro" >
							<?echo form_error('semana'); ?>
						</div>		
					</div>
								
				</form>		
					
				<div class="box-prod-semanal" style=""> 							
					<table class="table tab-prod-sem" id="tab-prod-sem">
					
						<thead>
							<tr>
								<th> Repicador </th>
								<th> Total expl. prod. </th>
								<th> Média tx mult.</th>
								<th class="col-destaque"> Pontuação</th>
								<th> Produção</th>
								<th> Ações </th>
							</tr>						
						</thead>
						
						<tbody>
							<?php
								if($lista_prod_semanal != 0){
								for($i = 1; $i <= sizeof($lista_prod_semanal)+1; $i++) { 
									$id = ($i == sizeof($lista_prod_semanal)+1 ) ? 'cadastrar_prod_sem' : 'linha'.$i ;
							?>
											
							<tr id="<?echo $id;?>">
							<form class="form-inline" name="controle_prod_semanal" id="<?echo 'controle_prod_semanal'.$i?>" method="post" action=""> 
								 														
								<input type="hidden" name="ano" value="<?php echo $ano;?>">
																
								<select style="display:none" name="n"> 
									<option value="<?echo $num_semana_selec?>" selected>  </option> 
								</select>
				
								<td>
									<? //$valor = ($i <= sizeof($lista_prod_semanal)) ? $lista_prod_semanal[$i]['fase'] : $dados['fase']; ?> 
									<select class="form-control selecao-repic" name="repicador"  id="<?echo 'repicador'.$i?>">
										<option value=''>Selecione</option>
										<?	if($lista_prod_semanal[$i]['id_repicador']){
												foreach ($lista_repicadores as $id => $repicador){
													echo ($lista_prod_semanal[$i]['id_repicador'] == $id) ? "<option value='$id' selected>".$repicador."</option>" : "<option value='$id'>".$repicador."</option>"; 
												}
											}else{
												foreach ($lista_repicadores as $id => $repicador){
													echo "<option value='$id' ".set_select('repicador',$id,($dados['id_repicador'] == $id ? TRUE : FALSE )).">$repicador</option>";
												}
											}
										?>
									</select>
								</td>
									
								<td> 
									<? $valor = ($i <= sizeof($lista_prod_semanal)) ? $lista_prod_semanal[$i]['total_expl_prod'] : $dados['total_expl_prod']; ?>  
									<input class="form-control" type="text" name="total_expl_prod"  id="<?echo 'total_expl_prod'.$i?>" maxlength="7" value="<? echo $valor?>">
								</td>
								
								<td> 
									<? $valor = ($i <= sizeof($lista_prod_semanal)) ? $lista_prod_semanal[$i]['media_tx_mult'] : $dados['media_tx_mult']; ?> 
									<input class="form-control" maxlength="7" type="text" name="media_tx_mult" id="<?echo 'media_tx_mult'.$i?>" value="<? echo $valor?>">
								</td>
																
								<td>
									<? $valor = ($i <= sizeof($lista_prod_semanal)) ? $lista_prod_semanal[$i]['pontuacao'] : $dados['pontuacao']; ?>  
									<input class="form-control" maxlength="7" type="text" name="pontuacao" id="<?echo 'pontuacao'.$i?>" value="<? echo $valor?>">
								</td>
								
								<td>
									<? $valor = ($i <= sizeof($lista_prod_semanal)) ? $lista_prod_semanal[$i]['producao'] : $dados['producao']; ?>  
									<input class="form-control" maxlength="7" type="text" name="producao" id="<?echo 'producao'.$i?>" value="<? echo $valor?>">
								</td>
																						
								<td>								  			
									<div class="comandos">
									<?php if ($i <= sizeof($lista_prod_semanal)) { ?>
  										<span class="glyphicon glyphicon-pencil btn-editar" onMouseOver="this.title='Habilita/Desabilita para edição'" id="<?echo "edita_".$i?>"> </span> 
  										<span class="glyphicon glyphicon-ok btn-atualiza" onMouseOver="this.title='Atualizar indicador semanal'" onClick="atualizar_prod_semanal(<?echo $i?>)" id="<?echo "atualiza_".$i?>"> </span>				
									<?php } else { ?>
									
									<button type="button" class="btn btn-default btn-lote" onMouseOver="this.title='Cadastrar indicador semanal'" onClick="cadastrar_prod_semanal(<?echo $i?>)">
  										<span class="glyphicon glyphicon-floppy-open"> </span>
									</button>
									
									<?php } ?>
									</div>
								</td>
								
							</form>
							</tr>
							
							<?php 
								}// fim do for
							}// fim do if
							?>
						</tbody>
											
					</table>
						
					<!-- Fator multiplicação -->
					<!-- 
					<div id="box_fator_mult">Média Semanal</div>
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
								</tr>
						</table>
					</div>
					-->
													
				</div>					
					<div class="box-erro">
						<?php
							if ($lista_prod_semanal != 0) {
								foreach ($campos as $valor){
								echo "<div class='msg-erro-cadastro'>".form_error($valor)."</div>";
								} 
							}
						?>
					</div>
									
				</div><!-- fim panel-body -->
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>




