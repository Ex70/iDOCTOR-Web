<?php $this->load->helper('form'); 
?>
<script language="javascript">
function actualizaCosto() {
	    var t = $("#servicioid").val();
      var texto = $("#servicioid option:selected").text();
      if (texto=="SERVICIO DE DIAGNOSTICO") {
        $("#descuento").append('<option value=100>100%</option>');
      }
      else
        $("#descuento option[value='100']").remove();

        $.getJSON('/index.php/servicios/detalleserviciojson/' + t, null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
			if (key=='costo')
			   $("#costo").val(val);
       if (key=='clase')
         $("#detalleclase").html("Clase del servicio: " + val);


        });

    });
} 


 window.onload = function() {
	actualizaCosto();
} 
</script>

<?php echo form_open('servicios/guardaraequipo'); 
  
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
<table  class="tablaiframe">
	<tr><td colspan="2" style="height:10px;"></td></tr>
  <tr>
    <td colspan="2" align="center"><h3>Agregar servicio</h3></td>
  </tr>
 
   <tr>
   	
 <td colspan="2">
 	
 	<table border="0" width="100%">  	
   	<tr>
   <td>Servicio</td><td>Costo</td><td>Descuento</td></tr>
   <tr><td><?php 
    $valcosto = "0";
    $it = array();
    foreach ($result as $item) {
//		$it[$item['id']] = $item['id'] . "     " . $item['descripcion'];
		$it[$item['id']] = $item['descripcion'];
		if ($this->uri->segment(4,"")==$item['id'])
		    $valcosto = $item['costo'];
	}
	//$js = "onChange='document.location.href=\"/index.php/servicios/agregaraequipo/" . $this->uri->segment(3) . "/\" + this.options[this.selectedIndex].value';";
	$js = 'size="10" id="servicioid" onChange="actualizaCosto();"';	
	
	echo form_dropdown("servicio_id",$it,$this->uri->segment(4,""),$js);
	//print_r($it); die();
   ?>
   <div id="detalleclase" style="font-size:0.7em;"></div>
   </td>
    <td ><?php 
	$d    = array(
              'name'        => 'costo',
              'id'          => 'costo',
              'value'       => $valcosto,
              'maxlength'   => '30',
              'size'        => '10',
              'readonly'    => 'readonly',
              'style'       => 'font-size:1.2em'
            );
	//echo "<div class='inputfake'>" . sprintf("%01.2f", $costo) . "</div>"		
	echo form_input($d); ?></td>
    <td><?php 
    if ($this->session->userdata('nivel')=="1")
      $desctos=array("0"=>"0%","5"=>"5%","10"=>"10%","15"=>"15%",
	   "20"=>"20%","25"=>"25%","30"=>"30%","35"=>"35%","40"=>"40%","45"=>"45%","50"=>"50%");
     else
      $desctos=array("0"=>"0%","5"=>"5%","10"=>"10%","15"=>"15%",
     "20"=>"20%");

    echo form_dropdown('descuento',$desctos,'0',"size='10' id='descuento'"); ?></td>
  </tr>
 
 
 </table>
 </td></tr>

 <?php 
 if ($this->session->userdata('nivel')!=1) {
 ?> 	
  
  <tr> 
    <td style="font-size:0.5em;">Contrase&ntilde;a de un usuario administrador<br>
    	para autorizar el descuento    </td>
    <td ><?php 
	echo form_password("passwd",""); ?></td>
  </tr>
<?php
 }
 ?>

 
  
      <tr>
    
    <td colspan="2" class="demo" align="center"><?php echo form_submit("submit","Enviar"); ?></td>
  </tr>  
</table>

<?php echo form_close(); 

?>

