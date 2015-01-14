$(document).ready(function(){
	$("#tabs").tabs();
	
//	//carrega função automaticamente
//	$(window).load(function() {
//		  // $('body').text('document esta carregado');
//			  $.post(url_listar_entregas,
//					  {
//					    mes:'01'
//					  },
//					  function(data){
//					   //alert("Data: " + data);
//						//var data1 = $("#data1");
//						//data1.html(data);   
//				});
//		  
//		});

	 $("#mes1").click(function() { envia_dados(1); });
	 $("#mes2").click(function() { envia_dados(2); });
	 $("#mes3").click(function() { envia_dados(3); });
	 $("#mes4").click(function() { envia_dados(4); });
	 $("#mes5").click(function() { envia_dados(5); });
	 $("#mes5").click(function() { envia_dados(6); });
	 $("#mes7").click(function() { envia_dados(7); });
	 $("#mes8").click(function() { envia_dados(8); });
	 $("#mes9").click(function() { envia_dados(9); });
	 $("#mes10").click(function(){ envia_dados(10); });
	 $("#mes11").click(function(){ envia_dados(11); });
	 $("#mes12").click(function(){ envia_dados(12); });
	 	
	 function envia_dados($mes)
	 {
		 $.post(url_listar_entregas,
				  {
				    mes:$mes,
				    async:true
				  },
				  function(data){	
				   //obj = jQuery.parseJSON(data); 
				   //window.alert(obj.mes);
				   var tab_mes = $("#tabs"+$mes);
				   tab_mes.html(data);  
			});
	 }
	 	 	 
	 
}); 














