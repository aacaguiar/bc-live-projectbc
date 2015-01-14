$(document).ready(function(){
	
	$("#data_anterior").datepicker({ showWeek: true, firstDay: 1 });
	$("#data_atual").datepicker({ showWeek: true, firstDay: 1 });
	
	$('#tab_et_prod :input').attr('readonly', true);
	
	//verifica ao carregar a página ou quando é dado refresh
	if( $('#pd_fungo').val()==''){ $('#pd_fungo').val(0); } ;
	if( $('#pd_bact').val()=='') { $('#pd_bact').val(0); } ;
	if( $('#pd_oxid').val()=='') { $('#pd_oxid').val(0); } ;
	if( $('#pd_total').val()=='') { $('#pd_total').val(0); } ;
	
	if( $('#num_expl_prod').val()=='' )		  { $('#num_expl_prod').val(0); } ;
	if( $('#num_fr_trab').val()=='' )		  { $('#num_fr_trab').val(0); } ;
	if( $('#num_expl_fr_trab').val()=='' )	  { $('#num_expl_fr_trab').val(0); } ;
	if( $('#num_total_expl_trab').val()=='' ) { $('#num_total_expl_trab').val(0); } ;
	
	if( $('#num_pote_prod').val()=='' )	{ $('#num_pote_prod').val(0); } ;
	if( $('#num_expl_pote').val()=='' )	{ $('#num_expl_pote').val(0); } ;
	if( $('#subtotal1').val()=='' )		{ $('#subtotal1').val(0); } ;
	
	if( $('#num_fr_prod').val()=='' )	{ $('#num_fr_prod').val(0); } ;
	if( $('#num_expl_fr').val()=='' )	{ $('#num_expl_fr').val(0); } ;
	if( $('#subtotal2').val()=='' )		{ $('#subtotal2').val(0); } ;
	
	if( $('#num_queb').val()=='') { $('#num_queb').val(0); } ;
	if( $('#total_expl_prod').val()=='') { $('#total_expl_prod').val(0); } ;
	
	
	//verifica se esses campos foram alterados e calcula o nº de perda total
	$('#pd_fungo').keyup( function(){ calcula_perda_total(); });
	$('#pd_bact').keyup( function(){ calcula_perda_total(); });
	$('#pd_oxid').keyup( function(){ calcula_perda_total(); });
	
	//verifica se esses campos foram alterados e calcula o nº total de explantes trabalhados
	$('#num_fr_trab').keyup( function(){ calcula_num_total_expl_trab(); });
	$('#num_expl_fr_trab').keyup( function(){ calcula_num_total_expl_trab(); });
	
	//verifica se esses campos foram alterados e calcula o subtotal1
	$('#num_pote_prod').keyup( function(){ calcula_subtotal1(); });
	$('#num_expl_pote').keyup( function(){ calcula_subtotal1(); });
	
	//verifica se esses campos foram alterados e calcula o subtotal2
	$('#num_fr_prod').keyup( function(){ calcula_subtotal2(); });
	$('#num_expl_fr').keyup( function(){ calcula_subtotal2(); });
	
	$('#num_queb').keyup( function(){ calcula_total_expl_prod(); });
	
	
	function calcula_perda_total()
	{	
		//perdas
		$pd_fungo = $('#pd_fungo').val();
		if( $pd_fungo == '') $pd_fungo = 0;
		
		$pd_bact = $('#pd_bact').val();
		if( $pd_bact == '') $pd_bact = 0;
		
		$pd_oxid = $('#pd_oxid').val();
		if( $pd_oxid == '') $pd_oxid = 0;
		
		//calcula o nº total expl trab.
		$num_fr_trab = $('#num_fr_trab').val();
		if( $num_fr_trab == '') $num_fr_trab = 0;
		
		$num_expl_fr_trab = $('#num_expl_fr_trab').val();
		if( $num_expl_fr_trab == '') $num_expl_fr_trab = 0;
		
		//valor total
		$('#pd_total').val( parseInt($pd_fungo) + parseInt($pd_bact) + parseInt($pd_oxid) );
		
		//num total expl trab
		$('#num_total_expl_trab').val( (parseInt($num_fr_trab) * parseInt($num_expl_fr_trab) ) - parseInt($('#pd_total').val()) );
		
		//num expl prod
		$('#num_expl_prod').val( parseInt($('#pd_total').val()) + parseInt($('#num_total_expl_trab').val()) );
		
	}
	
	function calcula_num_total_expl_trab()
	{
		$num_fr_trab = $('#num_fr_trab').val();
		if( $num_fr_trab == '') $num_fr_trab = 0;
		
		$num_expl_fr_trab = $('#num_expl_fr_trab').val();
		if( $num_expl_fr_trab == '') $num_expl_fr_trab = 0;
		
		$('#num_total_expl_trab').val( ( parseInt($num_fr_trab) * parseInt($num_expl_fr_trab) ) - parseInt($('#pd_total').val()) );
		
		//excutado sempre que houver alteração na perda total ou nº total expl trab.
		$('#num_expl_prod').val( parseInt($('#pd_total').val()) + parseInt($('#num_total_expl_trab').val()) );
	}
	
	function calcula_subtotal1()
	{
		$num_pote_prod = $('#num_pote_prod').val();
		if( $num_pote_prod == '') $num_pote_prod = 0;
		
		$num_expl_pote = $('#num_expl_pote').val();
		if( $num_expl_pote == '') $num_expl_pote = 0;
		
		$('#subtotal1').val( parseInt($num_pote_prod) * parseInt($num_expl_pote) );	
		
		calcula_total_expl_prod();
	}
	
	function calcula_subtotal2()
	{
		$num_fr_prod = $('#num_fr_prod').val();
		if( $num_fr_prod == '') $num_fr_prod = 0;
		
		$num_expl_fr = $('#num_expl_fr').val();
		if( $num_expl_fr == '') $num_expl_fr = 0;
		
		$('#subtotal2').val( parseInt($num_fr_prod) * parseInt($num_expl_fr) );
		
		calcula_total_expl_prod();
	}
	
	function calcula_total_expl_prod()
	{	
		$num_queb = $('#num_queb').val();
		if( $num_queb == '') $num_queb = 0;
		
		$('#total_expl_prod').val( parseInt($('#subtotal1').val()) + parseInt($('#subtotal2').val()) + parseInt($('#num_queb').val()) );	
	}
	
	
	 $(".tab-et-lote>tbody>tr").click(function(){
	        $(".tab-et-lote>tbody>tr").removeClass("linhaSelecionada");
	        $(this).addClass("linhaSelecionada");
	 });
	 
	 
	 $("#id_fase").change(function(){
		 i = $("#id_fase").val();
		//alert(cod_fase_fator[i]['cod_fase']);
		$("#cod_fase").val( cod_fase_fator[i]['cod_fase'] );
		$("#fator_conversao").val( cod_fase_fator[i]['fator_conversao'] );
		
		$("#pontos_repic").val( ($("#fator_conversao").val() * $('#total_expl_prod').val()).toFixed(2) );
	 });
 
 
	 $("#fator_conversao").keyup(function(){
		 $("#pontos_repic").val( ($("#fator_conversao").val() * $('#total_expl_prod').val()).toFixed(2) );
	 });
	 
	 				
});


function enviar()
{
	var f = document.getElementById('form_filtragem');
	f.submit();
}

function enviar2()
{
	var f = document.getElementById('form_cult');
	f.submit();
}

function carrega_ajax()
{
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}


/*
 * chamado pelo select da cultura
 * e carregado automaticamente ao carregar a página
 */
function carregar_variedade()
{
	var cod_cultura = document.getElementById("cultura").value;	
	if(cod_cultura !='0' && cod_cultura !=''){
		var cod_variedade = document.getElementById("variedade").value;
	
		//window.alert(cod_cultura);
		xmlhttp1 = carrega_ajax();
		xmlhttp1.onreadystatechange = function() {
			if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
		  		document.getElementById("variedade").innerHTML=xmlhttp1.responseText;
		  		}
		}

		//window.alert(cultura);
		dados="cod_cultura="+cod_cultura+"&cod_variedade="+cod_variedade;
		xmlhttp1.open("POST", url_carregar_var, true);
		xmlhttp1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp1.send(dados);	
	}	
}

/*
 * chamado pelo select da variedade
 * e carregado automaticamente ao carregar a página
 */
function carregar_lotes()
{
	xmlhttp2 = carrega_ajax();
	var cod_cultura = document.getElementById("cultura").value;	
	if(cod_cultura !='0' && cod_cultura !='') {
		var cod_variedade = document.getElementById('variedade').value;
		 
		xmlhttp2.onreadystatechange=function() {
			if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
		  		document.getElementById("lote").innerHTML=xmlhttp2.responseText;
		  		}
		}

		//window.alert(cod_variedade);
		//code_lote_selec é variável global declarada na view
		dados="cod_cultura="+cod_cultura+"&cod_variedade="+cod_variedade+"&cod_lote="+cod_lote_selec;
		xmlhttp2.open("POST",url_carregar_lotes,true);
		xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp2.send(dados);	
	}	
}


function alt_controle_prod(id){
	//window.alert(url_alt_controle_prod);
	var f = document.getElementById('form'+id);
	f.action = url_alt_controle_prod;
}


function exc_controle_prod(id){
	var resposta = window.confirm("Deseja excluir estes dados sobre o lote");
	if(resposta){
		var f = document.getElementById('form'+id);
		f.action = url_excl_controle_prod;
	}
	
}




