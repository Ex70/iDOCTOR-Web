<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comunicaciones extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
		

	public function agregaraequipo() {

		$this->load->model("Clientesmodel");
		
        $data = array("id"=>"","fecha"=>date("Y-m-d"),"asunto"=>"","notas"=>"","usuario_id"=>$this->session->userdata('usuario_id'));

        $cliente = $this->Clientesmodel->get_cliente_de_equipo($this->uri->segment(3));

		//$cliente = $this->Clientesmodel->get_detalle($equipo['cliente_id']);

		$data['cliente'] = $cliente;

        $this->load->view('inicio/top_single1');
		$this->load->view('comunicaciones/agregarcomunicacionaequipo',$data); 
		$this->load->view('inicio/bottom_single1');
		
	}	
	
	public function guardaraequipo() {
		
		$accion = $_POST['accion'];
		
        unset($_POST['accion']);
	    unset($_POST['passwd']);
		unset($_POST['submit']);
		
		$_POST['fecha'] = date('Y-m-d');
		
//		print_r($_POST); die();
		if ($accion=="i") {
		   $this->db->insert('comunicaciones',$_POST);
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "AGREGAR",
			                 "tabla"   => "comunicaciones",
			                 "detalle" => " Equipo: " . $_POST['equipo_id']);
		    $this->db->insert('registroacciones',$registroacc);  
		   
		   
		  $this->load->view('inicio/top_single1');
		  $this->load->view('comun/cerrartop'); 
		  $this->load->view('inicio/bottom_single1');
		}
	}	
	
	
	public function eliminardeequipo() {	
		$arr =  $this->db->query('delete from comunicaciones where id=' . $this->uri->segment(3));
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "comunicaciones",
			                 "detalle" => $this->uri->segment(3));
		    $this->db->insert('registroacciones',$registroacc);
		    
         $this->load->view('top_single');
	  	 $this->load->view('comun/cerrartop'); $this->load->view('inicio/bottom1');
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */