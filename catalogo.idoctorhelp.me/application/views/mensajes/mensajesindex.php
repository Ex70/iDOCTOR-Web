<div align="center">
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
		Mensaje
	</th>
		<th>
Enviado a	</th>

	<th>
		
	</th>

</tr>
<?php
   foreach($mensajes as $item) {
   	   echo "<tr>";
   	   echo "<td style='width:100px;text-align:center'>" . $item['usuario'] . "</td>";
   	   echo "<td style='width:100px'>" . $item['fecha'] . "</td>";
   	   echo "<td style='width:100px'>" . $item['hora'] . "</td>";
   	   echo "<td><a href='/index.php/mensajes/vermensaje/" . $item['id'] . "'>" . $item['titulo'] . "</a></td>";
   	   echo "<td>" . substr($item['mensaje'],0,15) . "...</td>";
   	   echo "<td style='width:100px'>" . $item['usuario_destinatario'] . "</td>";
   	   
 if ($this->session->userdata('usuario_id')==$item['usuario_id']) 	
   	   echo "<td align='center'><a href='/index.php/mensajes/eliminar/" . $item['id'] . "'><img src='/images/ico_eliminar.png'></a></td>";		

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
<p>

<div align="center" class="demo">
	<a href="/index.php/mensajes/agregar">Agregar</div>
</div>




