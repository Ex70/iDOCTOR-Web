<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articulos extends CI_Controller {

   public function clase() {
        $this->load->model('Articulosmodel');
		$data['result'] = $this->Articulosmodel->get_articulos_por_clase($this->uri->segment(3));

		$this->load->view('inicio/top1'); 
		$this->load->view('articulos/articulosclase',$data); 
		$this->load->view('inicio/bottom1');       
   }
	 
	public function index()
	{
		$this->load->model('Articulosmodel');


        $wh = " where (1=1) ";
		$pendientes = "S";
		$busca_nombre = "";

		
		// $busca_numorden busca_numserie busca_nombre busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_nombre'])) && ($_POST['busca_nombre']!=""))  {
				  $wh .= " and (descripcion like '" . $_POST['busca_nombre'] . "%')";				 
				$busca_nombre = $_POST['busca_nombre']; 		
			  }
			  
		}	
		
	
		
        $this->load->library('pagination'); 
        $lim = $this->uri->segment(3,'0');
		
		$data['result'] = $this->Articulosmodel->get_articulos_where_str($wh,$lim,"20");
		
		$config['base_url'] = '/index.php/articulos/index';

        $config['total_rows'] = $this->Articulosmodel->num_total_articulos();

        $config['per_page'] = 20; 
		$data['busca_nombre'] = $busca_nombre;
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top1'); 
		 $this->load->view('articulos/articulosindex',$data); 
		 $this->load->view('inicio/bottom1'); 
		 
		
	}


   public function venta() {
   	  $this->load->model("Articulosmodel");
   	  $this->load->model("Clientesmodel");

   	  $data = $this->Clientesmodel->get_campos();
   	  $data['uniqid'] = $this->Articulosmodel->get_articulos_uniqid();
   	  $this->load->view('inicio/top1'); 
	  $this->load->view('articulos/ventaarticulos',$data); 
	  $this->load->view('inicio/bottom1'); 

   }	

   public function guardarventa() {
   	  $this->load->model("Articulosmodel");
   	  $this->load->model("Equiposmodel");
   	  $this->load->model("Clientesmodel");


      if ($_POST['cliente_id']=="") {

			$_POST['cliente_id'] = $this->Clientesmodel->agregar_nuevo_cliente_nueva_orden($_POST);
			
		}
		
		    unset($_POST['nombrecliente']);
			unset($_POST['telefono1']);
			unset($_POST['telefono2']);
			unset($_POST['correo_electronico']);
			unset($_POST['direccion']);
			unset($_POST['colonia']);
			unset($_POST['cp']);
			unset($_POST['ciudad']);
			unset($_POST['estado']);


   	  $numero_remision = $this->Equiposmodel->get_numremision_incrementar();
      $a = array("cliente_id"=>$_POST['cliente_id'],
      	         "numero_remision"=>$numero_remision,
      	         "fecha"=>date ("Y-m-d"),
      	         "hora"=>date("H:i:s"),
      	         "forma_de_pago"=>$_POST['forma_de_pago']
      	         );

   	  $this->db->where("uniqid",$_POST['uniqid']);
   	  $this->db->update("articulos",$a);

      $data = array("numero_remision"=>$numero_remision);
      //redirect("articulos/venta");
   	  $this->load->view('inicio/top1'); 
	  $this->load->view('articulos/ventaguardada',$data); 
	  $this->load->view('inicio/bottom1'); 

   }	


	

	
	public function articulosjson()
	{		        
		$this->load->model("Articulosmodel");
	    $data['result'] = $this->Articulosmodel->get_articulos_para_json;
		 $this->load->view('articulos/articulosjson',$data); 
	}	


	
	public function buscar() 
	{   $this->load->view('inicio/top_single1');
	    $this->load->view('articulos/buscar'); 
		$this->load->view('inicio/bottom_single1');
	}
	
	public function cerrarresultados() {
        $this->load->view('inicio/top_single1');
	    $this->load->view('articulos/cerrarresultados'); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function resultados() {
        $this->load->model("Articulosmodel");

        $wh = " where (1=1) ";
		$pendientes = "S";
		$busca_descripcion = "";

		
		// $busca_numorden busca_numserie busca_descripcion busca_estatus busca_modelo busca_tipo
		if (count($_POST)>0) { 
			     $wh = " where (1=1) ";
			
			  if ((isset($_POST['busca_descripcion'])) && ($_POST['busca_descripcion']!=""))  {
				  $wh .= " and (descripcion like '" . $_POST['busca_descripcion'] . "%')";				 
				$busca_descripcion = $_POST['busca_descripcion']; 		
			  }
			  
		}	
		
	
		
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');

        $data['result'] = $this->Articulosmodel->get_articulos_where_str($wh,$lim,10);
		
		//$arr = ( $this->db->query('select * from catarticulos ' . $wh . ' limit ' . $lim . ',10'));
	    //$data['result'] = ($arr->result_array());
		
		$config['base_url'] = '/index.php/articulos/resultados';
        $config['total_rows'] = $this->Articulosmodel->num_total_articulos();
        $config['per_page'] = 10; 
		$data['busca_descripcion'] = $busca_descripcion;
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top_single1'); 
		 $this->load->view('articulos/resultados',$data); 
		 $this->load->view('inicio/bottom_single1'); 	
	
	}
	
	public function agregar() {
		$this->load->model('Articulosmodel');
		$registro = $this->Articulosmodel->get_campos();
        $registro['desdeequipo'] = "N";
        //print_r($registro); die();
		$this->load->view('inicio/top1');
		$this->load->view('articulos/detallearticulo',$registro); 
		$this->load->view('inicio/bottom1');		
	}
	
	public function agregardesdeventa() {
		$this->load->model('Articulosmodel');
		$registro = $this->Articulosmodel->get_campos();
	
		$this->load->view('top_single');
		$this->load->view('articulos/detallearticulo',$registro); 
		$this->load->view('inicio/bottom_single1');		
	}
	
	public function modificar() {
        $this->load->model('Articulosmodel');
		$registro = $this->Articulosmodel->get_detalle($this->uri->segment(3));
		$this->load->view('inicio/top1');
		$this->load->view('articulos/detallearticulo',$registro); 
		$this->load->view('inicio/bottom1');		
	}	

    public function consultaventas() {
    	$this->load->model("Articulosmodel");
    	$this->load->model("Articulosventasmodel");
    	$anio = $this->uri->segment(3,"");
    	$mes  = $this->uri->segment(4,"");
    	if ($anio=="") {
    		$anio = date("Y");
    		$mes = date("m");
    	}
    	$result['ventas'] = $this->Articulosventasmodel->consulta_ventas_por_mes($anio,$mes);
    	$result['tipo_consulta'] = "MES";
		$this->load->view('inicio/top1');
		$this->load->view('articulos/consultaventas',$result); 
		$this->load->view('inicio/bottom1');		    	
    }

    public function articulosventa() {
    	$this->load->model("Articulosmodel");
    	$this->load->model("Articulosventasmodel");
        $result['articulos'] = $this->Articulosventasmodel->get_articulos_numero_remision($this->uri->segment(3));    	
		$this->load->view('inicio/top_single1');
		$this->load->view('articulos/articulosventa',$result); 
		$this->load->view('inicio/bottom_single1');		    	
    }
	
	
	
	
	
	public function guardar() {
		$this->load->model("Articulosmodel");
		$this->load->model("Registroaccionesmodel");
        unset($_POST['submit']);
		unset($_POST['enviardatos']);
		$accion = $_POST['accion'];
        unset($_POST['accion']);
		
		if ($accion=="i") {
						
			$this->Articulosmodel->agregar_articulo($_POST);
          
		   $this->Registroaccionesmodel->registrar("NUEVO","articulos","ID: " . $_POST['id']);
		        redirect('/articulos/'); 
		}
		else { // ELSE DE ACCION
	     $this->Articulosmodel->modificar_articulo($_POST['id'],$_POST);		
		   $this->Registroaccionesmodel->registrar("MODIFICACION","articulos","ID: " . $_POST['id']);
			
		    redirect('/articulos/modificar/' . $_POST['id']);			 
		 }
		
	}


  public function ajax_tr_articulo() {
  	$this->load->model("Articulosmodel");
  	$this->load->model("Articulosventasmodel");
  	$id = $this->uri->segment(3);
  	$uniqid = $this->uri->segment(4);
  	$articulo = $this->Articulosmodel->get_detalle($id);
  	$a = array("articulo_id"=>$id,"descripcion"=>$articulo['descripcion'],
  	      "clase_compatibilidad"=>$articulo['clase_compatibilidad'],"precio"=>$articulo['precio'],
  	      "uniqid"=>$uniqid);

  	//$this->db->insert("articulos",$a);   
  	$insertid = $this->Articulosventasmodel->agregar_articulo_venta($a);   

  	$tr = "<tr id='row" . $insertid . "'>" . 
          "<td>" . $articulo['id'] . "</td><td>" . $articulo['descripcion'] .
  	      "</td><td>" . $articulo['clase_compatibilidad'] . "</td><td align='right'>" . $articulo['precio'] . "</td>" .
  	      "<td align='center'><a href=\"javascript:eliminararticulo('" . $insertid . "');\"><img src='/images/ico_eliminar.png'></a></td></tr>";

  	echo $tr;
  }

  public function ajax_tr_eliminar_articulo() {
  	$this->load->model("Articulosventasmodel");
  	$this->Articulosventasmodel->eliminar_articulo_venta($this->uri->segment(3));
  }

private function _cambiaf_a_normal($fecha){ 
   	//ereg( "([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})", $fecha, $mifecha);
	preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
   	$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
   	return $lafecha; 
} 	   


public function notadeventa3() {

	ini_set("memory_limit","64M");


	$this->load->model("Articulosmodel");

	$this->load->model("Clientesmodel");

	$this->load->model("Equiposmodel");
	$this->load->model("Articulosventasmodel");

   $numero_remision = $this->uri->segment(3);
   
   $articulos = $this->Articulosventasmodel->get_articulos_numero_remision($numero_remision);

   $cliente = $this->Clientesmodel->get_detalle($articulos[0]['cliente_id']); 

   $fecha = $articulos[0]['fecha'];

	$this->load->library('Pdf');


$ddx = 0; $ddy = 0; $mostrarcirculos = 0;

$bord = 0; // BORDER


$pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
$pdf->SetTitle('Nota de venta de articulo');
//$pdf->SetHeaderMargin(30);
//$pdf->SetTopMargin(20);
$pdf->setFooterMargin(0);
//echo $pdf->getFooterMargin(); die();
$pdf->SetAutoPageBreak(false);
$pdf->SetAuthor('iDoctor');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetDisplayMode('real', 'default');
$pdf->AddPage();

//Image($file, $x='', $y='', $w=0, $h=0, $type='', $link='', $align='', 
//    $resize=false, $dpi=300, $palign='', $ismask=false, $imgmask=false, 
//    $border=0, $fitbox=false, $hidden=false, $fitonpage=false, $alt=false, $altimgs=array()


$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta_ov_sup.png' , 13 , 10 , 190, 20, 'PNG', '', '', false, 300, '', 
  	            false, false, 0, false, false, false);

$pdf->Image(dirname(__FILE__) . '/../../images/nota_venta_ov_inf.png' , 13 , 247 , 190, 18, 'PNG', '', '', true, 300, '', 
	            false, false, 0, false, false, false);


$pdf->SetFont('Helvetica', '', 12, '', 'false');

$yy = 40;

$clave_sucursal = $this->Equiposmodel->get_clave_sucursal();

$pdf->writeHTMLCell($w=0, $h=0, $x=175, $y=18 , $clave_sucursal . " " . $numero_remision, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->SetFont('Helvetica', '', 12, '', 'false');

$yy = $yy + 10;

$pdf->writeHTMLCell($w=0, $h=0, $x=135, $y=$yy , "Fecha:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=180, $y=$yy , $this->_cambiaf_a_normal($fecha), $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);



$yy = $yy + 10;


$pdf->writeHTMLCell($w=215, $h=5, $x=0, $yy, "<b>Información del Cliente</b>"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='C', $autopadding=true);

$yy = $yy + 10;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Nombre:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=60, $yy, $cliente['nombre']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Teléfono:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono1']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$yy = $yy + 7;

$pdf->writeHTMLCell($w=40, $h=5, $x=20, $yy, "Correo electrónico:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=60, $yy, $cliente['correo_electronico']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


$pdf->writeHTMLCell($w=40, $h=5, $x=120, $yy, "Móvil:"  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=80, $h=5, $x=140, $yy, $cliente['telefono2']  , 
	   $border=$bord, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$yy = $yy + 10;




$yy = $yy + 10;

$style = array('width' => 0.2, 'cap' => 'butt', 'join' => 'miter',  'phase' => 10, 'color' => array(0, 0, 0));




$ddy = 10;



 
 $linea = 0;
 $total = 0;


  $pdf->Line(15, $yy+18, 200, $yy+18, $style);


  $linea = $linea + 1;

      $pdf->writeHTMLCell($w=0, $h=0, $x=16 + $ddx, $y=$yy + $ddy + $linea,"Cantidad", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=$yy + $ddy + $linea, "Concepto", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=$yy + $ddy + $linea, "Precio unitario", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
      $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=$yy + $ddy + $linea, "Importe", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$linea = $linea + 7;

 foreach ($articulos as $servicio) {
      $pdf->writeHTMLCell($w=0, $h=0, $x=20 + $ddx, $y=$yy + $ddy + $linea,"1", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
	 
      $pdf->writeHTMLCell($w=0, $h=0, $x=40 + $ddx, $y=$yy + $ddy + $linea, $servicio['descripcion'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
       $pdf->writeHTMLCell($w=0, $h=0, $x=150 + $ddx, $y=$yy + $ddy + $linea, "$" . number_format($servicio['precio'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=$yy + $ddy + $linea, "$" . number_format($servicio['precio'], 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

	 $linea = $linea + 5; 
	 $total += $servicio['precio'];
 }

$pdf->Line(15, 178 + $ddy, 200, 178 + $ddy, $style);


       $pdf->writeHTMLCell($w=0, $h=0, $x=160 + $ddx, $y=180 + $ddy , "Total", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=185 + $ddx, $y=180 + $ddy , "$" . number_format($total, 2, '.', ','), $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 

       $pdf->writeHTMLCell($w=0, $h=0, $x=20 + $ddx, $y=180 + $ddy , "Forma de pago:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
 
       $pdf->writeHTMLCell($w=0, $h=0, $x=58 + $ddx, $y=180 + $ddy , $articulos[0]['forma_de_pago'], $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=20, $y=190 + $ddy , "No. de Nota:", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$pdf->writeHTMLCell($w=0, $h=0, $x=58, $y=190 + $ddy , $articulos[0]['numero_remision'], $border=0, $ln=1, $fill=0, $reseth=true, $align='L', $autopadding=true);




$pdf->Output('Nota_de_venta.pdf', 'I'); 


}	  


	
	
}

