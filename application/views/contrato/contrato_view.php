<script type="text/javascript" src="<?php echo base_url('js/contrato/jstree.min.js');?>"> </script>
<script type="text/javascript" src="<?php echo base_url('js/contrato/pdfobject.js');?>"> </script>
<link rel="stylesheet" href="<?php echo base_url('css/contrato/jstree.css');?>">

<script type="text/javascript">
url_carregar_contrato = "<?php echo base_url('contrato/carregar_contrato')?>";

	$(document).ready(function () { 
		$('#box-file').jstree();

		$("#box-file ul").on("click", "li.item" ,function(){
			//alert($(this).attr("id"));
			var $id = $(this).attr("id");
			var $ano = "<?php echo $ano; ?>";
			
		$.post( url_carregar_contrato,
				  {
				    id: $id, 
				    ano: $ano,
				  },
				  function(data){
				    //alert("Data: " + data + "\nStatus: " + status);
					var box_pdf = $("#box-pdf");
					box_pdf.html(data); 
			});

		});//fim do $(document)

//   		$(".lista li a").click(function(){
// 			//$('#box-file').jstree(true).select_node('child_node_1');
//   			alert( $(this).attr("id") ); 
//  	 	});
 	 		
	});
	
	window.onload = function (){
		
        //var myPDF = new PDFObject({ url: "http://10.1.1.90/bioclone/files_upload/contratos/2014/novembro/Manual_de_layout2.pdf" }).embed("box-pdf");
    };
    

//     function load_contrato(id){
// 		//window.alert(id);	
// 		//onClick="load_contrato(this.id)";
		
//     	var xmlhttp;
//     	if (window.XMLHttpRequest){
//     	  	xmlhttp = new XMLHttpRequest();
//     	}
//     	else{
//     	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
//     	}
    	
//     	xmlhttp.onreadystatechange=function(){
//     	  if (xmlhttp.readyState==4 && xmlhttp.status==200){
//     		 x = xmlhttp.responseText;
//     		 document.getElementById("box-pdf").innerHTML = x;
//     		 //x = "http://10.1.1.90/bioclone/files_upload/contratos/2014/outubro/teste2.pdf";
//     		 //myPDF = new PDFObject({ url: xmlhttp.responseText }).embed("box-pdf");
//     	    }
//     	  }
  	  
//     	dados = "id="+id+"&ano="+ano;
//     	xmlhttp.open("POST", url_carregar_contrato, true);
//     	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//     	xmlhttp.send(dados);

//     }
   
</script>
		
<h4 class="text-center">Contratos</h4>

<div class="panel panel-default">

	<div class="panel-heading">
		<div class="panel-title"> 
			<strong> 
				Listagem de contratos 
			</strong> 
		</div>	
	</div>

	<div class="panel-body">
	
		<div class="container-fluid">
			 <div class="row box-contrato">
			   
			  <div class="col-md-12" style="/*height:30px;border:1px solid red;*/">
			  
			  	<div class="pesquisar">    
				  <form role="form" name="exibir_cont" method="post" action="<?php echo base_url('contrato/exibir_contrato');?>">
					  <div class="form-inline">
						 <div class="form-group">
						    <label> Ano </label>
						  </div>
						  
						  <div class="form-group">
						    <input type="text" name="ano" class="form-control" size="10" value="<?php echo set_value('ano')?>">
						  </div>
						  										  					  
						  <input type="submit" class="btn btn-default" value="pesquisar">
					   </div>
					   
					   <div class="msg-erro-contrato">
							<?php echo form_error('ano'); ?>
						</div>
				  </form>	   
				</div>
				
			  </div>
			  
			  <div class="col-md-3 box-file">
			   	<div id="box-file">
				  <ul >
					<li class="jstree-open" id="node_1" data-jstree='{"icon":"glyphicon glyphicon-folder-close"}'> <?php echo "Contratos ".$ano; ?>
						<ul> 
							<?php for ($i=1 ; $i<=$num_mes ; $i++) { ?>
								<li data-jstree='{"icon":"glyphicon glyphicon-folder-close"}'> <?php echo $nome_mes[$i]?>
									<ul class="lista">
										<?php $a = 1; ?>
										<?php foreach ($dir_nome_mes[$i] as $arquivo) { ?>
											<li class="item" id="<?php echo $i.'-'.$arquivo ?>" data-jstree='{"icon":"glyphicon glyphicon-list-alt"}' > <?php echo  str_replace('_', ' ', $arquivo) ?> </li>              
										<?php $a++; } ?>
									</ul>
								</li>
							<?php } ?>
						</ul>
					</li>
				  </ul>
				</div>
			  </div>
			  				     
  			  <div id="box-pdf" class="col-md-9 box-conteudo"> 
  			  	<!-- visualiza pdf aqui -->
  			  </div>
  				
			</div>
		</div>
	      		
	</div> <!-- fim do panel body -->
		 
	<div class="panel-footer">
		
	</div>
			
				
</div> <!-- fim do panel -->

