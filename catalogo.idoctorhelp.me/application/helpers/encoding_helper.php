<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('encodeToUtf8'))
{
    function encodeToUtf8($string) {
     return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "UTF-8, ISO-8859-1, ISO-8859-15", true));
}
}

if ( ! function_exists('substitute_encoding')) 
{
	function substitute_encoding($string) {
		 $desc = $string;

		$desc = str_replace('í¡', 'á', $desc);
		$desc = str_replace('í³', 'ó', $desc);
		$desc = str_replace('Ã±', 'ñ', $desc);
		$desc = str_replace('í±', 'ñ', $desc);		
		
		$desc = str_replace('Ã¡','á',$desc);
		$desc = str_replace('â','',$desc);
		$desc = str_replace('í©','é',$desc);
	    $desc = str_replace('Ã', 'í', $desc);
		return $desc;
	}
}


?>