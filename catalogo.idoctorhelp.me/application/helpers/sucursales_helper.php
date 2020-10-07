<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('sucursales_con_indices'))
{

function sucursales_con_indices(){
    //$bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"CAT");
    $bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"MI2",11=>"CAT",12=>"MG1",13=>"CS1",14=>"CQ1",15=>"TX1");
    return $bases;
}
}


if ( ! function_exists('sucursales_catalogo_con_indices'))
{
function sucursales_catalogo_con_indices(){
    //$bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"CAT");
    $bases=array(0=>"XA1",1=>"XC1",2=>"XU1",3=>"CL1",4=>"OZ1",5=>"VM1",6=>"VA1",7=>"VB1",8=>"PA1",9=>"PR1",10=>"MI2",11=>"CAT",12=>"MG1",13=>"CS1",14=>"CQ1",15=>"TX1");
    return $bases;
}
}

if ( ! function_exists('sucursales_nombres_dd'))
{
function sucursales_nombres_dd(){
    $bases=array("XA1"=>"Xalapa Animas"
    	  ,"XC1"=>"Xalapa Centro"
    	  ,"XU1"=>"Xalapa Araucarias"
    	  ,"CL1"=>"Córdoba Lomas"
		  ,"OZ1"=>"Orizaba Sora"
    	  ,"CZ1"=>"Coatza Paraiso"
		  ,"VA1"=>"Veracruz Americas"
    	  ,"VM1"=>"Villahermosa Morett"
		  ,"VM2"=>"Villahermosa Deportiva"
    	  ,"PR1"=>"Poza Rica"
          ,"TX1"=>"Tuxpan"
          ,"CS1"=>"Culiacán Sendero"
		  ,"CQ1"=>"Culiacán Las Quintas"
		  ,"MG1"=>"Mérida Gran Plaza"
          ,"PA1"=>"Puebla Animas"
		  ,"VB1"=>"Veracruz Bolívar"
    	  ,"MI2"=>"Xalapa Pruebas");
        return $bases;

}
}

?>

