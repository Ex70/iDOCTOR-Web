<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Solicitudescompras extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{		
	
        $wh = "";	
		
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_categoria'])) && ($_POST['busca_categoria']!="")) 
				  $wh .= " and (categoria like '%" . $_POST['busca_categoria'] . "%')";				 
				 		
			  
		}	

			
	
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
		$arr = ( $this->db->query('select * from solicitudescompras ' . $wh . ' limit ' . $lim . ',20'));
	    $data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/solicitudescompras/index';
		$arrtot = ( $this->db->query('select * from solicitudescompras'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 20; 
		$this->pagination->initialize($config); $this->load->view('inicio/top1'); 
		 //$this->load->view('inicio/menuinterior');
		 $this->load->view('solicitudescompras/solicitudesindex',$data); 
		 $this->load->view('inicio/bottom1'); 
	}
	
	
	public function piezasjson()
	{		
        
		//if (isset($_REQUEST['tipo']) && ($_REQUEST['tipo']!=""))
		if ($this->uri->segment(3,'')!="")
			  $wh = " where tipo='" . $this->uri->segment(3,'') . "'";
	    else  $wh = "";
		$arr =  $this->db->query("select * from catpiezas" . $wh);
	    $data['result'] = ($arr->result_array());

		$this->load->view('piezas/piezasjson',$data); 
	}	
	
	public function agregar() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	
		
		
		$registro = array(
							 "id"=>"",
							 "nombre"=>"",
							 "categoria"=>"",
							 "asunto"=>"",
							 "telefono"=>"",
							 "correo_electronico"=>"",
							 "checado"=>"N"
							 );
		
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('solicitudescompras/detallesolicitud',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
       //echo  $this->uri->segment(3);
		
        $arr =  $this->db->query("select * from solicitudescompras where id='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());
		$registro = array();
		$registro = $data[0];

		$this->load->view('inicio/top1');
		 //$this->load->view('inicio/menuinterior');
		$this->load->view('solicitudescompras/detallesolicitud',$registro); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	
	
	public function guardar() {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
        // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "NUEVO",
			                 "tabla"   => "solicitudescompras",
			                 "detalle" => $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);				
			
			
		   $this->db->insert('solicitudescompras',$_POST);
		   redirect('/solicitudescompras/'); 
		}
		else {
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('solicitudescompras', $_POST);
        // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "solicitudescompras",
			                 "detalle" => "ID: " . $_POST['id'] . " " . $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		   redirect('/solicitudescompras/modificar/' . $_POST["id"]); 
		}
		
	}	
	
public function eliminar() {
      	$this->db->query("delete from solicitudescompras where id='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "solicitudescompras",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/solicitudescompras/'); 
	}
	
	
	public function agregaraequipo() {
      
		
		$arr = ( $this->db->query('select * from catpiezas'));
	    $data['result'] = ($arr->result_array());
		
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}	
		
		$data['tipos'] = $tip;		
		
		$arreq =  $this->db->query('select tipo from equipos where id=' . $this->uri->segment(3));
	    $eq = ($arreq->result_array());	
		
		$data['tipo'] = $eq[0]['tipo'];
		

        //$data['pieza_id'] =  $this->uri->segment(3);
        $this->load->view('top_single');
		$this->load->view('piezas/agregarpiezaaequipo',$data); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */