<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	 
	public function index()
	{
		$this->load->model('Clientesmodel');

        $wh = " where (1=1) ";
		$pendientes = "S";
		$busca_nombre = "";

		
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!=""))  {
				  $wh .= " and (nombre like '" . $_POST['busca_nombre'] . "%')";				 
				$busca_nombre = $_POST['busca_nombre']; 		
			  }
			  
		}	
		
	
		
        $this->load->library('pagination'); 
        $lim = $this->uri->segment(3,'0');
		
		$data['result'] = $this->Clientesmodel->get_clientes_where_str($wh,$lim,"20");

		//print_r($data['result']); die();

		/*$arr = ( $this->db->query('select * from clientes ' . $wh . ' limit ' . $lim . ',20'));
	    $data['result'] = ($arr->result_array());*/
		
		$config['base_url'] = '/index.php/clientes/index';
		$arrtot = ( $this->db->query('select * from clientes'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 20; 
		$data['busca_nombre'] = $busca_nombre;
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top1'); 
		// $this->load->view('inicio/menuinterior');
		 $this->load->view('clientes/clientesindex',$data); $this->load->view('inicio/bottom1'); 
		 
		
	}
	
	

	
	public function clientesjson()
	{		
        
		
		$arr =  $this->db->query("select * from clientes order by nombre");
	    $data['result'] = ($arr->result_array());
		



		 $this->load->view('clientes/clientesjson',$data); 
	 
		
	}	

	public function nombreclientejson()
	{		
        
		
		$arr =  $this->db->query("select * from clientes where id=" . $this->uri->segment(3,'0'));
	    $data['result'] = ($arr->result_array());
		//print_r($data); die();


         $datacli['result'] = $data['result'][0];
		 $this->load->view('clientes/nombreclientejson',$datacli); 
	 
		
	}	
	
	public function buscar() 
	{   $this->load->view('inicio/top_single1');
	    $this->load->view('clientes/buscar'); 
		$this->load->view('inicio/bottom_single1');
	}
	
	public function cerrarresultados() {
 $this->load->view('inicio/top_single1');
	    $this->load->view('clientes/cerrarresultados'); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function resultados() {
        $wh = " where (1=1) ";
		$pendientes = "S";
		$busca_nombre = "";

		
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!=""))  {
				  $wh .= " and (nombre like '" . $_POST['busca_nombre'] . "%')";				 
				$busca_nombre = $_POST['busca_nombre']; 		
			  }
			  
		}	
		
	
		
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
		$arr = ( $this->db->query('select * from clientes ' . $wh . ' limit ' . $lim . ',10'));
	    $data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/clientes/resultados';
		$arrtot = ( $this->db->query('select * from clientes'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 10; 
		$data['busca_nombre'] = $busca_nombre;
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top_single1'); 
		 $this->load->view('clientes/resultados',$data); 
		 $this->load->view('inicio/bottom_single1'); 	
	
	}
	
	public function agregar() {
		$this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_campos();
        $registro['desdeequipo'] = "N";
		$this->load->view('inicio/top1');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}
	
	public function agregardesdeequipos() {
		$this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_campos();
		$registro['desdeequipo'] = "S";

        //$registro = array("id"=>"","nombre"=>"","telefono1"=>"","telefono2"=>"","direccion"=>"","correo_electronico"=>"","desdeequipo"=>"S");
		$this->load->view('top_single');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function modificar() {
        $this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_detalle($this->uri->segment(3));
		$this->load->view('inicio/top1');
		$this->load->view('clientes/detallecliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}	
	
	public function enviarcorreo() {
        $arr = ( $this->db->query('select * from clientes where id=' . $this->uri->segment(3)));
	    $data = ($arr->result_array()); 
		$registro = $data[0];
		$registro["desdeequipo"] = "N";
		//print_r($registro); die(); 
		$this->load->view('inicio/top1');
		//$this->load->view('inicio/menuinterior');
		$this->load->view('clientes/correoacliente',$registro); 
		$this->load->view('inicio/bottom1');		
	}	

	public function correoenviar() {
        $this->load->model('Clientesmodel');
		$registro = $this->Clientesmodel->get_detalle($_POST['id']);
		 
$this->load->library('email');

$this->email->from('hospitaldeipods@disisweb.com', 'Hospital de IPODS');
$this->email->to($registro['correo_electronico']);  

$this->email->subject('Hospital de iPods');
$this->email->message($_POST['mensaje']);	

$this->email->send();		
		redirect("/clientes/modificar/" . $_POST['id']);
	/*	$this->load->view('inicio/top1');
		$this->load->view('inicio/menuinterior');
		$this->load->view('clientes/correoacliente',$registro); 
		$this->load->view('inicio/bottom1');
	
	 */		
	}	
	
	
	public function eliminar() {
     $arr = ( $this->db->query('select * from equipos where cliente_id=' . $this->uri->segment(3)));
     if ($arr->num_rows==0) {
     	$this->db->query('delete from clientes where id=' . $this->uri->segment(3));
           // REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "ELIMINADO",
			                 "tabla"   => "clientes",
			                 "detalle" => "ID: " . $this->uri->segment(3));
		   $this->db->insert('registroacciones',$registroacc);		 
		 
		 redirect('/clientes/'); 
     }
	 else {
	 	$data=array("mensaje"=>"No se puede eliminar el cliente. Existen equipos asignados.",
	 	  "url"=>"/index.php/clientes");
        $this->load->view('inicio/top_single1');
		$this->load->view('comun/mensaje',$data);
		$this->load->view('inicio/bottom_single1');
		 	
	 	
	 }
	   // $data = ($arr->result_array()); 
		//$registro = $data[0];
			
		
	}
	
	
	
	public function guardar() {
        unset($_POST['submit']);
		unset($_POST['enviardatos']);
		$accion = $_POST['accion'];
		$desdeequipo = $_POST['desdeequipo'];
        unset($_POST['accion']);
		unset($_POST['desdeequipo']);
		
		if ($accion=="i") {
			
			$_POST['telefono1'] =  $_POST['telefono1a'] . "-" . $_POST['telefono1b'] . "-" . $_POST['telefono1c'];
		    $_POST['telefono2'] =  $_POST['telefono2a'] . "-" . $_POST['telefono2b'] . "-" . $_POST['telefono2c'];			              
		    unset($_POST['telefono1a']);
			unset($_POST['telefono1b']);
			unset($_POST['telefono1c']);
			unset($_POST['telefono2a']);
			unset($_POST['telefono2b']);
			unset($_POST['telefono2c']);
		   
			
		   $this->db->insert('clientes',$_POST);
		   $lastid = $this->db->insert_id();
		   $_POST['id'] = $lastid;
          
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "NUEVO",
			                 "tabla"   => "clientes",
			                 "detalle" => $lastid . " " . $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);
			
		   if ($desdeequipo=="N")
		        redirect('/clientes/'); 
           else {
           	//print_r($_POST);
              $this->load->view('top_single');
		      $this->load->view('clientes/cerrartopactualizarselect',$_POST); 
		      $this->load->view('inicio/bottom_single1');				
		    }
		}
		else { // ELSE DE ACCION
	     $this->db->where('id', $_POST["id"]);
		 $this->db->update('clientes', $_POST);	
			// REGISTRO DE ACCIONES
			$registroacc = array(
			                 "usuario" => $this->session->userdata('usuario'),
			                 "usuario_id" => $this->session->userdata('usuario_id'),
			                 "fecha_hora" => date ("Y-m-d H:i:s"),
			                 "accion"  => "MODIFICACION",
			                 "tabla"   => "clientes",
			                 "detalle" => $_POST['id'] . " " . $_POST['nombre']);
		   $this->db->insert('registroacciones',$registroacc);
			
		    redirect('/clientes/modificar/' . $_POST['id']);			 
		 }
		
	}


   public function pdf() {
   	$this->load->library('Pdf');

$pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);
$pdf->SetTitle('My Title');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
//$pdf->setFooterMargin(20);
//$pdf->SetAutoPageBreak(true);
$pdf->SetAuthor('Author');
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

$pdf->Image(dirname(__FILE__) . '/../libraries/imagenes/encabezadoHI.jpg', 5, 5, 200, 20, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
//$pdf->Image($file)
//$pdf->writeHTMLCell(200, 100, 100, 100,"HOLA");
//$pdf->writeHTML("ABCDEFG");
$html = '<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y=100, $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
//$pdf->Write(50, 'Some sample text');
$pdf->Output('My-File-Name.pdf', 'I'); 
   }	
	
	
}

