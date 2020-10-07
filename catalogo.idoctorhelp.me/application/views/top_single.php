<?php
 if ($this->session->userdata('session_id')===FALSE) 
       die();
	   //echo 
 if ($this->session->userdata('username')=="")
       die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HIPODS</title>
<LINK REL=StyleSheet HREF="/style1.css" TYPE="text/css">
<LINK REL=StyleSheet HREF="/js/datePicker.css" TYPE="text/css">

<!-- jQuery -->
<script type="text/javascript" src="/js/jquery.min.js"></script>

<!-- required plugins -->
<script type="text/javascript" src="/js/date.js"></script>
<!--[if IE]><script type="text/javascript" src="scripts/jquery.bgiframe.js"></script><![endif]-->

<!-- jquery.datePicker.js -->
<script type="text/javascript" src="/js/jquery.datePicker.js"></script>
<script type="text/javascript" src="/js/thickbox.js"></script>
<link rel="stylesheet" href="/js/thickbox.css" type="text/css" media="screen" />

<script type="text/javascript" charset="utf-8">
            $(function()
            {
				$('.date-pick').datePicker({autoFocusNextInput: true});
            });
		</script>
</head>
<body>
