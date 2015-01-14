<link rel="stylesheet" href="<?php echo base_url('js/jquery-ui/accordion_tabs.css');?>"> 
<link rel="stylesheet" href="<?php echo base_url('css/entregas/entregas.css');?>"> 
<script src="<?php echo base_url('js/jquery-ui/accordion_tabs.js');?>"> </script>
<script src="<?php echo base_url('js/entregas/entregas.js');?>"> </script>

<script type="text/javascript">
	var url_listar_entregas = "<?php echo base_url('entregas/listar_entregas')?>";
</script>

<h4 class="text-center">Consultar Entregas </h4>
 
<div class="box-cadastro-cli">
		<div class="panel panel-default">
		
			<div class="panel-heading">
				<span class="panel-title"> <strong> Entregas por mês </strong> </span>
			</div>
			
			<div class="panel-body">
				<div id="tabs">
					<ul>
						<li id="mes1">  <a href="#tabs1">  Janeiro	 	</a> </li>
						<li id="mes2">  <a href="#tabs2">  Fevereiro 	</a> </li>
					 	<li id="mes3">  <a href="#tabs3">  Março	 	</a> </li>
						<li id="mes4">  <a href="#tabs4">  Abril	 	</a> </li>
						<li id="mes5">  <a href="#tabs5">  Maio			</a> </li>
						<li id="mes6">  <a href="#tabs6">  Junho	 	</a> </li>
						<li id="mes7">  <a href="#tabs7">  Julho	 	</a> </li>
						<li id="mes8">  <a href="#tabs8">  Agosto	 	</a> </li>
						<li id="mes9">  <a href="#tabs9">  Setembro		</a> </li>
						<li id="mes10"> <a href="#tabs10"> Outubro	 	</a> </li>
						<li id="mes11"> <a href="#tabs11"> Novembro		</a> </li>
						<li id="mes12"> <a href="#tabs12"> Dezembro		</a> </li>	
					</ul>
					
					<?php for($i=1; $i<=12 ; $i++) { ?>
						<div id="<?php echo "tabs".$i ?>">	
						
						</div>
					<?php } ?>
					
				</div>
			</div>
			
			<div class="panel-footer"> </div>
		</div>

</div>