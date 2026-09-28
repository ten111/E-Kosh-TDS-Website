<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest extends MY_Controller {
	
	function __construct() {
        parent::__construct();
    }
	
	public function login_api()
	{	
		$data = json_decode(file_get_contents('php://input'), true);
		//echo json_encode(array("u"=>$data['username'],"p"=>$data['password']));exit;
		$emp=substr($data['username'],3);
		$chk=$this->db->get_where("employees",array("emp_id"=>$emp,"emp_password"=>md5($data['password']),"emp_status"=>""));
		if($chk->num_rows()>0){
			$user=$chk->row();
			$d=array("branch"=>$user->branch_id,"name"=>$user->firstname.' '.$user->lastname,"userid"=>$user->emp_id,"msg"=>" You have Logged in successfully.","status"=>0);	
		}else{
			$d=array("msg"=>"Incorrect Username or Password.","status"=>1);
		}echo json_encode($d); 
		
	}
	
	public function leaves_api(){
		$leaves=$this->db->get("leaves")->result_array();
		echo json_encode($leaves);	
	}
	
	public function leaves_widgets($uid){
		$leaves=array();
		$l=$this->db->get("leaves")->result();
		foreach($l as $l){
			  $this->db->select_sum('total_days');  
			  $this->db->where("empid",$uid); 
			  $this->db->where("lid",$l->leave_id); 
			  $total=$this->db->get('leave_apply')->row();
			  $bal=$total->total_days;
			  $left=$l->max_days-$bal;
			  $used=$l->max_days-$left;
			  $data=array("ltype"=>$l->leave_type,"max"=>$l->max_days,"left"=>$left,"availed"=>$used);
			  array_push($leaves,$data);
			 // $leaves+=$data;
		}
		echo json_encode($leaves);
	}
	
	public function total_days(){
		$data = json_decode(file_get_contents('php://input'), true);
		$diff = ((strtotime($data['end_date'])- strtotime($data['start_date']))/24/3600)." days";
		echo json_encode(array("days"=>$diff));
	}
	
	public function request_leave($user){
		$data = json_decode(file_get_contents('php://input'), true);
		//echo json_encode($data);exit;
		//echo json_encode(array("status"=>0,"msg"=>"Please Select Correct Dates.","laid"=>0));exit;
		$end=date("Y-m-d",strtotime($data['end_date']));
		$start=date("Y-m-d",strtotime($data['start_date']));
		//echo json_encode(array("status"=>0,"msg"=>$end."Please Select Correct Dates.".$start,"laid"=>0));exit;
		if($end<$start){
			echo json_encode(array("status"=>0,"msg"=>"Please Select Correct Dates.","laid"=>0));exit;
		}
		$apr_user=$this->db->get_where("employees",array("emp_id"=>$user))->row();
		$diff = ((strtotime($data['end_date'])- strtotime($data['start_date']))/24/3600);
		  
		  $l=$this->db->get_where("leaves",array("leave_id"=>$data['leave_type']))->row();
			//echo json_encode($l);exit;
		  $this->db->select_sum('total_days');  
		  $this->db->where("empid",$user); 
		  $this->db->where("lid",$data['leave_type']); 
		  $total=$this->db->get('leave_apply');
		  if($total->num_rows()>0){
			  $tt=$total->row();
			  $bal=$tt->total_days;
			  $left=$l->max_days-$bal;
			  $used=$l->max_days-$left;
		  }else{
			  $left=$l->max_days;
			  $used=0; 
		  }
		  //echo json_encode(array("status"=>0,"msg"=>$used."You are ".$diff."left with only ".$left." more leaves.","laid"=>0));exit;
			 if($diff>$left){ echo json_encode(array("status"=>0,"msg"=>"You are asking for ".$diff." days leaves and have only ".$left." leaves available.","laid"=>0));exit;}
		if($this->db->insert("leave_apply",array("empid"=>$user,"l_from"=>$data['start_date'],"l_to"=>$data['end_date'],"reason"=>$data['reason'],"applied_date"=>date("Y-m-d"),"lid"=>$data['leave_type'],"total_days"=>$diff,"l_status"=>"Pending","apr_emp"=>$apr_user->reporting_emp))==true){
			$this->db->select("*");
			$this->db->from("leave_apply");
			$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
			$this->db->where("leave_apply.empid",$user);
			$leaves=$this->db->get()->result_array();
			echo json_encode($leaves);	
		}else{
			echo json_encode(array("status"=>0,"msg"=>"Couldnot apply leave please try later.","laid"=>0));
		}
	}
	
	public function req_leaves_api($emp){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
		$this->db->where("leave_apply.empid",$emp);
		$this->db->where("leave_apply.l_status","Pending");
		$leaves=$this->db->get()->result_array();
		echo json_encode($leaves);	
	}
	public function req_leaves_api2($emp){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
		$this->db->where("leave_apply.empid",$emp);
		$this->db->where("leave_apply.l_status!=","Pending");
		$leaves=$this->db->get()->result_array();
		echo json_encode($leaves);	
	}
	
	public function pending_lreq($emp){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
		$this->db->join("employees","leave_apply.empid=employees.emp_id");
		$this->db->where("leave_apply.apr_emp",$emp);
		$leaves=$this->db->get()->result_array();
		echo json_encode($leaves);	
	}
	
	public function approveLeave($lid,$emp){
		$this->db->where("laid",$lid);
		$this->db->update("leave_apply",array("l_status"=>"Approve"));
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
		$this->db->join("employees","leave_apply.empid=employees.emp_id");
		$this->db->where("leave_apply.apr_emp",$emp);
		$leaves=$this->db->get()->result_array();
		echo json_encode($leaves);	
	}
	public function rejectLeave($emp){
		$data = json_decode(file_get_contents('php://input'), true);
		
		$this->db->where("laid",$data['rlid']);
		$this->db->update("leave_apply",array("l_status"=>"Rejected","l_remarks"=>$data['rreason']));
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leave_apply.lid=leaves.leave_id");
		$this->db->join("employees","leave_apply.empid=employees.emp_id");
		$this->db->where("leave_apply.apr_emp",$emp);
		$leaves=$this->db->get()->result_array();
		echo json_encode($leaves);	
	}
}

?>