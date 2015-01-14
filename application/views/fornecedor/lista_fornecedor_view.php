<script type="text/javascript" src="<?php echo base_url('js/fornecedor/lista_fornecedor.js');?>"></script>
<script type="text/javascript">
url_alterar_fornec="<?php echo base_url('fornecedor/alterar_fornecedor');?>";
url_excluir_fornec="<?php echo base_url('fornecedor/excluir_fornecedor');?>";
</script>

<h4 class="text-center"> Consulta de Fornecedores </h4>

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
			
			<h3 class="panel-title"> 
				<strong> 
					Listagem de Fornecedores - <? echo ($tipo_fornecedor == 'fisica') ? 'pessoa física' : 'pessoa jurídica';?> 
				</strong>
			</h3>
				
			</div>
			
			<div class="panel-body">
						<div class="">
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
								 		<th>linha</th>
								 		<th>Cód.</th>
								 		<? if($tipo_fornecedor=='fisica'){?>
										<th>Nome</th>
										<th>Cpf</th>
										<? } else {?>
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
										<!-- <th>Fornecedor</th> -->
										<!-- <th>Cód.Fornec.</th> -->
										<th>Ações</th>
									</tr>
								</thead>
								
								<tbody>			
								<?php for ($i=0; $i<sizeof($lista_fornecedor); $i++ ){
									
									if($tipo_fornecedor=='fisica')
									{
										if(strlen($lista_fornecedor[$i]['cpf_cnpj'])=='11'){
											$cpf_cnpj_formatado = substr($lista_fornecedor[$i]['cpf_cnpj'],0,3).".".substr($lista_fornecedor[$i]['cpf_cnpj'],3,3).".".substr($lista_fornecedor[$i]['cpf_cnpj'],6,3)."-".substr($lista_fornecedor[$i]['cpf_cnpj'],9,2);
										}else{
											$cpf_cnpj_formatado = " ";
										}	
									}
									
									if($tipo_fornecedor=='juridica')
									{
										if(strlen($lista_fornecedor[$i]['cpf_cnpj'])=='14'){
											$cpf_cnpj_formatado = substr($lista_fornecedor[$i]['cpf_cnpj'],0,2).".".substr($lista_fornecedor[$i]['cpf_cnpj'],2,3).".".substr($lista_fornecedor[$i]['cpf_cnpj'],5,3)."/".substr($lista_fornecedor[$i]['cpf_cnpj'],8,4).".".substr($lista_fornecedor[$i]['cpf_cnpj'],12,2);  
										}else{
											$cpf_cnpj_formatado = " ";
										}
									}

									if(strlen($lista_fornecedor[$i]['cep'])=='8'){
										$cep_formatado = substr($lista_fornecedor[$i]['cep'],0,2).".".substr($lista_fornecedor[$i]['cep'],2,3)."-".substr($lista_fornecedor[$i]['cep'],5,3);	
									}
									else{
										$cep_formatado = " ";
									}
									
									if(strlen($lista_fornecedor[$i]['fone_residencial'])=='10'){
										$fone_formatado = "(".substr($lista_fornecedor[$i]['fone_residencial'],0,2).")".substr($lista_fornecedor[$i]['fone_residencial'],2,4)."-".substr($lista_fornecedor[$i]['fone_residencial'],6,4);
									}
									else{
										$fone_formatado = " ";
									}
																		
									if(strlen($lista_fornecedor[$i]['fone_celular'])=='10'){
										$celular_formatado = "(".substr($lista_fornecedor[$i]['fone_celular'],0,2).")".substr($lista_fornecedor[$i]['fone_celular'],2,4)."-".substr($lista_fornecedor[$i]['fone_celular'],6,4);
									}
									else if(strlen($lista_fornecedor[$i]['fone_celular'])=='11'){
											$celular_formatado = "(".substr($lista_fornecedor[$i]['fone_celular'],0,2).")".substr($lista_fornecedor[$i]['fone_celular'],2,5)."-".substr($lista_fornecedor[$i]['fone_celular'],7,4);
										  }else{
											$celular_formatado = " ";
										  }
									
								?>
								<tr class="texto-pesquisa-user">
								<form method="post" action="" name="listar" id="<?echo "form".$i;?>">

										<input type="hidden" name="cod_fornecedor" 	 value="<? echo $lista_fornecedor[$i]['cod_fornecedor'];?>">
										<input type="hidden" name="check_fornecedor" value="<? echo $lista_fornecedor[$i]['check_fornecedor'];?>">  
										<input type="hidden" name="cod_endereco" 	 value="<? echo $lista_fornecedor[$i]['cod_endereco'];?>"> 
										<input type="hidden" name="tipo_fornecedor"  value="<? echo $tipo_fornecedor;?>">
										
										<td> <? echo $inicio++; ?> </td>
										
										<td> <? echo $lista_fornecedor[$i]['cod_fornecedor'];?> </td>
										
											 <input type="hidden" name="id_clifor" value="<? echo $lista_fornecedor[$i]['id_clifor'];?>"> 
										<td> <input type="hidden" name="nome_rsocial" value="<? echo $lista_fornecedor[$i]['nome_rsocial'];?>"> <? echo $lista_fornecedor[$i]['nome_rsocial'];?> </td>	
										<td> <input type="hidden" name="cpf_cnpj" value="<? echo $lista_fornecedor[$i]['cpf_cnpj'];?>"> <? echo $cpf_cnpj_formatado; ?> </td>
																		
										<td> <input type="hidden" name="endereco" value="<? echo $lista_fornecedor[$i]['endereco'];?>"> <? echo $lista_fornecedor[$i]['endereco'];?> </td>
										
										<td> <input type="hidden" name="bairro" value="<? echo $lista_fornecedor[$i]['bairro'];?>"> <? echo $lista_fornecedor[$i]['bairro'];?> </td>
										
										<td> <input type="hidden" name="estado" value="<? echo $lista_fornecedor[$i]['estado'];?>"> <? echo $lista_fornecedor[$i]['estado'];?> </td>
										
										<td> <input type="hidden" name="cidade" value="<? echo $lista_fornecedor[$i]['cidade'];?>"> <? echo $lista_fornecedor[$i]['cidade'];?> </td>
										
										<td> <input type="hidden" name="cep" value="<? echo $lista_fornecedor[$i]['cep'];?>"> <? echo $cep_formatado;?> </td>
										
										<td> <input type="hidden" name="fone_residencial" value="<? echo $lista_fornecedor[$i]['fone_residencial'];?>"> <? echo $fone_formatado;?> </td>
										   
										<td> <input type="hidden" name="fone_celular" value="<? echo $lista_fornecedor[$i]['fone_celular'];?>"> <?php echo $celular_formatado;?> </td>
										
										<td> <input type="hidden" name="email" value="<? echo $lista_fornecedor[$i]['email'];?>"> <? echo $lista_fornecedor[$i]['email'];?> </td>
																				
										<!-- <td> <input type="hidden" name="fornecedor" value="<? //echo $lista_fornecedor[$i]['cod_fornecedor'];?>"> <? //echo $lista_fornecedor[$i]['cod_fornecedor'];?> </td> -->  
									  
										<td style="width:45px;"> 
										
											<button type="submit" class="btn-editar" onMouseOver="this.title='Editar'" onClick="alt_fornec(<?echo $i;?>)">
  													<span class="glyphicon glyphicon-pencil" style=""> </span>
											</button>	
											
											<button type="submit" class="btn-excluir" onMouseOver="this.title='Excluir'" onClick="exc_fornec(<?echo $i;?>)">
  													<span class="glyphicon glyphicon-trash" style=""> </span>
											</button>
											
										</td>		
								</form>
								</tr>
								<?php }?>	
							</tbody>
						</table>
					</div><!-- fim do table-responsive -->	
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


