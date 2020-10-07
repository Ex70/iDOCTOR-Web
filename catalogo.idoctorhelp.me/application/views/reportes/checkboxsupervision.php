
<?php echo form_open('reportes/supervision'); ?>

<h5 align="center">Supervisión General</h5>

<div class="row">
<div class="two columns">
<input type="checkbox" name="todos" value="todos" id="todos">  Marcar todos 
</div>
<div class="two columns">
<input type="checkbox" name="propias" value="todos" id="propias">      Propias 
</div>
<div class="three columns">
<input type="checkbox" name="gestionadas" value="todos" id="gestionadas">      Gestionadas
</div>
<div class="four columns"> 
<input type="checkbox" name="noGestionadas" value="todos" id="noGestionadas">      No gestionadas  
</div>
</div>
<br>

<div class="row">
<div class="three columns">
		<input type="checkbox" name="XA1" value="XA1">  Xalapa Animas(XA1)</br>
</div>
<div class="three columns">
        <input type="checkbox" name="XC1" value="XC1">  Xalapa Centro(XC1)</br>
</div>
<div class="three columns">
        <input type="checkbox" name="XU1" value="XU1">  Xalapa Urban(XU1)</br>
</div>
<div class="three columns">
        <input type="checkbox" name="CL1" value="CL1">  Córdoba Lomas(CL1)</br>
</div>
</div>

<div class="row">    
     <div class="three columns">
      <input type="checkbox" name="CZ1" value="CZ1">  Coatza Paraiso(CZ1)</br>
    </div>
     <div class="three columns">
       <input type="checkbox" name="OZ1" value="OZ1">  Orizaba Sora(OZ1)</br>
    </div>
     <div class="three columns">
        <input type="checkbox" name="VA1" value="VA1">  Veracruz Americas(VA1)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="MG1" value="MG1">  Mérida Plaza(MG1)</br>
    </div>
</div>
<div class="row">
    <div class="three columns">
        <input type="checkbox" name="CS1" value="CS1">  Culiacán Sendero(CS1)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="PR1" value="PR1">  Poza Rica(PR1)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="VM1" value="VM1">  Villa Morett(VM1)</br>
    </div>
    <div class="three columns">
      <input type="checkbox" name="VM2" value="VM2">  Villa Deportiva(VM2)</br>
    </div>
</div>

<div class="row">
    <div class="three columns">
        <input type="checkbox" name="TX1" value="TX1">  Tuxpan(TX1)</br>
    </div>
    <!--<div class="three columns">
        <input type="checkbox" name="PR1" value="PR1">  Poza Rica(PR1)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="VM1" value="VM1">  Villa Morett(VM1)</br>
    </div>
    <div class="three columns">
      <input type="checkbox" name="VM2" value="VM2">  Villa Deportiva(VM2)</br>
    </div>-->
</div>
<!--<div class="row">
    <div class="three columns">
        <input type="checkbox" name="MI2" value="MI2">  Xalapa Pruebas(MI2)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="PA1" value="PA1">  Puebla Animas(PA1)</br>
    </div>
    <div class="three columns">
        <input type="checkbox" name="VB1" value="VB1">  Veracruz Bolívar(VB1)</br>
    </div>
    <div class="six columns"></div>
   
</div>-->

<div class="row"></div>

<div class="row">
       <br> <center><button type="submit class="btn btn-primary" style="background-color:#047c79; color:#FFFFFF;">Descargar</button></center><br>
</div>

<script>
	$("#todos").change(function () {
	  $("input[name='VM1']").prop('checked', $(this).prop("checked"));
      $("input[name='VM2']").prop('checked', $(this).prop("checked"));
      $("input[name='CZ1']").prop('checked', $(this).prop("checked"));
      $("input[name='CL1']").prop('checked', $(this).prop("checked"));
      $("input[name='OZ1']").prop('checked', $(this).prop("checked"));
      $("input[name='VA1']").prop('checked', $(this).prop("checked"));
      $("input[name='XA1']").prop('checked', $(this).prop("checked"));
      $("input[name='XC1']").prop('checked', $(this).prop("checked"));
      $("input[name='XU1']").prop('checked', $(this).prop("checked"));
      $("input[name='PR1']").prop('checked', $(this).prop("checked"));
      $("input[name='MG1']").prop('checked', $(this).prop("checked"));
      $("input[name='CS1']").prop('checked', $(this).prop("checked"));
	  $("input[name='TX1']").prop('checked', $(this).prop("checked"));
  });
</script>

<script>
	$("#propias").change(function () {
      $("input[name='CZ1']").prop('checked', $(this).prop("checked"));
      $("input[name='CL1']").prop('checked', $(this).prop("checked"));
      $("input[name='OZ1']").prop('checked', $(this).prop("checked"));
      $("input[name='VA1']").prop('checked', $(this).prop("checked"));
      $("input[name='XA1']").prop('checked', $(this).prop("checked"));
      $("input[name='XC1']").prop('checked', $(this).prop("checked"));
      $("input[name='XU1']").prop('checked', $(this).prop("checked"));
  });

	$("#gestionadas").change(function () {
      $("input[name='PR1']").prop('checked', $(this).prop("checked"));
      $("input[name='MG1']").prop('checked', $(this).prop("checked"));
      $("input[name='CS1']").prop('checked', $(this).prop("checked"));
	  $("input[name='TX1']").prop('checked', $(this).prop("checked"));
  });

	$("#noGestionadas").change(function () {
      $("input[name='VM1']").prop('checked', $(this).prop("checked"));
      $("input[name='VM2']").prop('checked', $(this).prop("checked"));
  });
</script>

