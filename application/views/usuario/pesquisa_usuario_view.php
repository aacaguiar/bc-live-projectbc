<script type="text/javascript">
url_alterar_cliente="<?php echo base_url('usuario/alterar_usuario');?>";
url_excluir_cliente="<?php echo base_url('usuario/excluir_usuario');?>";
function alt_cliente(id){
	var f = document.getElementById('form'+id);
	f.action=url_alterar_cliente;
}
function exc_cliente(id){
	var resposta = window.confirm("Deseja excluir o usuario");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_cliente;
	}
}
</script>
<h4 class="text-center"> Pesquisa de usuários </h4>

		<div class="panel panel-default">
		
			<div class="panel-heading">
				<span class="panel-title"><strong>Listagem de todos os usuários do Sistema:</strong></span>
			</div>
			
			<div class="panel-body">
			
						<div class="table-responsive">
						
							<table class="table table-hover table-striped table-condensed">					
								<thead>
								 	<tr class="success">
										<th>Nome</th>
										<th>Usuário</th>
										<th>Senha</th>
										<th>email</th>
										<th>Ativo</th>
										<th>Nível de acesso</th>
										<th>Ações</th>
									</tr>
								
								</thead>
								
								<tbody>				
								<?php for ($i=0; $i<sizeof($lista_usuarios); $i++ ){?>
								<form method="post" action="" name="listar" id="<?echo "form".$i;?>">
									<input type="hidden" name="cod_usuario" value="<?php echo $lista_usuarios[$i]['cod_usuario'];?>">  
										<tr>
											<td class="texto-pesquisa-user"> <input type="hidden" name="nome" value="<?php echo $lista_usuarios[$i]['nome'];?>"> <?php echo $lista_usuarios[$i]['nome'];?> </td>
											<td class="texto-pesquisa-user"> <input type="hidden" name="login" value="<?php echo $lista_usuarios[$i]['login'];?>"> <?php echo $lista_usuarios[$i]['login'];?> </td>
											<td class="texto-pesquisa-user"> <input type="hidden" name="senha" value="<?php echo $lista_usuarios[$i]['senha'];?>"> <?php echo "**********";?> </td>
											<td class="texto-pesquisa-user"> <input type="hidden" name="email" value="<?php echo $lista_usuarios[$i]['email'];?>"> <?php echo $lista_usuarios[$i]['email'];?> </td>
											<td class="texto-pesquisa-user"> <input type="hidden" name="ativo" value="<?php echo $lista_usuarios[$i]['ativo'];?>"> <?php echo $lista_usuarios[$i]['ativo'];?> </td>
											<td class="texto-pesquisa-user"> <input type="hidden" name="permissao" value="<?php echo $lista_usuarios[$i]['permissao'];?>"> <?php echo $lista_usuarios[$i]['permissao'];?> </td>
											
											<td class="texto-pesquisa-user" style="width:45px;">
												<button type="submit" class="btn-editar" name="editar" onMouseOver="this.title='Editar'" onClick="alt_cliente(<? echo $i; ?>)">
  													<span class="glyphicon glyphicon-pencil"> </span>
												</button>
												
												<button type="submit" class="btn-editar" name="excluir" onMouseOver="this.title='Excluir'" onClick="exc_cliente(<? echo $i; ?>)">
  													<span class="glyphicon glyphicon-trash"> </span>
												</button>
																					  			
										  		<!-- <input type="image" src="<?php //echo base_url('imagens/icones/Pencil2.png')?>" onMouseOver="this.title='Editar'" onClick="alt_cliente(<?//echo $i;?>)" name="editar" class="btn-editar"> -->
										  		<!-- <input type="image" src="<?php //echo base_url('imagens/icones/Trash-icon.png')?>" onMouseOver="this.title='Excluir'" onClick="exc_cliente(<?//echo $i;?>)" name="excluir" class="btn-excluir"> -->
											<!--  
											<input type="submit" name="editar" value="editar" class="btn-editar-pesquisa-user"> 
											-->
											</td>
										</tr>
								</form>
								<?php }?>	
							</tbody>
						</table>
					</div><!-- fim do table-responsive -->
				
			</div>
			
			<div class="panel-footer">
				<strong>Legenda:</strong>
				<ul class="list-inline">
					<li><small>1-Administrador</small></li>
					<li><small>2-Diretor</small></li>
					<li><small>3-Financeiro</small></li>
					<li><small>4-Supervisor</small></li>
					<li><small>5-Coordenador Técnico</small></li>
					<li><small>6-Coordenador de Produção</small></li>		
				</ul>
			</div>
					
		</div><!-- fim do panel -->

