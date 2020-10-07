<?
require (APPPATH . 'config/qrcode' . EXT);
require_once ($qrcode['base_directory'] . '/qrlib.php');

class qrcode_library {
	

	private $_config = array();
	
	
	function __construct() {
		# load the config file
		require (APPPATH . 'config/qrcode' . EXT);
		$this -> _config = $qrcode;
		unset($qrcode);
		
	}
	
	function make_qrcode($data, $errorCorrectionLevel= '', $matrixPointSize='')
	{
		if($errorCorrectionLevel == '')
		$errorCorrectionLevel = $this->_config['errorCorrectionLevel'];
		if($matrixPointSize == '')
		$matrixPointSize = $this->_config['matrixPointSize'];
		
		
		$filename = $this->_config['PNG_TEMP_DIR'].''.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
		QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
//		$filename = $this->_config['base_url'].$filename;
        $p = strpos($filename,"..");
		$fn = substr($filename,$p + 2,1000);
		//$filename = "/images/qr/" .$filename;
		//return $filename;
		return $fn;  
	}
	
	

}
