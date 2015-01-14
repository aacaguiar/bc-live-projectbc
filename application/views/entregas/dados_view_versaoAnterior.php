<script type="text/javascript">
$(document).ready(function(){
	for(var i=1; i<=12 ; i++){
		$("#accordion"+i).accordion();
// 		 $("#ent_conc_sim"+i).change(function(){ salvar_ent_conc($("#ent_conc_sim").val()); });
// 		 $("#ent_conc_nao"+i).change(function(){ salvar_ent_conc($("#ent_conc_nao").val()); });
	}

//	 $("#ent_conc_sim").change(function(){ window.alert($("#ent_conc_sim").val()); /*salvar_ent_conc($("#ent_conc_sim").val());*/ });
//	 $("#ent_conc_nao").change(function(){ salvar_ent_conc($("#ent_conc_nao").val()); });
//	 var var_name = $("input[name='radio_name']:checked").val();

	 $("input[name='radio_name']").change(function(){
		 var $id = $(this).attr("id");
		 window.alert($id);

	 });
	 
	 window.alert(var_name);
	 
	 function salvar_ent_conc($opcao)
	 {
		if($opcao == 't')
		{
			$("#ent_conc_nao").attr('checked', false);
			var $resposta =  window.confirm("Tem certeza que a esta entrega foi concluída ?");
			if($resposta){
				$.post(url_listar_entregas,
		 				  {
		 				    mes:$mes,
		 				    async:true
		 				  },
		 				  function(data){	
		 				   //obj = jQuery.parseJSON(data); 
		 				   //window.alert(obj.mes);
		 				   var x = $("#tabs"+$mes);
		 				   x.html(data);  
		 			});
			}else{
				//window.alert('passou - false');
				if($opcao == 't'){ 
					$("#ent_conc_sim").attr('checked', false);
				}else{
					$("#ent_conc_nao").attr('checked', true);
				}	
			}
		}
	 }

});
</script>

<style type="text/css">
.pos-rad {position:relative; top:-3px;}
.pos-lab {position:relative; top:-5px; font-weight: bold;}
</style>

<div id="<?php //echo $accordion;?>"> 
<?php for($i=1; $i <= $tot_entregas; $i++) { ?>
	<h5> Dia <?php echo $dia[$i]['data_entrega']; ?> </h5>
		<div> 
			<table class="table table-hover">
				<tr class="success">
					<th>Nº LOTE </th>
					<th>CLIENTE </th>
					<th>VARIEDADE </th>
					<th>Nº DA ENTREGA </th>
					<th>QTDE</th>
					<th>ENT. CONCLUÍDA</th>
				</tr>
						
				<?php for($cnt=1; $cnt<=$dia[$i]['total']; $cnt++) { ?>
					<tr> 
						<td> <?php echo $dia[$i][$cnt]['num_lote']; ?> </td> 
						<td> <?php echo $dia[$i][$cnt]['nome_rsocial']; ?> </td> 
						<td> <?php echo $dia[$i][$cnt]['variedade']; ?> </td> 
						<td> <?php echo $dia[$i][$cnt]['num_entrega'];?> </td> 
						<td> <?php echo $dia[$i][$cnt]['qtde_parcial']; ?> </td> 
						<td> 
    						<input class="pos-rad" type="radio" value="" id="<? echo 'ent_conc_sim'.$i?>" <?php echo ($dia[$i][$cnt]['ent_concluida'] == 't') ? 'checked' : 'unchecked' ;?>> <span class="pos-lab"> Sim </span>							
     							<span> &nbsp </span> 
    						<input class="pos-rad" type="radio" value="" id="<? echo 'ent_conc_nao'.$i?>" <?php echo ($dia[$i][$cnt]['ent_concluida'] == 'f') ? 'checked' : 'unchecked' ;?>> <span class="pos-lab"> Não </span> 	 
						</td> 	
					</tr>
				<?php } ?>
				
			</table>
		</div>
<?php } ?>
</div>





