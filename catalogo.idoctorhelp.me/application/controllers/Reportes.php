<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

	 
	public function index()
	{
		  if ($this->session->userdata('nivel')==1) {	
		     $this->load->model('Reportesmodel');
			 $listareportes = $this->Reportesmodel->GetListaReportes(); 

		 $data['listareportes'] = $listareportes;
		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/reportesindex',$data); 
		 $this->load->view('inicio/bottom1');
		 }
		
	}
	
	public function detallereporte() {
		$this->load->model('Reportesmodel');
		$result = array();
		$reporte = $_REQUEST['reporte'];
		$result['elementos'] = $this->Reportesmodel->getReporte($reporte);
		$result['tipos'] = $this->Reportesmodel->tiposDropdown();
		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/detallereporte',$result); 
		 $this->load->view('inicio/bottom1');		
	}
	
	public function guardarreporte() {
		print_r($_POST);
	}
	
	public function ordenesentregadasporfecha()
	{
		//  if ($this->session->userdata('nivel')==1) {	

		
		$data['titulo'] = "Ordenes entregadas por fecha";

      if ($this->input->post('fechaini')) {
          $sql =  "select equipos.id,equipos.num_orden,clientes.nombre,bitacoras.fecha,equipos.tipo from equipos "; 
          $sql .= "inner join bitacoras ";
          $sql .= "on equipos.estatus_id=bitacoras.estatus_id ";
          $sql .= "and equipos.id=bitacoras.equipo_id ";
		  $sql .= "inner join clientes ";
          $sql .= "on equipos.cliente_id=clientes.id ";
          $sql .= "where bitacoras.estatus='Entregado' ";
          $sql .= "and bitacoras.fecha between '" . $this->input->post('fechaini') . "' and '" . $this->input->post('fechafin') . "' ";
		$arr = ( $this->db->query($sql)); 
	    $data['result'] = ($arr->result_array());
	  }
	  else $data['result'] = "";
		
		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/ordenesentregadasporfecha',$data); 
		 $this->load->view('inicio/bottom1');		 		
	}
	
	public function piezaspendientes() {
          $sql  = "select equipos.id,equipos.num_orden,equipos.tipo,piezas.pieza_id, ";
          $sql .= "catpiezas.descripcion,clientes.nombre,piezas.fecha from equipos ";
          $sql .= "inner join piezas on piezas.equipo_id=equipos.id ";
          $sql .= "inner join catpiezas on piezas.pieza_id=catpiezas.id ";
          $sql .= "inner join clientes on clientes.id=equipos.cliente_id ";
          $sql .= "where equipos.situacion='A' and piezas.surtida='N'";
          $sql .= "order by piezas.fecha ";

 		$arr = ( $this->db->query($sql)); 
	    $data['result'] = ($arr->result_array());
	    
         $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/piezaspendientes',$data); 
		 $this->load->view('inicio/bottom1');
	}

	public function exportarequipos() {
		$data = array();
		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/equipospormes',$data); 
		 $this->load->view('inicio/bottom1');

	}

	public function reporteequipospordia() {
		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/equipospordia'); 
		 $this->load->view('inicio/bottom1');		
	}

	public function equipospordia() {
        $this->load->model("Equiposmodel");
        $equipos_recibidos = $this->Equiposmodel->get_equipos_where_str("where fecha_recibido='" . $_POST['fecha'] . "' order by num_orden ");
        $equipos_entregados = $this->Equiposmodel->get_equipos_where_str("where fecha_de_entrega='" . $_POST['fecha'] . "'  order by num_orden ");
        $data['equipos'] = array_merge($equipos_recibidos,$equipos_entregados);
        //print_r($equipos);die();

		 $this->load->view('inicio/top1'); 
		 $this->load->view('reportes/equipospordia',$data); 
		 $this->load->view('inicio/bottom1');		
	}


    public function cierredemes() {
    	//$this->output->enable_profiler(TRUE);
		$this->load->model("equipos/Equiposmodel");
        if ($this->session->userdata('nivel')==1) {

		if ($this->uri->segment(3,'')=='') {
       	  redirect('/reportes/cierredemes/' . date("Y") . "/" . date("n") . "/XA1");
		}

        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion($this->uri->segment(5),$this->uri->segment(3),$this->uri->segment(4));
		$data['sucursales'] = sucursales_nombres_dd();
		$this->load->view('inicio/top1'); 
		$this->load->view("reportes/cierredemes",$data); 
		$this->load->view('inicio/bottom1');  

        }
    } 

      /*   public function cierredemesvarios($seleccionados, $anio, $mes) {
    	//$this->output->enable_profiler(TRUE);
       $this->load->model("equipos/Equiposmodel");
        if ($this->session->userdata('nivel')==1) {
		//$input = $this->input->post('input_name');
		//print_r($input);
        if ($this->uri->segment(3,'')=='') {
       	  redirect('/reportes/cierredemesvarios/MI2/2018/10');
       }

       $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($seleccionados, $anio, $mes);
		$data['sucursales'] = sucursales_nombres_dd();
		$this->load->view('inicio/top1'); 
		$this->load->view('reportes/checkboxsucursales');
       $this->load->view("reportes/cierredemesvarios",$data); 
		$this->load->view('inicio/bottom1');  

        }
    }*/


    public function cierredemesvarios() {
    	//$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     if ($this->session->userdata('nivel')==1) {
		//$input = $this->input->post('input_name');
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = [];
      $j = 0;
      for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) { 
        if($this->input->post($sucursales_keys[$i]) == true){ //Pregunta si el item con id o name esta activado
         $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
         $j++;
       }
     }
     

     if(empty($sucursales_seleccionadas)){

      $data['cierredemes'] = $sucursales_seleccionadas;
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1'); 
      $this->load->view('reportes/checkboxsucursales');
      $this->load->view("reportes/cierredemesvarios",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $this->input->post("anios"), $this->input->post("mes"));
      $data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1'); 
      $this->load->view('reportes/checkboxsucursales');
      $this->load->view("reportes/cierredemesvarios",$data); 
      $this->load->view('inicio/bottom1');  
    }

  }
}

    public function cierredemespropias() {
      //$this->output->enable_profiler(TRUE);
      $this->load->model("equipos/Equiposmodel");
      if ($this->session->userdata('nivel')==1) {
        //$input = $this->input->post('input_name');
        //$sucursales_keys = array_keys(sucursales_nombres_dd());
        $sucursales_seleccionadas = [];
        $sucursales_seleccionadas[0] = "XA1";
        $sucursales_seleccionadas[1] = "XC1";
        $sucursales_seleccionadas[2] = "XU1";
        $sucursales_seleccionadas[3] = "VA1";
        $sucursales_seleccionadas[4] = "CZ1";
        $sucursales_seleccionadas[5] = "CL1";
        $sucursales_seleccionadas[6] = "OZ1";

        $anio = date("Y");
        $mes =  date("m");
        $dia =  date("d");

        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1'); 
        $this->load->view("reportes/cierredemes",$data); 
        $this->load->view('inicio/bottom1');  
      }
    }

    public function cierredemesculiacan() {
      //$this->output->enable_profiler(TRUE);
      $this->load->model("equipos/Equiposmodel");
      if ($this->session->userdata('nivel')==1) {
        //$input = $this->input->post('input_name');
        //$sucursales_keys = array_keys(sucursales_nombres_dd());
        $sucursales_seleccionadas = ['CS1'];

        $anio = date("Y");
        $mes =  date("m");
        $dia =  date("d");

        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1'); 
        $this->load->view("reportes/cierredemes",$data); 
        $this->load->view('inicio/bottom1');  
      }
    }

    public function cierredemespozarica() {
      //$this->output->enable_profiler(TRUE);
      $this->load->model("equipos/Equiposmodel");
      if ($this->session->userdata('nivel')==1) {
        //$input = $this->input->post('input_name');
        //$sucursales_keys = array_keys(sucursales_nombres_dd());
        $sucursales_seleccionadas = ['PR1', 'TX1'];

        $anio = date("Y");
        $mes =  date("m");
        $dia =  date("d");

        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1'); 
        $this->load->view("reportes/cierredemes",$data); 
        $this->load->view('inicio/bottom1');  
      }
    }

    public function cierredemesvillahermosa() {
      //$this->output->enable_profiler(TRUE);
      $this->load->model("equipos/Equiposmodel");
      if ($this->session->userdata('nivel')==1) {
        //$input = $this->input->post('input_name');
        //$sucursales_keys = array_keys(sucursales_nombres_dd());
        $sucursales_seleccionadas = ['VM1', 'VM2'];

        $anio = date("Y");
        $mes =  date("m");
        $dia =  date("d");

        $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios($sucursales_seleccionadas, $anio, $mes);
        $data['sucursales'] = sucursales_nombres_dd();
        $this->load->view('inicio/top1'); 
        $this->load->view("reportes/cierredemes",$data); 
        $this->load->view('inicio/bottom1');  
      }
    }


	public function equiposdiapropias() {
    
		$this->load->model("equipos/Equiposmodel");
		if ($this->session->userdata('nivel')==1) {

			$sucursales_seleccionadas = [];
		  
			$sucursales_seleccionadas[0] = "XA1";
			$sucursales_seleccionadas[1] = "XC1";
			$sucursales_seleccionadas[2] = "XU1";
			$sucursales_seleccionadas[3] = "VA1";
			$sucursales_seleccionadas[4] = "CZ1";
			$sucursales_seleccionadas[5] = "CL1";
			$sucursales_seleccionadas[6] = "OZ1";
			
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			
			
			$data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios_dia($sucursales_seleccionadas, $anio, $mes, $dia);
			//$data['sucursales'] = sucursales_nombres_dd();
			$this->load->view('inicio/top1'); 
			//$this->load->view('reportes/checkboxsucursales');
			$this->load->view("reportes/cierredemesvarios",$data); 
			$this->load->view('inicio/bottom1');  
		}

	}

	public function equiposdiaculiacan() {
    
		$this->load->model("equipos/Equiposmodel");
		if ($this->session->userdata('nivel')==1) {

			$sucursales_seleccionadas = ['CS1'];
									
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			
			$data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios_dia($sucursales_seleccionadas, $anio, $mes, $dia);
			//$data['sucursales'] = sucursales_nombres_dd();
			$this->load->view('inicio/top1'); 
			//$this->load->view('reportes/checkboxsucursales');
			$this->load->view("reportes/cierredemesvarios",$data); 
			$this->load->view('inicio/bottom1');  
		}

	}

	public function equiposdiapozarica() {
    
		$this->load->model("equipos/Equiposmodel");
		if ($this->session->userdata('nivel')==1) {

			$sucursales_seleccionadas = [];
		  
			$sucursales_seleccionadas = ['PR1', 'TX1'];
			
			$anio = date("Y");
			$mes = 	date("m");
			$dia = 	date("d");
			
			
			$data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios_dia($sucursales_seleccionadas, $anio, $mes, $dia);
			//$data['sucursales'] = sucursales_nombres_dd();
			$this->load->view('inicio/top1'); 
			//$this->load->view('reportes/checkboxsucursales');
			$this->load->view("reportes/cierredemesvarios",$data); 
			$this->load->view('inicio/bottom1');  
		}
	}

  public function equiposdiavillahermosa() {
    
    $this->load->model("equipos/Equiposmodel");
    if ($this->session->userdata('nivel')==1) {

      $sucursales_seleccionadas = [];
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      
      $anio = date("Y");
      $mes =  date("m");
      $dia =  date("d");
      
      
      $data['cierredemes'] = $this->Equiposmodel->get_cierre_de_mes_administracion_varios_dia($sucursales_seleccionadas, $anio, $mes, $dia);
      //$data['sucursales'] = sucursales_nombres_dd();
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsucursales');
      $this->load->view("reportes/cierredemesvarios",$data); 
      $this->load->view('inicio/bottom1');  
    }

  }
	
public function supervision() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = [];
      $j = 0;
      for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) { 
        if($this->input->post($sucursales_keys[$i]) == true){
         $sucursales_seleccionadas[$j] = $sucursales_keys[$i];
         $j++;
       }
     }
     if(empty($sucursales_seleccionadas)){
      $data['result'] = $sucursales_seleccionadas;
      $this->load->view('inicio/top1'); 
      $this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/supervision",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      $this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/supervision",$data); 
      $this->load->view('inicio/bottom1');  
    }

  }
}


//---------------------------------------------------------
// RECIBIDOS DEL DIA
//---------------------------------------------------------

public function recibidosdiapropias() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'VA1', 'XA1', 'XC1', 'XU1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      //$this->load->view("reportes/recibidosdiapropias",$data);
	  $this->load->view("reportes/equiposrecibidos",$data);	  
      $this->load->view('inicio/bottom1');  
    }
  }
}

public function recibidosdiaculiacan() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['CS1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/recibidosdiagestionadas",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}


public function recibidosdiapozarica() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/recibidosdiafranquicias",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/recibidosdiapozarica",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}

public function recibidosdiavillahermosa() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['VM1', 'VM2'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/recibidosdiavillahermosa",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosdiarios($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/recibidosdiavillahermosa",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}


//---------------------------------------------------------
// RECIBIDOS DEL MES
//---------------------------------------------------------

public function recibidosmespropias() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      $sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['CZ1', 'CL1', 'OZ1', 'VA1', 'XA1', 'XC1', 'XU1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}

public function recibidosmesculiacan() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      //$sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['CS1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}

public function recibidosmespozarica() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      //$sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}

public function recibidosmesvillahermosa() {
      //$this->output->enable_profiler(TRUE);
     $this->load->model("equipos/Equiposmodel");
     $this->load->library('pagination'); 
     if ($this->session->userdata('nivel')==1) {
    //$input = $this->input->post('input_name');
    //print_r($input);
      //$sucursales_keys = array_keys(sucursales_nombres_dd());
      $sucursales_seleccionadas = ['PR1', 'TX1'];
      
      if(empty($sucursales_seleccionadas)){
      $data['result'] = $this->Equiposmodel->get_supervision_sucursales(0);
      $this->load->view('inicio/top1'); 
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1'); 
    }else{
      $data['result'] = $this->Equiposmodel->get_registrosmes($sucursales_seleccionadas);
      $this->load->view('inicio/top1'); 
      //$this->load->view('reportes/checkboxsupervision');
      $this->load->view("reportes/equiposrecibidos",$data); 
      $this->load->view('inicio/bottom1');  
    }
  }
}



public function supervisionss() {
      //$this->output->enable_profiler(TRUE);
  $this->load->model("equipos/Equiposmodel");

  if ($this->session->userdata('nivel')==1) {
    $this->load->model('Calendariomodel');

    $this->load->library('pagination'); 
    
    //$this->x_week_range($sd,$ed,fecha_actual_mysql());
    
    $sucursal_id = $this->session->sucursal_id;


  
    $qry = "select ";
    $qry .= "T1.ID, T1.ESTATUS, T1.NUM_ORDEN, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO, T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID, CURRENT_DATE-T1.fecha_recibido as dias_vencidos, SUM(T2.SUBTOTAL) AS SUBTOTAL_COMPLETO";
    //$qry .= ", T2.COSTO, T2.DESCRIPCION, T2.DESCUENTO, T2.SUBTOTAL";
    $qry .= " FROM ";
    $qry .= "EQUIPOS T1 INNER JOIN SERVICIOS T2 ON T1.ID=T2.EQUIPO_ID";
    $qry .= " WHERE ";
    $qry .= "T1.SUCURSAL_ID = 'XA1' AND T1.ESTATUS <> 'Entregado' AND T1.ESTATUS <> 'Abandonado' AND T1.ESTATUS <> 'Donado a reciclaje' AND T1.ESTATUS <> 'Garant' AND T1.ESTATUS <> 'Donado'";
    $qry .= " GROUP BY T1.NUM_ORDEN, T1.ID, T1.ESTATUS, T1.TIPO, T1.MODELO, T1.NUM_SERIE, T1.CAPACIDAD, T1.FECHA_RECIBIDO, T1.HORA_RECIBIDO,  T1.DESCRIPCION_PROBLEMA, T1.CONDICIONES_RECEPCION_EQ, T1.NUMERO_REMISION, T1.FECHA_DE_ENTREGA, T1.CLASE, T1.SITUACION, T1.DIAGNOSTICO, T1.SUCURSAL_ID;";


        $arr = $this->db->query($qry);

      $data['result'] = $arr->result_array();


    $data['titulo'] = "Calendario de operaciones";
    $data['urlregresar'] = "/index.php/inicio/proceso";
    //$data['fechainicio'] = $this->_cambiaf_a_normal($sd);
    //$data['fechatermino'] = $this->_cambiaf_a_normal($ed);  
    
     $this->load->view('inicio/top1'); 
     $this->load->view('reportes/checkboxsucursales');
     $this->load->view('equipos/supervision',$data);  
     $this->load->view('inicio/bottom1');     
  }
}

    public function validarcheckbox(){
    	print_r("bien");

    	$sucursales_keys = array_keys(sucursales_nombres_dd());
    	$sucursales_seleccionadas = [];
    	if(empty($sucursales_seleccionadas)){
    		print_r("Esta vacio");
    	}

    	$j = 0;
    	for ($i=0; $i < sizeof(sucursales_nombres_dd()); $i++) { 
    		if($this->input->post($sucursales_keys[$i]) == true){
    			$sucursales_seleccionadas[$j] = $sucursales_keys[$i];
    			$j++;
    		}
    	}

    	    $valor = $this->input->post("anios");
    		print_r($valor);
    		

    	/*if($this->input->post('XADSA') == false){
    		print_r("Esta vacio");
    	}

    	if($this->input->post('XC1') == true){
    		print_r("Esta lleno");
    	}*/

    	//$completed_todos[0] = $this->input->post('XA1');
    	//print_r($completed_todos[0]);

    	print_r($sucursales_seleccionadas);
    	
    	//print_r(array_keys(sucursales_nombres_dd())[5]);
    }     



function exportarcierredemes() {
   ini_set('memory_limit','32M');
   $this->load->helper("exportacion");
   $this->load->model("equipos/Equiposmodel");
   $tabla = $this->Equiposmodel->get_cierre_de_mes_administracion($this->uri->segment(5),$this->uri->segment(3),$this->uri->segment(4));



   $xls = exporta_excel($tabla);

    $this->output->set_content_type('application/vnd.ms-excel');
    $this->output->set_header("Content-Disposition: attachment; filename=cierredemes_" . $this->uri->segment(5) . "-" . $this->uri->segment(4) . "_" . $this->uri->segment(5) .".xls");
    $this->output->set_output($xls);   

}



	
}


