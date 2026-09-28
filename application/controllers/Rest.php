<?php header("Access-Control-Allow-Origin: *");//Auro
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest extends MY_Controller {
	
	function __construct() {
        parent::__construct();
		error_reporting(0);
    }

	public function mcxdata_api(){
		echo json_encode($this->db->get("metals")->result_array());
	}
	public function getdata2(){
		// Receive JSON from Tampermonkey
		$json = file_get_contents('php://input');

		$data = json_decode($json, true);
		$this->db->where("symb",$data['metal']);
		$this->db->update("metals",array("rate"=>str_replace(',', '', $data['price'])));
		echo json_encode($data);exit;

	}
	
	public function graph_api($emp,$mon=false){
		//$m=$mon;
		if($mon==false){
		$mon=date("M-Y");
		}
		//$data=array();
		$count1=$this->db->get_where("leads",array("last_update_mon"=>$mon,"lead_status"=>"Switch Off","lead_emp"=>$emp))->num_rows(); 
		$count2=$this->db->get_where("leads",array("last_update_mon"=>$mon,"lead_status"=>"Not Interested","lead_emp"=>$emp))->num_rows(); 
		$count3=$this->db->get_where("leads",array("last_update_mon"=>$mon,"lead_status"=>"Follow Up","lead_emp"=>$emp))->num_rows(); 
		$count4=$this->db->get_where("leads",array("last_update_mon"=>$mon,"lead_status"=>"Interested","lead_emp"=>$emp))->num_rows();	
		$count5=$this->db->get_where("leads",array("last_update_mon"=>$mon,"lead_status"=>"Free Trial","lead_emp"=>$emp))->num_rows();
		echo json_encode(array("count1"=>$count1,"count2"=>$count2,"count3"=>$count3,"count4"=>$count4,"count5"=>$count5));	
	}
	public function showw(){
		echo date("H:i",strtotime("02:00 PM"));
	}
	public function status_update_api(){
		$_POST= json_decode(file_get_contents('php://input'), true);
	//	echo json_encode($_POST);exit;//
		$d=explode("T",$_POST['next_date']);
		//$dd=explode("-",$d[0]);
		//$next_date=$dd[2].'-'.$dd[1].'-'.$dd[0];
		// json_encode(array("sd"=>$next_date));exit;
		$query=$this->db->insert("followups",array("action_user"=>$_POST['userid'],"next_date"=>$d[0],"lead_id"=>$_POST['lead_id'],
				"action_date"=>date("Y-m-d"),"next_remark"=>$_POST['remark'],"pro_type"=>$_POST['pro_type'],"next_time"=>date("H:i",strtotime($_POST['lead_time'])),
				"action_time"=>date("Y-m-d H:i:s"),"f_status"=>$_POST['lead_status']));
				if($query==true){	
					$this->db->where("lead_id",$_POST['lead_id']);
					$this->db->update("leads",array("lead_status"=>$_POST['lead_status'],"last_update"=>date("Y-m-d"),"last_update_mon"=>date("M-Y"),"lead_week"=>date('W')));
					echo json_encode(array("status"=>0,"msg"=>"Lead Status Updated Successfully."));			
				}else{
					echo json_encode(array("status"=>1,"msg"=>"Lead Status Couldnot be Deleted ."));	
				}
	}
	
	public function leads_list_api($uid,$type){
		$this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("state_list","leads.stateid=state_list.state_id");
		//$this->db->limit($_POST['limit']);
		$this->db->where("leads.lead_emp",$uid);
		if($type=='new'){
		$this->db->where("leads.lead_status","");	
		}else{
		$this->db->where("leads.lead_status",str_replace("-"," ",$type));	
		}
		$this->db->order_by("leads.lead_id","desc");
		$leads=$this->db->get()->result_array();	
		echo json_encode($leads);
	}
	
	public function calls_api($lim=false){
		if($lim==true){
			$this->db->limit(5);
			}
		$this->db->order_by("call_id","desc");
		$calls=$this->db->get_where("call_alerts",array("call_date"=>date("Y-m-d")))->result_array();
		echo json_encode($calls);
	}
	
	public function history_api($lead){
		$this->db->select("*");
		$this->db->from("followups");
		$this->db->join("employees","employees.emp_id=followups.action_user");
		$this->db->where("followups.lead_id",$lead);
		$this->db->order_by("followups.lead_id","desc");
		$history=$this->db->get()->result_array();
		$lead=$this->db->get_where("leads",array("lead_id"=>$lead))->row_array();
		echo json_encode(array("history"=>$history,"lead"=>$lead));
	}
	
	public function contracts_api($emp){
		$this->db->select("*");
		$this->db->from("leads");	
		$this->db->where("leads.is_converted","yes");	
		$this->db->order_by("leads.lead_id","desc");  
		$this->db->where("leads.lead_emp",$emp);
		$contracts=$this->db->get()->result_array();
	}
	
	public function followup_api($emp,$type){//
		$type=str_replace("-"," ",$type);
		$this->db->select("*");
		$this->db->from("followups");
		$this->db->join("leads","leads.lead_id=followups.lead_id");
		$this->db->where("leads.lead_status",$type);
		$this->db->where("followups.next_date>=",date("Y-m-d"));
		$this->db->order_by("followups.foid","desc");			
		$this->db->where("leads.lead_emp",$emp);
		$leads=$this->db->get()->result_array();
		echo json_encode($leads);
	}
	
	public function emp_dashboard_api($user){
		$data1=$this->db->get_where("leads",array("lead_emp"=>$user,"lead_status"=>""))->num_rows();
		$data2=$this->db->get_where("leads",array("lead_emp"=>$user,"lead_status"=>"Follow Up"))->num_rows();
		$data3=$this->db->get_where("leads",array("lead_emp"=>$user,"lead_status"=>"Free Trial"))->num_rows();
		$data4=$this->db->get_where("leads",array("lead_emp"=>$user,"lead_status"=>"Switch Off"))->num_rows();
		echo json_encode(array("data1"=>$data1,"data2"=>$data2,"data3"=>$data3,"swoff"=>$data4));
	}
	
	public function leads_api($user){
		$data=$this->db->get_where("leads",array("lead_emp"=>$user,"lead_status!="=>""))->result_array();
		echo json_encode($data);	
	}
	
	public function lead_del_api($lid){
		$query=$this->db->delete("leads",array("lead_id"=>$lid));
		if($query==true){
			$query=$this->db->delete("followups",array("lead_id"=>$lid));
			echo json_encode(array("status"=>0,"msg"=>"Lead Deleted Successfully."));			
		}else{
			echo json_encode(array("status"=>0,"msg"=>"Lead Couldnot be Deleted ."));	
		}
	}
	
	public function lead_his_del_api($lid){
		$query=$this->db->delete("followups",array("foid"=>$lid));
		if($query==true){
			echo json_encode(array("status"=>0,"msg"=>"Record Deleted Successfully."));			
		}else{
			echo json_encode(array("status"=>0,"msg"=>"Record Couldnot be Deleted ."));	
		}
	}
	
	public function lead_detail_api($lid){
		$data=$this->db->get_where("leads",array("lead_id"=>$lid))->row_array();
		echo json_encode($data);	
	}
	
	public function lead_history_api($lid){
		$this->db->order_by("foid","desc");
		$data=$this->db->get_where("followups",array("lead_id"=>$lid))->result_array();
		echo json_encode($data);	
	}
	
	public function lead_history_add(){
		$_POST= json_decode(file_get_contents('php://input'), true);
		//echo json_encode($_POST);exit;		
		$query=$this->db->insert("followups",array("lead_id"=>$_POST['lead_id'],"action_date"=>date("Y-m-d"),"next_date"=>'',//$_POST['next_date'],
		"lremark"=>$_POST['lremark'],"action_time"=>date("Y-m-d h:i:s"),"f_status"=>$_POST['f_status']));
		if($query==true){
			echo json_encode(array("status"=>0,"msg"=>"Lead Log Saved Successfully."));			
		}else{
			echo json_encode(array("status"=>0,"msg"=>"Lead Log Couldnot be Saved."));	
		}
			//redirect("admin/list_leads");
		
	}	
	public function new_lead_submit_api(){	
		$_POST= json_decode(file_get_contents('php://input'), true);
		//echo json_encode($_POST);exit;
		if($this->db->get_where("leads",array("contact_phone1"=>$_POST['mobile']))->num_rows()>0){
				echo json_encode(array("status"=>0,"msg"=>"Mobile Already registered."));	
		}else{
			$query=$this->db->insert("leads",array("contact_phone1"=>$_POST['mobile'],"lead_date"=>date("Y-m-d"),"contact_person"=>$_POST['name'],
			"lead_src"=>$_POST['lead_src'],"lead_remark"=>$_POST['lead_remark'],"email"=>$_POST['email']));
			if($query==true){
				echo json_encode(array("status"=>0,"msg"=>"Lead Created Successfully."));			
			}else{
				echo json_encode(array("status"=>0,"msg"=>"Lead Couldnot be Created."));	
			}
			//redirect("admin/list_leads");
		}
	}
	
	public function login_api(){	
		$data = json_decode(file_get_contents('php://input'), true);
		//echo json_encode($data);exit;
		//echo json_encode(array("u"=>$data['username'],"p"=>$data['password']));exit;
		//$emp=substr($data['username'],3);
		$chk=$this->db->get_where("employees",array("mob1"=>$data['username'],"emp_password"=>md5($data['password']),"emp_status"=>""));
		if($chk->num_rows()>0){
			$user=$chk->row();
			$d=array("branch"=>$user->branch_id,"name"=>$user->firstname.' '.$user->lastname,"userid"=>$user->emp_id,"msg"=>" You have Logged in successfully.","status"=>0);	
		}else{
			$d=array("msg"=>"Incorrect Username or Password.","status"=>1);
		}echo json_encode($d); 
		
	}
	
	public function change_password_api(){
		$data = json_decode(file_get_contents('php://input'), true);
		//
			echo json_encode($data);exit;
		//echo json_encode(array("u"=>$data['username'],"p"=>$data['password']));exit;
		//$emp=substr($data['username'],3);
		if($data['password']!=$data['cpassword']){
			$d=array("msg"=>"Password Changed Successfully.","status"=>1);echo json_encode($d); exit;
		}else
		if(strlen($data['password'])<6){
			$d=array("msg"=>"Min Password lenght is 6 character.","status"=>1);echo json_encode($d); exit;
		}else{
		$this->db->where("emp_id",$data['empid']);
		$chk=$this->db->update("employees",array("emp_password"=>md5($data['password'])));
		if($chk==true){
			$d=array("msg"=>"Password Changed Successfully.","status"=>0);	
		}else{
			$d=array("msg"=>"Password Couldnot be changed.","status"=>1);
		}echo json_encode($d); 
		}
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