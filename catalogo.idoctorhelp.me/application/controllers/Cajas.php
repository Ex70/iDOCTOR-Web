<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cajas extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{		
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
        $q = "select catcajas.id,catcajas.descripcion,catcajas.localizacion,equipos.id as equipo_id, " .
             " equipos.num_orden from catcajas left outer join equipos on catcajas.id=equipos.caja_id " .
             " order by catcajas.id limit " . $lim . ",100";		
		
		$arr = ( $this->db->query($q));
	    $data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/cajas/index';
		$arrtot = ( $this->db->query('select * from catcajas'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 100; 
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top1'); 
		//$this->load->view('inicio/menuinterior');
		$this->load->view('cajas/cajasindex',$data); 
		$this->load->view('inicio/bottom1'); 
		 
		
	}
	
	
	
	public function agregar() {
    	
		$registro = array(
							 "descripcion"=>"",
							
							 "localizacion"=>"", "id" => "",
							 "codigoqr" => ""
						
							 );
		
     
		
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('cajas/detallecaja',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
       //echo  $this->uri->segment(3);
		
        $arr =  $this->db->query("select * from catcajas where id='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());
		$registro = array();
		$registro = $data[0];
		
//        $pagina = "http://" . $_SERVER['SERVER_NAME'] . "/index.php/equipos/localizarqrcaja/" . $this->uri->segment(3);
        $pagina = "http://sistema.hospitaldeipods.mx/index.php/equipos/localizarqrcaja/" . $this->uri->segment(3);
	    $this->load->library('qrcode_library');
        $registro['codigoqr'] =  $this->qrcode_library->make_qrcode($pagina, $errorCorrectionLevel= '', $matrixPointSize='');		
	
		
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('cajas/detallecaja',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function mostrarcodigoqr() {
//        $pagina = "http://" . $_SERVER['SERVER_NAME'] . "/index.php/equipos/localizarqrcaja/" . $this->uri->segment(3);
        $pagina = "http://sistema.hospitaldeipods.mx/index.php/equipos/localizarqrcaja/" . $this->uri->segment(3);
	    $this->load->library('qrcode_library');
        $codigoqr =  $this->qrcode_library->make_qrcode($pagina, $errorCorrectionLevel= '', $matrixPointSize='');
		echo "<html><body><img src='" .  $codigoqr .  "'></body></html>";				
	}	
	
	
	
	public function guardar() {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   $this->db->insert('catcajas',$_POST);
		   redirect('/cajas/'); 
		}
		else {
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('catcajas', $_POST);
		// print_r($_POST); die();
		//echo $this->db->last_query(); die();
		   redirect('/cajas/modificar/' . $_POST["id"]); 
		}
		// PARA ACTUALIZAR: $this->db->update('mytable', $data); 
		
	}	
	
public function eliminar() {
     $arr = ( $this->db->query("select * from equipos where caja_id='" . $this->uri->segment(3) . "'"));
     if ($arr->num_rows==0) {
     	$this->db->query("delete from catcajas where id=" . $this->uri->segment(3));
		
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "cajas",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/cajas/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar  la caja. Existen equipos registrados en ella.",
	 	  "url"=>"/index.php/inicio/administracion");
        $this->load->view('inicio/top1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
	 }
	}	
	
	
	function llenarcajas(){
		$this->db->query("delete from catcajas");
		for ($i=1;$i<200;$i++) {
			  $p = array("descripcion"=>"Caja " . $i);
			  $this->db->insert('catcajas',$p);
			  unset($p);
			
		}
	}
	
	function codigosqrcajas() {
		
		$data = array();
		$reg = array();
	  for ($i=1;$i<200;$i++) {
	  	$pagina = "http://sistema.hospitaldeipods.mx/index.php/equipos/localizarqrcaja/" . $i;
	    $this->load->library('qrcode_library');
        $codigoqr =  $this->qrcode_library->make_qrcode($pagina, $errorCorrectionLevel= '', $matrixPointSize='');
		
	  	$data[] =  $codigoqr;
 		
	  }
	    $reg['datos'] = $data;
        $this->load->view('inicio/top_single1');
		$this->load->view('cajas/codigosqrcajas',$reg);
		$this->load->view('inicio/bottom_single1');		
	 
		
		
	}
	
	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */