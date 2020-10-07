<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estados extends CI_Controller {

	
    public function __construct()
       {
            parent::__construct();
			$this->output->enable_profiler(FALSE);
           
       }	 

	 
	public function index()
	{		
	
        $wh = "";	
		
		
			
	

		
		$arr = ( $this->db->query('select * from estados'));
	    $data['result'] = ($arr->result_array());
		
		 $this->load->view('inicio/top1'); 
		 $this->load->view('estados/estadosindex',$data); 
		 $this->load->view('inicio/bottom1'); 
		 
		
	}

	public function modificar() {
		redirect("estados/index");
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */