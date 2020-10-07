<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paquetes extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
		//	$this->output->enable_profiler(TRUE);
           
       }	 



	 
	public function index()
	{		
		$this->load->model("Paquetesmodel");
        
	

		if ($this->uri->segment(3,'')!="") 
			$wh = array("clase like"=>$this->uri->segment(3) . "%");

		if (($this->uri->segment(4,'')!="") && ($this->uri->segment(4,'')!='undefined'))
			$wh['paquete'] = $this->uri->segment(4);

		if (!isset($wh))
			$wh = "";

		$paquetes = $this->Paquetesmodel->get_paquetes($wh);
	    $data['result'] = $paquetes;
	    $data['superclases'] = $this->Paquetesmodel->get_superclases();
	    $data['paquetes'] = $this->Paquetesmodel->get_paquetes_dropdown();
 		

		$this->load->view('inicio/top1'); 
		$this->load->view('paquetes/paquetesindex',$data); 
		$this->load->view('inicio/bottom1'); 
		 
		
	}
	
	
	public function agregar() {


		$this->load->model("Paquetesmodel");
		$this->load->model("Clasesmodel");
		$this->load->model("Serviciosmodel");
		$clases = $this->Clasesmodel->get_clases_dropdown();
		$paquetes = $this->Paquetesmodel->get_paquetes_dropdown();
		unset($paquetes[""]);

		$registro = $this->Paquetesmodel->get_campos();
        $registro['clases'] = $clases;
        $registro['servicios'] = $this->Serviciosmodel->get_servicios_dd_clase('IMAC');
        $registro['paquetes'] = $paquetes;


		
		$this->load->view('inicio/top1');
		$this->load->view('paquetes/detalle',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {

		$this->load->model("Paquetesmodel");
		$this->load->model("Clasesmodel");
		$this->load->model("Serviciosmodel");
		$paquetes = $this->Paquetesmodel->get_paquetes_dropdown();
		unset($paquetes[""]);

		$registro = $this->Paquetesmodel->get_detalle($this->uri->segment(3));

		$registro['clases'] = $this->Clasesmodel->get_clases_dropdown();
		$registro['servicios'] = $this->Serviciosmodel->get_servicios_dd_clase('IMAC');
        $registro['paquetes'] = $paquetes;

	
		
	
		
		$this->load->view('inicio/top1');
		$this->load->view('paquetes/detalle',$registro); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	
	
	public function guardar() {
     	$this->load->model("Paquetesmodel");

     	$this->Paquetesmodel->guardar($_POST);

     	if ($_POST['id']!="")
		 redirect('/paquetes/modificar/' . $_POST["id"]);
		else
		  redirect('/paquetes/index'); 
		
	}	
	
public function eliminar() {
     	$this->load->model("Paquetesmodel");
        $this->Paquetesmodel->eliminar($this->uri->segment(3));

		 redirect('/paquetes/'); 
	}	
	
	
	

	
}

