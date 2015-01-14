function alt_pedido(id){
	//window.alert(url_alterar_pedido);
	var f = document.getElementById('form'+id);
	f.action = url_alterar_pedido;
}

function exc_pedido(id){
	var resposta = window.confirm("Deseja excluir este pedido");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_pedido;
	}
}

$(document).ready(function(){
	
	$("#selec_pesq").change(function(){ 
	    var opcao = $("#selec_pesq option:selected").val(); 
	    //var mask = "";
	    if(opcao == 'cliente'){
		    $('#pesquisa').val('');
		    //$('#pesquisa').unmask();
	    }else if(opcao == 'pedido'){
		    $('#pesquisa').val('');
		    //mask = "999.999.999-99";
	    $("#pesquisa").mask(mask);
	    }else{
		    //$('#pesquisa').val('');
		    //$('#pesquisa').unmask();
	    }
	   
	  });  
}); 

