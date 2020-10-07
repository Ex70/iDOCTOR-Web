<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/clientes');
$('#titulo').html('Lista de clientes');
</script>

<?php echo form_open('clientes/index'); ?>
<div align="center">
<table class="buscar">
<th colspan="3">Buscar por nombre</th>
<tr>
<td>Nombre:</td>
<td><?php echo form_input("busca_nombre",(isset($busca_nombre) ? $busca_nombre : "")); ?></td>
<td><div align="center"><?php echo form_submit("submit","Filtrar"); ?></div></td>
</tr>
</table>
<?php echo form_close(); ?>

<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Telefono 1</th>
<th>Telefono 2</th>
<th>Correo electronico</th>
<th>Eliminar</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='/index.php/clientes/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
	echo "<td><a href='/index.php/clientes/modificar/" . $item['id'] . "'>" . $item['nombre'] . "</a></td>";
	echo "<td>" . $item['telefono1'] . "</td>";
	echo "<td>" . $item['telefono2'] . "</td>";
	echo "<td>" . $item['correo_electronico'] . "</td>";
	echo "<td align='center'><a href='/index.php/clientes/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";
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
<div class="demo">
<a href="/index.php/clientes/agregar">Agregar cliente</a>
</div>
</div>

