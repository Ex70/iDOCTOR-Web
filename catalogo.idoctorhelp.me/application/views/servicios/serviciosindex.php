
<?php echo form_open('servicios/index'); ?>

<?php if (isset($clases)) { ?>

<div class="row">
<h4>Buscar por descripción</h4>
</div>

<div class="row">	

<div class="four columns" align="left">Clase:</div>
<div class="eight columns" align="left"><?php  echo form_dropdown("clase",$clases,$clase); ?></div>


</div>

<div class="row">
<div class="four columns" align="left">Descripci&oacute;n:</div>
<div class="four columns" align="left"><?php echo form_input("busca_descripcion",(isset($busca_descripcion) ? $busca_descripcion : "")); ?></div>
<div class="four columns" align="left"><?php echo form_submit("submit","Filtrar","class='button button-primary'"); ?></div>
</div>



<?php } ?>
<?php echo form_close(); ?>

<div align="center">

<table width="100%" id="tablaservicios"  class="cell-border stripe compact hover">
	<thead>
<tr>
<th style='width:100px'>ID</th>
<th>Descripci&oacute;n</th>
<th style='width:70px'>Costo</th>
<th>Clase</th>
<th><?php
  if ($this->session->userdata('nivel')==1) 	{
  	?>Eliminar<?php } ?></th>
</tr>
</thead>
<tbody>
<?php
$cl = "#ffffff";
foreach ($result as $item) {
	echo "<tr>";
	
 if ($this->session->userdata('nivel')==1) 	
	echo "<td style='background-color:" . $cl . "'><a href='/index.php/servicios/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
 else 
 	echo "<td style='background-color:" . $cl . "'>" . $item['id'] . "</td>"; 
	echo "<td style='background-color:" . $cl . "'>" . $item['descripcion'] . "</td>";
	$costo = $item['costo'];
	echo "<td style='background-color:" . $cl . "' align='right'>" . number_format($costo, 2, '.', ',')  . "</td>";
	echo "<td style='background-color:" . $cl . "'>" . $item['clase'] . "</td>";

if ($this->session->userdata('nivel')==1) 		 
	echo "<td style='background-color:" . $cl . "' align='center'><a href='/index.php/servicios/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
else echo "<td style='background-color:" . $cl . "'>&nbsp;</td>";		
	echo "</tr>";	

  if ($cl=="#ffffff") $cl="#89ded1"; else $cl="#ffffff";

}

?>
</tbody>
</table>

<?php
  if ($this->session->userdata('nivel')==1) 	{
  	?>
<div class="row"><a class="button button-primary" href="/index.php/servicios/agregar">Agregar servicio</a>
</div>
<div class="row">
<a class="button button-primary" href="/index.php/servicios/pdf">Imprimir</a></div>
<?php } ?>
</div>



<script>
$(document).ready(function() {
    $('#tablaservicios').DataTable( {
    	paging:false,
    	searching:false,
    	ordering:false,
    	info: ""
     });
} );
</script>

