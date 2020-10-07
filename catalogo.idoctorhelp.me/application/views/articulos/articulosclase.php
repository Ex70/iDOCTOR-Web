<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/articulos');
$('#titulo').html('Lista de articulos');
</script>

<div align="center">


<table id="grid">
<tr>
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Clases</th>
<th>Precio</th>
<th>Eliminar</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
	echo "<td><a href='/index.php/articulos/modificar/" . $item['id'] . "'>" . $item['descripcion'] . "</a></td>";
	echo "<td>" . $item['clase_compatibilidad'] . "</td>";
	echo "<td>" . number_format($item['precio'],2) . "</td>";
	echo "<td align='center'><a href='/index.php/articulos/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
	echo "</tr>";	
}
//print_r($result); 
?>
</table>

<div class="demo">
<a href="/index.php/articulos/agregar">Agregar art&iacute;culo</a>
</div>
</div>

