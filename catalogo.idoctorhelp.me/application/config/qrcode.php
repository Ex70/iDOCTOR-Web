<?php

/************************************************************
 * QRCode - CodeIgniter Integration
 * Configuration file
 * ----------------------------------------------------------
 * @author bumfank - Jarosław Kamiński http://jaroslawkaminski.pl
 * @version 1.0
 * @package qrcode_ci
 ***********************************************************/


/***************************************************************************
 * PATH CONFIGURATION PARAMETERS
 **************************************************************************/



	
	$qrcode['base_directory'] = APPPATH.'third_party/phpqrcode';

	$qrcode['base_url'] = 'http://localhost/';
	//$qrcode['PNG_TEMP_DIR'] = $qrcode['base_directory'].'/cache/';
	$qrcode['PNG_TEMP_DIR'] = APPPATH . "../images/qr/";
	$qrcode['PNG_WEB_DIR'] = '/images/qr/';
 	$qrcode['errorCorrectionLevel'] = 'H';
	$qrcode['matrixPointSize'] = '5';