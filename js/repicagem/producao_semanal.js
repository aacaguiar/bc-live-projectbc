$(document).ready(function(){
	var i=1;
	while(i <= num_total){
		$("#linha"+i).find("input,select").attr("disabled", true);		
		i++;	
	}
	
	$("#box_fator_mult").click(function(){
	    $("#panel").slideToggle("slow");
	  });
	
	 $("#flip").click(function(){
		    $("#panel").slideToggle("slow");
		  });
	
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
					$("#tab-prod-sem").find("input,select").attr("disabled", true);
					$("#"+linha).find("input,select").attr("disabled", false);
					$(".btn-atualiza").find("image").attr("disabled", false);
					break;
				/*Desabilita linha*/
				case 2:
					$("#tab-prod-sem").find("input,select").attr("disabled", true);
					$("#"+linha).find("input,select").attr("disabled", true);
					$("#cadastrar_prod_sem").find("input,select").attr("disabled", false);
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
	
});

function cadastrar_prod_semanal(i)
{
	var f = document.getElementById('controle_prod_semanal'+i);
	f.action = url_cadastrar_prod_semanal;
	f.submit();
}

function enviar_form1(){
	var f = document.getElementById('form1');
	//f.action = url_gerenciar_lote;
	//f.method ="post";
	f.submit();
}
