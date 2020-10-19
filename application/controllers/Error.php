<?php 
	/**
	* 
	*/
	class Error extends CI_Controller
	{
		public function index(){
			$this->load->view("error/index");
		}

		public function restrictedPage(){
			$this->load->view("error/restrict");
		}
	}
?>