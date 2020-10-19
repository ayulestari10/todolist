<?php  

	Class EmployeePermission extends ICT_Controller{
		public function __construct(){
			parent::__construct();
			$this->loader();
		}

		public $data;

		public function index(){
			checkPrivilege(array("OLGA_01","OLGA_03"));
			self::setupMasterPage("Transaction", "EmployeePermission_index", "Employee Permission");

			$sort[] 						= array("EP.START_DATE", "ASC");
			$today 							= dateTimeFormat("d-m-Y");
			$filter_awal["DATE"] 			= dateTimeFormat("Ymd", $today);
			$filter_awal["LE_START_DATE"]	= dateTimeFormat("Ymd", $today);
			$filter_awal["GE_END_DATE"] 	= dateTimeFormat("Ymd", $today);
			
			// $filter_awal["WHERE_MANUAL"]	= "
			// 	( TO_NUMBER(EP.START_DATE) 		>= '". dateTimeFormat("Ymd", $today) ."'
			// 	AND TO_NUMBER(EP.END_DATE) 		<= '". dateTimeFormat("Ymd", $today) ."' )
			// 	OR ( TO_NUMBER(EP.START_DATE) 	= '". dateTimeFormat("Ymd", $today) ."'
			// 	OR TO_NUMBER(EP.END_DATE) 		= '". dateTimeFormat("Ymd", $today) ."' )
			// ";
			$objData["DATE"]				= $today;
			$this->data["list_of_data"] 	= $this->M_EmployeePermission->getAllDataEmployeePermission($filter_awal, $sort);

			$filter[] 	= null;
			if($this->input->post("btnSearch")){

				$objData 	= [
					"DATE"  		=> $this->input->post("DATE"),
					"EMPLOYEE_CODE" => $this->input->post("EMPLOYEE_CODE")
				];

				if(self::validateSearch($objData)){
					
					if(isset($objData["DATE"]) && isNotNullAndEmpty($objData["DATE"])){
						$filter["DATE"] 		= dateTimeFormat("Ymd", $objData["DATE"]);
						$filter["LE_START_DATE"]= dateTimeFormat("Ymd", $objData["DATE"]);
						$filter["GE_END_DATE"] 	= dateTimeFormat("Ymd", $objData["DATE"]);
					}

					if(isset($objData["EMPLOYEE_CODE"]) && isNotNullAndEmpty($objData["EMPLOYEE_CODE"])){
						$filter["EMPLOYEE_CODE"]= $objData["EMPLOYEE_CODE"];
			      		$cek_data = $this->M_VEmployee->getDataEmployee(["PERS_NUM" => $filter["EMPLOYEE_CODE"]]);

			      		if(count($cek_data) >= 1){
			      			$filter["NAME"] 	= $cek_data["NAME"];
			      		}
					}

					$this->data["list_of_data"] = $this->M_EmployeePermission->getAllDataEmployeePermission($filter, $sort);
					
					if(isset($filter["DATE"]) && isNotNullAndEmpty($filter["DATE"])){
						$filter["DATE"] = dateTimeFormat('d-m-Y', $filter["DATE"]);
					}
					else{
						$filter["DATE"] = "";
					}
				}
				else{
					$filter = $objData;
					$this->data["list_of_data"] = null;
				}
			}

			self::createInputView();
			$this->data["filter"] 		= $filter;
      		$this->data["Container"]	= $this->load->view("EmployeePermission/index", $this->data, true);
			$this->load->view("Shared/master", $this->data);
			removeSuccessErrMsg();
		}

		public function create(){

			checkPrivilege(array("OLGA_01","OLGA_03"));
			self::setupMasterPage("Transaction", "EmployeePermission_index", "Employee Permission");
			$filter 	= self::bindingFilter();
			$objData 	= self::bindingData();
      		$this->data["filter"] = $filter;

			if(isRequestPost()){
				$objData 	= self::bindingData(true);

				if(self::validateInput($objData)){
					$objData["CREATED_DATE"] 	= dateTimeFormat("Ymd");
          			$objData["CREATED_TIME"] 	= dateTimeFormat("His");
          			$objData["CREATED_BY"]   	= userInformation()["GEN_USER"];
					$objData["ID"]			 	= $this->M_EmployeePermission->getNextID();
					$objData["START_DATE"]	 	= dateTimeFormat("Ymd", $objData["START_DATE"]);
					$objData["END_DATE"]	 	= dateTimeFormat("Ymd", $objData["END_DATE"]);

          			if($this->M_EmployeePermission->insertEmployeePermission($objData)){
          				$cekData 	= $this->M_EmployeePermission->getAllDataEmployeePermission(["ID" => $objData["ID"], "CREATED_TIME" => $objData["CREATED_TIME"]]);
						if(count($cekData) >= 1){
							
							$file_name = self::doUpload($cekData[0]["ID"], $objData, false);
							if(isset($file_name)){
								$this->M_EmployeePermission->updateEmployeePermission(["FILES" => $file_name], $cekData[0]["ID"]);
							}
						}
            			$msg[] = "Create Data is Success.";
            			setSuccessMsg($msg);
            			return redirect(base_url("EmployeePermission"));
          			}
				}
			}

			self::createInputView();
      		$this->data["objData"] 			= $objData;
      		$this->data["Container"] 		= $this->load->view("EmployeePermission/input",$this->data, true);
      		$this->load->view("Shared/master", $this->data);
      		removeSuccessErrMsg();
		}

		public function edit(){
      		$this->data["edit_mode"] = true;
			checkPrivilege(array("OLGA_01","OLGA_03"));
			self::setupMasterPage("Transaction", "EmployeePermission_index", "Employee Permission");
			$this->load->helper("form");
			$filter = self::bindingFilter();

			$ID = $this->input->get("ID");

			if(isNotNullAndEmpty($ID)){
				$objData 		= self::bindingData();
				$get_data 		= $this->M_EmployeePermission->getAllDataEmployeePermission(["ID" => $ID]);

				if(isRequestPost()){
					if(isset($get_data)){
						$objData 		= self::bindingData(true);
						
						if(strlen($_FILES["FILES"]["name"]) <= 0){
							$objData["FILES"] = $get_data[0]["FILES"];
						}

						if(self::validateInput($objData, true)){
							$objData["UPDATED_DATE"] 	= dateTimeFormat("Ymd");
							$objData["UPDATED_TIME"] 	= dateTimeFormat("His");
							$objData["UPDATED_BY"]	 	= userInformation()["GEN_USER"];
							$objData["START_DATE"]		= dateTimeFormat("Ymd", $objData["START_DATE"]);
							$objData["END_DATE"]		= dateTimeFormat("Ymd", $objData["END_DATE"]);

							if($objData["STATUS"] == 2){ // cek ini
								$objData["TIME"] 	= "";
							}
							
							$this->M_EmployeePermission->updateEmployeePermission($objData, $objData["ID"]);

							if(strlen($_FILES["FILES"]["name"]) > 0){
								$path = dirname($_SERVER["SCRIPT_FILENAME"])."/upload_path/EmployeePermission";
								@unlink($path . "/" . $get_data[0]["FILES"]);

								$file_name = self::doUpload($objData["ID"], $objData, true);

								if(isset($file_name) && $file_name != false){
									$objData["FILES"] = $file_name;

									if($this->M_EmployeePermission->updateEmployeePermission($objData, $objData["ID"])){
										$msg[] = "Update Data is Success.";
										setSuccessMsg($msg);
										return redirect(base_url("EmployeePermission"));
									}
								}
								else{
									$err_msg[]	= "File Failed to Upload.";
									setErrMsg($err_msg);
									return redirect(base_url("EmployeePermission/edit?ID=".$ID));
								}
							}
							elseif(strlen($_FILES["FILES"]["name"]) == 0 && !empty($_FILES["FILES"])){ // image tidak berubah
								if($this->M_EmployeePermission->updateEmployeePermission($objData, $objData["ID"])){
									$msg[] = "Update Data is Success.";
									setSuccessMsg($msg);
									return redirect(base_url("EmployeePermission"));
								}
							}
							else{
								$objData	= $this->M_EmployeePermission->getEmployeePermission($ID);
								if(count($objData) <= 0){
									$err_msg[]	= "Data not found.";
									setErrMsg($err_msg);
									return redirect(base_url("EmployeePermission"));
								}
							}
						}
					}
				}
				elseif(count($get_data) <= 0){
					$err_msg[]	= "Data not found.";
					setErrMsg($err_msg);
					return redirect(base_url("EmployeePermission"));
				}
				else{
					$objData 				= $this->M_EmployeePermission->getAllDataEmployeePermission(["ID" => $ID])[0];
					$objData["START_DATE"]	= dateTimeFormat("d-m-Y", $objData["START_DATE"]);
					$objData["END_DATE"]	= dateTimeFormat("d-m-Y", $objData["END_DATE"]);

					if(count($objData) <= 0){
						$err_msg[]	= "Data not found.";
						setErrMsg($err_msg);
						return redirect(base_url("EmployeePermission"));
					}
				}
			}
			else {
				$err_msg[]	= "Employee Code Not Found.";
				setErrMsg($err_msg);
				return redirect(base_url("EmployeePermission"));
			}

			self::createInputView();
			$this->data["objData"] 		= $objData;
			$this->data["filter"] 		= $filter; 
			$this->data["Container"]	= $this->load->view("EmployeePermission/input", $this->data, true);
			$this->load->view("Shared/master", $this->data);
			removeSuccessErrMsg();
		}

    	public function delete(){
	      	$ID 			= $this->input->get("ID");
	     	$filter["ID"] 	= $ID ;
	     
		    if(isNotNullAndEmpty($ID)){
		    	$objDataOld		= $this->M_EmployeePermission->getEmployeePermission($ID);
		    	
		    	if(count($objDataOld) > 0){
					if($this->M_EmployeePermission->deleteEmployeePermission($ID)){
						$path 		= dirname($_SERVER["SCRIPT_FILENAME"])."/upload_path/EmployeePermission/";
						@unlink($path . "/" . $objDataOld["FILES"]);

			      		$success_msg[] = "Delete Data is Success.";
			      		setSuccessMsg($success_msg);
					}
			      	else{
			        	$err_msg[] = "Delete Data is Failed.";
			        	setErrMsg($err_msg);
			      	}  
		      	}
		      	else{
		        	$err_msg[] = "Data Not Found.";
		        	setErrMsg($err_msg);
		      	}
		    }
			else {
				$err_msg[]	= "Employee Code Not Found.";
				setErrMsg($err_msg);
			}
	      
	      	//LOAD VIEW
	      	return redirect(base_url()."EmployeePermission");
    	}

    	public function import(){
	      checkPrivilege(array("OLGA_01","OLGA_03"));
	      self::setupMasterPage("Transaction", "EmployeePermission_index", "Employee Permission");

	      if(isRequestPost()){
	        $obj_data = importExcel("MY_FILES");

	        if(isNotNullAndGreaterThanZero($obj_data)){
	          //CHECK HEADER IS VALID OR NO 
	          $header_table = $this->M_EmployeePermission->getHeaderTableEmployeePermission();
	          $is_valid_header = true;
	          foreach ($obj_data[0] as $key => $value) {
	            $is_column_valid = false;
	            foreach ($header_table as $key2 => $value2) {
	              if($key == $value2->name){
	                $is_column_valid = true;
	                break;
	              }
	            }

	            if(!$is_column_valid){
	              $err_msg[] = "Field <b>".$key."</b> is Not Valid.";
	              setErrMsg($err_msg);
	              $is_valid_header = false;
	            }
	          }

	          if(!$is_valid_header){
	            return redirect(base_url()."EmployeePermission");
	          }
	          //-----------------------------------------------------------
	          
	          $counter_success_import = 0;
	          $row_data = 1;
	          foreach ($obj_data as $key => $value) {
	            if(self::validateInputImport($value, $row_data)){

	                //BINDING DATA
	                $my_value = NULL; 
	                $my_value = $value;

	                $my_value["CREATED_DATE"] 	= dateTimeFormat("Ymd");
          			$my_value["CREATED_TIME"] 	= dateTimeFormat("His");
          			$my_value["CREATED_BY"]   	= userInformation()["GEN_USER"];
					$my_value["ID"]			 	= $this->M_EmployeePermission->getNextID();

	                if($this->M_EmployeePermission->insertEmployeePermission($my_value)){
	                  $counter_success_import++;
	                } 
	            }
	            
	            $row_data++;
	          }

	          if($counter_success_import > 0){
	            $success_msg[] = "Import <b>".$counter_success_import."</b> Data is Success.";
	            setSuccessMsg($success_msg);
	          }
	        }
	        
	        
	        return redirect(base_url()."EmployeePermission");
	      }

	      self::createInputView();
	      $this->data["Container"] = $this->load->view("EmployeePermission/import",$this->data, true);
	      $this->load->view("Shared/master", $this->data);
	      removeSuccessErrMsg();
	    }

	    public function importFiles(){

	    	//notes :
	    	//upload file zip only
	    	//buat folder kalo ga ada folder nya berdasarkan date time username
	    	//extract
	    	//update data berdasarkan folder name (ID)
	    	//pindahin file ke path upload
	    	//hapus folder
	    	//done

	    	$folder_name = dateTimeFormat("YmdHis").userInformation()["GEN_USER"];
			if (!is_dir('uploads/'.$folder_name)) {
			    mkdir('./uploads/' . $folder_name, 0777, TRUE);
			}

			// $archive = RarArchive::open('./uploads/20191206195551andika/testing_rar.rar');
			// $entries = $archive->getEntries();
			// foreach ($entries as $entry) {
			//     $entry->extract('./uploads/20191206195551andika/hasilextract');
			// }
			// $archive->close();


			## Extract the zip file ---- start
            $zip = new ZipArchive;
            $res = $zip->open("./uploads/20191206195551andika/testing_rar.zip");
            if ($res === TRUE) {
            	$folder_name = "20191206195551andika/hasilextract";
				if (!is_dir('uploads/'.$folder_name)) {
				    mkdir('./uploads/' . $folder_name, 0777, TRUE);
				}
                // Unzip path
                $extractpath = "./uploads/".$folder_name;

                // Extract file
                $zip->extractTo($extractpath);
                $zip->close();

                $this->session->set_flashdata('msg','Upload & Extract successfully.');
            } else {
                $this->session->set_flashdata('msg','Failed to extract.');
            }
            ## ---- end
	    }




	    // ================================== Private Function ================================== 

		private function bindingData($upload = false){
			$input["ID"] 				= $this->input->post("ID");
			$input["EMPLOYEE_CODE"] 	= $this->input->post("EMPLOYEE_CODE");
      		$input["PERMISSION_CODE"]  	= $this->input->post("PERMISSION_CODE");
      		$input["START_DATE"]  		= $this->input->post("START_DATE");
      		$input["END_DATE"]  		= $this->input->post("END_DATE");
      		$input["DESCRIPTION"]  		= $this->input->post("DESCRIPTION");
      		$input["STATUS"]			= $this->input->post("STATUS");
      		$data_permission 			= $this->M_PermissionCategory->getPermissionCategory($input["PERMISSION_CODE"]);

	      	if(count($data_permission) > 0){
	      		if($data_permission["TIME_INPUT"] == "1"){ 
	      			$input["TIME"] 	=  $this->input->post("TIME");
	      		}
	      		else {
	      			$input["TIME"] 	= "";
	      		}
	      	}
	      	else{
	      		$input["TIME"]  	= "";
	      	}

  			if($upload){
				if(isNotNullAndEmpty($_FILES["FILES"])){
					$input["FILES"]	= $_FILES["FILES"]["name"];
				} else {
					$input["FILES"] = "";
				}
      		} 
      		else {
				$input["FILES"] = "";
			}

      		if(isNotNullAndEmpty($input["EMPLOYEE_CODE"])){
	      		$cek_data = $this->M_VEmployee->getDataEmployee(["PERS_NUM" => $input["EMPLOYEE_CODE"]]);

	      		if(count($cek_data) >= 1){
	      			$input["EMPLOYEE_NAME"] = $cek_data["NAME"];
	      		}
	      	}
      		return $input;
    	}

    	private function validateInput($param, $is_edit_mode = false){
        	$result  		= true;
        	$result_files 	= true;
        	$err_msg 		= NULL;
    		
        	if(!isNotNullAndEmpty($param["EMPLOYEE_CODE"])){
          		$result 	= false;
          		$err_msg[] 	= "Employee Code is Required.";
        	}	

        	if(!isNotNullAndEmpty($param["PERMISSION_CODE"])){
          		$result 	= false;
          		$err_msg[] 	= "Permission is Required.";
        	}

        	if(strlen($param["FILES"]) > 0){
				if(is_string($param["FILES"]) && $_FILES["FILES"]["size"] != 0){
					$file_name = strtolower($param["FILES"]);
					if(strpos($file_name, ".jpeg") == true || strpos($file_name, ".jpg") == true || strpos($file_name, ".png") == true || strpos($file_name, ".pdf") ) {
						$result_files 	= true;
					}
					else {
						$result_files 	= false;
						$err_msg[] 		= "Format file Must be pdf/jpeg/jpg/png.";
					}
				}

				if(strlen($_FILES["FILES"]["name"]) > 0){
					if($_FILES["FILES"]["size"] != 0){
						if($_FILES["FILES"]["size"] > (5 * 1024 * 1024)){
							$result_files 	= false;
							$err_msg[] 	= "The maximum file size is 5 Mb.";
						}
					}
					else {
						if(intval($_SERVER['CONTENT_LENGTH']) > 0 ){
						    $result_files 	= false;
							$err_msg[] 	= "The maximum file size is 5 Mb.";
						}
					}
				}
			}

			if($result_files == true && $result == false){
				$result = false;
			}
			elseif($result_files == false){
				$result = false;
			}

		    if(!isNotNullAndEmpty($param["START_DATE"])){
          		$result 	= FALSE;
          		$err_msg[] 	= "Start Date is Required.";
        	}

        	if(!isNotNullAndEmpty($param["END_DATE"])){
          		$result 	= FALSE;
          		$err_msg[] 	= "End Date is Required.";
        	}

        	else {

				if(isNotNullAndEmpty($param["PERMISSION_CODE"]) && isNotNullAndEmpty($param["START_DATE"]) && isNotNullAndEmpty($param["END_DATE"])){
		        	$cek_start_date	= explode("-", $param["START_DATE"]);
        			$cek_end_date	= explode("-", $param["END_DATE"]);
		        	$result_format 	= true;

		        	if(count($cek_start_date) > 0){
		        		if( (strlen($cek_start_date[0]) != 2) || (strlen($cek_start_date[1]) != 2) || (strlen($cek_start_date[2]) != 4) ) {
		        			$result_format 	= false;
		          			$err_msg[] 		= "Start Date is invalid.";
		        		}
		        	}
		        	else{
		        		$result_format	= false;
	          			$err_msg[] 		= "Start Date must in dd-mm-yyyy format.";
		        	}

		        	if(count($cek_end_date) > 0){
		        		if( (strlen($cek_end_date[0]) != 2) || (strlen($cek_end_date[1]) != 2) || (strlen($cek_end_date[2]) != 4) ) {
		        			$result_format 	= false;
		          			$err_msg[] 		= "End Date is invalid.";
		        		}
		        	}
		        	else{
		        		$result_format	= false;
	          			$err_msg[] 		= "End Date must in dd-mm-yyyy format.";
		        	}

		        	if($result_format == true){
			        	$date1 	= new DateTime($param["START_DATE"]);
						$date2 	= new DateTime($param["END_DATE"]);

						if($date1 > $date2){
							$result 	= false;
							$err_msg[] 	= "Start Date Must Be Smaller Than End Date.";
						}
						else{
							// check duplicate
							$filter["EMPLOYEE_CODE"] 	= $param["EMPLOYEE_CODE"];
							$filter["PERMISSION_CODE"] 	= $param["PERMISSION_CODE"];
							$filter["START_DATE"] 		= dateTimeFormat("Ymd", $param["START_DATE"]);
							$filter["END_DATE"] 		= dateTimeFormat("Ymd", $param["END_DATE"]);
							$result_date 				= true;

							if($is_edit_mode == true){
								$check_data 			= $this->M_EmployeePermission->getAllDataEmployeePermission($filter);

								if(count($check_data) <= 0){
									$check_all_data	= $this->M_EmployeePermission->getAllDataEmployeePermission(["EMPLOYEE_CODE" => $param["EMPLOYEE_CODE"], "PERMISSION_CODE" => $param["PERMISSION_CODE"], "ID_NOT_EQUAL" => $param["ID"]]);

									if(count($check_all_data) > 0){
										for($i=0; $i<count($check_all_data); $i++){
											$exists_date1 = new DateTime(self::convertDate2($check_all_data[$i]["START_DATE"]));
											$exists_date2 = new DateTime(self::convertDate2($check_all_data[$i]["END_DATE"]));
											if( (($date1 >= $exists_date1) && ($date2 <= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 >= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 <= $exists_date2) && ($date2 >= $exists_date1))  or (($date1 >= $exists_date1) && ($date2 >= $exists_date2) && ($date1 <= $exists_date2))  ){
												$result_date = false;
											}
										}

										if($result_date == false){
											$result 	= false;
											$err_msg[] 	= "The Data Has Been Registered During That Period.";
										}
									}
								}
							}
							else{
								$check_duplicate = $this->M_EmployeePermission->getAllDataEmployeePermission($filter);
								if(count($check_duplicate) > 0){
									$result 	= false;
									$err_msg[] 	= "Data is Duplicate.";
								}
								else {

									if(isNotNullAndEmpty($param["EMPLOYEE_CODE"])){
										$check_data	= $this->M_EmployeePermission->getAllDataEmployeePermission(["EMPLOYEE_CODE" => $param["EMPLOYEE_CODE"]]) ;
										if(count($check_data) > 0){
											for($i=0; $i<count($check_data); $i++){
												$exists_date1 = new DateTime(self::convertDate2($check_data[$i]["START_DATE"]));
												$exists_date2 = new DateTime(self::convertDate2($check_data[$i]["END_DATE"]));
												if( (($date1 >= $exists_date1) && ($date2 <= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 >= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 <= $exists_date2) && ($date2 >= $exists_date1))  or (($date1 >= $exists_date1) && ($date2 >= $exists_date2) && ($date1 <= $exists_date2))  ){
													$result_date = false;
												}
											}
											if($result_date == false){
												$result 	= false;
												$err_msg[] 	= "The Data Has Been Registered During That Period.";
											}
										}
									}
								}
							}
						}
					}
					else{
						$result = false;
					}
				}
        	}
        	setErrMsg($err_msg);
        	
        	return $result;
       	}

       	private function validateInputImport($param, $row){
	        $result  = TRUE;
	        $err_msg = NULL;
	        $is_edit_mode = false;	
	        //CHECK EMPLOYEE_CODE IS REQUIRED
	        if(!isset($param["EMPLOYEE_CODE"]) || !isNotNullAndEmpty($param["EMPLOYEE_CODE"])){
	          $result = FALSE;
	          $err_msg[] = "EMPLOYEE_CODE on Row <b>".$row."</b> is Empty.";
	        }

	        //CHECK PERMISSION_CODE IS REQUIRED
	        if(!isset($param["PERMISSION_CODE"]) || !isNotNullAndEmpty($param["PERMISSION_CODE"])){
	          $result = FALSE;
	          $err_msg[] = "PERMISSION_CODE on Row <b>".$row."</b> is Empty.";
	        }

	        //CHECK START_DATE IS REQUIRED
	        if(!isset($param["START_DATE"]) || !isNotNullAndEmpty($param["START_DATE"])){
	          $result = FALSE;
	          $err_msg[] = "START_DATE on Row <b>".$row."</b> is Empty.";
	        }

	        //CHECK END_DATE IS REQUIRED
	        if(!isset($param["END_DATE"]) || !isNotNullAndEmpty($param["END_DATE"])){
	          $result = FALSE;
	          $err_msg[] = "END_DATE on Row <b>".$row."</b> is Empty.";
	        }

	        if(!(!isset($param["EMPLOYEE_CODE"]) || !isNotNullAndEmpty($param["EMPLOYEE_CODE"])) 
	        	&& !(!isset($param["EMPLOYEE_CODE"]) || !isNotNullAndEmpty($param["EMPLOYEE_CODE"]))
	        	&& !(!isset($param["START_DATE"]) || !isNotNullAndEmpty($param["START_DATE"]))
	        	&& !(!isset($param["END_DATE"]) || !isNotNullAndEmpty($param["END_DATE"]))
	        ){
	          
	          //EMPLOYEE CODE VALIDATION
	          $filter = NULL;
	          $filter["PERS_NUM"] = $param["EMPLOYEE_CODE"];
	          $employee_information = $this->M_VEmployee->getAllDataVEmployee($filter);
	          if(!isNotNullAndGreaterThanZero($employee_information) || count($employee_information) != 1){
	            $result     = FALSE;
	            $err_msg[]  = "EMPLOYEE_CODE on Row <b>".$row."</b> is Not Valid.";
	          }

	          //PERMISSION CODE VALIDATION
	          $filter = NULL;
	          $filter["CODE"] = $param["PERMISSION_CODE"];
	          $permission_category = $this->M_PermissionCategory->getAllDataPermissionCategory($filter);
	          if(!isNotNullAndGreaterThanZero($permission_category) || count($permission_category) != 1){
	            $result     = FALSE;
	            $err_msg[]  = "PERMISSION_CODE on Row <b>".$row."</b> is Not Valid.";
	          }
	          else{
	          	if($permission_category[0]["TIME_INPUT"] == "1"){
	          		if(!isset($param["TIME"]) || !isNotNullAndEmpty($param["TIME"])){
			          	$result = FALSE;
			          	$err_msg[] = "TIME on Row <b>".$row."</b> is Empty.";
			        }
	          	}
	          }

	          	//check
	          	$cek_start_date	= explode("-", $param["START_DATE"]);
				$cek_end_date	= explode("-", $param["END_DATE"]);
	        	$result_format 	= true;

	        	if($result_format == true){
		        	$date1 	= new DateTime($param["START_DATE"]);
					$date2 	= new DateTime($param["END_DATE"]);

					if($date1 > $date2){
						$result 	= false;
						$err_msg[] 	= "Start Date Must Be Smaller Than End Date on Row <b>".$row."</b>.";
					}
					else{
						// check duplicate
						$filter = null;
						$filter["EMPLOYEE_CODE"] 	= $param["EMPLOYEE_CODE"];
						$filter["PERMISSION_CODE"] 	= $param["PERMISSION_CODE"];
						$filter["START_DATE"] 		= dateTimeFormat("Ymd", $param["START_DATE"]);
						$filter["END_DATE"] 		= dateTimeFormat("Ymd", $param["END_DATE"]);
						$result_date 				= true;

						if($is_edit_mode == true){
							$check_data 			= $this->M_EmployeePermission->getAllDataEmployeePermission($filter);

							if(count($check_data) <= 0){
								$check_all_data	= $this->M_EmployeePermission->getAllDataEmployeePermission(["EMPLOYEE_CODE" => $param["EMPLOYEE_CODE"], "PERMISSION_CODE" => $param["PERMISSION_CODE"], "ID_NOT_EQUAL" => $param["ID"]]);

								if(count($check_all_data) > 0){
									for($i=0; $i<count($check_all_data); $i++){
										$exists_date1 = new DateTime(self::convertDate2($check_all_data[$i]["START_DATE"]));
										$exists_date2 = new DateTime(self::convertDate2($check_all_data[$i]["END_DATE"]));
										if( (($date1 >= $exists_date1) && ($date2 <= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 >= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 <= $exists_date2) && ($date2 >= $exists_date1))  or (($date1 >= $exists_date1) && ($date2 >= $exists_date2) && ($date1 <= $exists_date2))  ){
											$result_date = false;
										}
									}

									if($result_date == false){
										$result 	= false;
										$err_msg[] 	= "The Data Has Been Registered During That Period on Row <b>".$row."</b>.";
									}
								}
							}
						}
						else{
							$check_duplicate = $this->M_EmployeePermission->getAllDataEmployeePermission($filter);
							if(count($check_duplicate) > 0){
								$result 	= false;
								$err_msg[] 	= "Data is Duplicate on Row <b>".$row."</b>.";
							}
							else {

								if(isNotNullAndEmpty($param["EMPLOYEE_CODE"])){
									$check_data	= $this->M_EmployeePermission->getAllDataEmployeePermission(["EMPLOYEE_CODE" => $param["EMPLOYEE_CODE"]]) ;
									if(count($check_data) > 0){
										for($i=0; $i<count($check_data); $i++){
											$exists_date1 = new DateTime(self::convertDate2($check_data[$i]["START_DATE"]));
											$exists_date2 = new DateTime(self::convertDate2($check_data[$i]["END_DATE"]));
											if( (($date1 >= $exists_date1) && ($date2 <= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 >= $exists_date2)) or (($date1 <= $exists_date1) && ($date2 <= $exists_date2) && ($date2 >= $exists_date1))  or (($date1 >= $exists_date1) && ($date2 >= $exists_date2) && ($date1 <= $exists_date2))  ){
												$result_date = false;
											}
										}
										if($result_date == false){
											$result 	= false;
											$err_msg[] 	= "The Data Has Been Registered During That Period on Row <b>".$row."</b>.";
										}
									}
								}
							}
						}
					}
				}
				else{
					$result = false;
				}

	        }

	        if(!$result){
	          setErrMsg($err_msg);
	        }

	        return $result;
	    }

       	private function validateSearch($param){
    		$result  	= TRUE;
        	$err_msg 	= NULL;

	      	if(isset($param["DATE"]) && isNotNullAndEmpty($param["DATE"])){
	      		$cek_date 	= explode("-", $param["DATE"]);

	        	if(count($cek_date) > 0){
	        		if( (strlen($cek_date[0]) != 2) || (strlen($cek_date[1]) != 2) || (strlen($cek_date[2]) != 4) ) {
	        			$result 		= FALSE;
	          			$err_msg[] 		= "Date is invalid.";
	        		}
	        	}
	        	else{
	        		$result			= FALSE;
	      			$err_msg[] 		= "Date must in dd-mm-yyyy format.";
	        	}
	      	}

      		if(count($err_msg) > 0){
      			setErrMsg($err_msg);
      		}

      		return $result;
    	}

		private function loader(){
      		$this->load->model("M_EmployeePermission");
      		$this->load->model("M_VEmployee");
      		$this->load->model("M_GenerateCombo");
    	}

    	private function setupMasterPage($HeadMenu = null, $Menu = null, $Title = null){
      		$this->data["HeadMenu"]       = $HeadMenu;
      		$this->data["Menu"]           = $Menu;
      		$this->data["Title"]          = $Title;
    	}

    	private function bindingFilter(){
	      	$filter 					= null;
      		$filter["PERMISSION_CODE"] 	= $this->input->post("PERMISSION_CODE");

	      	return $filter;
	    }

		private function createInputView(){
	        $this->data["Combo_permission"]		= $this->M_GenerateCombo->comboPermission();
	        $this->data["popup_employee_code"]  = $this->M_VEmployee->getAllDataVEmployee(null);
    	} 

		private function doUpload($ID, $objData, $is_edit_mode = false){
	      	$this->data["upload_file_name"] = null;
	      	
	      	if(empty($_FILES["FILES"]["name"])){
	        	return null;
	     	}
	      	
	      	$path = dirname($_SERVER["SCRIPT_FILENAME"])."/upload_path/EmployeePermission/";
	      	$config["upload_path"]      = $path;
	      	
			$rename_filename = str_replace(' ', '_', $objData["FILES"]);
	      	
	      	if($is_edit_mode){
		      	$config["file_name"]	= $objData["UPDATED_DATE"] . "" . $objData["UPDATED_TIME"] . "_". $rename_filename;
	      	}
	      	else {
		      	$config["file_name"]	= $objData["CREATED_DATE"] . "" . $objData["CREATED_TIME"] . "_". $rename_filename;      	
	      	}
	      	$config["allowed_types"]    = "jpeg|jpg|png|pdf|doc|docx";
	      	$config["max_size"]         = 5120; // 5 MB
	      	$this->load->library("upload", $config);

	      	if (!$this->upload->do_upload("FILES")){
	        	$error = array("error" => $this->upload->display_errors());
	        	$this->session->set_flashdata("err_msg", $error);
	        	return false;
	      	}
	      	else{
	        	$data = array("upload_data" => $this->upload->data());
	        	$this->data["upload_file_name"] = $data["upload_data"]["file_name"];
				// checkInput($this->data["upload_file_name"]);
	        	return $this->data["upload_file_name"];
	      	}
	    }

	    // convert Date yyyymmdd TO dd-mm-yyyy
	    private function convertDate2($date){
	    	if(!isNotNullAndEmpty($date)){
	    		return "";
	    	}

	    	$day 	= substr($date, 6, 2);
	    	$month 	= substr($date, 4, 2);
	    	$year 	= substr($date, 0, 4);

	    	return $day."-".$month."-".$year;
	    }

	}
?>