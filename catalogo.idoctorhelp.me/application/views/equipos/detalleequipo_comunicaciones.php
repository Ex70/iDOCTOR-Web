<?php   // COMUNICACIONES
  if (isset($comunicaciones)) {
	  echo "<tr><td width='30'><a href='/index.php/comunicaciones/agregaraequipo/" . $id ."/" . $clase ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Agregar' class='thickbox'><img src='/images/ico_hi_agregar.jpg'></a></td><td colspan=3><div class='titulo3'>Comunicaciones<div></td></tr>";
	  echo "<tr><td colspan=4>";
	  
	 echo "<table class='servicios'>";
	  
	     echo "<tr>";
		 echo "<th width='15%'>Fecha</th>";
		 echo "<th width='30%'>Asunto</th>";
		 echo "<th width='40%'>Notas</th>";
		 echo "<th>Usuario</th>";
		 echo "<th width='30px';></th>";
	     echo "</tr>";	  

  $total = 0;
         $cl = "#ffffff";
 foreach ($comunicaciones as $comunicacion) {
	     echo "<tr>";
		 echo "<td width='15%' style='background-color:" . $cl . "'>" . $comunicacion['fecha']  . "</td>";
		// echo "<td><a href='/index.php/piezas/modificardeequipo/" . $servicio['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Modificar' class='thickbox'>" . $servicio['servicio_id'] . "</a></td>";
		 echo "<td style='background-color:" . $cl . "'>" . $comunicacion['asunto'] . "</td>";	
		 echo "<td align='right' style='background-color:" . $cl . "'>" . $comunicacion['notas'] . "</td>";
		 echo "<td align='right' style='background-color:" . $cl . "'>" . $comunicacion['usuario'] . "</td>";
		 echo "<td align='center' style='background-color:" . $cl . "'>";
		 echo "<a href='/index.php/comunicaciones/eliminardeequipo/" .$comunicacion['id']  ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Eliminar' class='thickbox'>";	 
		 echo "<img src='/images/ico_eliminar.png'></a></td>";
		 echo "</tr>";
		  if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";
      }     
	  echo "</table>";
	  echo "</td></tr>";
	  
	  //$p = number_format($precio, 2, '.', ',');
  }
?>
