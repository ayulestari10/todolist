<?php
  class ICT_Model extends CI_Model{
    public function __construct(){
      parent::__construct();
      $this->scheme = "production";
      $this->scheme_ctl = substr($this->scheme, 0, strlen($this->scheme) - 3)."CTL";
    }

    // PROTECTED SECTION

    protected $scheme;
    protected $scheme_ctl;

    public function checkCanDeleteByRelationalSetup($table, $value_table){
      $exploded_table = explode(".", $table);
      $where[] = array("EQUAL", "TABLE_NAME", $exploded_table[1]);
      $where[] = array("EQUAL", "GEN_APPS", APPS_CODE);
      $relation_table = LEGACY.".GEN_RELATION_TABLE";
      $list_data = self::getAllData($relation_table, NULL, $where);
      if(isNotNullAndGreaterThanZero($list_data)){
        foreach ($list_data as $key => $value) {
          $scheme = LEGACY;
          if(strtoupper(trim($value["RELATED_TABLE_SCHEME"])) != "LEGACY"){
            $scheme = MDM;
          }
          $table_name_on_relation = $scheme.".".strtoupper(trim($value["RELATED_TABLE_NAME"]));
          $field_name = strtoupper(trim($value["RELATED_TABLE_KEY_FIELD"]));

          $this->db->where($field_name, $value_table);
          $this->db->from($table_name_on_relation);
          $this->db->limit(1);
          $count = $this->db->count_all_results();

          if($count >= 1){
            return false;
          }
        }
      }

      return true;
    }

    public function checkCanDelete($value, $related_table, $field_name){
      $this->db->where($field_name, $value);
      $this->db->from($related_table);
      $this->db->limit(1);
      $count = $this->db->count_all_results();

      $result = true;
      if($count >= 1){
        $result = false;
      }

      return $result;
    }

    protected function getNextNumber($seq, $text){
      $my_number = self::getCurrentNumber($seq);

      if($my_number != null && count($my_number) > 0){
        self::updateNextNumber($seq);
        return $my_number[0]->GEN_NUMBER;
      }

      self::insertNextNumber($seq, $text);
      return self::getNextNumber($seq, $text);
    }

    protected function getHeadColumn($table){
      $field = $this->db->field_data($table);
      return $field;
    }

    protected function getAllData($table, $selection = null, $filter = null, $sort = null, $joins = null, $group_by = null, $limit = null, $offset = null, $distinct = null){
      //NOTES:
      //FORMAT $selection : "field_a, field_b, field_c,...."
      //FORMAT $filter : array(0 => array(0 => "SPECIFICATION", 1 = > "FIELD", 2 => "VALUE"))
      //FORMAT $sort : array(0 => array(0 => "FIELD", 1 = > "ASC / DESC"))
      //FORMAT $joins : array(0 => array("join_table" => "value", "join_on" => "value", "join_heading" => "value"))
      $select = "*";
      if($selection != null ){
        $select = $selection;
      }
      if($distinct != null){
        $this->db->distinct();
      }
      $this->db->select($select);
      $this->db->from($table);
      if($filter != null){
        $this->generateWhereFromFilter($filter);
      }
      if($sort != null){
        
        $this->generateSorting($sort);
      }
      if($joins != null){
        $this->generateJoin($joins);
      }
      if($group_by != null){
        $this->db->group_by($group_by);
      }
      if($limit != null && $offset == null){
        $this->db->limit($limit);
      }
      
      if($limit != null && $offset != null){

        $this->db->limit($limit, $offset);
      }
      
      $query = $this->db->get();
      return $query->result_array();
    }

    protected function getData($table, $id){
      $query = $this->db->get_where($table, $id);
      return $query->row_array();
    }

    protected function insertDataAutoIncrement($table, $input){
      $input = self::setParamTable($table,$input);
      $result = "";
      try {
        // $input = $this->setAuditInformation($input, 1); 

        $this->db->trans_begin(); 
        $this->db->insert($table, $input);
        $result = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback();}
        else{$this->db->trans_commit();}       

      } catch (Exception $e) {
        $this->session->set_flashdata($e);
      }

      return $result;
    }

    protected function insertData($table, $input){
      $input = self::setParamTable($table,$input);
      $result = "";
      try {
        // $input = $this->setAuditInformation($input, 1); 

        $this->db->trans_begin(); 
        $this->db->insert($table, $input);

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback(); return false;}
        else{$this->db->trans_commit(); return true;}       

      } catch (Exception $e) {
        $this->session->set_flashdata($e);
      }

      return $result;
    }

    protected function insertDataOracle($table, $input){
      $input = self::setParamTable($table,$input);
      $result = "";
      try {
        // $input = $this->setAuditInformation($input, 1); 

        $this->db->trans_begin(); 
        if($input != null){
          foreach ($input as $key => $value) {
            if(!is_array($value)){
              $this->db->set($key, $value);
            }
            else{
              if(key($value) == 'DATE_VALUE')
                $this->db->set($key, "TO_DATE('".$value["DATE_VALUE"]."','yyyy/mm/dd')", false);
              else if(key($value) == 'DATETIME_VALUE')
                $this->db->set($key, "TO_DATE('".$value["DATE_VALUE"]."','yyyy/mm/dd HH24:MI:SS')", false);
                
            }
          }
        }

        $this->db->insert($table);

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback();}
        else{$this->db->trans_commit();return true;}       

      } catch (Exception $e) {
        $this->session->set_flashdata($e);
      }

      return $result;
    }

    protected function updateDataOracle($table, $input, $where){
      $input = self::setParamTable($table,$input);
      $result = "";
      try {
        // $input = $this->setAuditInformation($input, 1); 

        $this->db->trans_begin(); 
        if($input != null){
          foreach ($input as $key => $value) {
            if(!is_array($value)){
              $this->db->set($key, $value);
            }
            else{
              $this->db->set($key, "TO_DATE('".$value["DATE_VALUE"]."','yyyy/mm/dd')", false);
            }
          }
        }
        
        $this->db->where($where);
        $result = $this->db->update($table); 

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback();}
        else{$this->db->trans_commit();}       

      } catch (Exception $e) {
        $this->session->set_flashdata($e);
      }

      return $result;
    }



    protected function getQuery($table, $selection = null, $filter = null, $sort = null, $joins = null, $group_by = null, $limit = null){
      //NOTES:
      //FORMAT $selection : "field_a, field_b, field_c,...."
      //FORMAT $filter : array(0 => array(0 => "SPECIFICATION", 1 = > "FIELD", 2 => "VALUE"))
      //FORMAT $sort : array(0 => array(0 => "FIELD", 1 = > "ASC / DESC"))
      //FORMAT $joins : array(0 => array("join_table" => "value", "join_on" => "value", "join_heading" => "value"))

      $select = "*";
      if($selection != null ){
        $select = $selection;
      }
      $this->db->select($select);
      $this->db->from($table);
      if($filter != null){
        $this->generateWhereFromFilter($filter);
      }
      if($sort != null){
        
        $this->generateSorting($sort);
      }
      if($joins != null){
        $this->generateJoin($joins);
      }
      if($group_by != null){
        $this->db->group_by($group_by);
      }
      if($limit != null ){
        $this->db->limit($limit);
      }

      $this->checkInput($this->db->get_compiled_select());
      die();
    }

    protected function update($table, $input, $where, $custome_where = null){
      $input = self::setParamTable($table,$input);
      try {
        // $input = $this->setAuditInformation($input, 2); 

        $this->db->trans_begin(); 

        if(isNotNullAndEmpty($custome_where)){
          $this->generateWhereFromFilter($where);
        }
        else{
          $this->db->where($where);
        }
        
        $this->db->update($table, $input); 

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback();}
        else{$this->db->trans_commit();} 

        return true;    
        
      } catch (Exception $e) {
        $this->session->set_flashdata($e);
        return false;
      }
    }

    protected function delete($table, $where_id){
      try {
        $value_table_key = "";
        if($where_id != NULL){
          foreach ($where_id as $key_where_id => $value_where_id) {
            $value_table_key = $value_where_id;
          }
        }

        if(!self::checkCanDeleteByRelationalSetup($table, $value_table_key)){
          return false;
        }


        $this->db->trans_begin(); 
        $this->db->where($where_id);
        $this->db->delete($table); 

        if ($this->db->trans_status() === FALSE){$this->db->trans_rollback();}
        else{$this->db->trans_commit();} 

        return true;    
        
      } catch (Exception $e) {
        $this->session->set_flashdata($e);
        return false;
      }
    }

    // PRIVATE SECTION
    private function generateJoin($joins){
      foreach ($joins as $value) {
        $this->db->join($value["join_table"], $value["join_on"], $value["join_heading"]);
      }
    }

    private function setAuditInformation($input, $audit_type){
      // NOTES:
      // type 1 = insert
      // type 2 = update

      // if($audit_type == 1){
      //   $input["torg"] = (isset($_SESSION["userinfo"]) && $_SESSION["userinfo"] != null ? $_SESSION["userinfo"]["id"] : "");
      //   $input["created_date"] = date("Y-m-d H:i:s");
      // }
      // else if($audit_type == 2){
      //   $input["user"] = (isset($_SESSION["userinfo"]) && $_SESSION["userinfo"] != null ? $_SESSION["userinfo"]["id"] : "");
      //   $input["updated_date"] = date("Y-m-d H:i:s");
      // }

      // return $input;

      return null;
    }

    private function generateWhereFromFilter($filters){
      foreach ($filters as $filter) {

        if($filter == null){continue;}

        if(strtoupper($filter[0]) == "LIKE"){
          $this->db->like($filter[1], $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "EQUAL"){
          $this->db->where($filter[1], $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "NOT_EQUAL"){
          $this->db->where($filter[1]." != ", $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "LESS_OR_EQUAL"){
          $this->db->where($filter[1]." <= ", $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "GREATER_OR_EQUAL"){
          $this->db->where($filter[1]." >= ", $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "LESS"){
          $this->db->where($filter[1]." < ", $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "GREATER"){
          $this->db->where($filter[1]." > ", $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "IN"){
          $this->db->where_in($filter[1], $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "NOT_IN"){
          $this->db->where_not_in($filter[1], $filter[2]);
          continue;
        }
        else if(strtoupper($filter[0]) == "IS_NULL"){
          $this->db->where($filter[1]." IS NULL", null, false);
          continue;
        }
        else if(strtoupper($filter[0]) == "IS_NOT_NULL"){
          $this->db->where($filter[1]." IS NOT NULL", null, false);
          continue;
        }
        else if(strtoupper($filter[0]) == "WHERE_MANUAL"){
          $this->db->where($filter[1], null, false);
          continue;
        }
      }
    }

    private function generateSorting($sort){
      foreach ($sort as $data) {
        if($data == null){continue;}
        $this->db->order_by($data[0], $data[1]);
      }
    }



    protected function julianToGregorian($julian){
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


    protected function gregoriantoJulian($gregorian){
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


    private function getCurrentNumber($seq){
      $sql="SELECT GEN_NUMBER 
      FROM ".LEGACY.".GEN_LOOKUP_NUMB 
      WHERE GEN_APPS='".APPS_CODE."' AND GEN_SEQ=".$seq." AND GEN_FISCAL_YEAR=".date("y");
      return $this->db->query($sql)->result();      
    }

    //1. update  next number
    private function updateNextNumber($seq){
      $sql="UPDATE ".LEGACY.".GEN_LOOKUP_NUMB 
      SET GEN_NUMBER=(GEN_NUMBER + 1) 
      WHERE GEN_APPS='".APPS_CODE."' AND GEN_SEQ=".$seq." AND GEN_FISCAL_YEAR=".date("y");  
      $this->db->query($sql);
      return $this->db->affected_rows();      
    }

    //1. insert  next number
    private function insertNextNumber($seq, $text){
      try {
        $first_number = (date("y")) * FIRST_COUNTER_DB;
        
        $preparedData["GEN_APPS"]       = APPS_CODE;
        $preparedData["GEN_SEQ"]      = $seq;
        $preparedData["GEN_DESCRIPTION"]  = $text;
        $preparedData["GEN_FISCAL_YEAR"]  = date("y");
        $preparedData["GEN_NUMBER"]     = $first_number;

        $this->db->trans_start(FALSE);
        $this->db->insert(LEGACY.".GEN_LOOKUP_NUMB", $preparedData);
        $this->db->trans_complete();
        
        $db_error = $this->db->error();
        if (!empty($db_error)) {
            throw new Exception('Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            return false; // unreachable retrun statement !!!
        }
        return TRUE;
      } 
      catch (Exception $e) {
          // this will not catch DB related errors. But it will include them, because this is more general. 
          log_message('error: ',$e->getMessage());
          return false;
      }    
    }

    private function setParamTable($table, $param){
      $column_table = self::getHeadColumn($table);
      $result = NULL;
      foreach ($param as $key => $value) {
        foreach ($column_table as $column_table_key => $column_table_value) {
          if($key == $column_table_value->name){
            $result[$key] = $value;
            unset($column_table[$column_table_key]);
            break;
          }
        }
      }
      
      return $result;
    }
  }
?>
