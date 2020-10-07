<?php $this->load->helper('form'); 
  ?>
<?php echo form_open('piezas/guardaraequipo'); 
  
 /* if ($estatus!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
		   echo form_hidden("equipo_id",  $equipo_id);
	   }
		 else*/ {
			    echo form_hidden("accion", "i");
				echo form_hidden("equipo_id",  $this->uri->segment(3));
				
		       }
?>
<script language="javascript">
function actualizaPiezas() {
	    var t = $("#clase").val();
		
        $.getJSON('/index.php/piezas/piezasjson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#piezas').html(options);
		$("#piezas option[value='']").remove();
      $("#piezas").val($("#piezas option:first").val());



    });
} 


 $(document).ready(function () {
  
  actualizaPiezas();
  
});
 

 window.onload = function() {
<?php if (isset($pieza_id)) {
	?>	 
	 $("#piezas").val('<?php echo $pieza_id; ?>');
<?php } ?>	 
<?php if (isset($clase)) {
	?>	 
	 $("#clase").val('<?php echo $clase; ?>');
<?php } ?>	
} 

</script>
<table  class="tablaiframe">
	<tr><td colspan="2" style="height:10px;"></td></tr>
  <tr>
    <td align="center" colspan="2"><h3>Agregar refacci&oacute;n</h3></td>
  </tr>
  <tr>
  <td>
 <table width="100%" border="0"> 	  
    <td >Clase</td><td>Refacci&oacute;n <span style="font-size:0.8em">(cantidad disponible entre par&eacute;ntesis)</span></td><td>Tipo</td><td>Cantidad</td><!--td>Disponibilidad</td -->
  </tr>
 <tr> 
    <td ><?php 
      $js = 'size="10" id="clase" onChange="actualizaPiezas();"';
	    echo form_dropdown("clase", $clases, (isset($clase) ? $clase : ""),$js); 
	  
	?></td>
   <td><?php 
    $it = array();
   // foreach ($result as $item) {
	//	$it[$item['id']] = $item['id'] . "     " . $item['descripcion'];
//	}
	  $js = 'size="10" id="piezas"';
	echo form_dropdown("pieza_id", $it,"",$js);
	//print_r($it); die();
   ?>
   </td>
   
  <td >
  <?php
     echo form_dropdown("tipo_pieza", array("N"=>"Nueva","O"=>"Otra"), "N","size='10'");
  ?>
  </td>
   <td ><?php 
     $can = range(0,100);
	 unset($can[0]);
   echo form_dropdown('cantidad',$can,"1","size='10'"); ?></td>
   <!--
  <td >
  <?php
     echo form_dropdown("surtida", array("S"=>"Surtida","N"=>"No hay, debe surtirse"), "S","size='10'");
  ?>
  </td>-->
  </tr>
 </table> 
 </td></tr>

 
  
      <tr>
    <td  colspan="2" align="center" class="demo"><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>  
</table>

<?php echo form_close(); 

?>

