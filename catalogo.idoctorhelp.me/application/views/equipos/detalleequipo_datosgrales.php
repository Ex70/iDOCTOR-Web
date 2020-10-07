<div>
<table class="tabla1">
  <tr><td colspan="4" style="text-align:right">
<span><a href="/index.php/equipos/modificar/<?php echo $anterior_id; ?>"><img src="/images/button-previous.png" title="anterior" alt="anterior"></a></span>
<span><a href="/index.php/equipos/modificar/<?php echo $siguiente_id; ?>"><img src="/images/button-next.png" title="siguiente" alt="siguiente"></a></span>
<div align="right">Ir a la orden&nbsp; <?php echo form_input("eq_id_ir","","id='irequipo'"); 
    echo form_button("irorden","      Ir      ", "onclick='ir_a_equipo();'");
?></div>
<script language="javascript">
  function ir_a_equipo() {
    ideq = $("#irequipo").val();
    top.location.href="/index.php/equipos/iraequipo/<?php echo  $this->uri->segment(3); ?>/" + ideq;
  }
</script>
  </td></tr>
  <tr>
    <td colspan="4"><h2>Detalle de orden de equipo</h2></td>
  </tr>
  <tr>
    <td>No. de orden</td><td><?php  
    $dat = array(
              'name'        => 'num_orden',
              'id'          => 'numorden',
              'value'       => (isset($num_orden) ? $num_orden : ""),
              'maxlength'   => '20',
              'size'        => '12',
              'style'       => 'color:#660000;font-weight:bold;font-size:1.4em;'
            );  
	if ($this->session->userdata('nivel')!=1)
	    $dat['readonly'] = 'readonly';		
    echo form_input($dat); ?></td>

    <?php
      if ($numero_remision=="") {
         echo "<td>ID</td><td>" .  $id . "</td>";
       }   
       else {
       	if ($this->uri->segment(4,'')=="M") 
         echo "<td>Num. remisi&oacute;n (nota)</td><td>" .  form_input("numero_remision",$numero_remision) . "</td>";
        else
         echo "<td>Num. remisi&oacute;n (nota)</td><td>" .  $numero_remision . "</td>";
       }  
    ?>
  </tr>
  <tr>
    <td width="15%">Estatus</td>
    <td width="31%"><?php //echo form_input("estatus",(isset($estatus) ? $estatus : "")); 

	   echo $estatus;
	   
	   if ($estatus!="") {
	       echo form_hidden("accion", "u");
		   echo form_hidden("id",$id);
	   }
		 else echo form_hidden("accion", "i");
	?></td>
    <td width="25%">Tipo</td>
    <td width="29%"><?php 
	if ($this->uri->segment(4,'')=="M") {
	   $js = 'id="tipo" onChange="actualizaCap();"';
	   echo  form_dropdown("tipo", $tipos, (isset($tipo) ? $tipo : ""),$js);
	}
	else
	{
	   echo form_hidden("tipo",$tipo);
	   echo $tipos[$tipo]; 
	}
	?>

    </td>
  </tr>
  <tr>
  	<td>Situaci&oacute;n</td><td>
  		<?php
  		echo form_dropdown("situacion",array("A"=>"Activa","C"=>"Concluida","X"=>"Cancelada"),$situacion)?>
  		 
  		</td>
  	<td><?php if ($situacion=="X") 
  	                   echo "Fecha de cancelaci&oacute;n "; ?></td>
  	      <td><?php if ($situacion=="X") 
  	                   echo $fecha_cancelado; ?></td>
  </tr>
  
  <tr>
    <td>Modelo</td>
    <td><?php 
       $m = array("name"=>"modelo",
                  "value"=> (isset($modelo) ? $modelo : ""),
				  "size" => 8,
				  "readonly" => "readonly",
				  "id" => "modelo");
       echo form_input($m); ?></td>
    <td>Capacidad</td>
    <td><?php
	if ($this->uri->segment(4,'')=="M") {
	    $js = 'id="capacidad"';
	    echo form_dropdown("capacidad",array(),(isset($capacidad) ? $capacidad : ""),$js);
	}
	  else
	   echo $capacidad; 
	   ?></td>
  </tr>
<?php if (substr($tipo,0,5)=="iPhon")
   {
 ?>  	

  <tr>
    <td>IMEI</td>
    <td><?php 
       echo $iphone_imei;
     ?></td>
    <td>Firmware del modem</td>
    <td><?php
       echo $iphone_firmware_modem;	
	   ?></td>
  </tr>
<?php 
  }
  ?>

  <tr>
    <td>Versi&oacute;n del IOS</td>
    <td><?php 
       echo $ios_version;
     ?></td>
    <td>&nbsp;</td>
    <td><?php
       
	   ?>&nbsp;</td>
  </tr>

  <tr>
    <td>No. Serie</td>
    <td>
    <?php 
	if ($this->uri->segment(4,'')=="M") 
	    echo form_input("num_serie",(isset($num_serie) ? $num_serie : "")); 
	else
	    echo $num_serie;	
		
		?></td>
    <td></td>
    <td valign="top"> 
    	</td>
  </tr>
  <tr>
    <td>Color</td>
    <td>
    <?php 
	if ($this->uri->segment(4,'')=="M") 
	   echo form_input("color",$color);
   else
	echo $color; ?></td>
    <td>Operador</td>
    <td valign="top"> 
    	<?php 
    		
			 echo $operador;
    		?>
    	</td>
  </tr>
  
  <tr>
    <td>Fecha de recibido</td>
    <td><?php 
	$val = "";
	if ($fecha_recibido!="") {
		    $val = $fecha_recibido;
	}		
	else
	   $val = date("Y-m-d");
	
	
	
	$dat = array(
              'name'        => 'fecha_recibido',
              'id'          => 'fechaRecibido',
              'value'       => $val,
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );  
//	    echo form_input($dat);
   if ($this->uri->segment(4,'')=="M") 
	  echo form_input($dat); 
  	    else
  	    echo $fecha_recibido;
  	    ?>
    <td>Hora de recibido</td>
    <td><?php
       if ($this->uri->segment(4,'')=="M") 
       	echo form_input("hora_recibido",$hora_recibido);
       else
    	  echo $hora_recibido; 
      //echo form_input("hora_recibido",(($hora_recibido!="") ? $hora_recibido : date("H:m:s"))); ?></td>
  </tr>
 
<tr>
    <td>Fecha de entrega</td>
    <td><?php 
	$dat = array(
              'name'        => 'fecha_de_entrega',
              'id'          => 'fechaEntrega',
              'value'       => $fecha_de_entrega,
              'maxlength'   => '20',
              'size'        => '15',
              'class'       => 'date-pick'
            );
			
	if ($this->uri->segment(4,'')=="M") 		
	    echo form_input($dat);
	else
		echo $fecha_de_entrega;  
	?>
   <td>Usuario que recibi&oacute;</td>
    <td style="font-size:0.8em;"><?php 
        //$ud = $this->session->all_userdata();		
	   echo $usuario_recibio; 
	   ?></td>
  </tr>  
  
  
  
  <tr>
    <td>Cliente</td>
    <td colspan=3>
    <table width="100%" border="0">
    <tr><td colspan="3">
	<?php
	 $arn = array("name"=>"cliente_id","id"=>"clienteid","size"=>"2",
					   "readonly"    => "readonly",
					   "value" => (isset($cliente_id) ? $cliente_id : ""));
	 echo form_input($arn);
	 ?></td><td>
     <?php
	 //echo form_input("cliente_id",(isset($cliente_id) ? $cliente_id : ""));
	   $arn = array("name"=>"nombrecliente","id"=>"nombrecliente","size"=>"40",
					   "readonly"    => "readonly",
					    'style'       => 'color:#000000;font-weight:bold;font-size:1.2em;',
					   );
	    echo form_input($arn);
	  
	   //echo form_input("nombrecliente",(isset($cliente_id) ? $cliente_id : "")); 
		
	    //$js = 'id="clienteid"';
	    //echo  form_dropdown("cliente_id", $clientes, (isset($cliente_id) ? $cliente_id : ""),$js);
	   /*
	    <td>
    <a href='/index.php/clientes/agregardesdeequipos?keepThis=true&TB_iframe=true&height=200&width=800' title='Agregar' class='thickbox'><strong>+</strong></a>
</td>
	    */ 
	?>
    </td>
 <td>
<!--<a href='/index.php/clientes/buscar?keepThis=true&TB_iframe=true&height=300&width=800' title='Buscar' class='thickbox'><strong><img src="/images/ico_lupa.gif"></strong></a>-->  
</td></tr></table>  
    </td>
   
  </tr>
  <tr>
    <td colspan="4">Descripci&oacute;n del problema<br />
    <?php
	$data = array(
              'name'        => 'descripcion_problema',
              'id'          => 'descproblema',
              'value'       => (isset($descripcion_problema) ? $descripcion_problema : ""),
              'rows'   => '7',
              'cols'        => '30',
              'style'       => 'width:100%',
              'readonly'    => 'readonly'
            );

echo form_textarea($data);
	?>
    
    </td>
<tr>
    <td colspan="4">Condiciones de recepci&oacute;n del equipo<br />
    <?php
	$data = array(
              'name'        => 'condiciones_recepcion_eq',
              'id'          => 'condreceq',
              'value'       => (isset($condiciones_recepcion_eq) ? $condiciones_recepcion_eq : ""),
              'rows'   => '4',
              'cols'        => '30',
              'style'       => 'width:100%',
              'readonly'    => 'readonly'
            );

echo form_textarea($data);
	?>
    
    </td>    
    
  </tr>
<tr>
    <td colspan="4">Diagn&oacute;stico del t&eacute;cnico<br />
    <?php
	$data = array(
              'name'        => 'diagnostico',
              'id'          => 'diagnostico',
              'value'       => (isset($diagnostico) ? $diagnostico : ""),
              'rows'   => '4',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?>
    
    </td>    
    
  </tr>
<tr>
  <td colspan="4">
    <div class="demo" align="center">
      <input type="button" value="Enviar" id="botonenmedio" onclick="enviar();">
      <script>
        function enviar() {
           $("#sub").click();
        }
        
      </script>
    </div>
  </td>  
  
<tr>
    <td colspan="4">Notas<br />
    <?php
	$data = array(
              'name'        => 'notas',
              'id'          => 'notas',
              'value'       => (isset($notas) ? $notas : ""),
              'rows'   => '4',
              'cols'        => '30',
              'style'       => 'width:100%',
            );

echo form_textarea($data);
	?>
    
    </td>    
    
  </tr>  