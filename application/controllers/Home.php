<?php 
  class Home extends ICT_Controller{
    
    public function __construct(){
      parent::__construct();
      $this->setupMasterPage();
    }
    //PUBLIC PROPERTY
    public $FUNCTION_ID = "HOME"; 
    public $data;

    //PUBLIC FUNCTION SECTION
    public function index(){
      $this->data["Container"] = $this->load->view("Home/index",$this->data, true);
      $this->load->view("Shared/master",$this->data);
    }

    private function setupMasterPage(){
      $this->data["HeadMenu"] = "Home";
      $this->data["Menu"] = "";
      $this->data["HeadBreadCrumb"] = "";
      $this->data["Title"] = "Home";
    }    
  }


?>