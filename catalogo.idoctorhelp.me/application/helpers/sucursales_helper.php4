<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('sucursales_con_indices'))
{

function sucursales_con_indices(){
    $bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"CAT");
    return $bases;
}
}


if ( ! function_exists('sucursales_catalogo_con_indices'))
{
function sucursales_catalogo_con_indices(){
    $bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"CAT");
    return $bases;
}
}

if ( ! function_exists('sucursales_nombres_dd'))
{
function sucursales_nombres_dd(){
    $bases=array("XA1"=>"Xalapa Animas"
    	  ,"XC1"=>"Xalapa Centro"
    	  ,"XU1"=>"Xalapa Urban"
    	  ,"CL1"=>"Córdoba Lomas"
		  ,"OZ1"=>"Orizaba Sur 17"
    	  ,"VM1"=>"Villahermosa Morett"
    	  ,"VA1"=>"Veracruz Americas"
    	  ,"VB1"=>"Veracruz Bolívar"
    	  ,"PA1"=>"Puebla Animas"
		  ,"PR1"=>"Poza Rica");
        return $bases;

}
}

?>

