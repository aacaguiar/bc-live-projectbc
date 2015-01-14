//view cadastrar cultura
function exibir_culturas()
{	
	if(document.getElementById("lista_var").checked){			
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		
	xmlhttp.onreadystatechange=function() {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  	document.getElementById("box_cultura").innerHTML=xmlhttp.responseText;
		  	}
	}
		
	//dados="qtde_entrega="+qtde_entrega;
	xmlhttp.open("POST",url_listar_culturas,true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(null);	
	}
}

function enviar()
{
	var f = document.getElementById('form_cult');
	f.submit();
}

//view cadastrar variedade
function listar_campos_var()
{
	var qtde_var = document.getElementById("qtde_var").value;
	if(qtde_var!=0){			
		for(var i=1; i<=10; i++){
			document.getElementById('linha-campo'+i).style.display="none";
			document.getElementById('linha-erro'+i).style.display="none";
		}
		for(var i=1; i<=qtde_var; i++){	
			document.getElementById('linha-campo'+i).style.display='';
			document.getElementById('linha-erro'+i).style.display='';
		}
	}else{
		for(var i=1; i<=10; i++){
			document.getElementById('linha-campo'+i).style.display="none";
			document.getElementById('linha-erro'+i).style.display="none";
		}
	}
}

//view consultar variedades
function carregar_variedade()
{
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	var cultura = document.getElementById("cultura").value;	
	if(cultura !=0 && cultura !='')
	{
		xmlhttp.onreadystatechange=function() 
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  		document.getElementById("conteudo").innerHTML=xmlhttp.responseText;
		  		}
		}
		dados="cultura="+cultura;
		xmlhttp.open("POST",url_carregar_variedade,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(dados);	
	}
}


//view consultar variedades
function alt_variedade(id){
	var f = document.getElementById('form'+id);
	//pega id do form
	var nome_cultura = document.getElementById('nome_cultura'+id);
	//pega texto do select cultura
	var c = document.getElementById('cultura');

	nome_cultura.value = c.options[c.selectedIndex].text;
	
	f.action=url_alterar_variedade;
}

function exc_variedade(id){
	var resposta = window.confirm("Deseja excluir esta Variedade");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_variedade;
	}
}


//View Consultar Culturas
function alt_cultura(id){
	var f = document.getElementById('form'+id);	
	f.action=url_alterar_cultura;
}

//view consultar variedades
function exc_cultura(id){
	var resposta = window.confirm("Deseja excluir esta Cultura");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action=url_excluir_cultura;
	}
}


/*
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
*/



