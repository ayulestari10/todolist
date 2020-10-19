<?php
  class ICT_Controller extends CI_Controller{
    public function __construct($needIsLogin = true){
      parent::__construct();
      if($needIsLogin){
        $this->isLogin();
      }
      //$this->getMenuData();
    }
    public $err_message;

    protected function checkPrivilege($user_type){
      $my_user_type = userInformation()["usergroup_code"];
      $match = false;
      foreach ($user_type as $key => $value) {
        if($my_user_type == $value){
          $match = true;
          break;
        }
      }
      if(!$match){
        return redirect(base_url()."Home");
      }
    }

    protected function validateAllInput($input){
    	// NOTES:
    	// index 0 of input = RULE (required, maxsize, etc)
    	// index 1 of input = FIELD
    	// index 2 of input = VALUE
    	// index 3,4,5,... of input = FLAG for another validation

    	$no_error = true;

    	if($input != null && count($input) > 0){
    		foreach ($input as $field) {
          if(strtoupper($field[0]) == "EQUAL2FIELD"){
            $this->validateEqual2Field($field[1], $field[2],$field[3],$field[4]);
          }
          if(strtoupper($field[0]) == "EMAILFORMAT"){
            $this->validateMailFormat($field[1], $field[2]);
          }
    			if(strtoupper($field[0]) == "REQUIRED"){
    				$this->validateRequired($field[1], $field[2]);
    			}
          if(strtoupper($field[0]) == "MAXLENGTH"){
            $this->validateMaximumLength($field[1], $field[2], $field[3]);
          }
          if(strtoupper($field[0]) == "MINLENGTH"){
            $this->validateMinimumLength($field[1], $field[2], $field[3]);
          }
          if(strtoupper($field[0]) == "EQUALLENGTH"){
            $this->validateEqualLength($field[1], $field[2], $field[3]);
          }
          if(strtoupper($field[0]) == "EMPTYLIST"){
              $this->listMustMoreThan1($field[1], $field[2]);
          }
          if(strtoupper($field[0]) == "MUSTGREATERTHAN"){
              $this->listMustGreaterThan($field[1], $field[2], $field[3]);
          }
    		}

    		if($this->err_message != null && count($this->err_message) > 0){
    			$this->session->set_flashdata("err_msg", $this->err_message);
    			$no_error = false;
    		}
    	}

    	return $no_error;
    }

    public function generateExcel($title,$fields,$datas){ 
      //title parameter must be string value 
      //fields parameter must be array value
      //datas parameter must be array on array value

      $this->load->library("ExcelPrint");

      //membuat objek
      $objPHPExcel = new PHPExcel();
      // Nama Field Baris Pertama

      $col = 0;
      foreach ($fields as $field)
      {
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
          $col++;
      }

      // Mengambil Data
      $row = 2;
      $no_row = 1;

      if($datas != null & count($datas) > 0){
        foreach ($datas as $data) {
            $col_data = 0;
            foreach ($data as $data_val) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col_data++, $row, $data_val);
            }
            $row++;
          }
      }
      $objPHPExcel->setActiveSheetIndex(0);

      //Set Title
      $objPHPExcel->getActiveSheet()->setTitle($title);

      //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

      //Header
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Cache-Control: post-check=0, pre-check=0", false);
      header("Pragma: no-cache");
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

      //Nama File
      header('Content-Disposition: attachment;filename="'+$title+'.xlsx"');

      //Download
      $objWriter->save("php://output");
    }
    private function validateEqual2Field($field_label, $value, $field_label2, $value2){
      if($value != $value2){
        $this->err_message[] = "Field <strong>".$field_label."</strong> is Not Equal With Field <strong>".$field_label2."</strong>.";
      }
    }

    private function validateRequired($field_label, $value){
    	if($value == "" || $value == null){
    		$this->err_message[] = "Field <strong>".$field_label."</strong> is Required.";
    	}
    }

    private function validateMinimumLength($field_label, $value,$value2 ){
      if(strlen($value) < $value2){
        $this->err_message[] = "Field <strong>".$field_label."</strong> Minimum Length is ".$value2." Digits.";
      }
    }

    private function validateMaximumLength($field_label, $value,$value2 ){
      if(strlen($value) > $value2){
        $this->err_message[] = "Field <strong>".$field_label."</strong> Maximum Length is ".$value2." Digits.";
      }
    } 

    private function validateEqualLength($field_label, $value, $value2 ){
      if(strlen($value) != $value2){
        $this->err_message[] = "Field <strong>".$field_label."</strong> Length Must be ".$value2." Digits.";
      }
    }

    private function listMustMoreThan1($field_label, $value){
        if(count($value)  <= 0){
            $this->err_message[] = "<strong>".$field_label."</strong> Must More Than 1.";
        }
    }

    private function listMustGreaterThan($field_label, $value, $number){
        if(count($value)  <= 0){
            $this->err_message[] = "<strong>".$field_label."</strong> Must Greater Than ".$number.".";
        }
    }

    private function validateMailFormat($field_label, $value){
      if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
          $this->err_message[] = "<strong>".$field_label."</strong> Format is Invalid.";
      }
    }

    private function isLogin(){
        if(!isset($_SESSION[__USERINFO]) || $_SESSION[__USERINFO] == null){
            return redirect(base_url()."Login");
        }
    }

    private function getMenuData(){
      if(!isset($_SESSION[__MENU])){
        $menu_full_information = null;
        //load model
        $this->load->model("M_PrivilegeInfo");
        $this->load->model("M_Menu");
        //-----------------------------------
        $filter_privilege["usergroup_code"] = userInformation()["usergroup_code"];
        $sort_privilege[] = array("line_number","ASC");

        $privilege_info = $this->M_PrivilegeInfo->getAllDataPrivilegeInfo($filter_privilege, $sort_privilege);
        if($privilege_info != null){
          foreach ($privilege_info as $value) {
            $menu = null;
            $filter_menu["id"] = $value["parent_id"];

            $current_menu = $this->M_Menu->getAllDataMenu($filter_menu);
            checkInput($current_menu);
            while ($current_menu != null && count($current_menu) > 0) {
              # code...
            }
          }
        }
      }
    }


    public function julianToGregorian($julian)
    {
        $data['isposted'] = true;
        
        // $julian=$this->input->post('julian');
        $julian2 = $julian + 1900000;
        $year = substr($julian2,0,4);
        $totmonth = substr($julian2,4,3);

        $listmonth=[31,28,31,30,31,30,31,31,30,31,30,31];

        if($year%4==0)
        {
            $listmonth[1]=29;
        }
        $month=0;
        $day=0;
        for($i=0;$i<12;$i++)
        {
            $month++;
            
            if($totmonth - $listmonth[$i] <= 0)
            {
                $day=(int)$totmonth;
                break;
            }
            $totmonth = $totmonth-$listmonth[$i];
        }
            $data['year']=$year;
            $data['month']=$month;
            $data['day']=$day;
            $data['full_date'] = $day."-".$month."-".$year;
            
            return $data;
    }


    public function gregoriantoJulian($gregorian)
    {
        $date=date('d',strtotime($gregorian));
        $month=date('m',strtotime($gregorian));
        $year=date('Y',strtotime($gregorian));
        
        $julian =($year*1000) - 1900000;
        $day=mktime(0,0,0,$month,$date,$year);
        $day2=date("z",$day);
        $julian= $julian + $day2;
        $julian2=$julian+1;

        $data['julian']=$julian2;

        return $data;
    }

    public function generatePDFbyString($html, $title_name, $use_watermark = false, $use_page_number = false){
      $this->load->library("Pdf2");
      // $mpdf=new mPDF('c');
      // $mpdf=new mPDF('utf-8', 'A4-L', '20', '', 2, 2, 2, 2, 2, 2,'L');


      $mpdf=new mPDF('',    // mode - default ''
       '',    // format - A4, for example, default ''
       30,     // font size - default 0
       '',    // default font family
       1,    // margin_left
       1,    // margin right
       1,     // margin top
       1,    // margin bottom
       1,     // margin header
       1,     // margin footer
       'P');  // L - landscape, P - portrait      $mpdf->AddPage("portrait");
      $mpdf->showImageErrors = true;
      $mpdf->debug = true;
      if($use_watermark){
        $img_file = "assets/img/LOGO_SEMEN_BATURAJA.png";
        $mpdf->SetWatermarkImage($img_file);
        $mpdf->showWatermarkImage = true;
        $mpdf->watermarkImageAlpha = 0.07;
      }

      if($use_page_number){
        $mpdf->setFooter('{PAGENO}');  
      }

      $mpdf->WriteHTML($html);
      return $mpdf->Output($title_name.".pdf","D");
    }

    public function generatePDFbyURL($url, $title_name, $use_watermark = false, $use_page_number = false){
      ob_start();
      $this->load->view("LihatData/PrintListDO",$this->data);
      $html = ob_get_contents();
      ob_end_clean();
    }

    /**
     * @author Azhary Arliansyah
     *
     * Displaying pre-formatted value of a variable using pre and var_dump for debugging purpose
     */
    protected function dump($var)
    {
      echo '<pre>';
      var_dump($var);
      echo '</pre>';
    }

    /**
     * @author Azhary Arliansyah
     *
     * Shorter syntax for getting POST-ed value
     */
    protected function POST($name)
    {
      return $this->input->post($name);
    }

    /**
     * @author Azhary Arliansyah
     *
     * Uploading files with any extensions
     */
    protected function upload_file($id, $directory, $tag_name = 'userfile', $max_size = 0)
    {
      if ( isset( $_FILES[$tag_name] ) && !empty( $_FILES[$tag_name]['name'] ) )
      {
        $upload_path = realpath(FCPATH . $directory . '/');
        @unlink($upload_path . '/' . $id);
        $config = [
          'file_name'     => $id,
          'allowed_types' => '*',
          'upload_path'   => $upload_path,
          'max_size'      => $max_size
        ];
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload($tag_name);
        return true;
      }
      return FALSE;
    } 

  }
	
?>
