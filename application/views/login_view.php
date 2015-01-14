<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Sistema de Login Bioclone">
<meta name="author" content="Sharlon Franklin">
<title>Bioclone</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/signin.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('bootstrap/css/bootstrap.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
 <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<script type="text/javascript">
url = "<?php echo base_url('login/redefinir_senha')?>";
function nova_senha()
{
	var f = document.getElementById('form_login');
	f.action = url;
	f.submit();
}
</script>

<body>							
	
 <div class="container">
 
 		<div class="header">
				<img class="img-logo" src="<?php echo base_url('imagens/bioclone-logo.jpg');?>">
				<ul class="nav nav-pills pull-right">
					<!-- <li class="active"><a href="http://www.bioclone.com.br" target="_blank">Entrar no site Bioclone</a></li> -->
				</ul>
				<h4>Controle de Produção de Mudas - Bioclone S/A</h4>
		</div>

      <form class="form-signin"  name="form_login" id="form_login" method="post" action="<?php echo base_url('login/verificar_login'); ?>">
        <h2 class="cabecalho-login">Login</h2>
        
        <div class="box-user">
       		<label class="label-login" for="usuario">Usuário</label>
        	<input type="text" name="usuario" class="form-control" value="<?php echo set_value('usuario');?>" placeholder="Digite nome do usuário" required autofocus>
        	
        	<div class="msg-erro-login" id="nome_erro">
				<?php echo form_error('usuario'); ?>
			</div>	
        </div>
        
        <div class="box-passw">
        	<label class="label-login" for="senha">Senha</label>
       		<input type="password" name="senha" class="form-control" value="<?php echo set_value('senha');?>" placeholder="Password" required>
       		
       		<div class="msg-erro-login">
				<?php echo form_error('senha'); ?>
			</div>
        </div>
        
        <a style="cursor:pointer" onClick="nova_senha()">Redefinir senha</a> <br>
        
        <!-- 
        <button type="submit" class="btn btn-lg btn-primary btn-login" onclick="nova_senha()">Redefinir Senha</button>
		-->
				
        <button type="submit" class="btn btn-lg btn-primary btn-login">Entrar</button>
      </form>
    </div> 
 
<!--    
    <div id="footer">
       <div class="container">
        <p class="text-footer">&copy; Company 2013 - Todos os Direitos reservados <br> 
			Rua Luis Gouveia, 1255, Amador, Eusébio - Ce | Brasil. CEP: 61760-000 - (85) 3260-4929</p>
      </div>
    </div>
-->
   
</body>
</html>

