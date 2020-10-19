<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/mpdf/mpdf.php';

class CetakPDF {

	public function __construct()
	{
		
	}

	public function cetak($view_html, $title, $data){
		    $CI   = get_instance();
      	$html = $CI->load->view($view_html, $data, true);

      	$mpdf = new mPDF('','A4',7);
        $mpdf->SetWatermarkImage(base_url().'assets/img/LOGO_SEMEN_BATURAJA.png', 0.1);
        $mpdf->showWatermarkImage = true;	      	
      	$mpdf->AddPage("portrait");
      	$mpdf->setFooter('{PAGENO}');
      	$mpdf->WriteHTML($html);

      	$mpdf->Output($title,"D");
    }   


  public function generatePDF($title, $html){
        $CI     = get_instance();
        $mpdf   = new mPDF('','A4',7);          

        $mpdf->SetWatermarkImage(base_url().'assets/img/LOGO_SEMEN_BATURAJA.png',0.1);
        $mpdf->showWatermarkImage = true;

        $mpdf->AddPage("portrait");
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($html);

        $mpdf->Output($title,"D");
  }
}