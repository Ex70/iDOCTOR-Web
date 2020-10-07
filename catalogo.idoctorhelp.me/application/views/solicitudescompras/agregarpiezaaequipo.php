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
	    var t = $("#tipo").val();
		
        $.getJSON('/index.php/piezas/piezasjson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#piezas').html(options);
		$("#piezas option[value='']").remove();


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
<?php if (isset($tipo)) {
	?>	 
	 $("#tipo").val('<?php echo $tipo; ?>');
<?php } ?>	
} 

</script>
<table  class="tablaiframe">
  <tr>
    <td colspan="2"><h2>Detalle de pieza a agregar a equipo</h2></td>
  </tr>
  <tr>
    
    <td >Filtrar por tipo</td>
    <td ><?php 
     // Aqui checar como hacerle para meterle un OnChange
	   //echo form_dropdown("tipo", $catTipo);
	    $js = 'id="tipo" onChange="actualizaPiezas();"';
	    echo form_dropdown("tipo", $tipos, (isset($tipo) ? $tipo : ""),$js); 
	  
	?></td>
   </tr>
   <tr>
   <td>Pieza</td>
   <td><?php 
    $it = array();
   // foreach ($result as $item) {
	//	$it[$item['id']] = $item['id'] . "     " . $item['descripcion'];
//	}
	  $js = 'id="piezas"';
	echo form_dropdown("pieza_id", $it,"",$js);
	//print_r($it); die();
   ?>
   </td>
   </tr>
   
   <tr> 
    <td >Cantidad</td>
    <td ><?php echo form_input('cantidad','1'); ?></td>
  </tr>
<tr>
  <td >Tipo de pieza</td>
  <td >
  <?php
     echo form_dropdown("tipo_pieza", array("N"=>"Nueva","U"=>"Usada","R"=>"Reciclaje"), "N");
  ?>
  </td>
  </tr>
<tr>
  <td >Disponibilidad</td>
  <td >
  <?php
     echo form_dropdown("surtida", array("S"=>"Surtida","N"=>"No hay, debe surtirse"), "S");
  ?>
  </td>
  </tr>
  
  

 
  
      <tr>
    <td >&nbsp;</td>
    <td ><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>  
</table>

<?php echo form_close(); 

?>

