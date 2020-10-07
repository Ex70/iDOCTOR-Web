<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/iniciar');
$('#titulo').html('Lista de Equipos en la Empresa');
</script>
<div align="center">

<div style="height:30px;"></div>
<table class="classgrid">
<th colspan="9">Equipos</th>
<tr>
<th>Num. orden</th>
<th>Tipo</th>
<th>Estatus</th>
<th>Situaci&oacute;n</th>
<?php
  //if ($this->session->userdata('nivel')==1) 
   // echo "<th>Eliminar</th>";
?>
</tr>

<?php
$i = 0;
foreach ($result as $item) {
	echo "<tr>";
    echo "<td align='center'><a href='/index.php/equipos/modificar/" . $item['id'] . "'>" . $item['num_orden'] . "</td>";	
	echo "<td><b>" . $item['tipo'] . "</b><br><div style='font-size:0.7em;'>" . $item['clase'] . "</div></td>";
	echo "<td>" . $item['estatus'] . "</td>";
//	echo "<td>" . $item['fecha_recibido'] . "<br>" . $item['hora_recibido'] . "</td>";	
//if ($this->session->userdata('nivel')==1)
	//echo "<td align='center'><a href='/index.php/equipos/eliminar/" . $item['id'] . "/" . $item['num_orden'] . "'><img src='/images/ico_eliminar.png'></a></td>";
	switch ($item['situacion']) {
		case 'A':
			  $sit = '<strong>Activa</strong>';
			  break;
		case 'C':
			  $sit = 'Concluida';
			  break;
		case 'X':
			  $sit = 'Cancelada';
			  break;
	}		
	echo "<td align='center'>" . $sit . "</td>";
	echo "</tr>";
	$i++;	
}
//print_r($result);
	echo "<tr>";
	echo "<td style='height:12px;'>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td style='font-size:1.4em;'>Total: " . count($result) . " equipos</td>";
	echo "<td></td>";
	echo "</tr>";
 
?>
</table>


</div>

