function alt_cliente(id){
	var f = document.getElementById('form'+id);
	f.action=url_alterar_cliente;
}

function exc_cliente(id){
	var resposta = window.confirm("Deseja excluir o cliente");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_cliente;
	}
}

$(document).ready(function(){
	
	$("#selec_pesq").change(function(){ 
	    var opcao = $("#selec_pesq option:selected").val(); 
	    var mask = "";
	    if(opcao == 'nome'){
		    $('#pesquisa').val('');
		    $('#pesquisa').unmask();
	    }else if(opcao == 'cpf'){
		    $('#pesquisa').val('');
		    mask = "999.999.999-99";
	    $("#pesquisa").mask(mask);
	    }else{
		    $('#pesquisa').val('');
		    $('#pesquisa').unmask();
	    }
	   
	  });
	
	
//	$('#list_cli').on('click', 'tr', function () {
//	    $(this).siblings().removeClass('marcada');
//	    $(this).toggleClass('marcada');
//	});
	
	$("tr").on('click', function () {
	    if($(this).hasClass("marcada")) {
	        $(this).removeClass("marcada");
	    } else {
	        $(this).addClass("marcada");
	    }
	});
	
  
}); 