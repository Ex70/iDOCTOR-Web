<div align="center">
<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Estatus</th>
<th>Fecha</th>
<th>Descripci&oacute;n</th>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
	echo "<td>" . $item['estatus'] . "</td>";
	echo "<td>" . $item['fecha'] . "</td>";
	echo "<td>" . $item['descripcion'] . "</td>";
	echo "</tr>";	
}
//print_r($result); 
?>
</table>
<a href="/index.php/equipos/agregar">Agregar equipo</a>
</div>

