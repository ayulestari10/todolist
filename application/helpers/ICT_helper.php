<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('generateExcel')){    
    function generateExcel($title,$fields,$datas){ 
        //title parameter must be string value
        //fields parameter must be array value
        //datas parameter must be array on array value
        $CI = get_instance();
        $CI->load->library("ExcelPrint");

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
}

    
if ( ! function_exists('importExcel'))
{
    function importExcel($field_name){
        try {
            $CI = get_instance();
            $CI->load->library("ExcelImport");

            $target = basename($_FILES[$field_name]['name']) ;
            move_uploaded_file($_FILES[$field_name]['tmp_name'], $target);
            chmod($_FILES[$field_name]['name'],0777);

            $data = new Spreadsheet_Excel_Reader($_FILES[$field_name]['name'], false);
            $row_count = $data->rowcount($sheet_index=0);
            $result = NULL;
            if($row_count > 1){
                $column_count = $data->colcount();
                $header = NULL;
                //GET HEADER
                for($i = 1; $i <= $column_count; $i++){
                    $header[$i] = $data->val(1, $i);
                }

                //SET ITEMS
                for($i = 2; $i <= $row_count; $i++){
                    $single_result = NULL;
                    for($j = 1; $j <= $column_count; $j++){
                        $single_result[$header[$j]] = $data->val($i, $j)."";
                    }
                    $result[] = $single_result;
                }
            }

            return $result;

        } catch (Exception $e) {
            checkInput($e);
        }
    }

}

if ( ! function_exists('uploadFile'))
{
    function uploadFile($file_name, $upload_path = NULL, $allowed_types = NULL, $max_size = NULL, $max_width = NULL, $max_height = NULL){
      $CI = get_instance();
      $CI->data["upload_file_name"] = null;
      if(empty($_FILES[$file_name]['name'])){
        return true;
      }

      $path = dirname($_SERVER["SCRIPT_FILENAME"])."/upload_path/".$upload_path;
      if (!is_dir($path)) {
        mkdir($path, 0777, TRUE);
      }

      // if(isNotNullAndEmpty($allowed_types)){
      //   $exploded_allowed_format = explode("|", $allowed_types);
      //   $exploded_file_name = explode(".", $_FILES[$file_name]['name']);

      //   $is_not_allowed = false;
      //   $format_file = strtoupper($exploded_file_name[count($exploded_file_name) - 1]);

      //   foreach ($exploded_allowed_format as $key => $value) {
      //       $format = strtoupper($value);
      //       if(trim($format_file) == trim($format)){
      //           $is_not_allowed = true;
      //           break;
      //       }
      //   }

      //   if($is_not_allowed){
      //       $error = array('error' => "File is Not Allowed.");
      //       $CI->session->set_flashdata("err_msg", $error);
      //       return false;
      //   }
      // }

      $config['upload_path']          = $path;
      $config['allowed_types']        = '*';
      if(isNotNullAndEmpty($allowed_types)){
        $config['allowed_types']      = $allowed_types;       
      }
      if(isNotNullAndEmpty($max_size)){
        $config['max_size']      = $max_size;       
      }
      if(isNotNullAndEmpty($max_width)){
        $config['max_width']      = $max_width;       
      }
      if(isNotNullAndEmpty($max_height)){
        $config['max_height']      = $max_height;       
      }

      $CI->load->library('upload', $config);

      if(!$CI->upload->do_upload($file_name)){
        $error = array('error' => $CI->upload->display_errors());
        $CI->session->set_flashdata("err_msg", $error);
        return false;
      }
      else{
        $data = array('upload_data' => $CI->upload->data());
        return $data["upload_data"]["file_name"];
      }
    }
}

if ( ! function_exists('getMonthText'))
{  
    function getMonthText($month_number)
    {   
        $i = 1;
        $month_number = (int)$month_number;
        $month_text[$i++] = "Januari";
        $month_text[$i++] = "Februari";
        $month_text[$i++] = "Maret";
        $month_text[$i++] = "April";
        $month_text[$i++] = "Mei";
        $month_text[$i++] = "Juni";
        $month_text[$i++] = "Juli";
        $month_text[$i++] = "Agustus";
        $month_text[$i++] = "September";
        $month_text[$i++] = "Oktober";
        $month_text[$i++] = "November";
        $month_text[$i]   = "Desember";

        return $month_text[$month_number];
    } 
}

if ( ! function_exists('getMonthTextEnglish'))
{  
    function getMonthTextEnglish($month_number)
    {   
        $i = 1;
        $month_number = (int)$month_number;
        $month_text[$i++] = "January";
        $month_text[$i++] = "February";
        $month_text[$i++] = "March";
        $month_text[$i++] = "April";
        $month_text[$i++] = "May";
        $month_text[$i++] = "June";
        $month_text[$i++] = "July";
        $month_text[$i++] = "August";
        $month_text[$i++] = "September";
        $month_text[$i++] = "October";
        $month_text[$i++] = "November";
        $month_text[$i]   = "December";

        return $month_text[$month_number];
    } 
}

if ( ! function_exists('checkPrivilege'))
{  
    function checkPrivilege($user_group_code)
    {
        $result = false;
        if(is_array($user_group_code)){
            foreach ($user_group_code as $key => $value) {
                if(userInformation()["GEN_GROUP"] == $value){
                    $result = true;
                    return $result;
                }
            }
        }
        else{
            if(userInformation()["GEN_GROUP"] == $user_group_code){
                $result = true;
                return $result;
            }
        }

        return redirect(base_url()."Error/restrictedPage");
    } 
}


if ( ! function_exists('getUserIP'))
{  
    function getUserIP()
    {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                  $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP))
        {
            $ip = $client;
        }
        elseif(filter_var($forward, FILTER_VALIDATE_IP))
        {
            $ip = $forward;
        }
        else
        {
            $ip = $remote;
        }

        return $ip;
    } 
}

if ( ! function_exists('julianToGregorian'))
{
    function julianToGregorian($julian){
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
            
            return $data['full_date'];
    } 
}

if ( ! function_exists('gregoriantoJulian'))
{
    function gregoriantoJulian($gregorian){
        $date=date('d',strtotime($gregorian));
        $month=date('m',strtotime($gregorian));
        $year=date('Y',strtotime($gregorian));
        
        $julian =($year*1000) - 1900000;
        $day=mktime(0,0,0,$month,$date,$year);
        $day2=date("z",$day);
        $julian= $julian + $day2;
        $julian2=$julian+1;

        return $julian2;
    }   
}

if ( ! function_exists('getStatusDescription'))
{
    function getStatusDescription($value){
        $description["1"] = "SPM-CREATED_O";
        $description["2"] = "Z-WEIGHING_O";
        $description["3"] = "MATERIAL-LOAD_O";
        $description["4"] = "N-Weighing_O";
        $description["5"] = "SPJM-Created_O";
        $description["6"] = "N_Weighing_I";
        $description["7"] = "Material-Unloading_I";
        $description["8"] = "Z_Weighing_I";
        
        $description["100"] = "Finish";
        $description["99"] = "Cancel";

        $result = strtoupper((isset($description[trim($value)])?$description[trim($value)]:"")) ;
        return $result;
    }   
}

if ( ! function_exists('getStatusDescription2'))
{
    function getStatusDescription2($value){
        $description["10"] = "PEMBUATAN SPM";
        $description["20"] = "TIMBANG MASUK OUTBOUND";
        $description["30"] = "PENGISIAN MATERIAL";
        $description["40"] = "TIMBANG KELUAR OUTBOUND";
        $description["50"] = "DIPERJALANAN";
        $description["60"] = "TIMBANG MASUK INBOUND";
        $description["70"] = "PENGELUARAN MATERIAL";
        $description["80"] = "TIMBANG KELUAR INBOUND";
        
        $description["100"] = "SELESAI";
        $description["99"] = "BATAL";

        $result = strtoupper((isset($description[trim($value)])?$description[trim($value)]:"")) ;
        return $result;
    }   
}

if ( ! function_exists('getKualitasDescription'))
{
    function getKualitasDescription($value){
        $description["1"] = "SANGAT BAGUS";
        $description["2"] = "BAGUS";
        $description["3"] = "BIASA";
        $description["4"] = "JELEK";
        $description["5"] = "JELEK SEKALI";

        $result = strtoupper((isset($description[trim($value)])?$description[trim($value)]:"")) ;
        return $result;
    }   
}

if ( ! function_exists('isBoolean'))
{
    function isBoolean($value){
        if($value != "0" && $value != "1"){
            return false;
        }
        return true;
    }   
}

if ( ! function_exists('isNotNullAndEmpty'))
{
    function isNotNullAndEmpty($value){
        if($value != null && $value != ""){
            return true;
        }
        return false;
    }   
}

if ( ! function_exists('isNullAndEmpty'))
{
    function isNullAndEmpty($value){
        if($value != null && $value != ""){
            return false;
        }
        return true;
    }   
}

if ( ! function_exists('calculateClockFromSeconds'))
{
    function calculateClockFromSeconds($seconds){
        $in_minutes = floor($seconds / 60);

        $sec    = $seconds % 60;
        $minute = $in_minutes % 60;
        $hour   = floor($in_minutes / 60);
        //$result = dateTimeFormat("H:i:s", $hour.":".$minute.":".$sec);
        $result = formatClockMoreThan24($hour,$minute,$sec);

        return $result;
    }   
}

if ( ! function_exists('formatClockMoreThan24'))
{
    function formatClockMoreThan24($hours, $minutes, $seconds){
        if(strlen($hours) < 2){
            $hours = "0".$hours;
        }
        if(strlen($minutes) < 2){
            $minutes = "0".$minutes;
        }
        if(strlen($seconds) < 2){
            $seconds = "0".$seconds;
        }

        $result = $hours.":".$minutes.":".$seconds;

        return $result;
    }   
}

if ( ! function_exists('calculateDayDiff'))
{
    function calculateDayDiff($date1, $date2){
        $time_diff = calculateTimeDiff($date1, $date2, false, true);
        $second_per_day = (60 * 60 * 24);
        $result = $time_diff / $second_per_day;

        return $result;
    }   
}

if ( ! function_exists('calculateTimeDiff'))
{
    function calculateTimeDiff($date1, $date2, $get_value = false, $in_timestamp = false){
        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);

        $diff = $date1->diff($date2);

        if($in_timestamp){
            $diff = $date1->getTimestamp() -  $date2->getTimestamp();
            return $diff;
        }

        if($get_value){
            return $diff;
        }

        return $diff->h.":".$diff->i.":".$diff->s;
    }   
}


if ( ! function_exists('getTimeData'))
{
    function getTimeData($time, $string_format = false){
        $time = $time."";
        $length = strlen("".$time);
        $result_str = $time;

        for($i = $length; $i < 6; $i++){
            $result_str = "0".$result_str;
        }

        if($string_format){
            return $result_str;
        }

        $result["s"] = substr($result_str, 0,2);
        $result["i"] = substr($result_str, 2,2);
        $result["h"] = substr($result_str, 4,2);


        return $result;
    }   
}

if ( ! function_exists('isHavePostInput'))
{
    function isHavePostInput(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        }
        return false;
    }   
} 


if ( ! function_exists('decimalValue'))
{
    function decimalValue($value){
        if($value == null){
            return null;
        }
        return number_format ( $value ,2 );
    }   
} 



if ( ! function_exists('generateCaptcha'))
{
    function generateCaptcha(){
        $CI = get_instance();
        $CI->load->library("image_lib");
        $CI->load->helper('captcha');

        $vals = array(
                //'word'          => 'Random word',
                'img_path'      => 'assets/captcha/',
                'img_url'       => base_url()."assets/captcha/",
                //'font_path'     => './path/to/fonts/texb.ttf',
                'font_path'     => './path/to/fonts/captcha4.ttf',
                'img_width'     => '150',
                'img_height'    => 65,
                'expiration'    => 7200,
                'word_length'   => 8,
                'font_size'     => 15,
                'img_id'        => 'Imageid',
                'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

                // White background and border, black text and red grid
                'colors'        => array(
                        'background' => array(255, 255, 255),
                        'border' => array(255, 255, 255),
                        'text' => array(0, 0, 0),
                        'grid' => array(220, 200, 200)
                )
        );

        $cap = create_captcha($vals);

        return $cap;
    }   
} 


if ( ! function_exists('generateCaptcha2'))
{
    function generateCaptcha2(){
        $CI = get_instance();
        $CI->load->library("antispam");

        $configs = array(
                    'img_path'      => './captcha/',
                    'img_url'       => base_url() . 'captcha/',
                    'img_height'    => '50',
                    'img_path'      => 'assets/captcha/',
                    'img_url'       => base_url()."assets/captcha/",
                    'img_width'     => '250',
                    'img_height'    => 65,
                    'font_size'     => 20,
                    'char_set'      => "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ",
                    'char_length'   => 8
                );    

        $captcha = $CI->antispam->get_antispam_image($configs);
        return $captcha;
    }   
}

if ( ! function_exists('checkInput'))
{
    function checkInput($input){
        echo "<pre>";
        var_dump($input);
        die();
    }
}

if ( ! function_exists('checkInputTableArray'))
{
    function checkInputTableArray($input){
        $header = "";
        foreach ($input[0] as $key => $value) {
            $header .= "<th>";
            $header .= "<b>".$key."</b>";
            $header .= "</th>";
        }

        $content = "";
        foreach ($input as $key => $value) {
            $content .= "<tr>";
            foreach ($value as $key_value => $value_value) {
                $content .= "<td>";
                $content .= $value_value;
                $content .= "</td>";
            }

            $content .= "</tr>";
        }

        $template = "<table border='1'>
                        <tr>
                            ".$header."
                        </tr>
                        ".$content."
                    </table>";

        echo($template);
        die();
    }
}


if ( ! function_exists('isRequestPOST'))
{
    function isRequestPOST(){
        $CI = get_instance();
        if($CI->input->server("REQUEST_METHOD") == "POST"){
            return true;
        }

        return false;
    }
}



if ( ! function_exists('isRequestGET'))
{
    function isRequestGET(){
        $CI = get_instance();
        if($CI->input->server("REQUEST_METHOD") == "GET"){
            return true;
        }
        
        return false;
    }
}

if ( ! function_exists('isRequestGETPOST'))
{
    function isRequestGETPOST(){
        $CI = get_instance();
        if($CI->input->server("REQUEST_METHOD") == "POST" || $CI->input->server("REQUEST_METHOD") == "GET"){
            return true;
        }
        
        return false;
    }
}

if ( ! function_exists('getCaptcha'))
{
    function getCaptcha(){
        $CI = get_instance();
        $CI->load->model("M_Captcha");
        $result = $CI->M_Captcha->getRandomCaptcha();
        
        return $result[0];
    }
}

if ( ! function_exists('removeSuccessErrMsg'))
{
    function removeSuccessErrMsg(){
        $CI = get_instance();
        $CI->session->unset_userdata("success_msg");
        $CI->session->unset_userdata("err_msg");
    }
}

if ( ! function_exists('setSuccessMsg'))
{
    function setSuccessMsg($value){
       $CI = get_instance();
        $result = $value;
        if(isset($_SESSION["success_msg"]) && $_SESSION["success_msg"] != NULL){
            if(is_array($_SESSION["success_msg"])){
                $result = $_SESSION["success_msg"];
            }
            else{
                $result[] = $_SESSION["success_msg"];
            }

            if(is_array($value)){
                foreach ($value as $key_val => $val) {
                    $result[] = $val;
                }
            }
            else{
                $result[] = $value;
            }
        }
        $CI->session->set_userdata("success_msg",$value);
    }
}

if ( ! function_exists('getSuccessMsg'))
{
    function getSuccessMsg(){
        if(isset($_SESSION["success_msg"]) && $_SESSION["success_msg"] != null){
            return $_SESSION["success_msg"];
        }
        return null;
    }
}

if ( ! function_exists('setErrMsg'))
{
    function setErrMsg($value){
        $CI = get_instance();
        $result = $value;
        if(isset($_SESSION["err_msg"]) && $_SESSION["err_msg"] != NULL){
            if(is_array($_SESSION["err_msg"])){
                $result = $_SESSION["err_msg"];
            }
            else{
                $result[] = $_SESSION["err_msg"];
            }

            if(is_array($value)){
                foreach ($value as $key_val => $val) {
                    $result[] = $val;
                }
            }
            else{
                $result[] = $value;
            }
        }

        // CLEAN EMPTY MESSAGE START
        if (is_array($result)) {
            for ($i = 0; $i < count($result); $i++) {
                if (empty($result[$i])) {
                    unset($result[$i]);
                }
            }
        }
        // CLEAN EMPTY MESSAGE END

        $CI->session->set_userdata("err_msg",$result);
    }
}


if ( ! function_exists('getErrMsg'))
{
    function getErrMsg(){
        if(isset($_SESSION["err_msg"]) && $_SESSION["err_msg"] != null){
            return $_SESSION["err_msg"];
        }
        return null;
    }
} 

if ( ! function_exists('generateErrText'))
{
    function generateErrMsg($err_type, $value1 = "" , $value2 = ""){
        $msg["REQUIRED"] = "Field <strong>".$field1."</strong> Harus Diisi.";

        return $msg[strtoupper($err_type)];
    }
} 

if ( ! function_exists('userInformation'))
{
    function userInformation(){
        return $_SESSION[__USERINFO];
    }
} 

if (!function_exists('isNotNullAndGreaterThanZero'))
{
    function isNotNullAndGreaterThanZero($value){
        if($value != null && count($value) > 0 ){
            return true;
        }

        return false;
    }
} 

if (!function_exists('dateTimeFormat'))
{
    function dateTimeFormat($format, $value = NULL, $modify = NULL){
      $my_date = new DateTime($value);
      if($modify != NULL){
        $my_date->modify($modify);
      }
      $result = $my_date->format($format);

      return $result;
    }
}

if (!function_exists('dateInputFormat3'))
{
    function dateInputFormat3($value){
        $year = substr($value, 0, 4);
        $month = substr($value, 4, 2);
        $day = substr($value,6, 2); 

        $result = $day."-".$month."-".$year;
        
        return $result;
    }
}

if (!function_exists('dateInputFormat2'))
{
    function dateInputFormat2($value){
        $exploded_value = explode("-", $value);
        $result = "";
        for($i = (count($exploded_value) - 1); $i >= 0; $i--){
            $result .= $exploded_value[$i];
        }
        
        return $result;
    }
}

if (!function_exists('dateInputFormat'))
{
    function dateInputFormat($value){
        $result = date("Y-m-d", strtotime($value));
        return $result;
    }
} 

if (!function_exists('dateFormat'))
{
    function dateFormat($value){
        $my_date = $value;
        if(strlen($my_date) < 8){
            $counter = 8 - strlen($my_date);
            for($i = 8 ; $i < $counter;  $i++){
                $my_date = "0".$my_date;
            }  
        }

        $result = date("d-m-Y", strtotime($my_date));

        return $result;
    }
}


if (!function_exists('timeFormatInput'))
{
    function timeFormatInput($value){
        $time = $value;
        if(strlen($time) < 6){
            $counter = 6 - strlen($time);
            for($i = 0 ; $i < $counter;  $i++){
                $time = "0".$time;
            }  
        }

        $result = $time;

        return $result;
    }
}

if (!function_exists('timeFormat'))
{
    function timeFormat($value){
        $time = $value;
        if(strlen($time) < 6){
            $counter = 6 - strlen($time);
            for($i = 0 ; $i < $counter;  $i++){
                $time = "0".$time;
            }  
        }

        $result = date("H:i:s", strtotime("01-01-2000 ".$time));

        return $result;
    }
}

if (!function_exists('convertTime'))
{
    function convertTime($time){
      return substr($time, 0, 2). ":" . substr($time, 2, 2). ":" . substr($time, 4, 2);
    }
}

if (!function_exists('boolValue'))
{
    function boolValue($value, $use_color = false){
        $result[] = "No";
        $result[] = "Yes";

        if($use_color){
            $result[0] = "<span class='font-red'>No</span>";
            $result[1] = "<span class='font-green'>Yes</span>";
        }

        return $result[$value];
    }
} 

if (!function_exists('generateComboFromArray'))
{
    function generateComboFromArray($array_combo, $value_combo = null){
        //must value and text for text
        $html_combo = null;

        foreach ($array_combo as $key => $value) {
            $selected = "";
            if($value_combo == $value["value"]){
                $selected = "selected";
            }

            $template = "<option value='".$value["value"]."' ".$selected.">".$value["text"]."</option>";
            $html_combo .= $template;    
        }

        return $html_combo;
    }
}

if (!function_exists('generatePagination'))
{
    function generatePagination($count_data, $limit_page, $page_selected, $url){
        $number_of_pagination = ceil($count_data / $limit_page);

        $url_first  = $url.'?page=1';
        $url_end    = $url.'?page='.$number_of_pagination;
        
        if($page_selected == 1){
            $url_first = "javascript:;";
        }
        if($page_selected == $number_of_pagination){
            $url_end = "javascript:;";
        }

        $pagination_result = '
            <div>
                <ul class="pagination pagination-sm">
                    <li>
                        <a href="'.$url_first.'">
                            <<
                        </a>
                    </li>
                    __PAGINATION__
                    <li>
                        <a href="'.$url_end.'">
                            >>
                        </a>
                    </li>
                </ul>
            </div>
        ';

        $content_of_pagination = "";
        $counter_limit = 1 ;

        if($number_of_pagination > 0){
            $minus_before = 3;
            $plus_after = 3;

            $diff_minus = ($page_selected + $plus_after) - $number_of_pagination;
            if($diff_minus > 0){
                $minus_before += $diff_minus;
            }

            $diff_plus = (($page_selected - $minus_before) ) * -1;
            if($diff_plus >= 0){
                $plus_after += $diff_plus;
                $plus_after += 1;
            }

            for($i = ($page_selected - $minus_before); $i <= $page_selected; $i++ ){
                if($i < 1){continue;}
                $class_active = "";
                $url_pagination = $url.'?page='.$i;
                if($page_selected == $i){
                    $class_active = "active";
                    $url_pagination = "javascript:;";
                }

                $content_of_pagination .= '
                    <li class="'.$class_active.'">
                       <a href="'.$url_pagination.'" >
                            '.$i.' 
                       </a>
                    </li>
                ';
            }

            for($i = ($page_selected + 1); $i <= ($page_selected + $plus_after) ; $i++  ){
                if($i > $number_of_pagination){break;}

                $class_active = "";
                $url_pagination = $url.'?page='.$i;
                if($page_selected == $i){
                    $class_active = "active";
                    $url_pagination = "javascript:;";
                }

                $content_of_pagination .= '
                    <li class="'.$class_active.'">
                       <a href="'.$url_pagination.'" >
                            '.$i.' 
                       </a>
                    </li>
                ';
            }
        }

        $pagination_result = str_replace("__PAGINATION__", $content_of_pagination, $pagination_result
    );

        return $pagination_result;
    }
}

if (!function_exists('generateComboFromArray2'))
{
    function generateComboFromArray2($array_combo, $value_combo = null){
        //must value and text for text
        $html_combo = null;

        foreach ($array_combo as $key => $value) {
            $selected = "";
            if($value_combo == $value["value"]){
                $selected = "selected";
            }

            $template = "<option value=\"".$value["value"]."\" ".$selected.">".$value["text"]."</option>";
            $html_combo .= $template;    
        }

        return $html_combo;
    }
}

if (!function_exists('generateRadioFromArray'))
{
    function generateRadioFromArray($radio_name, $array_radio, $value_radio = null){
        //must value and text for text
        $html_radio = '                  
                    <div class="mt-radio-inline">
                        __TEMPLATE_CHANGE__
                    </div>
                    ';

        $is_first_loop = true;
        $count = 0;
        $radio = "";
        foreach ($array_radio as $key => $value) {
            $checked = "";
            if($value_radio == $value["value"] || $is_first_loop){
                $checked = "checked";
                $is_first_loop = false;
            }

            $template_radio = '
                    <label class="mt-radio">
                        <input type="radio" name="'.$radio_name.'" id="'.$radio_name.$count.'" value="'.$value["value"].'" '.$checked.'> '.$value["text"].'
                        <span></span>
                    </label>
                    ';

            $radio .= $template_radio;    
        }

        $html_radio = str_replace("__TEMPLATE_CHANGE__", $radio, $html_radio);
        
        return $html_radio;
    }
}






?>