<?php  
	class M_EmployeePermission extends ICT_Model {
		public function __construct(){
			parent::__construct();
			$this->table = LEGACY.".OLGA_EMPLOYEE_PERMISSION";
		}

		public $table;

		// ================================== Public Function ==================================

		public function getAllDataEmployeePermission($filter, $sort = null){
			$table 	= LEGACY.".OLGA_EMPLOYEE_PERMISSION EP";
			$where 	= $this->generateWhereTable($filter);
			$join 	= $this->generateJoinTable($filter);
			$result = null;
			$result = parent::getAllData($table, null, $where, $sort, $join);

			// checkInput($this->db->last_query());

			return $result;
		}

		public function getAllEmployeePermission($filter, $sort = null){
			$where 	= $this->generateWhereTable($filter);
			$join 	= $this->generateJoinTable($filter);
			$result = null;
			$result = parent::getAllData($this->table, null, $where, $sort, $join);

			return $result;
		}

		public function insertEmployeePermission($input){
			unset($input["EMPLOYEE_NAME"]);

			$input 	= self::formatInput($input);
			$result	= parent::insertDataOracle($this->table, $input);
			return $result;
		}

		public function updateEmployeePermission($input, $id){
			$where["ID"] = $id;
			unset($input["EMPLOYEE_NAME"]);

			$input = self::formatInput($input);
			return parent::update($this->table, $input, $where);
		}

		public function getEmployeePermission($id){
			$where["ID"] = $id;
			$result 	= parent::getData($this->table, $where);
			return $result;
		}

		public function deleteEmployeePermission($id){
			$where["ID"] = $id;
			return parent::delete($this->table, $where);
		}

		public function getHeaderTableEmployeePermission(){
			return parent::getHeadColumn($this->table);
		}

		public function getNextID(){
			return parent::getNextNumber(AN_OLGA_12_SEQ, AN_OLGA_12_DESC);
		}

		public function getPermissionAll($month, $year, $employee_code, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$year_month	= $year.$month;
			$first_day  = date('Ymd', strtotime($year. ''. $month. '01'));
		    $last_day   = date('Ymt', strtotime($first_day));


			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code ."
						AND 
						(
						    ( OEP.START_DATE LIKE '". $year_month ."%' AND OEP.END_DATE LIKE '". $year_month ."%' )
						    OR 
						    ( OEP.START_DATE NOT LIKE '". $year_month ."%' AND OEP.END_DATE LIKE '". $year_month ."%' )
						    OR 
						    ( OEP.START_DATE LIKE '". $year_month ."%' AND OEP.END_DATE NOT LIKE '". $year_month ."%' )
						    OR 
						    ( OEP.START_DATE <= '". $first_day ."' AND OEP.END_DATE >= '". $last_day ."' )
						)";
						

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			$res 	= $this->db->query($query);

			// checkInput($this->db->last_query());

			$res 	= $res->result_array();
			if(count($res) >= 1){
				$result = $res;
			}
			else{
				$result = null;
			}

			return $result;
		}

		public function getPermission($month, $year, $employee_code, $date, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$last_day 	= date('Ymt', strtotime($year. ''. $month. '01'));

			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code ."
						AND SUBSTR(OEP.". $date .", 5, 2) = ". $month ."
						AND SUBSTR(OEP.". $date .", 0, 4) = ". $year;

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			if($curr_month == $month && $curr_year == $year){
				// $query .= ' AND OEP.END_DATE <= '. $curr_date .' OR OEP.START_DATE >= '. $curr_date;
				$query .= " AND 
							(
								( OEP.END_DATE <= ". $curr_date ." AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01' ) 
									OR (OEP.END_DATE >= ". $curr_date ." AND OEP.START_DATE <= ". $curr_date .") 
							       	OR (OEP.END_DATE >= ". $curr_date ."
							           AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01'
							           AND OEP.START_DATE <= ". $last_day .")
							)" ;
			}

			$res 	= $this->db->query($query);

			$res 	= $res->result_array();
			if(count($res) >= 1){
				$result = $res;
			}
			else{
				$result = null;
			}

			return $result;
		}

		public function getPermissionBetween($month, $year, $employee_code, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$last_day 	= date('Ymt', strtotime($year. ''. $month. '01'));

			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code ."
						AND OEP.START_DATE >= '". $year ."". $month ."01' AND OEP.END_DATE <= '". date("Ymt", strtotime($year. "" . $month. "01")). "'" ;

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			if($curr_month == $month && $curr_year == $year){
				// $query .= ' AND OEP.END_DATE <= '. $curr_date .' OR OEP.START_DATE >= '. $curr_date;
				$query .= " AND 
							(
								( OEP.END_DATE <= ". $curr_date ." AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01' ) 
									OR (OEP.END_DATE >= ". $curr_date ." AND OEP.START_DATE = ". $curr_date .") 
							       	OR (OEP.END_DATE >= ". $curr_date ."
							           AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01'
							           AND OEP.START_DATE <= ". $last_day .")
							)" ;
			}

			$res 	= $this->db->query($query);

			$res 	= $res->result_array();
			if(count($res) <= 0){
				$res = null;
			}

			return $res;
		}

		public function getTotalPermission($month, $year, $employee_code, $cond = []){
		
			$query = "SELECT TO_DATE(END_DATE, 'YYYYMMDD') - TO_DATE(START_DATE, 'YYYYMMDD') AS TOTAL 
						FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY ON  ". LEGACY .".OLGA_EMPLOYEE_PERMISSION.PERMISSION_CODE =  ". LEGACY .".OLGA_PERMISSION_CATEGORY.CODE
						WHERE EMPLOYEE_CODE = ". $employee_code ."
						AND SUBSTR(START_DATE, 5, 2) = ". $month ."
						AND SUBSTR(START_DATE, 0, 4) = ". $year;

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					if($key == "Kecuali"){
						$query .= " AND NAME NOT IN ('Sakit', 'Cuti')";
					}
					else{
						$query .= " AND " . $key . " = '" . $val . "'";
					}
				}
			}
			$res 	= $this->db->query($query);

			$res 	= $res->result_array();
			if(count($res) >= 1){
				$result = $res[0]["TOTAL"];
			}
			else{
				$result = 0;
			}

			return $result;
		}

		// ================================== Private Function ==================================

		private function formatInput($param){
			if(isset($param["START_DATE"])){
				$param["START_DATE"] 	= dateTimeFormat("Ymd", $param["START_DATE"]);
			}

			if(isset($param["END_DATE"])){
				$param["END_DATE"] 		= dateTimeFormat("Ymd", $param["END_DATE"]);
			}

			if(isset($param["TIME"])){
				$param["TIME"] 			= dateTimeFormat("His", $param["TIME"]);
			}

			return $param;
		}

		private function generateJoinTable(){

			$join[] = array(
				"join_table" 		=> "(SELECT CODE AS PERMISSION_CODE, NAME AS PERMISSION_NAME, DESCRIPTION AS PERMISSION_DESCRIPTION, STATUS FROM ". LEGACY .".OLGA_PERMISSION_CATEGORY) P", 
				"join_on" 			=> "EP.PERMISSION_CODE = P.PERMISSION_CODE", 
				"join_heading" 		=> "LEFT");

			$join[] = array(
				"join_table" 		=> "(SELECT ID AS ID_PT, NAME AS NAME_PT FROM ". LEGACY .".OLGA_PERMISSION_TYPE) PT", 
				"join_on" 			=> "P.STATUS = PT.ID_PT", 
				"join_heading" 		=> "LEFT");

			$join[] = array(
				"join_table" 		=> "(SELECT PERS_NUM, NIK_SMBR AS NIK, NAME AS EMPLOYEE_NAME FROM  ". LEGACY .".V_HR_EMPLOYEE V) V", 
				"join_on" 			=> "EP.EMPLOYEE_CODE = V.PERS_NUM", 
				"join_heading" 		=> "LEFT");

			return $join;
		}
		
		private function generateWhereTable($filter){
	      	$where = null;

	      	if(isset($filter["ID"]) && isNotNullAndEmpty($filter["ID"])){
	      		$where[] = array("EQUAL", "EP.ID", $filter["ID"]);  
	      	}

	      	if(isset($filter["EMPLOYEE_CODE"]) && isNotNullAndEmpty($filter["EMPLOYEE_CODE"])){
	      		$where[] = array("EQUAL", "EP.EMPLOYEE_CODE", $filter["EMPLOYEE_CODE"]);  
	      	}

	      	if(isset($filter["ID_NOT_EQUAL"]) && $filter["ID_NOT_EQUAL"] != ""){
	        	$where[] = array("NOT_EQUAL", "EP.ID", $filter["ID_NOT_EQUAL"]);  
	      	}

	      	if(isset($filter["EMPLOYEE_CODE_NOT_EQUAL"]) && $filter["EMPLOYEE_CODE_NOT_EQUAL"] != ""){
	        	$where[] = array("NOT_EQUAL", $this->table. ".EMPLOYEE_CODE", $filter["EMPLOYEE_CODE_NOT_EQUAL"]);  
	      	}

	      	if(isset($filter["PERMISSION_CODE"]) && isNotNullAndEmpty($filter["PERMISSION_CODE"])){
	      		$where[] = array("EQUAL", "EP.PERMISSION_CODE", $filter["PERMISSION_CODE"]);
	      	}

	      	if(isset($filter["START_DATE"]) && isNotNullAndEmpty($filter["START_DATE"])){
	      		$where[] = array("EQUAL","EP.START_DATE", $filter["START_DATE"]);  
	      	}

	      	if(isset($filter["END_DATE"]) && isNotNullAndEmpty($filter["END_DATE"])){
	      		$where[] = array("EQUAL","EP.END_DATE", $filter["END_DATE"]);  
	      	}
	      	
	      	if(isset($filter["GE_START_DATE"]) && isNotNullAndEmpty($filter["GE_START_DATE"])){
		      	$where[] = array("GREATER_OR_EQUAL","TO_NUMBER(EP.START_DATE)", $filter["GE_START_DATE"]);  
		    }
		    
		    if(isset($filter["LE_START_DATE"]) && isNotNullAndEmpty($filter["LE_START_DATE"])){
		      	$where[] = array("LESS_OR_EQUAL","TO_NUMBER(EP.START_DATE)", $filter["LE_START_DATE"]);  
		    }
		    
		    if(isset($filter["GE_END_DATE"]) && isNotNullAndEmpty($filter["GE_END_DATE"])){
		      	$where[] = array("GREATER_OR_EQUAL","TO_NUMBER(EP.END_DATE)", $filter["GE_END_DATE"]);  
		    }
		    
		    if(isset($filter["LE_END_DATE"]) && isNotNullAndEmpty($filter["LE_END_DATE"])){
		      	$where[] = array("LESS_OR_EQUAL","TO_NUMBER(EP.END_DATE)", $filter["LE_END_DATE"]);  
		    }

		    if(isset($filter["WHERE_MANUAL"]) && isNotNullAndEmpty($filter["WHERE_MANUAL"])){
		      	$where[] = array("WHERE_MANUAL", $filter["WHERE_MANUAL"]);  
		    }

	      	return $where;
		}

		// ---------------- data lama

		public function getPermissionAll2($month, $year, $employee_code, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$last_day 	= date('Ymt', strtotime($year. ''. $month. '01'));


			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code;

						// $query .= "AND (( SUBSTR(OEP.START_DATE, 5, 2) = ". $month ."
						// AND SUBSTR(OEP.START_DATE, 0, 4) = ". $year ." ) OR 
						// ( SUBSTR(OEP.END_DATE, 5, 2) = ". $month ."
						// AND SUBSTR(OEP.END_DATE, 0, 4) = ". $year . " ))";

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			if($curr_month == $month && $curr_year == $year){
				$query .= " AND 
							(
								( OEP.END_DATE <= ". $curr_date ." AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01' ) 
									OR (OEP.END_DATE >= ". $curr_date ." AND OEP.START_DATE <= ". $curr_date .") 
							       	OR (OEP.END_DATE >= ". $curr_date ."
							           AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01'
							           AND OEP.START_DATE <= ". $last_day .")
							)" ;
			}

			$res 	= $this->db->query($query);

			checkInput($this->db->last_query());

			$res 	= $res->result_array();
			if(count($res) >= 1){
				$result = $res;
			}
			else{
				$result = null;
			}

			return $result;
		}

		public function getPermission2($month, $year, $employee_code, $date, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$last_day 	= date('Ymt', strtotime($year. ''. $month. '01'));

			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code ."
						AND SUBSTR(OEP.". $date .", 5, 2) = ". $month ."
						AND SUBSTR(OEP.". $date .", 0, 4) = ". $year;

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			if($curr_month == $month && $curr_year == $year){
				// $query .= ' AND OEP.END_DATE <= '. $curr_date .' OR OEP.START_DATE >= '. $curr_date;
				$query .= " AND 
							(
								( OEP.END_DATE <= ". $curr_date ." AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01' ) 
									OR (OEP.END_DATE >= ". $curr_date ." AND OEP.START_DATE <= ". $curr_date .") 
							       	OR (OEP.END_DATE >= ". $curr_date ."
							           AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01'
							           AND OEP.START_DATE <= ". $last_day .")
							)" ;
			}

			$res 	= $this->db->query($query);

			$res 	= $res->result_array();
			if(count($res) >= 1){
				$result = $res;
			}
			else{
				$result = null;
			}

			return $result;
		}

		public function getPermissionBetween2($month, $year, $employee_code, $cond = []){
			// get this month
			$curr_month = date("m");
			$curr_year 	= date("Y");
			$curr_date 	= date("Ymd");
			$last_day 	= date('Ymt', strtotime($year. ''. $month. '01'));

			$query = "SELECT OEP.*, OPC.NAME AS NAME_OPC, OPC.STATUS AS STATUS_OPC, OPT.NAME AS NAME_OPT FROM ". LEGACY .".OLGA_EMPLOYEE_PERMISSION OEP
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_CATEGORY OPC ON  ". LEGACY .".OEP.PERMISSION_CODE =  ". LEGACY .".OPC.CODE
						LEFT JOIN  ". LEGACY .".OLGA_PERMISSION_TYPE OPT ON  ". LEGACY .".OPT.ID =  ". LEGACY .".OPC.STATUS
						WHERE OEP.EMPLOYEE_CODE = ". $employee_code ."
						AND OEP.START_DATE >= '". $year ."". $month ."01' AND OEP.END_DATE <= '". date("Ymt", strtotime($year. "" . $month. "01")). "'" ;

			if(count($cond) > 0){
				foreach($cond as $key => $val){
					$query .= " AND " . $key . " = '" . $val . "'";
				}
			}

			if($curr_month == $month && $curr_year == $year){
				// $query .= ' AND OEP.END_DATE <= '. $curr_date .' OR OEP.START_DATE >= '. $curr_date;
				$query .= " AND 
							(
								( OEP.END_DATE <= ". $curr_date ." AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01' ) 
									OR (OEP.END_DATE >= ". $curr_date ." AND OEP.START_DATE = ". $curr_date .") 
							       	OR (OEP.END_DATE >= ". $curr_date ."
							           AND OEP.START_DATE >= '". $curr_year ."". $curr_month ."01'
							           AND OEP.START_DATE <= ". $last_day .")
							)" ;
			}

			$res 	= $this->db->query($query);

			$res 	= $res->result_array();
			if(count($res) <= 0){
				$res = null;
			}

			return $res;
		}

	}

?>