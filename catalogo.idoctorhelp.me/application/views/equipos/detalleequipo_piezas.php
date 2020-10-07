<?php   // PIEZAS
  if (isset($piezas)) {
	  echo "<tr><td width='30'><a href='/index.php/piezas/agregaraequipo/" . $id ."?keepThis=true&TB_iframe=true&height=300&width=900' title='Agregar' class='thickbox'><img src='/images/ico_hi_agregar.jpg'></a></td><td colspan=3><div class='titulo3'>Piezas</div></td></tr>";
	  echo "<tr><td colspan=4><table class='piezas'>";
	  
	     echo "<tr>";
		 echo "<th width='15%'>Fecha</th>";
		 echo "<th width='40%'>Descripci&oacute;n</th>";
		 echo "<th width='20%'>Cantidad</th>";
		  echo "<th>Del inventario</th>";
		
		 echo "<th width='30px';></th>";
	
		 echo "</tr>";	
		 
		  $cl="#ffffff";  
	  
      foreach ($piezas as $pieza) {
	     echo "<tr>";
		  echo "<td style='background-color:" . $cl . "'>" . $pieza['fecha'] . "</td>"; 
		 //echo "<td><a href='/index.php/piezas/modificardeequipo/" . $pieza['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Modificar' class='thickbox'>" . $pieza['pieza_id'] . "</a></td>";
		 echo "<td style='background-color:" . $cl . "'>" . $pieza['descripcion'] . "</td>";	
		 echo "<td align='center' style='background-color:" . $cl . "'>" . $pieza['cantidad'] . "</td>";
		 echo "<td align='center' style='background-color:" . $cl . "'>";

		   if ($pieza['tipo_pieza']=="N")
		   	  echo "Nuevas";
		   else echo "Otra";

		 echo "</td>";
		 
		 echo "<td align=center style='background-color:" . $cl . "'>";
		 echo "<a href='/index.php/piezas/eliminardeequipo/" .$pieza['id']  ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Eliminar' class='thickbox'>";	 
		 echo "<img src='/images/ico_eliminar.png'></a></td>";
		 echo "</tr>";
		  if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";
      }
	  echo "</table>";
	  echo "</td></tr>";
  }
?>
<script language="JavaScript">
	function surtirPieza(id) {
		if (confirm('Marcar la pieza como surtida?')) {
			top.location.href='/index.php/piezas/surtir/' + id;
		}
	}
</script>
