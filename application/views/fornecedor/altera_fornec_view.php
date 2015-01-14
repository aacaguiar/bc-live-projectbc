<script type="text/javascript" src="<?php //echo base_url('js/cliente/cadastro_cliente.js')?>"> </script>
<script type="text/javascript" src="<?php echo base_url('js/fornecedor/fornecedor.js')?>"> </script>
<script>
window.onload = function () {
	carregar_cidade();
	marcar_fornecedor();
}

function carregar_cidade()
{
	var estado = document.getElementById("estado").value;	
	if(estado !='0' && estado !=''){
		var cidade = document.getElementById("cidade").value;
		
		xmlhttp = carrega_ajax();
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  		document.getElementById("cidade").innerHTML=xmlhttp.responseText;
		  		}
		}
		dados="estado="+estado+"&cidade="+cidade;
		xmlhttp.open("POST","<?php echo base_url('fornecedor/carregar_cidades')?>",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(dados);
	}		
}
</script>

<h4 class="text-center">Alterar Fornecedor <small> <?php echo ($tipo_fornecedor == 'fisica') ? 'Pessoa Física' : 'Pessoa Jurídica'; ?> </small> </h4>
 
<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Informações do Fornecedor:</strong></span>
			</div>
			<div class="panel-body">
				<form name="cadastro_cliente" method="post" action="<?php echo base_url('fornecedor/alterar_dados_fornecedor');?>">
					<input type="hidden" name="cod_endereco" value="<? echo $endereco['cod_endereco'];?>">
					<input type="hidden" name="id_clifor" value="<?php echo $dados['id_clifor'];?>">
					<input type="hidden" name="tipo_fornecedor" value="<?php echo $tipo_fornecedor;?>">
						
					<div class="page-header">
  						<h3><small>Pessoa Física:</small></h3>
					</div>
				
				<!-- 								
					<div class="checkbox">
						<?//if ($dados['check_fornecedor']=='t') { ?>
		    					<input type="checkbox" id="check_fornecedor"  value='t' name="check_fornecedor" checked onClick="marcar_fornecedor()"> 
	    				<?//} else { ?>
	    						<input type="checkbox" id="check_fornecedor"  value='f' name="check_fornecedor" onClick="marcar_fornecedor()"> 
	    				<?//} ?>
    					<label>	
    						Este cliente também é fornecedor.
    					</label>
 					 </div>
  				-->							
  					<div class="form-group">
						<label for="cod_fornecedor">Cód. Fornecedor:</label> 
						<input type="text" readonly class="form-control" id="cod_fornecedor" name="cod_fornecedor"  size="15" value="<?php echo $dados['cod_fornecedor'];?>">
					</div>
					
					<?php if($tipo_fornecedor == 'fisica') { ?>
						<div class="form-group">
							<label for="pessoa_fisica">Nome:</label> 
							<input type="text" class="form-control" id="nome_rsocial" name="nome_rsocial"  size="75" value="<?php echo $dados['nome_rsocial'];?>">
						</div>
						
						<div class="msg-erro-cadastro-cli" id="erro-nome">
							<?php echo form_error('nome_rsocial'); ?>
						</div>
						
						<div class="form-group">
							<label for="cpf">Cpf:</label> 
							<input type="text" class="form-control" id="cpf" name="cpf_cnpj" size="35" value="<?php echo $dados['cpf_cnpj'];?>">
						</div>
											
						<div class="msg-erro-cadastro-cli" id="erro-cpf" style="width:270px;">
							<?php echo form_error('cpf_cnpj'); ?>
						</div>
					<?php } else { ?>
					
						<div class="form-group">
							<label for="pessoa_juridica">Razão Social:</label> 
							<input type="text" class="form-control" id="nome_rsocial" name="nome_rsocial"  size="75" value="<?php echo $dados['nome_rsocial'];?>">
						</div>
						
						<div class="msg-erro-cadastro-cli" id="erro-rsocial">
							<?php echo form_error('nome_rsocial'); ?>
						</div>
						
						<div class="form-group">
							<label for="cnpj">Cnpj:</label> 
							<input type="text" class="form-control" id="cnpj" name="cpf_cnpj" size="35" value="<?php echo $dados['cpf_cnpj'];?>">
						</div>
						
						<div class="msg-erro-cadastro-cli" id="erro-cnpj" style="width:270px;">
							<?php echo form_error('cpf_cnpj'); ?>
						</div>
					
					<?php } ?>
					
					<div class="form-group">
						<label for="endereco">Endereço:</label> 
						<input type="text" class="form-control" id="endereco" name="endereco" size="75" value="<?php echo $endereco['endereco'];?>">
					</div>
					
					<div class="form-group">
						<label for="bairro">Bairro:</label> 
						<input type="text" class="form-control" id="bairro" name="bairro" size="75" value="<?php echo $endereco['bairro'];?>">
					</div>
					
					<div class="form-group">
						<label for="estado">Estado:</label>
						<div class="select-cadastro-cli">
							<select class="form-control" id="estado" name="estado" onChange="carregar_cidade(this.value);">
								<option value='0'>Selecione uma opção</option>
									<?php
										foreach ($lista_estados as $estado) {
											if( $endereco['estado'] == $estado){
												echo "<option value='$estado' selected=\"selected\">".$estado."</option>";
											}else{
												echo "<option value='$estado'>".$estado."</option>";
											}	
										}	
									?>								
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-cli" style="width:324px;">
						<?php echo form_error('estado'); ?>
					</div>
					
					<div class="form-group">
						<label for="cidade">Cidade:</label>
							<div class="select-cadastro-cli">
								<select class="form-control" id="cidade" name="cidade">
									<option value='0'>Selecione a opção</option>
									<?php
										if($endereco['cidade'] != '0'){
											echo "<option value='".$endereco['cidade']."' selected='selected'>".$endereco['cidade']."</option>";
										}	
									?>					
								</select>	  
							</div>
					</div>
					
					<div class="msg-erro-cadastro-cli" style="width:324px;">
						<?php echo form_error('cidade'); ?>
					</div>
					
					<div class="form-group">
						<label for="cep">Cep:</label> 
						<input type="text" class="form-control" id="cep" name="cep" size="35" value="<?php echo $endereco['cep'];?>">
					</div>
					
					<div class="form-group">
						<label for="fone_residencial">Fone residencial:</label> 
						<input type="text" class="form-control" id="fone_residencial" name="fone_residencial" size="35" value="<?php echo $endereco['fone_residencial'];?>">
					</div>
					
					<div class="form-group">
						<label for="fone_celular">Fone celular:</label> 
						<input type="text" class="form-control" id="fone_celular" name="fone_celular" size="35" value="<?php echo $endereco['fone_celular'];?>">
					</div>
					
					<div class="form-group">
						<label for="email">E-mail:</label> 
						<input type="text" class="form-control" id="email" name="email" size="50" value="<?php echo $endereco['email'];?>">
					</div>
																																
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>



