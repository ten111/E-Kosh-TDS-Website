<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index()
	{
		$this->load->view('adminlogin');
	}
	
	public function employee()
	{
		$this->load->view('emplogin');
	}
	
	public function adminlogin(){
		$chk=$this->db->get_where("admin",array("username"=>$this->input->post("username"),"password"=>md5($this->input->post("password"))));
		if($chk->num_rows()>0)
		{
			$d=$chk->row();
			$data=array("admin"=>"true","type"=>'admin',"loggeduser"=>"admin");
						$this->session->set_userdata($data);
						redirect("admin");
		}
		else
		{
			$this->session->set_flashdata('msg', 'Invalid Username or Password');	
			redirect("home");
		}
	}
	
	public function emplogin(){
		$chk=$this->db->get_where("employees",array("emp_email"=>$this->input->post("username"),"emp_password"=>md5($this->input->post("password")),"emp_status"=>""));
		if($chk->num_rows()>0)
		{
			$d=$chk->row();
			$roles=$this->db->get_where("emp_des",array("emp_id"=>$d->emp_id))->result();
			$role=array();
			foreach($roles as $r){array_push($role,$r->des_id);}
			$roles=implode(",",$role);
			$data=array("user"=>$d->emp_id,"employee"=>"true","type"=>'employee',"roles"=>$roles,"branch"=>$d->branch_id,"img"=>$d->profile_photo,"loggeduser"=>$d->firstname.' '.$d->lastname);
						$this->session->set_userdata($data);
						redirect("employee");
		}
		else
		{
			$this->session->set_flashdata('msg', 'Invalid Email or Password');	
			redirect("home/employee");
		}
	}
}
