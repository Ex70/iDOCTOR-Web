<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/administracion');
$('#titulo').html('Cat&aacute;logo de Estados (Estatus)');
</script>
<div align="center">


<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Estatus</th>
<th>Mensaje para fecha adicional</th>
<th>ID siguiente estatus</th>
<th>Siguiente estatus</th>
<th>Imagen</th>
<th>Indice</th>
<th>Estatus de entrega</th>
<th>Estatus por notificar</th>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/estados/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
	echo "<td>" . $item['estatus'] . "</td>";
	echo "<td>" . $item['mensaje_para_fecha_adicional'] . "</td>";
	echo "<td>" . $item['id_siguiente_estatus'] . "</td>";
    echo "<td>" . $item['siguiente_estatus'] . "</td>";
	echo "<td>" . $item['imagen'] . "</td>";	
	echo "<td>" . $item['indice'] . "</td>";
	echo "<td align=center>" . $item['estatus_de_entrega'] . "</td>";	
	echo "<td align=center>" . $item['estatus_por_notificar'] . "</td>";	
	echo "</tr>";	
}
//print_r($result); 
?>
</table>

<a href="/index.php/estados/agregar">Agregar estatus</a>
</div>

