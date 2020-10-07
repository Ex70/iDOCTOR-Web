<script language="javascript">
$("a#regresar").attr('href', '/index.php/clientes/buscar');
$('#titulo').html('Resultados de b&uacute;squeda');


function actualizarycerrar(id,nombre) {
	top.seleccionarcliente(id,nombre);
	window.parent.tb_remove();
}
</script>



<table width="500" id="grid" align="center">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Telefono 1</th>
<th>Telefono 2</th>
<th>Correo electronico</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td>" . $item['id'] . "</td>";
	echo "<td><a href='#' onClick='actualizarycerrar(" . $item['id'] . ",\"" .  $item['nombre'] . "\");'>" . $item['nombre'] . "</a></td>";
	echo "<td>" . $item['telefono1'] . "</td>";
	echo "<td>" . $item['telefono2'] . "</td>";
	echo "<td>" . $item['correo_electronico'] . "</td>";
	echo "</tr>";	
}
//print_r($result); 
?>
</table>
<div class="paginate" align="center">
<?php

echo $this->pagination->create_links();		
		
?>
</div>

</div>

