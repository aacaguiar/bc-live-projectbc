<script type="text/javascript">
var url_conc_ent_parcial = "<?php echo base_url('entregas/concluir_ent_parcial'); ?>";

$(document).ready(function(){
	for(var i=1; i<=12 ; i++){
		$("#accordion"+i).accordion();
	}

	 $("input[type='radio']").change(function(){
		 var $id = $(this).attr("id");
		 var $valor = $("#"+$id).val();
		 salvar_ent_conc($id, $valor);
		//window.alert($res);
	 });
	 
	 function salvar_ent_conc($id, $valor)
	 {
		var $num = $id.substr(1);
		if($valor == 't')
		{
			$("#f"+$num).attr('checked', false);
			var $resposta =  window.confirm("Tem certeza que a esta entrega foi concluída ?");
			if($resposta){
				$.post(url_conc_ent_parcial,
		 				  {
		 				    id:$num,
		 				    async:true
		 				  },
		 				  function(data){
			 				  if(data){
								window.alert('Entrega atualizada com sucesso');
								$("#"+$id).attr('disabled', true);
								$("#f"+$num).attr('disabled', true);
			 				  }else{
								window.alert('Erro ao atulizar entrega');
								$("#"+$id).attr('disabled', false);
			 				  }
			 				  //window.alert(data);
			 				  
		 				   //obj = jQuery.parseJSON(data); 
		 				   //window.alert(obj.mes);
		 				   //var x = $("#tabs"+$mes);
		 				   //x.html(data); $("#campo1").attr("disabled",true); 
		 			});
			}else{
				//if($valor == 't'){ 
					$("#"+$id).attr('checked', false);
				//}else{
					$("#f"+$num).attr('checked', true);
				//}	
			}
		}
	 }

});
</script>

<style type="text/css">
.pos-rad {position:relative; top:-3px;}
.pos-lab {position:relative; top:-5px; font-weight: bold;}
</style>

<div>
 
	<table class="table table-hover">
		<tr class="success">
			<th>DIA </th>
			<th>Nº LOTE </th>
			<th>CLIENTE </th>
			<th>VARIEDADE </th>
			<th>Nº DA ENTREGA </th>
			<th>QTDE</th>
			<th>ENT. CONCLUÍDA</th>
		</tr>
	<?php 
		for($i=1; $i <= $tot_entregas; $i++) { 
	?>			
			<tr> 
				<td> <?php echo $entregas[$i]['data_entrega']; ?> </td>
				<td> <?php echo $entregas[$i]['num_lote']; ?> </td> 
				<td> <?php echo $entregas[$i]['nome_rsocial']; ?> </td> 
				<td> <?php echo $entregas[$i]['variedade']; ?> </td> 
				<td> <?php echo $entregas[$i]['num_entrega'];?> </td> 
				<td> <?php echo $entregas[$i]['qtde_parcial']; ?> </td> 
				<td> 
				<?php $disabled = ($entregas[$i]['ent_concluida'] == 't') ? 'disabled' : ' ' ;?>
    				<input class="pos-rad" type="radio" value="t" <? echo $disabled ?> id="<? echo 't'.$entregas[$i]['id_entrega']?>" <? echo ($entregas[$i]['ent_concluida'] == 't') ? 'checked' : 'unchecked'; ?>> <span class="pos-lab"> Sim </span>							
     					<span> &nbsp </span> 
    				<input class="pos-rad" type="radio" value="f" <? echo $disabled ?> id="<? echo 'f'.$entregas[$i]['id_entrega']?>" <? echo ($entregas[$i]['ent_concluida'] == 'f') ? 'checked' : 'unchecked' ;?>> <span class="pos-lab"> Não </span> 	 
				</td> 	
			</tr>
	<?php 
		}
	?>	
	</table>
	
</div>


		







