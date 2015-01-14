$(document).ready(function(){
		
	var i=1;
	while(i <= num_total){
		$("#data_entrada"+i).datepicker({ showWeek: true, firstDay: 1 });
		$("#data_saida"+i).datepicker({ showWeek: true, firstDay: 1 });
		$("#linha"+i).find("input,select").attr("disabled", true);		
		i++;	
	}
	
		$("#box_fator_mult").click(function(){
		    $("#panel").slideToggle("slow");
		  });
				
		
		/*
		 * Calcula nº planejado
		 */
		function calculado_num_planejado($valor_total, $num)
		{
			$valor_total = $valor_total.toString();// converte em string
			$corte = $valor_total.split("."); // separa a string em dois ex: 12.45, corte[0]=12, corte[1]=45 
			
			if(typeof $corte[1] == 'undefined'){
				$valor_total = parseFloat($corte[0]);
		    	$("#num_plan"+$num).val( $valor_total );
				//window.alert($valor_total);
			}else{
				$num_decimal = $corte[1].substring(0,1);
				if($num_decimal == 0){
					$valor_total = parseFloat($corte[0]);
					$("#num_plan"+$num).val( $valor_total );
					//window.alert($valor_total);
				}else{
					$valor_total = $corte[0]+'.'+$num_decimal;
					$("#num_plan"+$num).val($valor_total);
					//window.alert($valor_total);
				}	
			}		
		}
		
		
		/*
		 * Calcula Nº planejado ao mudar de fase
		 */
		$("select[name=fase]").change(function(){
			var $fase = $(this).attr("id");
			var $indice = ($fase.length)-1; /* indice correspondente ao número que compõe o nome(id) */
			var $num = $fase.substring($indice); /* recupera o número correspondente ao final do nome(id) */
			$valor_select = $("#"+$fase).val(); /* recupera o valor do campo */
	
			if($valor_select != '')
			{
				var $valor_input = $("#num_expl_trab"+$num).val();
				if($valor_input != ''){
					$valor_total = $valor_input * fator_multiplicacao[$valor_select];
					calculado_num_planejado($valor_total,$num);
				}
			}
			else
			{
				$("#num_plan"+$num).val('');
			}
		});
		
		
		/*
		 * Calcula o Nº da entrada com base na nº expl. produzido
		 */
		$("input[name=num_entrada]").click(function(){
			var $num_entrada = $(this).attr("id");
			var $indice = ($num_entrada.length)-1; /* indice correspondente ao número que compõe o nome(id) */
			var $num = $num_entrada.substring($indice); /* recupera o número correspondente ao final do nome(id) */
			
			if ($num != 1){
				$num_fase_anterior = $num - 1;
				$valor_input_prod = $("#num_expl_prod"+$num_fase_anterior).val(); //recuperar o expl_prod da fase anterior
				$("#"+$num_entrada).val($valor_input_prod);
				$("#num_expl_trab"+$num).val($valor_input_prod); //Atribui o valor do expl_prod da fase anterior ao expl_trab da fase posterior
				$valor_input_trab = $("#num_expl_trab"+$num).val();
				
				//Atualiza o nº planejado
				$value_fase = $("#fase"+$num).val();
				$valor_plan = $valor_input_trab * fator_multiplicacao[$value_fase];
				calculado_num_planejado($valor_plan,$num);
				
				//$("#num_plan"+$num).val($valor_plan);
				//calcular_num_plan($num);
			}
		});
	
		
		/*
		 * Calcula Nº planejado (num_expl_trab, nº plan)
		 */
		$("input[name=num_expl_trab]").keyup(function(){
			var $num_expl_trab = $(this).attr("id");
			var $indice = ($num_expl_trab.length)-1; /* indice correspondente ao número que compõe o nome(id) */
			var $num = $num_expl_trab.substring($indice); /* recupera o número correspondente ao final do nome(id) */
			$valor_input_trab = $("#"+$num_expl_trab).val(); /* recupera o valor do campo */
			$valor_input_prod = $("#num_expl_prod"+$num).val(); /* recupera o valor do campo */
	
			if($valor_input_trab != ''){	
				$value_fase = $("#fase"+$num).val();
				$valor_plan = $valor_input_trab * fator_multiplicacao[$value_fase];
				calculado_num_planejado($valor_plan,$num);
				
				if($valor_input_prod !=''){
					$taxa = ( $valor_input_prod / $valor_input_trab ); // divisão nº prod - nº trabalhado
					$taxa = $taxa.toFixed(2); //formatação da taxa de multiplicação	
					$diferenca = ( $valor_input_prod - $valor_plan );
					$("#taxa_mult"+$num).val($taxa);
					$("#diferenca"+$num).val($diferenca);
				}	
			}else{
				$("#num_plan"+$num).val('');
			}
		});
		
						
		/*
		 * Calcula tx mult (num_expl_prod, taxa mult)
		 */		
		$("input[name=num_expl_prod]").keyup( function(){
			var $num_expl_prod = $(this).attr("id");				
			var $indice = ($num_expl_prod.length)-1; // indice corresponde ao número que compõe o nome(id) 
			var $num = $num_expl_prod.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_prod = $("#"+$num_expl_prod).val(); // recupera o valor do campo produzido 
			
			if($valor_input_prod != ''){
				$valor_input_trab = $("#num_expl_trab"+$num).val();  // recupera o valor do campo trabalhado 
				$valor_input_plan = $("#num_plan"+$num).val();
				
				$taxa = ( $valor_input_prod / $valor_input_trab ); // divisão nº prod - nº trabalhado
				$taxa = $taxa.toFixed(2); //formatação da taxa de multiplicação	
				
				$diferenca = ( $valor_input_prod - $valor_input_plan);
				$("#taxa_mult"+$num).val($taxa);
				$("#diferenca"+$num).val($diferenca);
				
			}else{
				$("#taxa_mult"+$num).val('');
				$("#diferenca"+$num).val('');
			}
		});
		
		
		/*
		 * Calcular porcentagem Fungo
		 */		
		$("input[name=perda_fungo]").keyup( function(){
			var $perda_fungo = $(this).attr("id");				
			var $indice = ($perda_fungo.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $perda_fungo.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_fungo = $("#"+$perda_fungo).val(); // recupera o valor do campo perda_fungo 
			
			if($valor_input_fungo != ''){
				$pd_fungo_porcent = $("#pd_fungo_porcent"+$num);
				exibir_porcentagem( $valor_input_fungo, $num, $pd_fungo_porcent );
			}else{
				//$("#"+$perda_fungo).val('');
				$("#pd_fungo_porcent"+$num).val('');
			}
			
			calcular_perda_total($num);
		});
		
		
		/*
		 * Calcular porcentagem Bactéria
		 */		
		$("input[name=perda_bacteria]").keyup( function(){
			var $perda_bacteria = $(this).attr("id");				
			var $indice = ($perda_bacteria.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $perda_bacteria.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_bacteria = $("#"+$perda_bacteria).val(); // recupera o valor do campo perda_bacteria 
			
			if($valor_input_bacteria != ''){
				$pd_bacteria_porcent = $("#pd_bact_porcent"+$num);
				exibir_porcentagem($valor_input_bacteria, $num, $pd_bacteria_porcent );
			}else{
				//$("#"+$perda_bacteria).val('');
				$("#pd_bact_porcent"+$num).val('');
			}
			
			calcular_perda_total($num);
		});
		
		
		/*
		 * Calcular porcentagem Oxidação
		 */		
		$("input[name=perda_oxidacao]").keyup( function(){
			var $perda_oxidacao = $(this).attr("id");				
			var $indice = ($perda_oxidacao.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $perda_oxidacao.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_oxidacao = $("#"+$perda_oxidacao).val(); // recupera o valor do campo perda_oxidacao 
			
			if($valor_input_oxidacao != ''){
				$pd_oxid_porcent = $("#pd_oxid_porcent"+$num);
				exibir_porcentagem($valor_input_oxidacao, $num, $pd_oxid_porcent);
			}else{
				//$("#"+$perda_oxidacao).val('');
				$("#pd_oxid_porcent"+$num).val('');
			}
			
			calcular_perda_total($num);
		});
		

		/*
		 * Calcular perda total
		 */		
		function calcular_perda_total($num){
			
			//var perda_fungo = $("#perda_fungo"+$num).val();
			if( $("#perda_fungo"+$num).val() != '' ) { 
				perda_fungo = parseInt($("#perda_fungo"+$num).val()); 
				pd_fungo_porcent = $("#pd_fungo_porcent"+$num).val();
				
				total_carac = (pd_fungo_porcent.length)-1;
				pd_fungo_porcent = parseFloat( pd_fungo_porcent.substring(0, total_carac) ); 
				
			}else{
				perda_fungo = 0;
				pd_fungo_porcent = 0;
			}
			
			if( $("#perda_bacteria"+$num).val() != '' ) {
				perda_bacteria = parseInt($("#perda_bacteria"+$num).val()); 
				pd_bact_porcent = $("#pd_bact_porcent"+$num).val();
				
				total_carac = (pd_bact_porcent.length)-1;
				pd_bact_porcent = parseFloat( pd_bact_porcent.substring(0, total_carac) ); 
			}else{
				perda_bacteria = 0;
				pd_bact_porcent = 0;
			}
			
			if( $("#perda_oxidacao"+$num).val() != '') {
				perda_oxidacao = parseInt($("#perda_oxidacao"+$num).val()); 
				pd_oxid_porcent = $("#pd_oxid_porcent"+$num).val(); 
				
				total_carac = (pd_oxid_porcent.length)-1;
				pd_oxid_porcent = parseFloat( pd_oxid_porcent.substring(0, total_carac) ); 
			}else{
				perda_oxidacao = 0;
				pd_oxid_porcent = 0;
			}
						
			$soma_total = ( perda_fungo + perda_bacteria + perda_oxidacao );
			$soma_total_porcent = ( pd_fungo_porcent + pd_bact_porcent + pd_oxid_porcent );
			
			if($soma_total_porcent != '') {
				$soma_total_porcent = $soma_total_porcent.toFixed(2)+"%";
				//$soma_total_porcent = $soma_total_porcent+"%";
			}
			
			$("#perda_total"+$num).val($soma_total);
			$("#pd_total_porcent"+$num).val($soma_total_porcent);
		}

				
		/*
		 * exibir a valor porcentagem
		 */
		function exibir_porcentagem($valor_input_fungo, $num, $id )
		{
			$valor_input_trab = $("#num_expl_trab"+$num).val();
			$valor_porcent = (100 * $valor_input_fungo )/$valor_input_trab;
			$valor_porcent = $valor_porcent.toFixed(2)+"%";
			//$valor_fungo_porcent = $valor_fungo_porcent+"%";
			$($id).val($valor_porcent);	
		}
		
		
		/*
		 * Diferença entre datas
		 */
		$("input[name=data_entrada]").change( function(){
			var $data_entrada = $(this).attr("id");				
			var $indice = ($data_entrada.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $data_entrada.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_entrada = $("#"+$data_entrada).val(); // recupera o valor do campo data_entrada 
			$valor_input_saida = $("#data_saida"+$num).val(); // recupera o valor do campo data_entrada 
			
			if($valor_input_entrada != '' && $valor_input_saida != ''){
				calculaData($valor_input_entrada, $valor_input_saida, $num);
				calculaAtraso($num);
			}else{
				$('#duracao'+$num).val(0);
			}
			
		});
		
		$("input[name=data_saida]").change( function(){
			var $data_saida = $(this).attr("id");				
			var $indice = ($data_saida.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $data_saida.substring($indice); // recupera o número correspondente ao final do nome(id) 
			$valor_input_saida = $("#"+$data_saida).val(); // recupera o valor do campo data_entrada 
			$valor_input_entrada = $("#data_entrada"+$num).val(); // recupera o valor do campo data_entrada 
			
			if($valor_input_entrada != '' && $valor_input_saida != ''){
				calculaData($valor_input_entrada, $valor_input_saida, $num);
				calculaAtraso($num);
			}else{
				$('#duracao'+$num).val(0);
			}	
		});
		
		
		/*
		 * Calcula diferença entre data_entrada e data_saída
		 */
		function calculaData(data_entrada, data_saida, num){
			DAY = 1000 * 60 * 60  * 24;
		 		 
		    var nova_dt_entrada = data_entrada.toString().split('/');
		    nova_dt_entrada = nova_dt_entrada[1]+"/"+nova_dt_entrada[0]+"/"+nova_dt_entrada[2];
		 
		    var nova_dt_saida = data_saida.toString().split('/');
		    nova_dt_saida = nova_dt_saida[1]+"/"+nova_dt_saida[0]+"/"+nova_dt_saida[2];
		 
		    d1 = new Date(nova_dt_entrada);
		    d2 = new Date(nova_dt_saida);
		 
		    diferenca_dias = Math.round((d2.getTime() - d1.getTime()) / DAY);
		 
		    $('#duracao'+num).val(diferenca_dias);
		}
		
		/*
		 * calcula o atraso de dias
		 */
		$("select[name=prazo]").change( function(){
			var $prazo = $(this).attr("id");				
			var $indice = ($prazo.length)-1; // índice corresponde ao número que compõe o nome(id) 
			var $num = $prazo.substring($indice); // recupera o número correspondente ao final do nome(id) 
			calculaAtraso($num);
		});
		
		
		/*
		 * Calcula o atraso de dias
		 */
		function calculaAtraso($num){
			$valor_input_duracao = $("#duracao"+$num).val(); // recupera o valor do campo duracao
			$valor_select_prazo = $("#prazo"+$num).val(); // recupera o valor do campo prazo 
			
			if($valor_input_duracao != '' && $valor_select_prazo != ''){
				$("#dias_atrasados"+$num).val($valor_select_prazo - $valor_input_duracao);
			}else{
				$("#dias_atrasados"+$num).val('');
			}	
			
		}
	
		/*
		 * botões habilitar/desabilitar(editar) e atualizar
		 */
		$('.btn-editar').click(function(){	
			var linha = $(this).closest('tr').attr('id'); // table row ID
			var iteration = $(this).data('iteration')||1;
			var id = $(this).attr("id");
			var n = id.indexOf("_");
			var novo_id = id.substring(0,n);
			
			if(novo_id == 'edita')
			{	
				switch (iteration) 
				{
					/*Habilita linha*/
					case 1:
						$("#tab_ger_lote").find("input,select").attr("disabled", true);
						$("#"+linha).find("input,select").attr("disabled", false);
						$(".btn-atualiza").find("image").attr("disabled", false);
						break;
					/*Desabilita linha*/
					case 2:
						$("#tab_ger_lote").find("input,select").attr("disabled", true);
						$("#"+linha).find("input,select").attr("disabled", true);
						$("#cad_fase_lote").find("input,select").attr("disabled", false);
						$(".btn-atualiza").find("image").attr("disabled", true);
						break;
				}
				iteration++;
				if (iteration>2) iteration=1;
				$(this).data('iteration',iteration);
			}		
		});
		
		
		$('.btn-atualiza').click(function(){
			var $linha = $(this).closest('tr').attr('id');
			var $status = $("#"+$linha).find("input,select").attr('disabled');
			if($status == 'disabled'){
				window.alert("click no botão(caneta) para habilitar a linha");
			}else{
				var form = $("#"+$linha).find('form').attr('id');
				$("#"+form).attr("action", url_atualizar_fase_lote);
				$("#"+form).submit();
			}
		});
		
		
		/*
		 * textarea descontaminação, observação
		 */
		
		$("#check_descontam").click(function(){
			var $cultura = $("#cultura");
			var $variedade = $("#variedade");
			var $lote = $("#lote");
			if($cultura.val() != '' && $variedade.val() != '' && $lote.val() != ''){
				$("#descontaminacao").toggle();
				$("#texto_descontam").val(texto_descontam);
			}else{
				window.alert("Selecione Cultura, Variedade e Lote");
				$("#check_descontam").attr("checked", false);
			}
		});
		
		$("#check_observ").click(function(){
			var $cultura = $("#cultura");
			var $variedade = $("#variedade");
			var $lote = $("#lote");
			if($cultura.val() != '' && $variedade.val() != '' && $lote.val() != ''){
				$("#observacao").toggle();
				$("#texto_observ").val(texto_observ);
			}else{
				window.alert("Selecione Cultura, Variedade e Lote");
				$("#check_observ").attr("checked", false);
			}
		});
					
		$("#btn_descontam").click(function(){
			$value_campo = $("#texto_descontam").val();
			$cod_lote = $("#lote").val();
			$.post( url_atualizar_descontam_lote, { texto_descontam:$value_campo, cod_lote:$cod_lote }, 
					function(msg){
					 //var $dados = JSON.parse(data); //decodifica variáveis enviada pelo php com json_encode {'msg': $msg, 'texto_decontam': $texto_descontm }
						    alert(msg);
						    $("#check_descontam").attr("checked", false);
						    $("#descontaminacao").toggle();
						    enviar_form1();
					});
			//$("#form1").attr("action", url_atualizar_descontam_lote);
			//$("#form1").submit();	
		});
				
		$("#btn_observ").click(function(){
			$value_campo = $("#texto_observ").val();
			$cod_lote = $("#lote").val();
			$.post( url_atualizar_observ_lote, { texto_observ:$value_campo, cod_lote:$cod_lote }, 
				function(msg){
				 //var $dados = JSON.parse(data); //decodifica variáveis enviada pelo php com json_encode {'msg': $msg, 'texto_decontam': $texto_descontm }
					    alert(msg);
					    $("#check_observ").attr("checked", false);
					    $("#texto_observ").toggle();
					    enviar_form1();
				});
			//$("#form1").attr("action", url_atualizar_observ_lote);
			//$("#form1").submit();	
		});
							
});

function carrega_ajax()
{
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	return xmlhttp;
}

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
		xmlhttp1.open("POST", url_carregar_var_controle_lote, true);
		xmlhttp1.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp1.send(dados);	
	}	
}

function carregar_lotes()
{
	xmlhttp2 = carrega_ajax();
	var cod_cultura = document.getElementById("cultura").value;	
	if(cod_cultura !='0' && cod_cultura !=''){
		var cod_variedade = document.getElementById('variedade').value;

		xmlhttp2.onreadystatechange=function() {
			if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
		  		document.getElementById("lote").innerHTML=xmlhttp2.responseText;
		  		}
		}

		//window.alert(cod_variedade);
		dados="cod_cultura="+cod_cultura+"&cod_variedade="+cod_variedade+"&cod_lote="+cod_lote_selec;
		xmlhttp2.open("POST",url_carregar_lotes,true);
		xmlhttp2.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp2.send(dados);	
	}	
}

function enviar_form1(){
	var f = document.getElementById('form1');
	//f.action = url_gerenciar_lote;
	//f.method ="post";
	f.submit();
}

function cadastrar_fase(i)
{
	var f = document.getElementById('controle_lote'+i);
	f.action = url_cadastrar_fase_lote;
	f.submit();
}




