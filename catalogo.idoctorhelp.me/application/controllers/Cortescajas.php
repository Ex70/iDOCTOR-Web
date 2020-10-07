<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cortescajas extends CI_Controller {
	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{		
		$this->load->model("Cortescajasmodel");
        $this->load->library('pagination');
        $lim = $this->uri->segment(3,'0');
		
		$cortescajas = $this->Cortescajasmodel->get_cortescajas_where_str("", $lim , 100);
		//$arr = ( $this->db->query('select * from cortescajas limit ' . $lim . ',100'));
	    $data['result'] = $cortescajas;
		
		$config['base_url'] = '/index.php/cortescajas/index';
		$arrtot = ( $this->db->query('select * from cortescajas'));
        $config['total_rows'] = $arrtot->num_rows();
        $config['per_page'] = 100; 
		$this->pagination->initialize($config); 
		$this->load->view('inicio/top1'); 
		$this->load->view('cortescajas/cortescajasindex',$data); 
		$this->load->view('inicio/bottom1'); 
	}

	public function agregar() 
	{
		$this->load->model("Cortescajasmodel");
		$data = $this->Cortescajasmodel->get_campos();
		$data['fecha'] = date("Y-m-d");
		$data['hora'] = date("H:i:s");
		$data['bil_500'] = 0;
		$data['bil_200'] = 0;
		$data['bil_100'] = 0;
		$data['bil_50'] = 0;
		$data['bil_20'] = 0;
		$data['mon_10'] = 0;
		$data['mon_5'] = 0;
		$data['mon_2'] = 0;
		$data['mon_1'] = 0;
		$data['mon_0_5'] = 0;
		$data['mon_0_2'] = 0;
		$data['mon_0_1'] = 0;

		$data['notas'] = 0;
		$data['comprobante_de_gastos'] = 0;
		$data['vales_caja'] = 0;
		$data['saldo_en_caja_comprobacion'] = 0;

		$fechaturno = $this->Cortescajasmodel->fecha_turno_saldo_nuevo();
		$data['fecha'] = $fechaturno['fecha'];
		$data['turno'] = $fechaturno['turno'];
		$data['saldo_inicial'] = $fechaturno['saldo_en_caja_comprobacion'];


		$this->load->view('inicio/top1'); 
		$this->load->view('cortescajas/detallecortecaja',$data); 
		$this->load->view('inicio/bottom1'); 
	}

	public function modificar() {
		$this->load->model("Cortescajasmodel");
		$data = $this->Cortescajasmodel->get_detalle($this->uri->segment(3));
		$this->load->view('inicio/top1'); 
		$this->load->view('cortescajas/detallecortecaja',$data); 
		$this->load->view('inicio/bottom1'); 

	}

	public function guardar() 
	{
		$this->load->model("Cortescajasmodel");
		$this->Cortescajasmodel->guardar($_POST);
		redirect("cortescajas/index");
	}


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */