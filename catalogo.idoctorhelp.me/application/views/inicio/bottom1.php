<div class="row footer">

<div class="two columns">
iHelp
</div>
<div class="three columns">Usuario: <strong>
<?php 
  echo $this->session->userdata('username');
  ?>	
 </strong> 
</div>
	
<div class="three columns">Nivel: <strong>
<?php 
  echo $this->session->userdata('nivel') . "&nbsp;";
  switch ($this->session->userdata('nivel')) {
  	case 1:
		 echo "Administrador";
		 break;
	case 2:
		 echo "T&eacute;cnico";
		 break;
	case 3:
		 echo "S&oacute:lo lectura";
		 break;	
  }
  
  ?>	
 </strong> 
</div>	
<div class="two columns">
	<div id="titulo" align="center">M&oacute;dulo de cat&aacute;logos</div>	
</div>
<div class="two columns"><strong>
<a href="/index.php/inicio/terminar">Terminar sesi&oacute;n</a>
 </strong> 
</div>

</div>




</div> <!-- container -->
</body>
</html>