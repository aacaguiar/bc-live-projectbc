<h4 class="text-center"> Alteração de dados do usuário </h4>
 
<div class="box-altera-user">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<h3 class="panel-title">Altere as informações abaixo:</h3>
			</div>
			
			<div class="panel-body">
				<form method="post" action="<?php echo base_url('usuario/alterar_dados_usuario');?>">
					<input type="hidden" name="cod_usuario" value="<?php echo $dados['us_cod_usuario'];?>">
					<input type="hidden" name="senha_atual" value="<?echo $dados['us_senha'];?>">
					
					<div class="form-group">
						<label for="nome">Nome:</label> 
						<input type="text" class="form-control" id="nome" name="nome"  size="75" value="<?php echo $dados['us_nome'];?>" required>
					</div>
					
					<div class="msg-erro-altera-user">
						<?php echo form_error('nome'); ?>
					</div>
					
					<div class="form-group">
						<label for="login">Login:</label> 
						<input type="text" class="form-control" id="login" name="login" size="45" value="<?php echo $dados['us_usuario'];?>"  required>
					</div>
					
					<div class="msg-erro-altera-user" style="width:320px;">
						<?php echo form_error('login'); ?>
					</div>
					
					<div class="form-group">
						<label for="senha">Senha:</label> 
						<input type="password" class="form-control" id="senha" name="senha" size="45" value="******"  required>
					</div>
					
					<div class="msg-erro-altera-user">
						<?php echo form_error('senha'); ?>
					</div>
					
					<div class="form-group">
						<label for="email">E-mail:</label> 
						<input type="email" class="form-control" id="email" name="email" size="75" value="<?php echo $dados['us_email'];?>" required>
					</div>
					
					<div class="msg-erro-altera-user">
						<?php echo form_error('email'); ?>
					</div>
										
					<div class="form-group" style="margin-top:25px;">
						<label for="ativo">Ativo:</label>
						<?php
							if($dados['us_ativo']=='Sim') { 
								$sim='checked';
								$nao='';
							}else{ 
								$sim='';
								$nao='checked';
							}
						?> 
						<label class="radio-inline">
  							<input type="radio" id="ativo" name="ativo" value="TRUE" <?php echo $sim;?> > Sim
						</label>
						<label class="radio-inline">
  							<input type="radio" id="ativo" name="ativo" value="FALSE" <?php echo $nao;?> > Não
						</label>
					</div>
							
					<div class="form-group">
						<label for="permissao">Permissão:</label>
					
						<div class="campo-select-cadastro">
							<select class="form-control" name="permissao">
								<?php
									for($a=1; $a<=sizeof($lista_permissoes); $a++)
									{
										if( $dados['pe_cod_permissao'] == $a){
											echo "<option value=".$a." selected=\"selected\">".$lista_permissoes[$a]."</option>";
										}
										else{
											echo "<option value=".$a.">".$lista_permissoes[$a]."</option>";
										}						
									}								
								?>
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-user">
						<?php echo form_error('permissao'); ?>
					</div>
													
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>
</div>
