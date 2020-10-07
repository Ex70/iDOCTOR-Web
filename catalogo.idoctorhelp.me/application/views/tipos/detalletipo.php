<script language="javascript">
$("a#regresar").attr('href', '/index.php/tipos/index');
$('#titulo').html('Detalle de Tipo de Dispositivo');
</script>
<?php $this->load->helper('form'); 
 
?>
<?php echo form_open('tipos/guardar'); ?>
<script language="javascript">
function myFunction() {
    $.getJSON('/index.php/tipos/subtiposjson/iPad2', null, function(data) {

        var options = '';

        $.each(data, function(key, val) {
            options += '<option value="' + key + '">' + val + '</option>';
			
        });
        
        $('#select').html(options);
		$("#select option[value='']").remove();


    });
} 
</script>
<!--<a href="#" onclick="myFunction();">AAA</a>
<select id="select"></select>-->
<table  class="tabla1">
  <tr>
    <td colspan="2"><h2>Detalle de tipo</h2></td>
  </tr>
  <tr>
  <td>Tipo:</td>
    <td><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo form_input("tipo",$tipo);
	   
	   if ($tipo!="") 
	       echo form_hidden("accion", "u");
		 else
			echo form_hidden("accion", "i");

	?></td>
  </tr>
  <tr>
  <td>Descripci&oacute;n:</td>
  <td><?php echo form_input("descripcion",$descripcion); ?></td>
  </tr>
  <tr>
  <td>Clase</td>
  <td><?php 
  echo form_dropdown("clase",$clases,$clase);
  //echo form_input("clase",$clase); ?></td>
  </tr>
  
  
 <?php if ($tipo!="")
         {
   ?>
  <tr><td>&nbsp;</td>
  	<td>
  		<table style="border:1px solid;width:400px;">
  			<tr><th <?php if ($this->session->userdata('nivel')==1) echo "colspan='2'"; ?> style="background-color: #333333;color:#ffffff;">Capacidades</th></tr>
  		
  		<?php
foreach ($subtipos as $item) {
	echo "<tr>";
	echo "<td align='center'><a href='/index.php/subtipos/modificar/" . $item['id'] . "'>" . $item['capacidad'] . "</td>";
  if ($this->session->userdata('nivel')==1) 	
	echo "<td align='center'><a href='/index.php/subtipos/eliminar/" . $item['tipo'] . "/" . $item['capacidad'] . "'><img src='/images/ico_eliminar.png'></a></td>";		
	
	echo "</tr>";	
}              		
  		?>
  		</table>
  		<a href='/index.php/subtipos/agregar/<?php echo $tipo;?>'>Agregar subtipo (capacidad)</a>
  	</td>
  </tr>
  <?php } ?>
  <tr>
  	
    <td colspan="2"><div align="center" class="demo"><?php echo form_submit("submit","Enviar"); ?></div></td>
  </tr>
</table>

<?php echo form_close(); 

?>

