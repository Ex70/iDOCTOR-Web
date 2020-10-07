<?php
 if ($this->session->userdata('session_id')===FALSE) 
      redirect('/');
	   //echo 
 if ($this->session->userdata('username')=="")
      redirect('/');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>iHelp - iDoctor<?php if ($this->session->userdata('sucursal')!="") {
	echo " - " . $this->session->userdata('sucursal');
}?></title>

<link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700|Titillium+Web:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="/css/normalize.css">
<link rel="stylesheet" href="/css/skeleton.css">
<LINK REL=StyleSheet HREF="/css/style1.css" TYPE="text/css">
	
<LINK REL=StyleSheet HREF="/js/datePicker.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/css/cupertino/jquery-ui.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/css/themes/cupertino/jquery.ui.all.css" TYPE="text/css">

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.css">	
	
	

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>

<!-- required plugins -->
<script type="text/javascript" src="/js/date.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="/js/jquery.dataTables.js"></script>
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="/js/jquery.datePicker.js"></script>
<script type="text/javascript" src="/js/thickbox.js"></script>
<link rel="stylesheet" href="/js/thickbox.css" type="text/css" media="screen" />
<link rel="stylesheet" href="/css/dropdown-menu.css" />
<script type="text/javascript" src="/js/dropdown-menu.min.js"></script>

<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('.date-pick').datePicker({startDate:'1996-01-01',autoFocusNextInput:true});
				$( "input:submit", ".demo" ).button();
				$( "input:button,a", ".demo" ).button();
				 $('.dropdown-menu').dropdown_menu();	

            });
		</script>
</head>
<body>
<div class="container">

<div class="row">



<div class="three columns">
<a href="/index.php/inicio/iniciar"><img border="0" src="/images/idoctor.png"></a>
</div>
<div class="six columns" align="center">
	<h5>Módulo de Catálogos y Administración</h5>
</div>
<div class="three columns" align="right">
<a href="/index.php/inicio/iniciar"><img border="0" src="/images/ihelp.png"></a>
</div>

</div>
<div class="row" style="height:34px"></div>

	

<div class="row">

		<ul class="dropdown-menu" id="divmenu">
		<li><a href="/index.php/inicio/iniciar" title="Inicio"><img src="/images/ico_mnu_home.jpg"><span class='mnuNav1'>Home</a></a>
			<ul class="navigation-2">
				<li><a href="/index.php/inicio/terminar" title="Agregar orden">Terminar sesi&oacute;n</a></li>
			</ul>
		</li>
		<li><a href="#" title="Cat&aacute;logos"><img src="/images/ico_mnu_servicios.jpg"><span class='mnuNav1'>Catálogos</span></a>
			<ul class="navigation-2">
			    <li><a href="/index.php/clases" title="Clases">Lista de Clases</a></li>
			    <li><a href="/index.php/tipos" title="Tipos y subtipos">Lista de tipos</a></li>				
				<li><a href="/index.php/servicios" title="Lista de precios de servicios">Lista de precios</a></li>
				<li><a href="/index.php/piezas" title="Precios de refacciones (piezas)">Precios de refacciones</a></li>
			    <li><a href="/index.php/articulos" title="Lista de precios de art&iacute;culos">Lista de art&iacute;culos</a></li>
			    <li><a href="/index.php/paquetes" title="Lista de precios de paquetes">Lista de paquetes</a></li>
			    <li><a href="/index.php/usuarios" title="Usuarios">Lista de usuarios de todas las sucursales</a></li>

			</ul>
		</li>
		<li><a href="#" title="Reportes del sistema"><img src="/images/ico_mnu_reportes.jpg"><span class='mnuNav1'>Reportes</span></a>
			<ul>
					 	<li ><a href="/index.php/reportesadministracion/listadoremisiones" title="Reporte de remisiones">Remisiones por fechas</a></li>

				<li><a href="/index.php/reportesadministracion/entradassalidaspormes" title="Entradas y salidas por mes">Reporte de entradas y salidas por mes</a></li>
				<li><a href="/index.php/reportes/cierredemes" title="Entradas y salidas por mes">Reportes de cierre de mes</a></li>
				<?php if (FALSE) { ?>
				<li><a href="/index.php/reportes/ordenesentregadasporfecha" title="Reporte de equipos entregados por rango de fechas">Equipos entregados</a></li>
				<li><a href="/index.php/equipos/reporteequiposenempresa" title="Equipos en la empresa">Equipos en la empresa</a></li>
				<li><a href="/index.php/piezas/usadaspordia" title="Reporte de piezas por dia">Piezas por d&iacute;a</a></li>
				<li><a href="/index.php/reportes/exportarequipos" title="Equipos por mes a Excel">Exportaci&oacute;n a Excel</a></li>
				<li><a href="/index.php/reportes/reporteequipospordia" title="Equipos por d&iacute;a">Eq. recibidos y entregados</a></li>
				<?php } ?>

            </ul>
         </li>			
	</ul>
</div>
<div class="row" style="height:34px"></div>
  


