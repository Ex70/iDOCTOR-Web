<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('fecha_actual_mysql'))
{
    function fecha_actual_mysql()
    {
    	//$fa = date("Y-m-d");
    	$fa = date("Y-m-d", strtotime());
        return $fa;
    }   

}


if ( ! function_exists('hora_actual_mysql'))
{

    function hora_actual_mysql() {
    	$ha = date("H:i:s", strtotime());
    	//$ha = date("h:i:s");
    	return $ha;
    }

}


if ( ! function_exists('fecha_hora_actual_mysql'))
{

    function fecha_hora_actual_mysql() {
        $ha = date("Y-m-d H:i:s", strtotime());
        //$ha = date("Y-m-d h:i:s");
        return $ha;
    }

}


if ( ! function_exists('cambiaf_a_normal'))
{
    function cambiaf_a_normal($fecha){ 
       //ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
       preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
       $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
       return $lafecha; 
    }      
}


if ( ! function_exists('meses_array'))
{
    function meses_array() {
                 $meses = array(1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',
                        7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre');
        return $meses;
    }

}


if ( ! function_exists('anios_array'))
{
    function anios_array($anio_min,$anio_max) {
        $anios = array();
        for ($i=$anio_min;$i<=$anio_max;$i++) {
            $anios[$i] = $i;
        }
               
        return $anios;
    }

}


?>
