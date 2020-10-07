<?php
class Reportesmodel extends CI_Model {
	
function Formmodel() {
// load the parent constructor
parent::Model();
}

function getReporte($reporte){
	$arr = $this->db->get_where('reportes', array("reporte"=>$reporte), 10000, 0);	
	$arrres = $arr->result();
	return $arrres;
}

function getListaReportes() {
	    $sql = "select distinct reporte from reportes order by reporte";
		$arr = ( $this->db->query($sql)); 
	    $result = ($arr->result_array());
		$ret = array(); //print_r($result); die();
		foreach ($result as $item) {
			$ret[$item['reporte']] = $item['reporte'];
		}
		return $ret;
}

function preview($reporte,$ardata,$pagesize="LETTER",$layout="P") {
		$this->load->library('Pdf');
		$pdf = new Pdf($layout, 'mm', $pagesize, true, 'UTF-8', false);
		$pdf->SetTitle('Reporte');
		$pdf->SetAuthor('Author');
        $pdf->SetDisplayMode('real', 'default');
        $pdf->AddPage();
	//echo dirname(__FILE__); die();
	
    $this->db->order_by("id");
	$arr = $this->db->get_where('reportes', array("reporte"=>$reporte), 10000, 0);	
	$arrres = $arr->result();
	foreach ($arrres as $k=>$v) {
		switch ($v->tipo) {
			case "TEXTO":
			        $pdf->SetFont($v->fontname, '', $v->fontsize, '', 'false');
                    $pdf->writeHTMLCell($v->w, $v->h, $v->x , $v->y , $v->texto, 
					        $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);	
					break;		
			case "CAMPO":
			        $pdf->SetFont($v->fontname, '', $v->fontsize, '', 'false');
                    $pdf->writeHTMLCell($v->w, $v->h, $v->x , $v->y , $ardata[$v->tabla][$v->campo], 
					        $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);	
					break;		
			case "OPCIONMARCA":
			        $pdf->SetFont($v->fontname, '', $v->fontsize, '', 'false');
					if ($v->valormarca==$ardata[$v->tabla][$v->campo])
                        $pdf->writeHTMLCell($v->w, $v->h, $v->x , $v->y , ($v->texto!="" ? $v->texto : "X") , 
					        $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);	
					break;		
			case "IMAGEN":
                    $pdf->Image(dirname(__FILE__) . '/../..' . $v->texto, $v->x, $v->y, $v->w, $v->h, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);					
					break;		
					
					
		}
	}
	
	$pdf->Output('Reporte' . '.pdf', 'I'); 
}

function tiposDropdown () {
	$tipos = array("TEXTO"=>"Texto","CAMPO"=>"Campo","OPCIONMARCA"=>"Opcion marca","IMAGEN"=>"Imagen");
	return $tipos;
}


}

?>