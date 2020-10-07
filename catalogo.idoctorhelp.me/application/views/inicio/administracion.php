
<div align=center style="padding:80px;">
<table class="tablemenu" width="700" border="0" cellspacing="2" cellpadding="15" align="center">
  <tr>
 <?php  	
 if ($this->session->userdata('nivel')==1) {
 	?>
    <td align="center"><a href="/index.php/estados"><img src="/images/ico_catestatus.png" /><br />
   Cat&aacute;logo de Estatus</a></td>
    <td align="center"><a href="/index.php/registroacciones"><img src="/images/ico_registroacc.png" /><br />
   Registro de Acciones en la B.D.</a></td>
     <td align="center"><a href="/index.php/usuarios"><img src="/images/ico_usuarios.png" /><br />
   Control de usuarios del sistema</a></td>
  <td align="center"><a href="/index.php/tipos"><img src="/images/ico_ipodclassic.png" /><br />
   Tipos de Dispositivos</a></td>     
  <td align="center"><a href="/index.php/equipos/cambiarnumorden"><img src="/images/ico_siguientenumorden.png" /><br />
   Cambiar siguiente n&uacute;mero de orden</a></td>  
  <?php } ?> 
  </tr>
</table>
</div>
