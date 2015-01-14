function alt_fornec(id){
	var f = document.getElementById('form'+id);
	f.action=url_alterar_fornec;
}
function exc_fornec(id){
	var resposta = window.confirm("Deseja excluir o fornecedor");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_fornec;
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
  
});


