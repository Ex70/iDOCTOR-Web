 
<?php
  if (isset($bitacoras)>0) {
  	  if ($estatus=="Listo para entrega") {
  	  	$hw = "&height=500&width=900";
  	  }
	  else {
	    $hw = "&height=390&width=700";	
	  }
	  echo "<tr><td colspan='4'><div id='mensajebitacora'></div></td></tr>";
	  echo "<tr><td width='30'><div id='botonagregarbitacora'><a href='/index.php/bitacoras/agregar/" . $id ."?keepThis=true&TB_iframe=true" . $hw . "' title='Agregar' class='thickbox'><img src='/images/ico_hi_agregar.jpg'></a></div></td><td colspan=3><div class='titulo3'>Bit&aacute;cora</div></td></tr>";
	  echo "<tr><td colspan=4><table class='bitacora'>";
	  
	     echo "<tr>";
		// echo "<th>Id</th>";
		 echo "<th>Est&aacute;tus</th>";
		 echo "<th>Fecha/hora</th>";
		 echo "<th>Descripci&oacute;n</th>";
		 echo "<th>Otra fecha</th>";
     echo "<th>Proceso</th>";
     echo "<th>Ubicaci&oacute;n</th>";
		 echo "<th>Usuario</th>";
	if ($this->session->userdata('nivel')==1) { // SOLO ADMINISTRADORES	
		 echo "<th  width='30px';></th>";
		 echo "<th  width='30px';></th>";
	   }
		 echo "</tr>";	  
	     $cnt = 1;
	  $cl="#ffffff";
	  	 
      foreach ($bitacoras as $bitacora) {
	     echo "<tr style='background-color:" . $cl . "'>";
		// echo "<td>" . $bitacora['id'] . "</td>";
		// echo "<td><a href='/index.php/bitacoras/modificar/" . $bitacora['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Modificar' class='thickbox'>" . $bitacora['id'] . "</a></td>";
		 echo "<td style='background-color:" . $cl . "'>" . $bitacora['estatus'] . "</td>";	
		 echo "<td style='background-color:" . $cl . "'>" . $bitacora['fecha'] . " / " . $bitacora['hora'] . "</td>";
		 echo "<td style='background-color:" . $cl . "'>" . $bitacora['descripcion'] . "</td>";
		 echo "<td style='background-color:" . $cl . "'>" . $bitacora['mensaje_para_fecha_adicional'] . "<br>" . $bitacora['fecha_adicional'] . "</td>";
     echo "<td style='background-color:" . $cl . "'>" . $bitacora['proceso'] . "</td>";
     echo "<td style='background-color:" . $cl . "'>" . $bitacora['ubicacion'] . "</td>";
		 echo "<td style='background-color:" . $cl . "'>" . $bitacora['usuario'] . "</td>";	
	 if ($this->session->userdata('nivel')==1) {		 
		 echo "<td style='background-color:" . $cl . "' align='center'><a href='/index.php/bitacoras/modificar/" . $bitacora['id'] ."?keepThis=true&TB_iframe=true&height=400&width=700' title='Modificar' class='thickbox'><img src='/images/ico_modificar.gif'></a></td>";	
		 		 echo "<td style='background-color:" . $cl . "' align=center>";
		 if ((count($bitacoras)==$cnt) && (count($bitacoras)>1)) {
             echo "<a href='/index.php/bitacoras/eliminar/" . $this->uri->segment(3) . "/" . $bitacora['id'] ."?keepThis=true&TB_iframe=true&height=300&width=700' title='Eliminar' class='thickbox'>";	 
		    echo "<img src='/images/ico_eliminar.png'>";
			echo "</a>";
		 }
		 echo "</td>";
	 } // IF THIS SESSION...	 
		 echo "</tr>";
		 $cnt++;
		 if ($cl=="#ffffff") $cl="#49cdd1"; else $cl="#ffffff";
      }
	  echo "</table></td></tr>";
  }
?>