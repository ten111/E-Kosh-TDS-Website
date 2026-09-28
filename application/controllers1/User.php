<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct() {
        parent::__construct();
		//if(!$this->session->userdata("admin")){redirect("home");}	
		date_default_timezone_set("Asia/Kolkata");

    }
	
	public function create_tbl(){
		$query=	$this->db->query("CREATE TABLE 'clients' (
  'client_id' int NOT NULL,  'client_name' varchar(200) NOT NULL,  'client_slug' varchar(100) NOT NULL,
  'client_status' varchar(20) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;COMMIT;");	
  		if($query==true){
			echo 'yes';	
		}else{
			echo 'no';
		}
	}
	
	public function index()
	{
		$data=array();
		$this->load->view('admin2/header');
		$this->load->view('admin2/home');
	}
	
	public function campaigns()
	{
		$data=array();
		$this->load->view('admin2/header');
		$this->load->view('admin2/campaigns');
	}
	
}?>