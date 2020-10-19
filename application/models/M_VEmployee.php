<?php  
	class M_VEmployee extends ICT_Model {
		public function __construct(){
			parent::__construct();
			$this->table = LEGACY.".V_HR_EMPLOYEE";
		}

		public $table;

		// public sections

		public function getAllDataVEmployee($filter, $sort = null){
			$table 	= LEGACY.".V_HR_EMPLOYEE a";
			$select = 'a.PERS_NUM AS EMPLOYEE_CODE, a.NIK_SMBR AS NIK, a.ORG AS ORG, a.PERS_AREA_T AS PERS_AREA_NAME, a.*';
			$sort[] = array("NAME", "ASC");

			$where 	= $this->generateWhereTable($filter);
			$result = null;
			$result = parent::getAllData($table, $select, $where, $sort, null, null, null, null, true);

			return $result;
		}
 
		public function getDataEmployee($filter = null){
			$result = self::getAllDataVEmployee($filter);

			$res 	= NULL;
			if(isNotNullAndGreaterThanZero($result)){
				$res = $result[0];
			}

			return $res;
		}

		public function getAllDataVEmployeeSubArea(){
			$table 	= LEGACY.".V_HR_EMPLOYEE a";
			$select = 'distinct(SUB_AREA) AS SUB_AREA, SUB_AREA_T';
			$sort[] = array("SUB_AREA", "ASC");

			$result = null;
			$result = parent::getAllData($table, $select, NULL, $sort);

			return $result;
		}

		//private section
		
		private function generateWhereTable($filter){
	      	$where = null;
	      	if(isset($filter["PERS_NUM"]) && isNotNullAndEmpty($filter["PERS_NUM"])){
	      		$where[] = array("EQUAL","PERS_NUM", $filter["PERS_NUM"]);  
	      	}

	      	if(isset($filter["NIK_SMBR"]) && isNotNullAndEmpty($filter["NIK_SMBR"])){
	      		$where[] = array("EQUAL","NIK_SMBR", $filter["NIK_SMBR"]);  
	      	}

	      	if(isset($filter["ORG"]) && isNotNullAndEmpty($filter["ORG"])){
	      		$where[] = array("EQUAL","ORG", $filter["ORG"]);  
	      	}

	      	return $where;
		}

		// tambahan covid
		public function getAllDataVHR($nik_smbr){
			$sql = "SELECT * FROM PRODSAPLEGACY.V_HR_EMPLOYEE WHERE NIK_SMBR LIKE '%". $nik_smbr ."%'";
			
			$result = $this->db->query($sql);

			return $result->row_array();
		}
	}

?>