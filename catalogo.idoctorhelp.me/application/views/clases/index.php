


<div align="center">

<table width="100%" id="tablaclases" class="cell-border stripe compact hover">
	<thead>
<tr>
<th>Clase</th>
<th>Descripción</th>
<th>Tipos</th>
<th>Servicios</th>
<th>Refacciones</th>
<th>Artículos</th>
<!-- th>Eliminar</th -->
</tr>
</thead>
<tbody>
<?php
foreach ($clases as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/clases/modificar/" . $item['clase'] . "'>" . $item['clase'] . "</a></td>";
	echo "<td>" . $item['descripcion'] . "</td>";
	echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/tipos/index/" . $item['clase'] . "\"'>Tipos</button></td>";	
	echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/servicios/clase/" . $item['clase'] . "\"'>Servicios</button></td>";	
	echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/piezas/clase/" . $item['clase'] . "\"'>Refacciones</button></td>";	
	echo "<td><button class='button button-primary' onclick='top.location.href=\"/index.php/articulos/clase/" . $item['clase'] . "\"'>Artículos</button></td>";	
	//echo "<td align='center'><a href='/index.php/clases/eliminar/" . $item['clase'] . "'><img src='/images/ico_eliminar.png'></a></td>";
	echo "</tr>";	
}

?>
</tbody>
</table>

<div>
<a class="button button-primary" href="/index.php/clases/agregar">Agregar clase</a>
</div>
</div>




<script>
$(document).ready(function() {
    $('#tablaclases').DataTable( {
    	paging:false,
    	searching:false,
    	ordering:false,
    	info: ""
     });
} );
</script>
