<script language="javascript">
$("a#regresar").attr('href', '/index.php/inicio/iniciar');
$('#titulo').html('Lista de &Oacute;rdenes de Equipos');
</script>
<div align="center">
<div style="height:30px;"></div>
<div class="paginate" align="center">
<?php

echo $this->pagination->create_links();		
		
?>
</div>
<div style="height:30px;"></div>
<table class="classgrid">
<th colspan="9">Equipos</th>
<tr>
<th>Num. orden</th>
<th>Cliente</th>
<th>Tipo</th>
<th>Diagn&oacute;stico</th>
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
	echo "<td>" . $item['nombre'] . "</td>";
	echo "<td><b>" . $item['tipo'] . "</b><br><div style='font-size:0.7em;'>" . $item['clase'] . "</div></td>";
	echo "<td><?php ?></td>";

    if (($item['numero_remision']!="") && ($item['numero_remision']!=0))
    	 $numrem = " (N.Vta: " . $item['numero_remision'] . ")";
    else $numrem = "";

	echo "<td>" . $item['estatus'] . $numrem . "</td>";
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

	echo "<td align='center'>" . $sit  . "</td>";
	echo "</tr>";
	$i++;	
}
//print_r($result);
for ($j=$i;$j<=50;$j++) {
	echo "<tr>";
	echo "<td style='height:12px;'>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
}
 
?>
</table>
<div class="paginate" align="center">
<?php

echo $this->pagination->create_links();		
		
?>
</div>

</div>

