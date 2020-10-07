<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
.tabla {
	 border-collapse:collapse;
	 border:solid 1px;
	 border-color:#333;
}
</style>
</head>
<body>
<div align="center">
<h1>Hospital de iPods</h1>
<h3>Reporte de Servicios</h3>
<table width="520" class="tabla">
<tr class="tabla">
<th>ID</th>
<th>Descripci&oacute;n</th>
<th>Costo</th>
<th>Tipo</th>
</tr>

<?php
foreach ($result as $item) {
	echo "<tr>";
	echo "<td class='tabla'>" . $item['id'] . "</td>";
	echo "<td class='tabla'>" . $item['descripcion'] . "</td>";
	$costo = $item['costo'];
	echo "<td  class='tabla' align='right'>" . number_format($costo, 2, '.', ',')  . "</td>";
	echo "<td class='tabla'>" . $item['tipo'] . "</td>";
	 
		
	echo "</tr>";	
}
//print_r($result); 
?>
</table>
</div>
</body>
</html>