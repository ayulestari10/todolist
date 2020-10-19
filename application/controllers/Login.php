<?php
  class Login extends ICT_Controller{
    public function __construct(){
      parent::__construct(false);
      $this->loader();
    }
    //PUBLIC PROPERTY
    public $data;

    //PUBLIC FUNCTION SECTION
    public function index(){
      if(isRequestPOST()){
        if($this->doLogin()){
          $user_group_list = array("OLGA_01", "OLGA_03");
          if(in_array(userInformation()["GEN_GROUP"], $user_group_list)){
              return redirect(base_url()."Home");
          }
        }
        setErrMsg(array("Username or Password is Wrong."));
      }

      // $this->data["captcha"] = getCaptcha();
      $this->load->view("Login/index",$this->data);
      removeSuccessErrMsg();
    }

    public function logout(){
      if($_SESSION != null){
        foreach ($_SESSION as $key => $value) {
          $this->session->unset_userdata($key);
        }
      }
      return redirect(base_url()."Login");
    }

    //PRIVATE FUNCTION SECTION
    //

    private function doLogin(){
      $username = str_replace(" ", "%20", $this->input->post("username")) ;
      $password = str_replace(" ", "%20", $this->input->post("password")) ;

      $url = API_URL."get/checkLogin/?i=".API_ID."&t=".API_TOKEN."&p=".$username."||".$password."||".APPS_CODE;
      $json = file_get_contents($url);
      $result = json_decode($json);
      
      if($result != null && $result->metadata->status == 200){
        if(count($result->response) > 0){
          $this->session->set_userdata(array(__USERINFO => (array)$result->response));
          return true;
        }
      }

      return false;
    }

    private function loader(){
      //$this->load->model("M_Login");
    }
  }
?>
