<?php

?>
<div align="center" class="general">Mensajes recientes</div>
<table id="grid0" style="width:900px">
	<tr>
	<th>
		Usuario
	</th>
	<th>
		Fecha
	</th>
	<th>
		Hora
	</th>
	<th>
		Titulo
	</th>
		<th>
Enviado a	</th>

</tr>
<?php
   foreach($mensajes as $item) {
   	   echo "<tr>";
   	   echo "<td style='width:100px'>" . $item['usuario'] . "</td>";
   	   echo "<td style='width:100px'>" . $item['fecha'] . "</td>";
   	   echo "<td style='width:100px'>" . $item['hora'] . "</td>";
   	   echo "<td style='color:#00f;text-align:left;text-decoration:underline'><a href='/index.php/mensajes/vermensaje/" . $item['id'] . "'>" . $item['titulo'] . "</a></td>";
   	   echo "<td style='width:100px'>" . $item['usuario_destinatario'] . "</td>";
   	   echo "</tr>";
   }
?>
</table>
<div style="float:left">
	<a href="/index.php/mensajes/index">Mensajes anteriores...</div>
</div>
<div style="float:right">
	<a href="/index.php/mensajes/agregar"><img src="/images/agregar_30px.png"></div>
</div>