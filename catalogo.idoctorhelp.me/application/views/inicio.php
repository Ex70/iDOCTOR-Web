<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>iHelp - iDoctor</title>
<LINK REL=StyleSheet HREF="/style1.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/menu_style.css" TYPE="text/css">
	
<LINK REL=StyleSheet HREF="/js/datePicker.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/css/cupertino/jquery-ui.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/css/themes/cupertino/jquery.ui.all.css" TYPE="text/css">
<link rel="stylesheet" href="/css/normalize.css">
<link rel="stylesheet" href="/css/skeleton.css">	
	

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>

<!-- required plugins -->
<script type="text/javascript" src="/js/date.js"></script>
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="/js/jquery.datePicker.js"></script>
<script type="text/javascript" src="/js/thickbox.js"></script>
<link rel="stylesheet" href="/js/thickbox.css" type="text/css" media="screen" />
<link href='http://fonts.googleapis.com/css?family=Quattrocento+Sans:400,700|Titillium+Web:400,700' rel='stylesheet' type='text/css'>

<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('.date-pick').datePicker({startDate:'1996-01-01',autoFocusNextInput:true});
				$( "input:submit", ".demo" ).button();
				$( "input:button", ".demo" ).button();
		       
            });
		</script>
</head>
<body>

<div class="row" align="center"><img border="0" src="/images/ihelp.png"></div>


<div>

<?php echo form_open('inicio/valida'); ?>
 <div style="height:30px"></div>
  	<div class="row" align="center"><h3>Módulo de Catálogos y Administración</h3></div><!--- row -->

    <div class="row">
      <div class="six columns" align="right">Usuario:</div>
      <div class="six columns"><?php echo form_input("usuario",""); ?></div>
      </div><!--- row -->
    <div class="row">
      <div class="six columns"  align="right">Contraseña:</div>
      <div class="six columns"><?php echo form_password("passwd",""); ?></div>
      </div><!--- row -->
    <div class="row">
      <div class="six columns">&nbsp;</div>
      <div class="six columns">&nbsp;</div>
      </div><!--- row -->
    <div class="row">
      <div align="center"><?php echo form_submit("submit","Enviar","class='button button-primary'"); ?></div>
      </div><!--- row -->
     

  
<?php echo form_close(); 

?>
</div>

</body>
</html>