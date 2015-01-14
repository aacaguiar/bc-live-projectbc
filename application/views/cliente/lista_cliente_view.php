<script type="text/javascript" src="<?php echo base_url('js/cliente/lista_cliente.js');?>"> </script>
<script type="text/javascript">
url_alterar_cliente="<?php echo base_url('cliente/alterar_cliente');?>";
url_excluir_cliente="<?php echo base_url('cliente/excluir_cliente');?>";
</script>


<h4 class="text-center">Consulta de Clientes</h4>

		<!-- 
			<form name="form_pesquisa" class="form-inline">
			  <div class="form-group">
				 <select class="form-control" id="selec_pesq">
					<option value="0">pesquisar por</option>
					<option value="nome">Nome</option>
					<option value="cpf">Cpf</option>
				</select>
			    <input type="text" class="form-control" style="width:350px" id="pesquisa" name="pesquisa" onMouseOver="this.title='Pesquisar'" placeholder="Escolha uma opção ao lado">
			    <button type="submit" class="btn btn-default"><img src="<?php //echo base_url('imagens/icones/pesquisar2.png')?>" class="img-pesquisar"> </button>
			  </div> 
			</form>
	   -->   
	   
    	<div class="panel panel-default">
			<div class="panel-heading">

			<div class="panel-title"> 
				<strong> 
					Listagem de clientes - <? echo ($tipo_cliente == 'fisica') ? 'pessoa física' : 'pessoa jurídica';?> 
				</strong> 
			</div>
					
			</div>
			
			<div class="panel-body">
			
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 	<? if($tipo_cliente=='fisica'){?>
										<th>Nome</th>
										<th>Cpf</th>
										<? } if($tipo_cliente=='juridica') {?>
										<th>Razão Social</th>
										<!-- <th>Contato</th> -->
										<th>Cnpj</th>
										<? } ?>
										<th>Endereço</th>
										<th>Bairro</th>
										<th>Estado</th>
										<th>Cidade</th>
										<th>Cep</th>
										<th>Fone/Fax</th>
										<th>Celular</th>
										<th>E-mail</th>
										<th>Fornec.</th>
										<!-- <th>Cód.Fornec.</th> -->
										<th>Ações</th>
									</tr>
								
								</thead>
								
								<tbody>				
								<? for ($i=0; $i<sizeof($lista_cliente); $i++ )
								{
									
									if($tipo_cliente=='fisica')
									{
										if(strlen($lista_cliente[$i]['cpf_cnpj'])=='11'){
											$cpf_cnpj_formatado = substr($lista_cliente[$i]['cpf_cnpj'],0,3).".".substr($lista_cliente[$i]['cpf_cnpj'],3,3).".".substr($lista_cliente[$i]['cpf_cnpj'],6,3)."-".substr($lista_cliente[$i]['cpf_cnpj'],9,2);
										}else{
											$cpf_cnpj_formatado = " ";
										}	
									}
									
									if($tipo_cliente=='juridica')
									{
										if(strlen($lista_cliente[$i]['cpf_cnpj'])=='14'){
											$cpf_cnpj_formatado = substr($lista_cliente[$i]['cpf_cnpj'],0,2).".".substr($lista_cliente[$i]['cpf_cnpj'],2,3).".".substr($lista_cliente[$i]['cpf_cnpj'],5,3)."/".substr($lista_cliente[$i]['cpf_cnpj'],8,4).".".substr($lista_cliente[$i]['cpf_cnpj'],12,2);  
										}else{
											$cpf_cnpj_formatado = " ";
										}
									}
									
									if(strlen($lista_cliente[$i]['cep'])=='8'){
										$cep_formatado = substr($lista_cliente[$i]['cep'],0,2).".".substr($lista_cliente[$i]['cep'],2,3)."-".substr($lista_cliente[$i]['cep'],5,3);	
									}else{
										$cep_formatado = " ";
									}
									
									if(strlen($lista_cliente[$i]['fone_residencial'])=='10'){
										$fone_formatado = "(".substr($lista_cliente[$i]['fone_residencial'],0,2).")".substr($lista_cliente[$i]['fone_residencial'],2,4)."-".substr($lista_cliente[$i]['fone_residencial'],6,4);
									}else{
										$fone_formatado = " ";
									}
																
									if(strlen($lista_cliente[$i]['fone_celular'])=='10'){
										$celular_formatado = "(".substr($lista_cliente[$i]['fone_celular'],0,2).")".substr($lista_cliente[$i]['fone_celular'],2,4)."-".substr($lista_cliente[$i]['fone_celular'],6,4);
									}else if(strlen($lista_cliente[$i]['fone_celular'])=='11'){
										$celular_formatado = "(".substr($lista_cliente[$i]['fone_celular'],0,2).")".substr($lista_cliente[$i]['fone_celular'],2,5)."-".substr($lista_cliente[$i]['fone_celular'],7,4);
									}else{
										$celular_formatado = " ";
									}

									$campo_fornecedor = ($lista_cliente[$i]['check_fornecedor']=='t') ? 'sim' : 'não';
									
								?>
								<tr class="texto-pesquisa-user">
									<form method="post" action="" name="listar" id="<?echo "form".$i;?>"> 
																															 
										<input type="hidden" name="cod_fornecedor" value="<? echo $lista_cliente[$i]['cod_fornecedor'];?>"> 
										<input type="hidden" name="cod_endereco" value="<? echo $lista_cliente[$i]['cod_endereco'];?>"> 
										<input type="hidden" name="tipo_cliente" value="<? echo $tipo_cliente;?>"> 
																		
										<td> <? echo $inicio++; ?> </td>
										
											 <input type="hidden" name="id_clifor" value="<? echo $lista_cliente[$i]['id_clifor'];?>"> 
										<td> <input type="hidden" name="nome_rsocial" value="<? echo $lista_cliente[$i]['nome_rsocial'];?>"> <? echo $lista_cliente[$i]['nome_rsocial'];?> </td>	
										<td> <input type="hidden" name="cpf_cnpj" value="<? echo $lista_cliente[$i]['cpf_cnpj'];?>"> <? echo $cpf_cnpj_formatado; ?> </td>
									
										<td> <input type="hidden" name="endereco" value="<? echo $lista_cliente[$i]['endereco'];?>"> <? echo $lista_cliente[$i]['endereco'];?> </td>
										
										<td> <input type="hidden" name="bairro" value="<? echo $lista_cliente[$i]['bairro'];?>"> <? echo $lista_cliente[$i]['bairro'];?> </td>
										
										<td> <input type="hidden" name="estado" value="<? echo $lista_cliente[$i]['estado'];?>"> <? echo $lista_cliente[$i]['estado'];?> </td>
										
										<td> <input type="hidden" name="cidade" value="<? echo $lista_cliente[$i]['cidade'];?>"> <? echo $lista_cliente[$i]['cidade'];?> </td>
										
										<td> <input type="hidden" name="cep" value="<? echo $lista_cliente[$i]['cep'];?>"> <? echo $cep_formatado;?> </td>
										
										<td> <input type="hidden" name="fone_residencial" value="<? echo $lista_cliente[$i]['fone_residencial'];?>"> <? echo $fone_formatado;?> </td>
										   
										<td> <input type="hidden" name="fone_celular" value="<? echo $lista_cliente[$i]['fone_celular'];?>"> <?php echo $celular_formatado;?> </td>
										
										<td> <input type="hidden" name="email" value="<? echo $lista_cliente[$i]['email'];?>"> <? echo $lista_cliente[$i]['email'];?> </td>
										
										<td> <input type="hidden" name="check_fornecedor" value="<? echo $lista_cliente[$i]['check_fornecedor'];?>"> <? echo $campo_fornecedor;?> </td> 
										
										<!-- <td> <input type="hidden" name="fornecedor" value="<? //echo $lista_cliente[$i]['cod_fornecedor'];?>"> <? //echo $lista_cliente[$i]['cod_fornecedor'];?> </td> -->  
									  
									  	<td style="width:45px;">
									  	
									  		<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_cliente(<? echo $i;?>)">
  													<span class="glyphicon glyphicon-pencil"> </span>
												</button>	
												
												<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_cliente(<? echo $i;?>)">
  													<span class="glyphicon glyphicon-trash"> </span>
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

