<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/clientes');
$('#titulo').html('Solicitudes Pendientes');
</script>
<div align="center">
<?php echo form_open('solicitudescompras/index'); ?>
<div align="center">
<table class="buscar">
<th colspan="3">Buscar por categor&iacute;a (tags)</th>
<tr>
<td>Categor&iacute;a:</td>
<td><?php echo form_input("busca_categoria",(isset($busca_categoria) ? $busca_categoria : "")); ?></td>
<td><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>

<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Categor&iacute;a</th>
<th>Asunto</th>
<th>Tel&eacute;fono</th>
<th>Correo electr&oacute;nico</th>
<th>Checado</th>
<th>Eliminar</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/solicitudescompras/modificar/" . $item['id'] . "'>" . $item['id'] . "</td>";
	echo "<td><a href='/index.php/solicitudescompras/modificar/" . $item['id'] . "'>" . $item['nombre'] . "</td>";
	echo "<td>" . $item['categoria'] . "</td>";
	echo "<td>" . $item['asunto'] . "</td>";
	echo "<td>" . $item['telefono'] . "</td>";
	echo "<td>" . $item['correo_electronico'] . "</td>";
    echo "<td align='center'>" . $item['checado'] . "</td>";
	
	echo "<td align='center'><a href='/index.php/solicitudescompras/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		
	
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
<a href="/index.php/solicitudescompras/agregar">Agregar solicitud</a>
</div>

