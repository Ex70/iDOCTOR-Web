<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clases extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{
		
		$this->load->model("Clasesmodel");
		

        $data['clases'] = $this->Clasesmodel->get();

	     $this->load->view('inicio/top1'); 
		 $this->load->view('clases/index',$data); 
		 $this->load->view('inicio/bottom1'); 
  	 
		
	}
	
	public function agregar() {

		$registro = array(
							 "clase"=>"",
							 "descripcion"=>""

							 );
							 		
		
        $this->load->view('inicio/top1');
		$this->load->view('clases/detalle',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
        $this->load->model('Clasesmodel');


	    $registro = $this->Clasesmodel->get_detalle($this->uri->segment(3));

		
		$registro['clases'] = $registro;							 
	
        $this->load->view('inicio/top1');
		$this->load->view('clases/detalle',$registro); 
		$this->load->view('inicio/bottom1');				
	}	
	
	
	
	public function guardar() {
		$this->load->model('Clasesmodel');
        $this->Clasesmodel->guardar($_POST);
		redirect("clases/modificar/" . $_POST['clase']);
		
	}	



public function eliminar() {
	    $this->load->model("Registroaccionesmodel");
        $this->load->model("Clasesmodel");
        $this->Clasesmodel->eliminar_servicio($this->uri->segment(3));

		   $this->Registroaccionesmodel->registrar("ELIMINADO","catservicios","ID: " . $this->uri->segment(3));

		 
		 redirect('/servicios/'); 
	}

	
	

	
}

