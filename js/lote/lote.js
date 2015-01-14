$(document).ready(function(){
	//$("#data_recebimento").datepicker();	
	$( "#data_recebimento" ).datepicker({
		showWeek: true,
		firstDay: 1
	});
});

function carrega_ajax()
{
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

function carregar_variedade()
{
	var cod_cultura = document.getElementById("cultura").value;	
	if(cod_cultura !='0' && cod_cultura !=''){
		var sigla_nomeVar = document.getElementById("variedade").value;
		
		xmlhttp1 = carrega_ajax();
		xmlhttp1.onreadystatechange = function(){
			if (xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
		  		document.getElementById("variedade").innerHTML = xmlhttp1.responseText;
		  		}
		}

		//window.alert(cod_cultura);
		dados="cod_cultura="+cod_cultura+"&sigla_nomeVar="+sigla_nomeVar;
		xmlhttp1.open("POST",url_carregar_variedade,true);
		xmlhttp1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp1.send(dados);
	}	
}


function gerar_lote()
{
	var fornec = document.getElementById('fornecedor').value;
	var variedade = document.getElementById('variedade').value;
	//window.alert(variedade);
	
	if( fornec !='0' && variedade !='0'){
	
		var hoje = new Date(); //recupera a data completa
		dia_atual = hoje.getDate(); //recupera o nº dia
		mes_atual = (hoje.getMonth()+1); //recupera o mês como array. Ex: [0]=>jan
		ano = hoje.getFullYear().toString(); //recupera o ano como int e converte para String	
		ano = ano.substr(2,3); //separa os dois dígitos finais do ano
		
		//separa o value do option:cód.Fornecedor-NomeFornecedor
		var caractere=fornec.indexOf("-");
		fornec = fornec.substr(0,caractere);
		
		//formata o cód.Fornecedor de 01 a 09
		if(fornec<10){
			fornec='0'+(fornec.toString());
		}else{
			fornec=fornec.toString();
		}
		
		//separa o value do option:sigla.variedade-nomeVariedade
		caractere = variedade.indexOf("-");
		variedade = variedade.substr(0,caractere).toString();
		
		//Calcula a semana
		 	var d = new Date();
		    d.setHours(0,0,0);
		    d.setDate(d.getDate()+4-(d.getDay()||7));
		    var semana =  Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
		
		document.getElementById('lote').value = variedade+semana+ano+fornec;
	}
}

function on_off_pedido(){
	var num_pedido = document.getElementById("num_pedido");	
	var radio1 = document.getElementById("radio1");
	var radio2 = document.getElementById("radio2");
	if(radio1.checked == true){
		num_pedido.disabled = false;
		radio2.checked = false;
	}else{
		num_pedido.disabled = true;
		radio2.checked = true;
	}
}

/*
function exibir_mapa_var()
{
	xmlhttp = carrega_ajax();
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	  		window.open(url_imagem_catalogo, 'new', 'width=860,height=540');
	  		}
	}
	xmlhttp.open("POST",url_cadastrar_lote,true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(null);
}
*/






