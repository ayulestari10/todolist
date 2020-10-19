<?php
  class Errors extends ICT_Controller{
    public function __construct(){
      parent::__construct(false);
      
    }
    //PUBLIC PROPERTY
    public $data;

    //PUBLIC FUNCTION SECTION
    public function index()
    {
      $this->load->view("Error/index");
    }

  }
?>
