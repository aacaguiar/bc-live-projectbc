function carrega_ajax()
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else{
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

$(document).ready(function(){
	 $("#cpf").mask("999.999.999-99");
	 $("#cnpj").mask("99.999.999/9999-99");
	 $("#cep").mask("99.999-999");
	 $("#fone_residencial").mask("(99)9999-9999");
	 
	 $('#fone_celular').focusout(function(){
		 var phone, element;
		 element = $(this);
		 element.unmask();
		 phone = element.val().replace(/\D/g, '');
		 if(phone.length > 10) {
		 element.mask("(99)99999-999?9");
		 } else {
		 element.mask("(99)9999-9999?9");
		 }
	}).trigger('focusout'); 
	 
	 
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
	
	$(window).load(function() {
		$opcao = $("#tipo_fornecedor").val();
		carrega_masc($opcao);
	});
	
	$("#tipo_fornecedor").change(function(){
		$opcao = $("#tipo_fornecedor").val();
		carrega_masc($opcao);
	}); 
	
	function carrega_masc($opcao)
	{
		if($opcao == 'fisica'){
			$("#cpf_cnpj").mask("999.999.999-99");
		}else if ($opcao == 'juridica') {
			$("#cpf_cnpj").mask("99.999.999/9999-99");
		}else{
			$("#cpf_cnpj").val("");
		}
	}
	 	 
});

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

function carregar_cidade()
{
	var estado = document.getElementById("estado").value;	
	if(estado !='0' && estado !=''){
		var cidade = document.getElementById("cidade").value;
		
		xmlhttp = carrega_ajax();
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  		document.getElementById("cidade").innerHTML=xmlhttp.responseText;
		  		}
		}

		dados="estado="+estado+"&cidade="+cidade;
		xmlhttp.open("POST",url_carregar_cidade,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(dados);
	}	
}

/*
function selecao_clifor(opcao)
{
	//var tipo_cliente = document.getElementById('tipo_cliente').value;
	//window.alert('teste'); 
	
	switch(opcao)
	{
		case 'fisica':
			//window.alert('teste');
			document.getElementById("nome").disabled = false;
			document.getElementById("erro-nome").style.display = "";
			document.getElementById("cpf").disabled = false;
			document.getElementById("erro-cpf").style.display = "";
				
			document.getElementById("razao_social").value = '';
			document.getElementById("razao_social").disabled = true;
			document.getElementById("erro-rsocial").style.display = "none";
				
			//document.getElementById("contato").value = '';
			//document.getElementById("contato").disabled = true;
			//document.getElementById("erro-contato").style.display = "none";
			document.getElementById("cnpj").value = '';
			document.getElementById("cnpj").disabled = true;
			document.getElementById("erro-cnpj").style.display = "none";
						
			break;
			
		case 'juridica':
			document.getElementById("nome").value = '';
			document.getElementById("nome").disabled = true;
			document.getElementById("erro-nome").style.display = "none";
			document.getElementById("cpf").value = '';
			document.getElementById("cpf").disabled = true;
			document.getElementById("erro-cpf").style.display = "none";
			
			document.getElementById("razao_social").disabled = false;
			document.getElementById("erro-rsocial").style.display = "";
			
			//document.getElementById("contato").disabled = false;
			//document.getElementById("erro-contato").style.display = "";
			document.getElementById("cnpj").disabled = false;
			document.getElementById("erro-cnpj").style.display = "";
			
			break;
			
		default:
			document.getElementById("nome").value = '';
			document.getElementById("nome").disabled = true;
			document.getElementById("erro-nome").style.display = "none";
			document.getElementById("cpf").value = '';
			document.getElementById("cpf").disabled = true;
			document.getElementById("erro-cpf").style.display = "none";
		
			document.getElementById("razao_social").value = '';
			document.getElementById("razao_social").disabled = true;
			document.getElementById("erro-rsocial").style.display = "none";
			//document.getElementById("contato").value = '';
			//document.getElementById("contato").disabled = true;
			//document.getElementById("erro-contato").style.display = "none";
			document.getElementById("cnpj").value = '';
			document.getElementById("cnpj").disabled = true;
			document.getElementById("erro-cnpj").style.display = "none";
			
			break;
	}
}
*/

/*
function carregar_cidade()
{
	var estado = document.getElementById("estado").value;
	if(estado !='0' && estado !=''){
		var cidade = document.getElementById("cidade").value;
		
		xmlhttp = carrega_ajax();
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		  		document.getElementById("cidade").innerHTML=xmlhttp.responseText;
		  		}
		}
		dados="estado="+estado+"&cidade="+cidade;
		xmlhttp.open("POST",url_carregar_cidade,true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send(dados);
	}	
}
*/