 <tr>
    	<td align="center">
    <?php     if ($this->session->userdata('nivel')==1) { ?>
    		<div class="demo"><a href="/index.php/equipos/modificar/<?php echo $this->uri->segment(3); ?>/M">Modificar</a></div>
      <? } ?>      
    	</td>
    <td align="center">
    	<?php
		  $serv = $_SERVER['SERVER_NAME'];
		  if (substr($serv,0,3)=='ve1')
		     $ad = "2"; 
		  else $ad = "";	 
    	  if ($estatus!="") 
		  {
		  	?> 
    	<div class="demo"><input type="button" value="Imprimir orden" onClick="top.location.href='/index.php/equipos/ordenpdf3<?php echo $ad . "/" . $id; ?>';"></div>
                
    	<?php
		  }
		  ?>
    	</td>
        
    <td align="center">
    	<script>
    		function imprimirNota() {
    			<?php if ($estatus!="Entregado") { ?>
    		if (confirm('El equipo no ha sido marcado como entregado. Imprimir la nota de venta?'))
    		     <?php } ?>		
    				    top.location.href='/index.php/equipos/notadeventa3/<?php echo $id; ?>';
    		}
    	</script>
    	<?php
    	  if ($estatus=="Entregado")  
		  {
		  	?> 
    	<div class="demo"><input type="button" value="Nota de venta" onClick="imprimirNota();"></div>                
    	<?php
		  }
		  ?>
    	</td>

        
    <td  class="demo"><?php echo form_submit("submit","Enviar","id='sub'"); ?></td>
  </tr>
  <tr><td align="center"><div class="demo"><a href="/index.php/equipos/cancelarorden/<?php echo $this->uri->segment(3); ?>">Cancelar</a></div></td>
       <td align="center">&nbsp;
     <?php     if ($this->session->userdata('nivel')==1) { ?>
       <div class="demo" id="buteliminar"><input type="button" value="Eliminar" onClick="$('#elim').show();$('#buteliminar').hide();"></div>   
     <?php          } ?>
     <div id="elim" style="display:none">Contrase&ntilde;a de admin: <input type="password" name="passwdadmin" id="passwdadmin" /><input type="button" value="Eliminar" onClick="eliminalaorden();"/></div>
     <div id="msgelim"></div>
     <script language="javascript">
        function eliminalaorden() {
			pw = $("#passwdadmin").val();
			$("#msgelim").load('/index.php/equipos/eliminar/<?php echo $id; ?>/<?php echo $num_orden; ?>/a/' + pw,
			       function() {
					      alert($("#msgelim").html()); 
						    msgel = $("#msgelim").html();
						   if (msgel!="Datos incorrectos para eliminar.") 
						     top.location.href = "/index.php/equipos/index";
						  }
			); 
			
        }
     </script>
       </td>
       <td align="center">
       <?php
    	  if ($estatus!="") 
		  {
		  	?> 
    	<div class="demo"><input type="button" value="Garant&iacute;a" onClick="top.location.href='/index.php/equipos/garantia/<?php echo $id; ?>';"></div>                
    	<?php
		  }
		  ?>
       </td>
       <td></td>
       </tr>

</table>

<?php echo form_close(); 


if ($this->uri->segment(4)=="imprimir") {
	echo "<script language='javascript'>\n";
  echo "location.replace('/index.php/equipos/modificar/" . $this->uri->segment(3) . "');\n";
	echo "window.open('/index.php/equipos/ordenpdf3/" . $this->uri->segment(3) . "','_newtab');\n";
	echo "</script>\n";
	
};

if ((sizeof($piezas)==0) && (sizeof($servicios)==0) && ($estatus=="Proceso")) {
	echo "<script language='javascript'>\n";
	echo '$("#botonagregarbitacora").hide();';
	echo '$("#mensajebitacora").html("<strong>Debes agregar piezas o servicios a la orden para poder seguir agregando a la bit&aacute;cora.</strong>");';
	echo "</script>\n";
	   
} 

?>

</div>

