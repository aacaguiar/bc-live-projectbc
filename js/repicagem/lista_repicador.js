//alterar repicador
function alt_repicador(id){
	var f = document.getElementById('form'+id);	
	f.action = url_alterar_repicador;
}

//excluir repicador
function exc_repicador(id,nome){
	var resposta = window.confirm("Deseja excluir este repicador"+nome);
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action = url_excluir_repicador;
	}
}