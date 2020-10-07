<script>
$("a#regresar").attr('href', '/index.php/inicio/administracion');
$('#titulo').html('<?php echo $titulo; ?>');
</script>

<div align="center">
<table width="500" id="grid">
<tr>
<th>ID</th>
<th>Usuario</th>
<th>Nombre</th>
<th>Nivel</th>
<?php 
 if ($this->session->userdata('nivel')==1) 	
 	 echo "<th></th>";
?>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td><a href='usuarios/modificar/" . $item['id'] . "'>" . $item['id'] . "</a></td>";
	echo "<td>" . $item['usuario'] . "</td>";
	echo "<td>" . $item['nombre'] . "</td>";
	echo "<td align='center'>" . $item['nivel'] . "</td>";
 if ($this->session->userdata('nivel')==1) 	
	echo "<td align='center'><a href='/index.php/usuarios/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		

	echo "</tr>";	
}
//print_r($result); 
?>
</table>
<div class="demo"><a href="/index.php/usuarios/agregar">Agregar usuario</a></div>
</div>

