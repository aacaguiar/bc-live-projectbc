<!DOCTYPE html>
<html lang="pt-BR"> 
<head>
<title>Bioclone</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Sistema de Login Bioclone">
<meta name="author" content="Sharlon Franklin">

<link rel="stylesheet" type="text/css" href='<?php echo $arquivo_css;?>'>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/templates/menu.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('css/templates/principal.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('bootstrap/css/bootstrap.css')?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
<script type="text/javascript" src="<?php echo base_url('js/jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('js/jquery.maskedinput.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('bootstrap/js/bootstrap.min.js');?>"></script>

<!-- 
 Just for debugging purposes. Don't actually copy this line! -->
<!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]
-->
</head>

<body>
 	
<!-- box imagem topo -->
<div class="navbar navbar-default navbar-static-top box-img-topo">
 		<!-- <img class="img-topo" src="<?php //echo base_url('imagens/img-cabecalho.png');?>"> -->
</div>
 
 <!-- navbar dos menus -->
 <div class="navbar navbar-default navbar-static-top" style="margin-top:-67px;">

   <div class="container" style="margin-top:0px;">  <!-- box menus -->
   
	  <div class="container-fluid">
	  	<div class="navbar-header">
	  		<img class="img-logo-principal" src="<?php echo base_url('imagens/bioclone-logo.jpg')?>">
	      	<a class="navbar-brand titulo" href="http://www.bioclone.com.br" target="_blanck">Sistema <br> &nbsp Bioclone</a> 
	    </div>
	
	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	        <li> <a href='<?php echo base_url('pagina_inicial')?>'> <!-- <img class="icone-menu" src="<? //echo base_url('imagens/icones/home.png')?>"> --> Home </a></li>
	      		 <?php 
	  				foreach ($lista_menu as $key => $lista){
	  						echo $lista; 							 		
	  					} 
	  			  ?>
	  		<li> <a href='<?php echo base_url('pagina_inicial/fechar_sessao')?>'> <!-- <img class="icone-menu" style="height:20px" src="<? //echo base_url('imagens/icones/exit-icon.png')?>"> --> Sair </a></li>	
	      </ul>
	            
	      <ul class="nav navbar-nav navbar-right">
	        <li class="username"> <?php echo 'Bem vindo, '.$nome_usuario; ?> </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</div>
</div> <!-- Fim navbar do menu principal -->
 
<div class="container conteudo">      

