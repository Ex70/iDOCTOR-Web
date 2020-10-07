<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/administracion');
$('#titulo').html('Lista de Tipos de Dispositivos');
</script>
<div align="center">
<table width="500" id="grid">
<tr>

<th>Descripci&oacute;n</th>
<th>Localizaci&oacute;n</th>
<th>Usada en la orden</th>
<?php
 if ($this->session->userdata('nivel')==1) 	
	echo "<th>Eliminar</th>";		
?>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td style='height:35px;text-align:center;'><a href='/index.php/cajas/modificar/" . $item['id'] . "'>" . $item['descripcion'] . "</td>";
	echo "<td align=center>" . $item['localizacion'] . "</td>";
	echo "<td align=center>" . $item['num_orden'] . "</td>";
 if ($this->session->userdata('nivel')==1) 	
	echo "<td align='center'><a href='/index.php/cajas/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		
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
<a href="/index.php/cajas/agregar">Agregar caja</a>
</div>

