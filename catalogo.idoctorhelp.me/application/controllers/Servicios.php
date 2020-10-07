<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	

	public function clase()
	{
		
        $this->load->model('Serviciosmodel');
		
	    $data['result'] = $this->Serviciosmodel->get_servicios_por_clase($this->uri->segment(3));
				

	     $this->load->view('inicio/top1'); 
		 $this->load->view('servicios/serviciosindex',$data); 
		 $this->load->view('inicio/bottom1');
    }         

	 
	public function index()
	{
		$busca_nombre = "";
        $wh = "";	

		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_descripcion'])) && ($_POST['busca_descripcion']!="")) 
				  $wh .= " and (descripcion like '" . $_POST['busca_descripcion'] . "%')";	
			   if ((isset($_POST['clase']))) {
				  $wh .= " and ((clase='" . $_POST['clase'] . "') or (clase like '%" . $_POST['clase'] . " %'))";
				  if ($_POST['clase']=='')
				     $wh = " where (clase is null) or (clase='')";				 
			   }	  
				 				
        $this->load->model('Serviciosmodel');
		
	    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
				
        $this->load->model('Clasesmodel');

		$registro['clases'] = $this->Clasesmodel->get_clases_dropdown_todas();	
		$data['clase'] = (isset($_POST['clase']) ? $_POST['clase'] : "");

	     $this->load->view('inicio/top1'); 
		 $this->load->view('servicios/serviciosindex',$data); 
		 $this->load->view('inicio/bottom1'); 
  	    }
		else {
	    $registro = array();

        $this->load->model('Clasesmodel');

		$registro['clases'] = $this->Clasesmodel->get_clases_dropdown_todas();					 

	     $this->load->view('inicio/top1'); 
		 $this->load->view('servicios/seleccionarclase',$registro); 
		 $this->load->view('inicio/bottom1'); 
	
		}	
		 
		
	}
	
	public function agregar() {

		$registro = array(
							 "id"=>"",
							 "descripcion_"=>"",
							 "costo"=>"0",
							 "clase"=>""
							 );
							 
        $this->load->model('Clasesmodel');


		$registro['clases'] = $this->Clasesmodel->get_clases_dropdown_todas();					 
		
		
        $this->load->view('inicio/top1');
		$this->load->view('servicios/detalleservicio',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
        $this->load->model('Serviciosmodel');
        $this->load->model('Clasesmodel');
	    $registro = $this->Serviciosmodel->get_detalle($this->uri->segment(3));


		$registro['clases'] = $this->Clasesmodel->get_clases_dropdown_todas();					 
	
        $this->load->view('inicio/top1');
		$this->load->view('servicios/detalleservicio',$registro); 
		$this->load->view('inicio/bottom1');				
	}	
	
	
	
	public function guardar() {
		$this->load->model('Serviciosmodel');
		$this->load->model('Registroaccionesmodel');
		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   //$this->db->insert('catservicios',$_POST);
		   $this->Serviciosmodel->agregar_servicio($_POST);	

		   $this->Registroaccionesmodel->registrar("NUEVO","catservicios","ID: " . $_POST['id']);

			
		   redirect('/servicios/'); 
		}
		else {
	     $this->Serviciosmodel->modificar_servicio($_POST['id'],$_POST);		

		 $this->Registroaccionesmodel->registrar("MODIFICACION","catservicios","ID: " . $_POST['id']);

		   
		   redirect('/servicios/modificar/' . $_POST["id"]); 
		}
		
		
	}	


	public function eliminar() {
	    $this->load->model("Registroaccionesmodel");
        $this->load->model("Serviciosmodel");
        $this->Serviciosmodel->eliminar_servicio($this->uri->segment(3));

		   $this->Registroaccionesmodel->registrar("ELIMINADO","catservicios","ID: " . $this->uri->segment(3));

		 
		 redirect('/servicios/'); 
	}

	
	public function agregaraequipo() {
		$this->load->model("Serviciosmodel");

	    $data['result'] = $this->Serviciosmodel->get_servicios_clase($this->uri->segment(4));
        $this->load->view('inicio/top_single1');
		$this->load->view('servicios/agregarservicioaequipo',$data); 
		$this->load->view('inicio/bottom_single1');
		
	}	
	
	public function guardaraequipo() {
        $this->load->model("Serviciosmodel");		
        $this->load->model("Serviciosequiposmodel");
        $this->load->model("Registroaccionesmodel");
		
		unset($_POST['submit']);
		$autenticado = 1;
		
		if (($this->session->userdata('nivel')!=1)  && ($_POST['descuento']!="0")) {
	        $arr = ( $this->db->query("select * from usuarios where passwd='" . $_POST['passwd'] . "'"));
	        if ($arr->num_rows()>0) {
	        	$autenticado = 1;
	        }
			else {
				$autenticado = 0;
			}
		 }

		// mODIFICACION PARA PROMOCION DE DIAGNOSTICO
		$res = $this->Serviciosmodel->get_detalle($_POST['servicio_id']);

	    //$arr = ( $this->db->query("select * from catservicios where id='" . $_POST['servicio_id'] . "'"));
	    //$res = ($arr->result_array());
		//print_R($res);
		$descripcion = $res['descripcion'];
		if ($descripcion=="SERVICIO DE DIAGNOSTICO")
			 $autenticado = 1;
		// TERMINA MODIFICACION

		if ($autenticado) {
		
		$accion = $_POST['accion'];
		
        unset($_POST['accion']);
	    unset($_POST['passwd']);
		
	    //$arr = ( $this->db->query("select * from catservicios where id='" . $_POST['servicio_id'] . "'"));
	    //$res = ($arr->result_array());
	    $res = $this->Serviciosmodel->get_detalle($_POST['servicio_id']);

		$_POST['descripcion'] = $res['descripcion'];
		$descuento = $_POST['costo'] * ($_POST['descuento'] / 100);
		$_POST['descuento'] = $descuento;
		$_POST['subtotal'] = $_POST['costo'] - $_POST['descuento'];
		$_POST['fecha'] = date('Y-m-d');
		$_POST['hora'] = date('H:i:s');
		
			if ($accion=="i") {

			$this->Serviciosequiposmodel->agregar_servicio_equipo($_POST);
			$this->Registroaccionesmodel->registrar("AGREGAR","servicios-equipo","ID: " . 
					 $_POST['servicio_id'] . " Equipo: " . $_POST['equipo_id']);

			   
			   
			  $this->load->view('inicio/top_single1');
			  $this->load->view('comun/cerrartop'); 
			  $this->load->view('inicio/bottom_single1');
			}
			else {
			 $this->Serviciosequiposmodel->modificar_servicio_equipo($_POST['id'],
					  $_POST);
			 
			   $this->Registroaccionesmodel->registrar("MODIFICACION","servicios-equipo","ID: " . 
					 $_POST['servicio_id'] . " Equipo: " . $_POST['equipo_id']);

			   redirect('/servicios/' . $_POST["id"]); 
			}
		} // IF AUTENTICADO
		else  {
			$msg = array("mensaje"=>"La contrase&ntilde;a es incorrecta. No se puede aplicar el descuento.",
				 "url"=>"javascript:history.go(-1)");
			$this->load->view('inicio/top_single1');
			$this->load->view('comun/mensaje',$msg); 
			$this->load->view('inicio/bottom_single1');    	
		}	
			
	}	
	
	
	public function eliminardeequipo() {	
		$this->load->model("Serviciosequiposmodel");
		$this->load->model("Registroaccionesmodel");
		$this->Serviciosequiposmodel->eliminar_servicio_equipo($this->uri->segment(3));
		   $this->Registroaccionesmodel->registrar("ELIMINADO","servicios-equipo",$this->uri->segment(3));
		    
         $this->load->view('top_single');
	  	 $this->load->view('comun/cerrartop'); $this->load->view('inicio/bottom1');
	}
	
	public function detalleserviciojson()
	{		
		if ($this->uri->segment(3,'')!="")
			  $wh = " where id='" . $this->uri->segment(3,'') . "'";
	    else  $wh = "";

	    $this->load->model("Serviciosmodel");
	    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);

		$this->load->view('servicios/detalleserviciojson',$data); 
	}

	public function serviciosclasejson()
	{		

	    $this->load->model("Serviciosmodel");
	    $s = $this->Serviciosmodel->get_servicios_dd_clase($this->uri->segment(3)); 
	    echo json_encode($s);

		//$this->load->view('servicios/detalleserviciojson',$data); 
	}

	
   public function pdf()
    {
    $this->load->helper('dompdf');

	    $this->load->model("Serviciosmodel");
	    $data['result'] = $this->Serviciosmodel->get_servicios_where($wh);
	
		
		//$arr = ( $this->db->query('select * from catservicios '));
	    //$data['result'] = ($arr->result_array());
	
	$html =	 $this->load->view('servicios/serviciospdf',$data,true); 	
	
    //$html = "<html><body>aaa</body></html>";
    pdf_create($html, 'servicios');
    }	


	
}

/* End of file Servicios.php */
/* Location: ./application/controllers/Servicios.php */