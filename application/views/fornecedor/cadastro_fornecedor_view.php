<script type="text/javascript" src="<?php echo base_url('js/fornecedor/fornecedor.js')?>"></script>
<script type="text/javascript">
var tipo_fornecedor ="<?php echo $tipo_fornecedor; ?>";
url_carregar_cidade = "<?php echo base_url('fornecedor/carregar_cidades')?>";
window.onload = function () {
	if(tipo_fornecedor != '0'){
		selecao_clifor(tipo_fornecedor);
	}
	carregar_cidade();
}
</script>

<h4 class="text-center">Cadastro de Fornecedor</h4>

<div class="box-cadastro-cli">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"> <strong>Preencha os dados abaixo:</strong> </span>
			</div>
			<div class="panel-body">
				<form name="cadastro_fornecedor" method="post" action="<?php echo base_url('fornecedor/cadastrar_fornecedor');?>">
				
				<div class="form-group">
						<label for="tipo_cliente">Fornecedor:</label>
					
						<div class="select-cadastro-cli">
							<select class="form-control" id="tipo_fornecedor" name="tipo_fornecedor">
								<option value="0">Selecione a opção</option>
								<option value="fisica" <?php echo set_select('tipo_fornecedor','fisica',($tipo_fornecedor == "fisica" ? TRUE : FALSE ));?>>Pessoa Física</option>
								<option value="juridica" <?php echo set_select('tipo_fornecedor','juridica',($tipo_fornecedor == "juridica" ? TRUE : FALSE ));?>>Pessoa Jurídica</option>									
							</select>	 
						</div>
					</div>
						
					<div class="msg-erro-cadastro-cli" style="width:324px;">
						<?php echo form_error('tipo_fornecedor'); ?>
					</div>
					 
					<!--   					
  					<div class="form-group">
						<label for="cod_fornecedor">Cód. Fornecedor:</label> 
						<input type="text" class="form-control" id="cod_fornecedor" name="cod_fornecedor"  size="15" value="<?php //echo set_value('cod_fornecedor')?>">
					</div>
					-->
					
					<div class="form-group">
						<label for="pessoa_fisica">Nome / Razão Social:</label> 
						<input type="text" class="form-control" id="nome_rsocial" name="nome_rsocial"  size="75" value="<?php echo set_value('nome_rsocial')?>">
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-nome">
						<?php echo form_error('nome_rsocial'); ?>
					</div>
					
					<div class="form-group">
						<label for="cpf">Cpf / Cnpj:</label> 
						<input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" size="35" value="<?php echo set_value('cpf_cnpj')?>">
					</div>
					
					<div class="msg-erro-cadastro-cli" id="erro-cpf" style="width:270px;">
						<?php echo form_error('cpf_cnpj'); ?>
					</div>
										
					<div class="form-group">
						<label for="endereco">Endereço:</label> 
						<input type="text" class="form-control" id="endereco" name="endereco" size="75" value="<?php echo set_value('endereco')?>">
					</div>
					
					<div class="form-group">
						<label for="bairro">Bairro:</label> 
						<input type="text" class="form-control" id="bairro" name="bairro" size="75" value="<?php echo set_value('bairro')?>">
					</div>
					
					<div class="form-group">
						<label for="estado">Estado:</label>
						  
					<div class="select-cadastro-cli">
							<select class="form-control" id="estado" name="estado" onChange="carregar_cidade();">
								<option value='0'>Selecione uma opção</option>
									<?php
										foreach ($lista_estados as $estado) {
											if( $selecao_estado == $estado){
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
									<option value='0'>Selecione uma opção</option>
										<? if($selecao_cidade !='0' && $selecao_cidade !='') { 
											echo "<option value='$selecao_cidade' selected>".$selecao_cidade."</option>";
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
						<input type="text" class="form-control" id="cep" name="cep" size="35" value="<?php echo set_value('cep')?>">
					</div>
					
					<div class="form-group">
						<label for="fone_residencial">Fone residencial:</label> 
						<input type="text" class="form-control" id="fone_residencial" name="fone_residencial" size="35" value="<?php echo set_value('fone_residencial')?>">
					</div>
					
					<div class="form-group">
						<label for="fone_celular">Fone celular:</label> 
						<input type="text" class="form-control" id="fone_celular" name="fone_celular" size="35" value="<?php echo set_value('fone_celular')?>">
					</div>
					
					<div class="form-group">
						<label for="email">E-mail:</label> 
						<input type="text" class="form-control" id="email" name="email" size="50" value="<?php echo set_value('email')?>">
					</div>
																																
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>


