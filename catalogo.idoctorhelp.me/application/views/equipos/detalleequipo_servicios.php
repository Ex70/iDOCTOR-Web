<?php   // SERVICIOS
  if (isset($servicios)) {
	  echo "<tr><td width='30'><a href='/index.php/servicios/agregaraequipo/" . $id ."/" . $clase ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Agregar' class='thickbox'><img src='/images/ico_hi_agregar.jpg'></a></td><td colspan=3><div class='titulo3'>Servicios<div></td></tr>";
	  echo "<tr><td colspan=4>";
	  
	 echo "<table class='servicios'>";
	  
	     echo "<tr>";
		 echo "<th width='15%'>Fecha</th>";
		 echo "<th width='40%'>Descripci&oacute;n</th>";
		 echo "<th width='20%'>Costo</th>";
		 echo "<th>Descuento</th>";
	     echo "<th>Subtotal</th>";
		 echo "<th width='30px';></th>";
	     echo "</tr>";	  

  $total = 0;
         $cl = "#ffffff";
 foreach ($servicios as $servicio) {
	     echo "<tr>";
		 echo "<td width='15%' style='background-color:" . $cl . "'>" . $servicio['fecha']  . "</td>";
		// echo "<td><a href='/index.php/piezas/modificardeequipo/" . $servicio['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Modificar' class='thickbox'>" . $servicio['servicio_id'] . "</a></td>";
		 echo "<td style='background-color:" . $cl . "'>" . $servicio['descripcion'] . "</td>";	
		 echo "<td align='right' style='background-color:" . $cl . "'>" . number_format($servicio['costo'], 2, '.', ',') . "</td>";
		 echo "<td align='right' style='background-color:" . $cl . "'>" . $servicio['descuento'] . "</td>";
		 echo "<td align='right' style='background-color:" . $cl . "'>" .  number_format($servicio['subtotal'], 2, '.', ',') . "</td>";
		 echo "<td align='center' style='background-color:" . $cl . "'>";
		 echo "<a href='/index.php/servicios/eliminardeequipo/" .$servicio['id']  ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Eliminar' class='thickbox'>";	 
		 echo "<img src='/images/ico_eliminar.png'></a></td>";
		 echo "</tr>";
		 $total += $servicio['subtotal'];
		  if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";
      }     
	  echo "<td colspan=3></td><td align=right>Total:</td><td  align='right'>$" . number_format($total, 2, '.', ',') . "</td>";
	  echo "<td>&nbsp;</td>";
	  echo "</table>";
	  echo "</td></tr>";
	  
	  //$p = number_format($precio, 2, '.', ',');
  }
?>