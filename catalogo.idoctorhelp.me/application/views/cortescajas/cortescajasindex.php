<script language="javascript">
$('#titulo').html('Lista de Cortes de Cajas');
</script>
<div align="center">
<table width="500" id="grid">
<tr>

<th>Fecha</th>
<th>Hora</th>
<th>Turno</th>
<?php
 if ($this->session->userdata('nivel')==1) 	
	echo "<th>Eliminar</th>";		
?>

</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td style='height:35px;text-align:center;'><a href='/index.php/cortescajas/modificar/" . $item['id'] . "'>" . $item['fecha'] . "</td>";
	echo "<td style='height:35px;text-align:center;'><a href='/index.php/cortescajas/modificar/" . $item['id'] . "'>" . $item['hora'] . "</td>";
	echo "<td align=center>" . $item['turno'] . "</td>";
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
<a href="/index.php/cortescajas/agregar">Agregar corte de caja</a>
</div>

