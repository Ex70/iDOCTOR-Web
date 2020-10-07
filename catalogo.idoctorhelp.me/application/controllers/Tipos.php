<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipos extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 


     public function sincronizar() {
     	$this->load->model("Tiposclasesequiposmodel");
     	$this->Tiposclasesequiposmodel->sincronizar_bds();
     }  

	 
	public function index()
	{		
		$this->load->model("Tiposclasesequiposmodel");
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
		//$arr = ( $this->db->query('select * from tipos limit ' . $lim . ',100'));

		//$tipos = $this->Tiposclasesequiposmodel->get_tipos_where_str("",$lim,100);
		if ($this->uri->segment(3,'')=='')
			$tipos = $this->Tiposclasesequiposmodel->get_tipos();
		else
			$tipos = $this->Tiposclasesequiposmodel->get_tipos_de_clase($this->uri->segment(3));

	    //$data['result'] = ($arr->result_array());
	    $data['result'] = $tipos;
	    $data['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();
	    $data['clases']['NE'] = "Seleccionar clase para ver sus tipos";
	    $data['clase'] = $this->uri->segment(3,'NE');
 		

		$this->load->view('inicio/top1'); 
		$this->load->view('tipos/tiposindex',$data); 
		$this->load->view('inicio/bottom1'); 
		 
		
	}
	
	public function subtiposjson()
	{		
        
		
		$arr =  $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3,'0')  . "'");
	    $data['result'] = ($arr->result_array());
		



		 $this->load->view('tipos/subtiposjson',$data); 
	 
		
	}	
	
	public function imagenjson()
	{
		// regresa un JSON con el nombre del archivo de imagen
		// OJO! SIN VIEW!
		$arr =  $this->db->query("select imagen from tipos where tipo='" . $this->uri->segment(3,'0')  . "'");
        echo "{ \n";

		if ($arr->num_rows>0) {
	    $data = ($arr->result_array());
		
        //print_r($result);
            echo '"imagen" : "' . $data[0]['imagen'] . '"';
        }
		else echo '"imagen" : "sin_imagen.png"';
        echo "\n}";

		
	}
	
	public function agregar() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	

		$this->load->model("Tiposclasesequiposmodel");

		$registro = $this->Tiposclasesequiposmodel->get_campos_tipos();

		$registro['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();


		
		$this->load->view('inicio/top1');
		$this->load->view('tipos/detalletipo',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
       //echo  $this->uri->segment(3);
		$this->load->model("Tiposclasesequiposmodel");


        $arr =  $this->db->query("select * from tipos where tipo='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());
		$registro = array();
		$registro = $data[0];
		
        $arr =  $this->db->query("select * from subtipos where tipo='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());

		$registro['clases'] = $this->Tiposclasesequiposmodel->get_clases_dropdown();

		$registro['subtipos'] = $data;		
		
	
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('tipos/detalletipo',$registro); 
		$this->load->view('inicio/bottom1');
		
	}	
	
	
	
	public function guardar() {
     	$this->load->model("Tiposclasesequiposmodel");

		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   $this->db->insert('tipos',$_POST);
     	


		   redirect('/tipos/'); 
		}
		else {
	     $this->db->where('tipo', $_POST["tipo"]);
		 $this->db->update('tipos', $_POST);
     	
		 redirect('/tipos/modificar/' . $_POST["tipo"]); 
		}
		
	}	
	
public function eliminar() {
     	$this->load->model("Tiposclasesequiposmodel");

     $arr = ( $this->db->query("select * from equipos where tipo='" . $this->uri->segment(3) . "'"));
     if ($arr->num_rows==0) {
     	$this->db->query("delete from tipos where tipo='" . $this->uri->segment(3) . "'");
		$this->db->query("delete from subtipos where tipo='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "tipos",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);	

// sincronizar bases de da tos
     	   $this->Tiposclasesequiposmodel->sincronizar_bds();
		 
		 redirect('/tipos/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el tipo. Existen equipos registrados de este tipo.",
	 	  "url"=>"/index.php/inicio/administracion");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
	 }
	}	
	
	
	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */