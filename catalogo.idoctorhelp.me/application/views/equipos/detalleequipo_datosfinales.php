<tr>
    <td colspan="2" style="height:80px;">C&oacute;mo te enteraste de nosotros</td><td colspan="2">
    <?php
	


$comoent = array("CORREO ELECTRONICO"=>"Correo electr&oacute;nico",
					 "ESPECTACULAR"=>"Espectacular",
					 "MEDALLON"=>"Medall&oacute;n auto/autobus",
					 "OTRO NEGOCIO"=>"Otro negocio",
					 "PUBLICACION"=>"Publicaci&oacute;n (diario/revista)",
					 "RECOMENDACION"=>"Recomendaci&oacute;n",
					 "REDES SOCIALES"=>"Redes sociales",
					 "SITIO WEB"=>"Sitio web",
					 "VISTE EL LOCAL"=>"Viste el local");
					 
    echo form_dropdown('como_te_enteraste',$comoent,(isset($como_te_enteraste) ? $como_te_enteraste : ""));

	?>
    
    </td>    
    
  </tr>
<?php 
  if ($estatus=="Entregado")
  {
?>
<tr>
<td colspan="4" style="height:60px;"><div class="titulo3">Datos de entrega</div></td>
</tr>
<!--<tr>
<td colspan="2">Documento de entrega</td>
<td colspan="2"><div class="inputfake"><?php echo $nota_o_factura; ?></div></td>	
</tr> -->
<tr>
<td colspan="2">N&uacute;mero de remisi&oacute;n</td>
<td colspan="2"><div class="inputfake"><?php echo $numero_remision; ?></div></td>	
</tr>
<tr>
<td colspan="2" style="height:30px;">Forma de pago</td> 
<td colspan="2"><?php echo $forma_de_pago; ?></td>
</tr> 
<tr>
<td colspan="2">Calificaci&oacute;n del servicio</td>
<td colspan="2"><div><?php
if ($calificacion_servicio!="") {
	for ($i=1;$i<=$calificacion_servicio;$i++) {
	  echo "<img src='/images/estrellita.gif'>";
	}	
	
} 
//echo $calificacion_servicio; ?></div></td>	
</tr>   
   
<?php 
  }
?>  
<tr>
	<td colspan="4"><p></p></td>
</tr>
 <tr><td colspan="4" style="text-align:right">
<span><a href="/index.php/equipos/modificar/<?php echo $anterior_id; ?>"><img src="/images/button-previous.png" title="anterior" alt="anterior"></a></span>
<span><a href="/index.php/equipos/modificar/<?php echo $siguiente_id; ?>"><img src="/images/button-next.png" title="siguiente" alt="siguiente"></a></span>
<div align="right">Ir a la orden&nbsp; <?php echo form_input("eq_id_ir2","","id='irequipo2'"); 
    echo form_button("irorden","      Ir      ", "onclick='ir_a_equipo2();'");
?></div>
<script language="javascript">
  function ir_a_equipo2() {
    ideq = $("#irequipo2").val();
    top.location.href="/index.php/equipos/iraequipo/<?php echo  $this->uri->segment(3); ?>/" + ideq;
  }
</script>
  </td></tr>
