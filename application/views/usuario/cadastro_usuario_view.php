<h4 class="text-center"> Cadastro de usuários </h4>
 
<div class="box-cadastro-user">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title"><strong>Preencha os dados abaixo:</strong></span>
			</div>
			<div class="panel-body">
				<form method="post" action="<?php echo base_url('usuario/cadastrar_usuario');?>">
					<div class="form-group">
						<label for="nome">Nome:</label> 
						<input type="text" class="form-control" id="nome" name="nome"  size="75" value="<?php echo set_value('nome')?>" placeholder="Digite o nome completo do usuário" required>
					</div>
					
					<div class="msg-erro-cadastro-user">
						<?php echo form_error('nome'); ?>
					</div>
					
					<div class="form-group">
						<label for="login">Login:</label> 
						<input type="text" class="form-control" id="login" name="login" size="45" value="<?php echo set_value('login')?>" placeholder="Digite um nome para Login no Sistema" required>
					</div>
					
					<div class="msg-erro-cadastro-user" style="width:320px;">
						<?php echo form_error('login'); ?>
					</div>
					
					<div class="form-group">
						<label for="senha">Senha:</label> 
						<input type="password" class="form-control" id="senha" name="senha" size="45" value="<?php echo set_value('senha')?>" placeholder="Digite uma senha para Login no Sistema" required>
					</div>
					
					<div class="msg-erro-cadastro-user">
						<?php echo form_error('senha'); ?>
					</div>
					
					<div class="form-group">
						<label for="email">E-mail:</label> 
						<input type="email" class="form-control" id="email" name="email" size="75" value="<?php echo set_value('email')?>" placeholder="Digite uma endereço de E-mail" required>
					</div>
					
					<div class="msg-erro-cadastro-user">
						<?php echo form_error('email'); ?>
					</div>
										
					<div class="form-group" style="margin-top:25px;">
						<label for="ativo">Ativo:</label> 
						<label class="radio-inline">
  							<input type="radio" id="ativo" name="ativo" value="TRUE" checked> Sim
						</label>
						<label class="radio-inline">
  							<input type="radio" id="ativo" name="ativo" value="FALSE"> Não
						</label>
					</div>
							
					<div class="form-group">
						<label for="permissao">Permissão:</label>
					
						<div class="campo-select-cadastro">
							<select class="form-control" name="permissao">
								  <option value='0'>Selecione uma opção</option>
									<?php
										for($a=1; $a<=sizeof($lista_permissoes); $a++)
										{
											if( $permissao == $a)
											{
												echo "<option value=".$a." selected=\"selected\">".$lista_permissoes[$a]."</option>";
											}
											else
											{
												echo "<option value=".$a.">".$lista_permissoes[$a]."</option>";
											}					
										}								
									?>			
							</select>	 
						</div>
					</div>
					
					<div class="msg-erro-cadastro-user" style="width:320px;">
						<?php echo form_error('permissao'); ?>
					</div>
													
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="cadastrar" value="Cadastrar">
				</form>
			</div><!-- fim panel-body -->
			
			<div class="panel-footer"></div>
			
		</div><!-- Fim Panel -->
	</div>


