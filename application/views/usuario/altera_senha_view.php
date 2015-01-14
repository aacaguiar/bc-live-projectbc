<h4 class="text-center"> Alteração de Senha </h4>
 
<div class="box-senha-user">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<span class="panel-title"><strong>Preencha os dados abaixo:</strong></span>
			</div>
		 	
			<div class="panel-body">
				<form method="post" action="<?php echo base_url('usuario/alterar_senha_usuario');?>">
					<div class="form-group">
						<label for="senha_atual">Senha atual:</label> 
						<input type="password" class="form-control" id="senha_atual" name="senha_atual"  size="30" value="<?php echo set_value('senha_atual')?>" placeholder="Digite a sua senha anterior" required>
					</div>
					
					<div class="msg-erro-senha-user">
						<?php echo form_error('senha_atual'); ?>
					</div>
									
					<div class="form-group">
						<label for="nova_senha">Nova senha:</label> 
						<input type="password" class="form-control" id="nova_senha" name="nova_senha"  size="30" value="<?php echo set_value('nova_senha')?>" placeholder="Digite a nova senha" required>
					</div>
					
					<div class="form-group">
						<label for="confirma_senha">Confirme a senha:</label> 
						<input type="password" class="form-control" id="confirma_senha" name="confirma_senha"  size="30" value="<?php echo set_value('confirma_senha')?>" placeholder="Digite novamente a senha" required>
					</div>
					
					<div class="msg-erro-senha-user">
						<?php echo form_error('confirma_senha'); ?>
					</div>
																		
					<input type="submit" class="btn btn-default" style="margin-top:20px;" id="alterar" value="Alterar">
				</form>
				
			</div><!-- fim panel-body -->					
			<div class="panel-footer"></div>	
		</div><!-- Fim Panel -->
</div>




