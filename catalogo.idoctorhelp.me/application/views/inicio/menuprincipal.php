<div align="center" style="display:none;">
<table class="tablemenu">
  <tr>
    <td><a href="/index.php/inicio/iniciar"><img src="/images/ico_inicio.jpg" /><br />Inicio</a></td> 
    <td><a href="/index.php/inicio/proceso"><img src="/images/ico_procesos.jpg" /><br />Proceso</a></td>
    <td><a href="/index.php/inicio/servicios"><img src="/images/ico_servicios.jpg" /><br />Servicios</a></td>
    <td><a href="/index.php/inicio/clientes"><img src="/images/ico_clientes.jpg" /><br />Clientes</a></td>    
    <td><a href="/index.php/inicio/sistema"><img src="/images/ico_piezas.jpg" /><br />Sistema</a></td>
 <?php  	
 if ($this->session->userdata('nivel')==1) {
 	?>
    <td><a href="/index.php/inicio/administracion"><img src="/images/ico_administracion.jpg" /><br />Administraci&oacute;n</a></td>
  <?php
 }
 ?>  
  </tr>
</table>  
</div>