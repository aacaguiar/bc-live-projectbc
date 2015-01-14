$(document).ready(function(){
	$(window).load(function() {
			calc_valor_total();
		});
	
	$("#cep").mask("99.999-999");
	
	$( "#data_pedido" ).datepicker({
		showWeek: true,
		firstDay: 1
	});
	
	for(var i=1; i<=30; ++i){
		//$('#data_entrega'+i).datepicker();
		$('#data_entrega'+i).datepicker({
			changeMonth: true,
			changeYear: true
		});
	}
	
	$("#qtde_pedido").keyup(function(){
		calc_valor_total();
	});
	
	$("#vl_muda").keyup(function(){
		calc_valor_total();
	});
	
	function calc_valor_total(){
		$qtde_ped = $("#qtde_pedido").val();
		$vl_muda = $("#vl_muda").val();
		$("#vl_total").val($vl_muda * $qtde_ped);
	}
	
	
});

function valida_form()
{
	for(var i=1; i<=30; ++i){
		var valor = document.getElementById('data_entrega'+i).value;
		if(valor==''){
			document.getElementById("box_datas").innerHTML=xmlhttp3.responseText;
		}
	}
}

function carrega_ajax()
{
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}else{
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

/*
function carregar_datas()
{	

	if (window.XMLHttpRequest) {
		xmlhttp3=new XMLHttpRequest();
	}else{
		xmlhttp3=new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	var qtde_entrega = document.getElementById("qtde_entrega").value;
	//alert(qtde_entrega);

	if(qtde_entrega !='0' && qtde_entrega !=''){
		
		//xmlhttp3 = carrega_ajax();
		xmlhttp3.onreadystatechange=function() {
			if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
		  		document.getElementById("box_datas").innerHTML=xmlhttp3.responseText;
		  		}
		}
		
		dados="qtde_entrega="+qtde_entrega;
		xmlhttp3.open("POST",url_carregar_data,true);
		xmlhttp3.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp3.send(dados);
	}	
}
*/


function carregar_datas2()
{
	var qtde_entrega = document.getElementById("qtde_entrega").value;
	if(qtde_entrega !='0'){			
		for(var i=1; i<=30; i++){
			document.getElementById('label_entrega'+i).style.display="none";
			document.getElementById('data_entrega'+i).style.display="none";
			document.getElementById('label_qtde_ent'+i).style.display="none";
			document.getElementById('qtde_ent_parcial'+i).style.display="none";
		}
		for(var i=1; i<=qtde_entrega; i++){	
			document.getElementById('label_entrega'+i).style.display="inline";
			//document.getElementById('data_entrega'+i).value=" ";
			document.getElementById('data_entrega'+i).style.display="inline";
			document.getElementById('label_qtde_ent'+i).style.display="inline";
			document.getElementById('qtde_ent_parcial'+i).style.display="inline";
		}
		//document.getElementById('titulo-entrega').style.marginTop = "20px";
	}else{
		for(var i=1; i<=30; i++){
			document.getElementById('label_entrega'+i).style.display="none";
			document.getElementById('data_entrega'+i).value=" ";
			document.getElementById('data_entrega'+i).style.display="none";
			document.getElementById('label_qtde_ent'+i).style.display="none";
			document.getElementById('qtde_ent_parcial'+i).value=" ";
			document.getElementById('qtde_ent_parcial'+i).style.display="none";
		}
	}
}

function carregar_variedade()
{
	
	var cultura = document.getElementById("cultura").value;	
	if(cultura !='0' && cultura !=''){
		var variedade = document.getElementById("variedade").value;
		//var caractere=cultura.indexOf("-");
		//cultura = cultura.substr(0,caractere);
	
		xmlhttp1 = carrega_ajax();
		xmlhttp1.onreadystatechange=function() {
			if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
		  		document.getElementById("variedade").innerHTML=xmlhttp1.responseText;
		  		}
		}
		dados="cultura="+cultura+"&variedade="+variedade;
		xmlhttp1.open("POST",url_carregar_variedade,true);
		xmlhttp1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp1.send(dados);
	}
	
}

function carregar_cidade()
{
	var estado = document.getElementById("estado").value;	
	if(estado !='0' && estado !=''){
		var cidade = document.getElementById("cidade").value;
		
		xmlhttp2 = carrega_ajax();
		xmlhttp2.onreadystatechange=function() {
			if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
		  		document.getElementById("cidade").innerHTML=xmlhttp2.responseText;
		  		}
		}

		dados="estado="+estado+"&cidade="+cidade;
		xmlhttp2.open("POST",url_carregar_cidade,true);
		xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp2.send(dados);
	}	
	
}

function listar_cliente()
{
	if(document.getElementById('pes_fisica').checked){
		opcao = 'fisica';
	}
	if(document.getElementById('pes_juridica').checked){
		opcao = 'juridica';
	}
	var cod_cliente = document.getElementById('cod_cliente').value;
	//var opcao = nome_form[tipo_cliente].value;
	
	xmlhttp3 = carrega_ajax();
	xmlhttp3.onreadystatechange=function() {
		if (xmlhttp3.readyState==4 && xmlhttp3.status==200) {
	  		document.getElementById("cod_cliente").innerHTML=xmlhttp3.responseText;
	  		}
	}
	
	dados="tipo_cliente="+opcao+"&cod_cliente="+cod_cliente;
	xmlhttp3.open("POST",url_carregar_cliente,true);
	xmlhttp3.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp3.send(dados);
	
}


function selecionar_endereco(){
	if(end_selecionado=='end_atual'){	
		document.getElementById('check_end_atual').checked=true;
		document.getElementById('check_novo_end').checked=false;
		var cod_id = document.getElementById('cod_cliente').value;
		if(cod_id!='0' && cod_id!=''){
			endereco_atual();
		}	
	}else if(end_selecionado=='end_novo'){	
		document.getElementById('check_end_atual').checked=false;
		document.getElementById('check_novo_end').checked=true;
		var cod_id = document.getElementById('cod_cliente').value;
		if(cod_id!='0' && cod_id!=''){
			novo_endereco();
		}
	}else{
		document.getElementById('check_end_atual').checked=false;
		document.getElementById('check_novo_end').checked=false;
	}
}
	

/*
function carregar_endereco()
{	
	var cod_id = document.getElementById('cod_cliente').value;
	if(cod_id!='0' && cod_id!=''){
		var end_atual = document.getElementById('check_end_atual');	
		if(end_atual.checked){
			endereco_atual();
		}else{
			novo_endereco();
		}
	}
}
*/

function endereco_atual()
{
	var end_atual = document.getElementById('check_end_atual');
	if(end_atual.checked)
	{
		document.getElementById('box-endereco').style.display="none";
		document.getElementById('check_novo_end').checked=false;
		desabilita_novo_end();
		
		var cod_id = document.getElementById('cod_cliente').value;
		var opcao_cliente='';
		
		if(cod_id!='0' && cod_id!='')
		{
			if (document.cadastro_pedido.tipo_cliente[0].checked){
				opcao_cliente = 'fisica';
			}
			
			if (document.cadastro_pedido.tipo_cliente[1].checked){
				opcao_cliente = 'juridica';
			}
			
			xmlhttp4 = carrega_ajax();
			xmlhttp4.onreadystatechange=function() {
				if (xmlhttp4.readyState==4 && xmlhttp4.status==200) {
			  		document.getElementById("endereco_atual").innerHTML=xmlhttp4.responseText;
			  		}
			}
			
			dados="cod_id="+cod_id+"&opcao_cliente="+opcao_cliente;
			xmlhttp4.open("POST",url_carregar_endereco,true);
			xmlhttp4.setRequestHeader("Content-type","application/x-www-form-urlencoded");	
			xmlhttp4.send(dados);
		}else{
			window.alert("cliente não selecionado");
			end_atual.checked=false;
		}
	}		
}

function novo_endereco()
{
	var novo_end = document.getElementById('check_novo_end');
	if(novo_end.checked){
		//window.alert("checado");
		var cod_id = document.getElementById('cod_cliente').value;
		if(cod_id!='0' && cod_id!='')
		{
			document.getElementById('box-endereco').style.display="";
			document.getElementById('check_end_atual').checked=false;
			habilita_novo_end();
						
			xmlhttp5 = carrega_ajax();
			xmlhttp5.onreadystatechange=function() {
				if (xmlhttp5.readyState==4 && xmlhttp5.status==200) {
			  		document.getElementById("endereco_atual").innerHTML=xmlhttp5.responseText;
			  		}
			}
			xmlhttp5.open("POST",url_apagar_endereco,true);
			xmlhttp5.setRequestHeader("Content-type","application/x-www-form-urlencoded");	
			xmlhttp5.send();
		}else{
			window.alert("cliente não selecionado");
			novo_end.checked=false;
		}
	}		
}


function habilita_novo_end()
{
	//document.getElementById("endereco").disabled = false;
	document.getElementById("erro-end").style.display = "";
	//document.getElementById("bairro").disabled = false;
	document.getElementById("erro-bairro").style.display = "";
	//document.getElementById("estado").disabled = false;
	document.getElementById("erro-estado").style.display = "";
	//document.getElementById("cidade").disabled = false;
	document.getElementById("erro-cidade").style.display = "";
	//document.getElementById("cep").disabled = false;
	document.getElementById("erro-cep").style.display = "";
}

function desabilita_novo_end()
{
	document.getElementById("endereco").value = '';
	//document.getElementById("endereco").disabled = true;
	document.getElementById("erro-end").style.display = "none";
	document.getElementById("bairro").value = '';
	//document.getElementById("bairro").disabled = true;
	document.getElementById("erro-bairro").style.display = "none";
	document.getElementById("estado").value = '0';
	//document.getElementById("estado").disabled = true;
	document.getElementById("erro-estado").style.display = "none";
	document.getElementById("cidade").value = '0';
	//document.getElementById("cidade").disabled = true;
	document.getElementById("erro-cidade").style.display = "none";
	document.getElementById("cep").value = '';
	//document.getElementById("cep").disabled = true;
	document.getElementById("erro-cep").style.display = "none";
	
}

function validar_qtde_parcial(valor)
{
	
}




