<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subtipos extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{		
		
		$arr = ( $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'"));
	    $data['result'] = ($arr->result_array());
		
		$data['tipo'] = $this->uri->segment(3,'0');
		 
		$this->load->view('inicio/top1'); 
		$this->load->view('subtipos/subtiposindex',$data); 
		$this->load->view('inicio/bottom1'); 
		 
		
	}
	
	public function subtiposjson()
	{		
        
		
		$arr =  $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'");
	    $data['result'] = ($arr->result_array());
		



		 $this->load->view('tipos/subtiposjson',$data); 
	 
		
	}	
	
	public function agregar() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	
		
		
		$registro = array(
		                     "id" => "",
							 "tipo"=>  $this->uri->segment(3,"") ,
							
							 "capacidad"=>""
						
							 );
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}	
		
		$registro['tipos'] = $tip; 
		
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('subtipos/detallesubtipo',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
       //echo  $this->uri->segment(3);
		
        $arr =  $this->db->query("select * from subtipos where id='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());
		$registro = array();
		$registro = $data[0];
		
	
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('subtipos/detallesubtipo',$registro); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	
	
	public function guardar() {
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   $this->db->insert('subtipos',$_POST);
		   redirect('/tipos/modificar/' . $_POST['tipo']); 
		}
		else {
			unset($_POST['tipo']);
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('subtipos', $_POST);
		// print_r($_POST); die();
		//echo $this->db->last_query(); die();
		   redirect('/subtipos/modificar/' . $_POST["id"]); 
		}
		// PARA ACTUALIZAR: $this->db->update('mytable', $data); 
		
	}	
	
public function eliminar() {
     $arr = ( $this->db->query("select * from equipos where tipo='" . $this->uri->segment(3) . "' and capacidad='" . $this->uri->segment(4) . "'"));
     if ($arr->num_rows==0) {
		$this->db->query("delete from subtipos where tipo='" . $this->uri->segment(3) . "' and capacidad='" . $this->uri->segment(4) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "subtipos",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/tipos/modificar/' . $this->uri->segment(3)); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el subtipo. Existen equipos registrados de esta capacidad.",
	 	  "url"=>"/index.php/inicio/administracion");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
	 }
	}		
	
	public function agregaraequipo() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	
		
		
		/*$registro = array(
							 "id"=>"",
							
							 "descripcion_"=>"",
							 "cant_nuevas"=>"0",
							 "cant_usadas"=>"0",
							 "tipo"=>""
							 );*/
		
		$arr = ( $this->db->query('select * from catpiezas'));
	    $data['result'] = ($arr->result_array());
		
		
        $arrt = ( $this->db->query('select * from tipos'));
        $tipos = ($arrt->result_array());		
		
		$tip = array();
		foreach ($tipos as $tipo) {
			$tip[$tipo["tipo"]] = $tipo["descripcion"];
		}	
		
		$data['tipos'] = $tip;		
		


        $this->load->view('top_single');
		$this->load->view('piezas/agregarpiezaaequipo',$data); //,$registro $this->load->view('inicio/bottom1');
		
	}	
	
	public function guardaraequipo() {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		
		unset($_POST['submit']);
		unset($_POST['tipo']);
		$accion = $_POST['accion'];
		$nvaousada = $_POST['nuevaousada'];
        unset($_POST['accion']);
		unset($_POST['nuevaousada']);
		
	    $arr = ( $this->db->query("select * from catpiezas where id='" . $_POST['pieza_id'] . "'"));
	    $res = ($arr->result_array());
		//print_R($res);
		$_POST['descripcion'] = $res[0]['descripcion'];
		//print_r($_POST); die();	
		
		if ($accion=="i") {
		   $this->db->insert('piezas',$_POST);
		   
		   // Actualizar inventarios
		   if ($nvaousada=="N") {
			   $query = "update catpiezas set cant_nuevas = cant_nuevas-1 where id='" . $_POST['pieza_id'] . "'" ;
               $r     = $this->db->query($query);
		   }
		      else {
			   $query = "update catpiezas set cant_usadas = cant_usadas-1 where id='" . $_POST['pieza_id'] . "'" ;
               $r     = $this->db->query($query);
		   } 
		   
		  $this->load->view('top_single');
		  $this->load->view('comun/cerrartop'); $this->load->view('inicio/bottom1');
		}
		else {
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('piezas', $_POST);
		// print_r($_POST); die();
		//echo $this->db->last_query(); die();
		   redirect('/piezas/' . $_POST["id"]); 
		}
		// PARA ACTUALIZAR: $this->db->update('mytable', $data); 
		
	}	


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */