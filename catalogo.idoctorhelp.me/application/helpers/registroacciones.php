<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registroacciones extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{
		$busca_nombre = "";
        $wh = "";	
		
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_descripcion'])) && ($_POST['busca_descripcion']!="")) 
				  $wh .= " and (descripcion like '" . $_POST['busca_descripcion'] . "%')";				 
				 		
			  
		}	

		
		
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
		$arr = ( $this->db->query('select * from registroacciones ' . $wh . ' order by fecha_hora desc limit ' . $lim . ',20'));
	    $data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/registroacciones/index';
		$arrtot = ( $this->db->query('select * from registroacciones'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 20; 
		$this->pagination->initialize($config);		
		
		
         $this->load->view('inicio/top1'); 
		// $this->load->view('inicio/menuinterior');
		 $this->load->view('registroacciones/registroindex',$data); 
		 $this->load->view('inicio/bottom1'); 
		 
		
	}
	
	


public function eliminar() {
    
     if ($this->session->userdata('nivel')==1) {
     	$this->db->query("delete from registroacciones where id='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "registroacciones",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/registroacciones/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el servicio. No tienes el nivel de usuario 1.",
	 	  "url"=>"/index.php/registroacciones");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
		 	
	 	
	 }
	}
	


	
}

