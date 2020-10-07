<tr>
<td style="height:60px;" colspan="4"><div class="titulo3">Checklist</div></td>
</tr>
<?php
  // SI ESTA USANDO EL CHECKLIST ANTERIOR..
  if ($chlst_rec_sensor_centro=="") {
 ?>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_encendido=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Encendido (conexión a corriente y carga de batería)</td>
</tr> 
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_lcd=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">LCD</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_digitalizador=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Digitalizador/Rueda</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_conector=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Conector de centro de carga</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_sonido=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Sonido (audífono, bocina, auricular)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_camara=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Cámara (frontal y trasera)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_conexiones=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Conexiones (wifi, bluetooth, antena telefónica)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_botones=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Botones (encendido, volumen, silencio, home)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_sim=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">SIM (bandeja y lectura)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_software=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Software (firmware, baseband, aplicaciones y jailbreak)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_carcasa=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Carcasa (golpes, roturas y rayones)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_sensores=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Sensores de humedad</td>
</tr>
<?php
}

else

  { // CHECK LIST NUEVO

      echo "<tr><td valign='top'>Equipo enciende</td><td colspan='3'>" . $equipo_enciende;
      if ($equipo_enciende=="NO") {
        echo "<br>El equipo no encendi&oacute; durante la recepci&oacute;n, por lo cual no fue posible realizarse las comprobaciones de rutina.";
      }

      echo "</td></tr>";
      echo "<tr><td valign='top'>Equipo mojado</td><td colspan='3'>" . $equipo_mojado;
      if ($equipo_mojado=="SI") {
        echo "<br>Debido a las condiciones de humedad en las que se recibe el equipo, se omitir&aacute; la comprobaci&oacute;n de rutina a fin de evitar mayores da&ntilde;os al dispositivo.";
      }

      echo "</td></tr>";


      if (($equipo_enciende=="SI") && ($equipo_mojado=="NO")) {

  	
      echo "<tr><td colspan='4'>";
      echo "<table>";
      foreach ($checklist as $k=>$v) {
         echo "<tr><td style='padding-left:100px;'>" . $v . "</td>";
         echo "<td align='center'>";
         eval("\$k1=\$" . $k . ";");
         switch ($k1) {
         	case "SI":
         	  echo "<img src='/images/check1.gif'>";
         	  break;
         	 case "NO":
         	   echo "<img src='/images/tache1.gif'>";
         	   break;
         	 case "NV":
         	   echo "No verificado";
         	  break;
         }
         echo form_hidden($k,$k1);
         echo "</td>";
         echo "</td></tr>";
      }
      echo "</table>";
      echo "</td></tr>";

    }

  }
?>