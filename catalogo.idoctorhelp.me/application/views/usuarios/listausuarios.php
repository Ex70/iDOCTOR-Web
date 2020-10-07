

<div align="center">
<table width="500" id="grid">
<tr>

<th>Usuario</th>
<th>Nombre</th>
<th>Sucursales donde puede acceder</th>
<th>Dar de baja</th>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";

	echo "<td><a href='/index.php/usuarios/modificar/" . $item['usuario'] . "'>" . $item['usuario'] . "</a></td>";
	echo "<td>" . $item['nombre'] . "</td>";
	echo "<td>" . $item['sucursales'] . "</td>";
	echo "<td align='center'><a href='/index.php/usuarios/eliminar/" . $item['usuario'] . "'><img src='/images/ico_eliminar.png'></a></td>";		

	echo "</tr>";	
}
//print_r($result); 
?>
</table>
<div ><a class="button button-primary" href="/index.php/usuarios/agregar">Agregar usuario</a></div>
</div>

