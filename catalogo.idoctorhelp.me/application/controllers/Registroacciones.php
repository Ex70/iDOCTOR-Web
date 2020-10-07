<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registroacciones extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{
		$this->load->model("Registroaccionesmodel");
        if (isset($_POST['anio']))
        	$anio = $_POST['anio'];
        else $anio = date("Y");

        if (isset($_POST['mes']))
        	$mes = $_POST['mes'];
        else $mes = date("m");

        if (isset($_POST['dia']))
        	$dia = $_POST['dia'];
        else $dia = date("d");

		$result = $this->Registroaccionesmodel->consulta_por_dia($anio,$mes,$dia);
		$result['result'] = $result;
		$result['anio'] = $anio;
		$result['mes'] = $mes;
		$result['dia'] = $dia;
		$this->load->view("inicio/top1");
		$this->load->view("registroacciones/registroindex",$result);
		$this->load->view("inicio/bottom1");
	
    }	
		 
		



	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */