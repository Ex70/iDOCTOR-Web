
<div class="row">
	<div class="three columns">
		Seleccionar conjunto de clases
	</div>
	<div class="three columns">
		<?php echo form_dropdown("superclases",$superclases,$this->uri->segment(3,''),"id='superclase'"); ?>
	</div>
<?php if ($this->uri->segment(3,'')!="") { ?>	
<div class="three columns">
		Seleccionar filtro de paquete
	</div>
	<div class="three columns">
		<?php echo form_dropdown("paquetes",$paquetes,$this->uri->segment(4,''),"id='paquete'"); ?>
	</div>	
<?php } ?>
</div>


<div align="center">
<table width="100%" id="tablapaquetes" class="cell-border stripe compact hover">
	<thead>
<tr>
<th>Paquete</th>

<th>Clase</th>

<th>Servicio</th>
<th>Descripción</th>
<th>Costo</th>
<th>Diferencia</th>
<th>Total</th>
<?php
 if ($this->session->userdata('nivel')==1) 	
	echo "<th>Eliminar</th>";		
?>

</tr>
</thead>
<tbody>
<?php
foreach ($result as $item) {

	echo "<tr>";
	echo "<td style='height:35px;'><a href='/index.php/paquetes/modificar/" . $item['id'] . "'>" . $item['paquete'] . "</td>";
	echo "<td>" . $item['clase'] . "</td>";
	echo "<td>" . $item['servicio_id'] . "</td>";
	echo "<td>" . $item['descripcion'] . "</td>";	
	echo "<td align='right'>" . number_format($item['costo'],2) . "</td>";
	echo "<td align='right'>" . number_format($item['diferencia'],2) . "</td>";
	echo "<td align='right'><strong>" . number_format($item['total'],2) . "</strong></td>";
	
 if ($this->session->userdata('nivel')==1) 	
	echo "<td align='center'><a href='/index.php/paquetes/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		
	echo "</tr>";	
}
?>
</tbody>
</table>

<div><a class="button button-primary" href="/index.php/paquetes/agregar">Agregar paquete</a></div>
</div>


<script>
$(document).ready(function() {
    $('#tablapaquetes').DataTable( {
    	paging:false,
    	searching:false,
    	ordering:false,
    	info: ""
     });

    $('#superclase').change(function() {
        cambiaSuperclase();
    });

    $('#paquete').change(function() {
        cambiaSuperclase();
    });

} );


   function cambiaSuperclase() {
   	   sc = $("#superclase").val();
   	   pq = $("#paquete").val();
   	   if (typeof pq == 'undefined')
   	   	   pq = '';
   	   if (sc!='') {
   	   	   top.location.href="/index.php/paquetes/index/" + sc + "/" + pq;
   	   }
   	   else top.location.href="/index.php/paquetes";
   }
</script>
