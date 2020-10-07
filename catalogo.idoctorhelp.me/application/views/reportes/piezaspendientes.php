<script language="javascript">
$('#titulo').html('Piezas pendientes de surtir');
</script>


<?php if (is_array($result)) {
	?>
<div align="center">

<table width="500" id="grid">
<tr>
<th>Fecha</th>
<th>No. orden</th>
<th>Tipo</th>
<th>Cliente</th>
<th>Pieza</th>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td>" . $item['fecha'] . "</td>";
	echo "<td align='center'><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['num_orden'] . "</a></td>";
	echo "<td align='center'>" . $item['tipo'] . "</td>";
	echo "<td align='center'>" . $item['nombre'] . "</td>";
	echo "<td align='center'>" . $item['pieza_id'] . "&nbsp;" . $item['descripcion'] .  "</td>";
	echo "</tr>";
	
}
//print_r($result);

} // IF ISARRAY 
?>
</table>

</div>



