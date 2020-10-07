<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios extends CI_Controller {

	
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
			   if ((isset($_POST['clase'])) && ($_POST['clase']!="")) {
				  $wh .= " and ((clase='" . $_POST['clase'] . "') or (clase like '%" . $_POST['clase'] . " %'))";				 
			   }	  
				 				
        //$this->load->library('pagination');
        //$lim = $this->uri->segment(3,'0');
		
		$arr = ( $this->db->query('select * from catservicios ' . $wh /*. ' limit ' . $lim . ',20'*/));
	    $data['result'] = ($arr->result_array());
		
		//$config['base_url'] = '/index.php/servicios/index';
		//$arrtot = ( $this->db->query('select * from catservicios'));
        //$config['total_rows'] = $arrtot->num_rows();
        //$config['per_page'] = 20; 
		//$this->pagination->initialize($config);		
		
        $arrt = ( $this->db->query('select * from clases order by clase'));
        $clases = ($arrt->result_array());		
		
		$cla = array(""=>"Seleccionar clase");
		foreach ($clases as $clase) {
			$cla[$clase["clase"]] = $clase["descripcion"];
		}	

        $data['clases'] = $cla;
		$data['clase'] = (isset($_POST['clase']) ? $_POST['clase'] : "");
		//echo $_POST['clase'];				
		
		/*$arr = ( $this->db->query('select * from catservicios'));
	    $data['result'] = ($arr->result_array());*/ $this->load->view('inicio/top1'); 
	//	 $this->load->view('inicio/menuinterior');
		 $this->load->view('servicios/serviciosindex',$data); 
		 $this->load->view('inicio/bottom1'); 
  	    }
else {
	    $registro = array();
        $arrt = ( $this->db->query('select * from clases order by clase'));
        $clases = ($arrt->result_array());		
		
		$cla = array(""=>"Seleccionar clase");
		foreach ($clases as $clase) {
			$cla[$clase["clase"]] = $clase["descripcion"];
		}	
		
		$registro['clases'] = $cla;	
	     $this->load->view('inicio/top1'); 
	//	 $this->load->view('inicio/menuinterior');
		 $this->load->view('servicios/seleccionarclase',$registro); 
		 $this->load->view('inicio/bottom1'); 
	
}	
		 
		
	}
	
	public function agregar() {
       /* $arr = ( $this->db->query('select * from equipos where id=1'));
	    $data = ($arr->result_array()); 
		$registro = $data[0];	*/	
		
		
		$registro = array(
							 "id"=>"",
							
							 "descripcion_"=>"",
							 "costo"=>"0",
							 "clase"=>""
							
							 );
							 
        $arrt = ( $this->db->query('select clase from clases order by clase'));
        $clases = ($arrt->result_array());		
		
		$cla = array();
		foreach ($clases as $clase) {
			$cla[$clase["clase"]] = $clase["clase"];
		}	
		
		$registro['clases'] = $cla;							 
		
		
        $this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('servicios/detalleservicio',$registro); 
		$this->load->view('inicio/bottom1');
		
	}
	
	public function modificar() {
		//$this->load->helper('url');
		//echo $this->uri->segment(3); die();
       //echo  $this->uri->segment(3);
		
        $arr =  $this->db->query("select * from catservicios where id='" . $this->uri->segment(3) . "'");
		
	    $data = ($arr->result_array());
		$registro = array();
		$registro = $data[0];
		
        $arrt = ( $this->db->query('select * from clases order by clase'));
        $clases = ($arrt->result_array());		
		
		$cla = array();
		foreach ($clases as $clase) {
			$cla[$clase["clase"]] = $clase["descripcion"];
		}	
		
		$registro['clases'] = $cla;							 
	
		
		
		//print_r($registro); die();		
        $this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('servicios/detalleservicio',$registro); 
		$this->load->view('inicio/bottom1');
				
	}	
	
	
	
	public function guardar() {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		
		unset($_POST['submit']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
		   $this->db->insert('catservicios',$_POST);
          // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "NUEVO",
			                 "tabla"   => "catservicios",
			                 "detalle" => "ID: " . $_POST['id']);
		   $this->db->insert('registroacciones',$registroacc);					
			
		   redirect('/servicios/'); 
		}
		else {
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('catservicios', $_POST);
          // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "catservicios",
			                 "detalle" => "ID: " . $_POST['id']);
		   $this->db->insert('registroacciones',$registroacc);	
		   
		   redirect('/servicios/modificar/' . $_POST["id"]); 
		}
		
		
	}	



public function eliminar() {
//     $arr = ( $this->db->query("select * from servicios where servicio_id='" . $this->uri->segment(3) . "'"));
  //   if ($arr->num_rows==0) {
     	$this->db->query("delete from catservicios where id='" . $this->uri->segment(3) . "'");
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "catservicios",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/servicios/'); 
   /*  }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el servicio. Existen equipos utiliz&aacute;ndolo.",
	 	  "url"=>"/index.php/servicios");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom1');
		 	
	 	
	 }*/
	}
	
	public function agregaraequipo() {
		
		$arr = $this->db->query("select * from catservicios where  ((clase='" . $this->uri->segment(4) . "') or (clase like '%" . $this->uri->segment(4) . " %'))");

	    $data['result'] = ($arr->result_array());
		
        //print_r($data['result']); die();

        $this->load->view('inicio/top_single1');
		$this->load->view('servicios/agregarservicioaequipo',$data); 
		$this->load->view('inicio/bottom_single1');
		
	}	
	
	public function guardaraequipo() {
		//$this->load->view('agregarcliente');
		
		//$_POST['id'] = $this->db->insert_id() + 1;   //print_r($_POST); die();
		
		
		
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

		 //if ($_POST['de'])
		 //print_r($_POST); die();
// mODIFICACION PARA PROMOCION DE DIAGNOSTICO
	    $arr = ( $this->db->query("select * from catservicios where id='" . $_POST['servicio_id'] . "'"));
	    $res = ($arr->result_array());
		//print_R($res);
		$descripcion = $res[0]['descripcion'];
		if ($descripcion=="SERVICIO DE DIAGNOSTICO")
			 $autenticado = 1;
// TERMINA MODIFICACION

    if ($autenticado) {
		
		$accion = $_POST['accion'];
		
        unset($_POST['accion']);
	    unset($_POST['passwd']);
		
	    $arr = ( $this->db->query("select * from catservicios where id='" . $_POST['servicio_id'] . "'"));
	    $res = ($arr->result_array());
		//print_R($res);
		$_POST['descripcion'] = $res[0]['descripcion'];
		$descuento = $_POST['costo'] * ($_POST['descuento'] / 100);
		$_POST['descuento'] = $descuento;
		$_POST['subtotal'] = $_POST['costo'] - $_POST['descuento'];
		$_POST['fecha'] = date('Y-m-d');
		$_POST['hora'] = date('H:i:s');
		//print_r($_POST); die();	
		
		if ($accion=="i") {
		   $this->db->insert('servicios',$_POST);
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "AGREGAR",
			                 "tabla"   => "servicios-equipo",
			                 "detalle" => $_POST['servicio_id'] . " Equipo: " . $_POST['equipo_id']);
		    $this->db->insert('registroacciones',$registroacc);  
		   
		   
		  $this->load->view('inicio/top_single1');
		  $this->load->view('comun/cerrartop'); 
		  $this->load->view('inicio/bottom_single1');
		}
		else {
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('servicios', $_POST);
		 
  // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "servicios-equipo",
			                 "detalle" => $_POST['servicio_id'] . " Equipo: " . $_POST['equipo_id']);
		    $this->db->insert('registroacciones',$registroacc);  
		// print_r($_POST); die();
		//echo $this->db->last_query(); die();
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
		$arr =  $this->db->query('delete from servicios where id=' . $this->uri->segment(3));
        // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "servicios-equipo",
			                 "detalle" => $this->uri->segment(3));
		    $this->db->insert('registroacciones',$registroacc);
		    
         $this->load->view('top_single');
	  	 $this->load->view('comun/cerrartop'); $this->load->view('inicio/bottom1');
	}
	
	public function detalleserviciojson()
	{		
        
		//if (isset($_REQUEST['tipo']) && ($_REQUEST['tipo']!=""))
		if ($this->uri->segment(3,'')!="")
			  $wh = " where id='" . $this->uri->segment(3,'') . "'";
	    else  $wh = "";
		$arr =  $this->db->query("select * from catservicios" . $wh);
	    $data['result'] = ($arr->result_array());
        // print_r($data['result']); die();
		$this->load->view('servicios/detalleserviciojson',$data); 
	}
	
   public function pdf()
    {
    $this->load->helper('dompdf');

	
		
		$arr = ( $this->db->query('select * from catservicios '));
	    $data['result'] = ($arr->result_array());
	
	$html =	 $this->load->view('servicios/serviciospdf',$data,true); 	
	
    //$html = "<html><body>aaa</body></html>";
    pdf_create($html, 'servicios');
    }	


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */