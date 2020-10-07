<script language="javascript">
$("a#regresar").attr('href', '<?php echo $urlregresar; ?>');
$('#titulo').html('<?php echo $titulo; ?>');
</script>
<div align="center">

<div style="height:30px;"></div>
<h3>Pendientes de la semana del <?php echo $fechainicio; ?> al <?php echo $fechatermino; ?></h3>
<p></p>
<table class="classgrid">
<tr>
<th>Fecha</th>
<th>Num. orden</th>
<th>Estatus</th>
<th>Cliente</th>
<th>Tel&eacute;fonos</th>

</tr>

<?php

$fa = ""; $fechaadicional = "";
foreach ($result as $item) {
   switch ($item['recordatorio_de']) {
    case "Notificar":
        $col = "#ffff00";
        break;
    case "Entregar":
        $col = "#22ff33";
        break;
    case "En espera":
         $col = "#0000ff";
        break;
    case "Diagnosticar":
        $col = "#aa00aa";
        break;
    case "Reparar":
        $col = "#ff0000";
        break;
	default:
		$col = "#ffffff";
		break; 
  }	
	
	echo "<tr>";
	 /* // echo date("w",'2012-04-03');
	switch () {  
		case "Sun": $sdia = "Domingo"; break;
		case "Mon": $sdia = "Lunes"; break;
		case "Tue": $sdia = "Martes"; break;
		case "Wed": $sdia = "Mi&eacute;rcoles"; break;
		case "Thu": $sdia = "Jueves"; break;
		case "Fri": $sdia = "Viernes"; break;
		case "Sat": $sdia = "S&aacute;bado"; break;
	}*/
	if ($fa==$item['fecha_adicional'])
	    $fechaadicional = "";
	else $fechaadicional = $item['fecha_adicional'];
	echo "<td align='center'>" . $fechaadicional . "</td>";
	$fa = $item['fecha_adicional'];
	/*echo "<td align=center style='background-color:" . $col . ";'>" . $item['recordatorio_de'];
    if (($item['recordatorio_de']=='Entregar') && ($item['dias_vencidos']>15)) {
    	echo "<br><div style='color:#ff0000;font-size:0.7em;'>Equipo en<br>abandono</div>";
    }
	echo "</td>";*/	
	//echo "<td>" . $item['tipo'] . "</td>";
	echo "<td><a href='/index.php/equipos/modificar/" . $item['equipo_id'] . "'>" . $item['num_orden'] ."</a></td>";
	echo "<td><b>" . $item['estatus'] . "</b>" . "</td>";
/*	echo "<td>" . $item['mensaje_para_fecha_adicional'] . "<br>" . 
	     $item['fecha_adicional'] . "<br><strong>" . $item['dias_vencidos'] . " dias vencidos.</strong></td>";	
*/
	echo "<td>" . $item['nombre'] . "</td>";
	echo "<td>" . $item['telefono1'] . "<br>" . $item['telefono2'] . "</td>";
	/*
	echo "<td>";
	if ($item['correo_electronico']!='') {
	    echo "<a href='/index.php/clientes/enviarcorreo/" . $item['cliente_id'] . "'>" . $item['correo_electronico'] . "</a>";
	}
	echo "</td>";
	 * 
	 */
	echo "<td>" . "" . "</td>";
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

