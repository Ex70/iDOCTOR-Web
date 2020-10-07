<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportesadministracion extends CI_Controller {


    public function __construct()
       {
            parent::__construct();

	   
       }	 


private function _cambiaf_a_normal($fecha){ 
  
   	//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
   	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
   	return $lafecha; 
} 	   


public function index() {
  echo "aaa";
}
	          

public function listadoremisiones() {
       $this->load->model("Movimientosmodel");

       if ($this->uri->segment(4,'')=='') {
          redirect('reportesadministracion/listadoremisiones/' . date("Y") . "/" . date("n") . "/XA1");
       }

      $sucursal = $this->uri->segment(5);

          $mpm = $this->Movimientosmodel->get_movimientos_por_mes($sucursal,$this->uri->segment(3),$this->uri->segment(4));
        
       $data = array();
       $data['movimientos'] = $mpm;
       $data['sucursales'] = sucursales_nombres_dd();

 
    $this->load->view('inicio/top1'); 
       $this->load->view("movimientos/listadomovimientos",$data); 
    $this->load->view('inicio/bottom1');        
}


public function entradassalidaspormes() {
       $this->load->model("Movimientosmodel");

       if ($this->uri->segment(4,'')=='') {
          redirect('reportesadministracion/entradassalidaspormes/' . date("Y") . "/" . date("n") . "/XA1");
       }

      $sucursal = $this->uri->segment(6);

          $mpm = $this->Movimientosmodel->get_entradas_salidas_por_mes($sucursal,$this->uri->segment(3),$this->uri->segment(4));
        
       $data = array();
       $data['movimientos'] = $mpm;
       $data['sucursales'] = sucursales_nombres_dd();

 
    $this->load->view('inicio/top1'); 
       $this->load->view("movimientos/entradassalidaspormes",$data); 
    $this->load->view('inicio/bottom1');        
}



}       