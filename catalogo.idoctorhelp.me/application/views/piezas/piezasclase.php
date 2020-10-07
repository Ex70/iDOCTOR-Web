

<div align="center">
<table width="500" id="grid">
<tr>
<th style='width:100px'>ID</th>
<th>Descripci&oacute;n</th>

<th>Clase</th>
</tr>

<?php
$cl = "#ffffff";
foreach ($piezas as $item) {
	echo "<tr>";
	

 	echo "<td style='background-color:" . $cl . "'>" . $item['id'] . "</td>"; 
	echo "<td style='background-color:" . $cl . "'>" . $item['descripcion'] . "</td>";

	echo "<td style='background-color:" . $cl . "'>" . $item['clase'] . "</td>";

	
	echo "</tr>";	

  if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";

}

?>
</table>


</div>
