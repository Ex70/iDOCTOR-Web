<tr><td style="height:30px;">Otras observaciones en la recepci&oacute;n</td>
  <td colspan="3"><?php echo $otras_observaciones_rec; ?>
  </td></tr>
<?php
  if ($estatus=='Entregado') {
?>

<tr>
<td style="height:60px;" colspan="4"><div class="titulo3">Checklist de entrega</div></td>
</tr>

<?php
  // SI ESTA USANDO EL CHECKLIST ANTERIOR..
  if ($chlst_rec_sensor_centro=="") {
 ?>


<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_encendido=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Encendido (conexión a corriente y carga de batería)</td>
</tr> 
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_lcd=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">LCD</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_digitalizador=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Digitalizador/Rueda</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_conector=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></td>	
<td colspan="3">Conector de centro de carga</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_sonido=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Sonido (audífono, bocina, auricular)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_camara=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Cámara (frontal y trasera)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_conexiones=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Conexiones (wifi, bluetooth, antena telefónica)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_botones=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Botones (encendido, volumen, silencio, home)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_sim=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">SIM (bandeja y lectura)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_software=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Software (firmware, baseband, aplicaciones y jailbreak)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_carcasa=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Carcasa (golpes, roturas y rayones)</td>
</tr>
<tr>
<td colspan="1" align="right"><img src="/images/<?php if ($chlst_ent_sensores=="S") echo "check1.gif"; else echo "tache1.gif"; ?>"></div></td>	
<td colspan="3">Sensores de humedad</td>
</tr>
<?php
  }
  else {

      echo "<tr><td colspan='4'>";
      echo "<table>";
      foreach ($checklistentrega as $k=>$v) {
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
?>



<?php
  }
?>

