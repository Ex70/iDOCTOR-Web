<script language="javascript">
$('#titulo').html('Detalle de Corte de Caja');
</script>
<?php $this->load->helper('form'); 
 ?>
<?php echo form_open('cortescajas/guardar'); 
      echo form_hidden("id",$id);
?>
<div align="center" style="height:600px;">
<table style="width:500px;border: 0.5px solid;">
<tr><td colspan="2" align="center" style="font-size:1.4em;height:50px">Corte de caja</td></tr>
<tr>
	<td>Fecha:</td>
	<td><?php $d = array("name"=>"fecha","value"=>$fecha,"class"=>"date-pick");
	         echo form_input($d);
	     ?>
</tr>	     
<tr>
	<td>Hora:</td>
	<td><?php $d = array("name"=>"hora","value"=>$hora);
	         echo form_input($d);
	     ?>
</tr>	     

<tr>
	<td>Saldo inicial:</td>
	<td><?php 
	     $d = array("name"=>"saldo_inicial","id"=>"saldoinicial","value"=>$saldo_inicial,"class"=>"cal");
	         echo form_input($d);
	     ?>
</tr>	     

<tr>
	<td>Turno n&uacute;mero:</td>
	<td><?php 
	         echo form_dropdown("turno",array("1"=>"1","2"=>"2"),$turno);
	     ?>
</tr>	     


<tr><td colspan="2" style="text-align:center"><b>Billetes</b></td></tr>
<tr><td colspan="2">
<table style="width:100%;border-style:solid;border-width:1px">
	<tr>
		<td width="20%">500</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"bil_500","value"=>$bil_500,"id"=>"b500","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="b500tot"></div></td>

	</tr>

	<tr>
		<td width="20%">200</td>
		<td width="20%">X</td>
		<td width="30%"><?php 
		    $d = array("name"=>"bil_200","value"=>$bil_200,"id"=>"b200","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="b200tot"></div></td>
	</tr>	

	<tr>
		<td width="20%">100</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"bil_100","value"=>$bil_100,"id"=>"b100","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="b100tot"></div></td>
    </tr>

	<tr>
		<td width="20%">50</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"bil_50","value"=>$bil_50,"id"=>"b50","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="b50tot"></div></td>
    </tr>

	<tr>
		<td width="20%">20</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"bil_20","value"=>$bil_20,"id"=>"b20","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="b20tot"></div></td>
    </tr>

</table>		

</td></tr>


<tr><td colspan="2" style="text-align:center"><b>Monedas</b></td></tr>
<tr><td colspan="2">
<table style="width:100%;border-style:solid;border-width:1px">
	<tr>
		<td width="20%">10</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_10","value"=>$mon_10,"id"=>"m10","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m10tot"></div></td>

	</tr>

	<tr>
		<td width="20%">5</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_5","value"=>$mon_5,"id"=>"m5","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m5tot"></div></td>

	</tr>

	<tr>
		<td width="20%">2</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_2","value"=>$mon_2,"id"=>"m2","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m2tot"></div></td>

	</tr>

	<tr>
		<td width="20%">1</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_1","value"=>$mon_1,"id"=>"m1","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m1tot"></div></td>

	</tr>

	<tr>
		<td width="20%">0.5</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_0_5","value"=>$mon_0_5,"id"=>"m05","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m05tot"></div></td>

	</tr>


	<tr>
		<td width="20%">0.2</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_0_2","value"=>$mon_0_2,"id"=>"m02","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m02tot"></div></td>

	</tr>

	<tr>
		<td width="20%">0.1</td>
		<td width="20%">X</td>

		<td width="30%"><?php 
		    $d = array("name"=>"mon_0_1","value"=>$mon_0_1,"id"=>"m01","class"=>"cal");
		   echo form_input($d); ?></td>
		<td width="30%" style="text-align:right"><div id="m01tot"></div></td>

	</tr>


</table>		

</td></tr>


<tr><td colspan="2" style="text-align:center"><b>Saldo en caja (f&iacute;sico)</b></td></tr>
<tr><td colspan="2">
<table style="width:100%;border-style:solid;border-width:1px">
	<tr>
		<td width="20%"></td>
		<td width="20%"></td>

		<td width="30%">Saldo en caja</td>
		<td width="30%" style="text-align:right"><div id="scf"></div></td>

	</tr>
</table>
</td></tr>

<tr>
	<td>Notas:</td>
	<td><?php 
	         $d = array("name"=>"notas","value"=>$notas,"id"=>"notas","class"=>"cal");
	         echo form_input($d);
	     ?>
</tr>	     

<tr>
	<td>Comprobante de gastos:</td>
	<td><?php 
	         $d = array("name"=>"comprobante_de_gastos","value"=>$comprobante_de_gastos,
	         	        "id"=>"comprobantedegastos","class"=>"cal");
	         echo form_input($d);
	     ?>
</tr>	     

<tr>
	<td>Vales de caja:</td>
	<td><?php 
	         $d = array("name"=>"vales_caja","value"=>$vales_caja,"id"=>"valescaja","class"=>"cal");
	         echo form_input($d);
	     ?>
</tr>	     
	
<tr>
	<td>Saldo en caja (comprobaci&oacute;n):</td>
	<td><?php 

	        $d = array("style"=>"display:none","name"=>"saldo_en_caja_comprobacion","value"=>$saldo_en_caja_comprobacion,
	        	   "id"=>"saldoencajacomprobacion");
	         echo form_input($d);

	     ?><div id="divsaldoencajacomprobacion"></div>
</tr>	     

</table>			




<tr><td colspan="2" align="center"><div class="demo"><?php 
     echo form_submit("enviar","Enviar");
?></div></td></tr>
</table>
</div>
<?php echo form_close(); ?>

<script language="javascript">
function calcular() {
	b500 = $("#b500").val() * 500;
  $("#b500tot").html(b500.toFixed(2));
    b200 = $("#b200").val() * 200;
  $("#b200tot").html(b200.toFixed(2));
    b100 = $("#b100").val() * 100;
  $("#b100tot").html(b100.toFixed(2));
    b50  = $("#b50").val() * 50;
  $("#b50tot").html(b50.toFixed(2));
    b20  = $("#b20").val() * 20;
  $("#b20tot").html(b20.toFixed(2));
    m10  = $("#m10").val() * 10;
  $("#m10tot").html(m10.toFixed(2));
    m5   = $("#m5").val() * 5;
  $("#m5tot").html(m5.toFixed(2));
    m2   = $("#m2").val() * 2;
  $("#m2tot").html(m2.toFixed(2));
    m1   = $("#m1").val() * 1;
  $("#m1tot").html(m1.toFixed(2));
    m05  = $("#m05").val() * 0.5;
  $("#m05tot").html(m05.toFixed(2));
    m02  = $("#m02").val() * 0.2;
  $("#m02tot").html(m02.toFixed(2));
    m01  = $("#m01").val() * 0.1;
  $("#m01tot").html(m01.toFixed(2));

  scf = ($("#b500").val() * 500) +
  		($("#b200").val() * 200) +
  		($("#b100").val() * 100) +
  		($("#b50").val() * 50)   +
  		($("#b20").val() * 20)   +
  		($("#m10").val() * 10) +
  		($("#m5").val() * 5)     +
  		($("#m2").val() * 2)     +
  		($("#m1").val() * 1)     +
  		($("#m05").val() * 0.5)     +
  		($("#m02").val() * 0.2)     +
  		($("#m01").val() * 0.1);
//  alert(scf);
  
  $("#scf").html(scf.toFixed(2));
  ncv = (($("#notas").val() * 1) + ($("#comprobantedegastos").val() * 1) + ($("#valescaja").val() * 1));
  scc = ($("#saldoinicial").val() * 1) - ncv;
  $("#saldoencajacomprobacion").val(scc);
  $("#divsaldoencajacomprobacion").html(scc.toFixed(2));

  

  }


  $(function() {
       $('.cal').change(function() {
       	  calcular();
        });  
        calcular();
   });

 </script>
