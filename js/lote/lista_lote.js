$(document).ready(function()
{
	$("#filt_ano").change(function(){
		$("#form_filtragem").submit();
		
		 $.post(url_carregar_lotes_ano,
				  {
				    filt_ano:$("#filt_ano").val()
				  },
				  function(data){
				    //alert("Data: " + data + "\nStatus: " + status);
					  var filt_lote = $("#filt_lote");
					  filt_lote.html(data);
				  });
		//window.alert("testey");
	});
	
	function carregar_lotes_ano()
	{
		
	}
	
//	$("#selec_pesq").change(function(){ 
//	    var opcao = $("#selec_pesq option:selected").val(); 
//	    //var mask = "";
//	    if(opcao == 'cliente'){
//		    $('#pesquisa').val('');
//		    //$('#pesquisa').unmask();
//	    }else if(opcao == 'lote'){
//		    $('#pesquisa').val('');
//		    //mask = "999.999.999-99";
//	    $("#pesquisa").mask(mask);
//	    }else{
//		    //$('#pesquisa').val('');
//		    //$('#pesquisa').unmask();
//	    }
//	   
//	  }); 
	
	
	
}); 


function alt_lote(id) 
{
	var f = document.getElementById('form'+id);
	f.action = url_alterar_lote;
}

function exc_lote(id) 
{
	var resposta = window.confirm("Deseja excluir este pedido");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action = url_excluir_lote;
	}
}

function gerenciar_lote(id) 
{
	var f = document.getElementById('form'+id);
	f.action = url_redirecionar_ger_lote;
}


