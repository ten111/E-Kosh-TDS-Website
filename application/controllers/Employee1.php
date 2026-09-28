<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Employee extends MY_Controller {
	function __construct() {
        parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		if(!$this->session->userdata("employee") && !$this->session->userdata("admin")){redirect("home/employee");}	
		error_reporting(0);
    }
	
	public function index(){
		$data=array();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/dashboard',$data,true);
		$this->emplayout();
	}
	
	public function calls(){
		$this->db->order_by("call_id","desc");
		$data['calls']=$this->db->get("call_alerts")->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/calls',$data,true);
		$this->emplayout();	
	}
	
	public function ajax_fetch_lead(){
		parse_str($_POST['formdata'],$form);
		$this->db->limit($_POST['lead_count']);
		$chk_leads=$this->db->get_where("leads",array("lead_type"=>$form['lead_type'],"lead_emp"=>""));
		$chk_old=$this->db->get_where("leads",array("lead_emp"=>$this->session->userdata("user"),"lead_status"=>""));
		if($chk_old->num_rows()>0){
			echo "Please Complete Calling on old leads first";
		}else
		if($chk_leads->num_rows()>0){
			$leads=$chk_leads->result();
			$i=0;foreach($leads as $ld){
			$this->db->where("lead_id",$ld->lead_id);
			$this->db->update("leads",array("lead_emp"=>$this->session->userdata("user")));
			$i++;}
			echo $i;
		}else{
			echo "No Leads Available"; 
		}
	}
	
	public function newlead(){
		$this->db->order_by("lead_id","desc");
		$data['leads']=$this->db->get_where("leads",array("created_user"=>$this->session->userdata("user")))->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/newlead',$data,true);
		$this->emplayout();
	}
	
	public function list_tasks($id=false){
		if($id==true){
		$data['edit']=$this->db->get_where("tasks",array("tsk_id"=>$id))->row();	
		}else{
		$data=array();
		}
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/all_tasks',$data,true);
		$this->emplayout(); 	
	}
	
	public function ajax_tsk_wt(){
		$this->db->where("tsk_emp_id",$_POST['id']);
		$this->db->update("task_emps",array("tsk_wt"=>$_POST['wt']));	
	}
	
	public function ajax_designation(){
		$desg=$this->db->get_where("designations",array("dep_id"=>$_POST['id']))->result();
		echo '<option value="">Select Designation</option>';
        foreach($desg as $d){echo '<option value="'.$d->des_id.'">'.$d->des_name.'</option>';}
	}
	
	public function delemp_task(){
		$this->db->delete("task_emps",array("tsk_emp_id"=>$_POST['id']));
		$this->db->delete("checklists",array("tsk_emp_id"=>$_POST['id']));
	}
	
	public function ajax_emps(){
		$this->db->select("*");
		$this->db->from("employees");
		$this->db->join("emp_des","emp_des.emp_id=employees.emp_id");
		$this->db->where("employees.branch_id",$_POST['br']);
		$this->db->where("emp_des.des_id",$_POST['des']);
		if(isset($_POST['emp'])){
			$this->db->where("employees.emp_id!=",$_POST['emp']);	
		}
		$emps=$this->db->get()->result();
		//echo "<pre>";print_r($emps);exit;
		echo '<option value="">Select Employee</option>';
        foreach($emps as $d){echo '<option value="'.$d->emp_id.'">'.$d->firstname.' '.$d->lastname.' EMP-'.$d->emp_id.'</option>';}
	}
	
	public function assign_task_emp(){
		parse_str($_POST['formdata'],$form);
		//print_r($form);exit;
		$chk=$this->db->get_where("task_emps",array("tsk_id"=>$form['task_id'],"emp_id"=>$form['emp']));
		if($chk->num_rows()>0){
			echo 0;	
		}else{
			$this->db->insert("task_emps",array("tsk_id"=>$form['task_id'],"emp_id"=>$form['emp'],"assign_date"=>date("Y-m-d")));
			$lid=$this->db->insert_id();
			foreach($form['checklist'] as $ch){
				$this->db->insert("checklists",array("tsk_id"=>$form['task_id'],"emp_id"=>$form['emp'],"checklist"=>$ch,"tsk_emp_id"=>$lid));
			}
			$data['id']=$form['task_id'];
			///$data['emp']=$ids[1];
			//$data['linkid']=$_POST['id'];
			$this->db->select("*");
			$this->db->from("task_emps");
			$this->db->join("employees","employees.emp_id=task_emps.emp_id");
			$this->db->where("task_emps.tsk_id",$form['task_id']);
			$data['emps']=$this->db->get()->result();
			$this->load->view("employee/ajax/ajax_emp_assign",$data);
		}
		//$this->db->where("tsk_id",$form['task_id']);	
//		if($this->db->update("tasks",array("tsk_emp"=>$form['emp']))==true){
//			$emp=$this->db->get_where("employees",array("emp_id"=>$form['emp']))->row();	
//			echo $emp->emp_id.'-'.$emp->firstname.' '.$emp->lastname;
//		}else{
//			echo 0;	
//		}
	}
	
	public function ajax_emp_assign(){
		//$ids=explode("-",$_POST['id']);
		$data['id']=$_POST['id'];
		///$data['emp']=$ids[1];
		//$data['linkid']=$_POST['id'];
		$this->db->select("*");
		$this->db->from("task_emps");
		$this->db->join("employees","employees.emp_id=task_emps.emp_id");
		$this->db->where("task_emps.tsk_id",$_POST['id']);
		$data['emps']=$this->db->get()->result();
		$this->load->view("employee/ajax/ajax_emp_assign",$data);
	}
	
	public function add_task(){
		$data=array("tsk_contract"=>$_POST['contract'],"tsk_subject"=>$_POST['tsk_subject'],"tsk_title"=>$_POST['tsk_title'],"tsk_desc"=>$_POST['tsk_desc'],"tsk_start"=>$_POST['tsk_start'],"tsk_end"=>$_POST['tsk_end'],"tsk_priority"=>$_POST['tsk_priority'],"tsk_created_date"=>date("Y-m-d"),"tsk_created_time"=>date("Y-m-d H:i:s"));
		if($this->db->insert("tasks",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Task Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Task Couldnot be Added.</div>');	}
		redirect("employee/list_tasks");
	}
	public function update_task(){
		$data=array("tsk_contract"=>$_POST['contract'],"tsk_subject"=>$_POST['tsk_subject'],"tsk_title"=>$_POST['tsk_title'],"tsk_desc"=>$_POST['tsk_desc'],"tsk_start"=>$_POST['tsk_start'],"tsk_end"=>$_POST['tsk_end'],"tsk_priority"=>$_POST['tsk_priority'],"tsk_created_date"=>date("Y-m-d"),"tsk_created_time"=>date("Y-m-d H:i:s"));
		$this->db->where("tsk_id",$_POST['tsk_id']);
		if($this->db->update("tasks",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Task Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Task Couldnot be Updated.</div>');	}
		redirect("employee/list_tasks");
	}
	
	
	public function search_contract(){
		$data['conts']=$this->db->get_where("contracts",array("cont_id"=>$_POST['id']))->result();
		$this->load->view("employee/ajax/search_contract",$data);
	}	
	
	public function ajax_tasks_list_all(){
		//print_r($_POST);exit;
		$this->db->select("*");
		$this->db->from("tasks");
		if($_POST['type']!=""){
		//$this->db->join("task_emps","task_emps.tsk_id=tasks.tsk_id");
		}else{
		//$this->db->join("task_emps","task_emps.tsk_id=tasks.tsk_id","left");
		}
		$this->db->order_by("tsk_id","desc");
		$data['tasks']=$this->db->get()->result();
		//print_r($data);exit;
		$this->load->view("employee/ajax/all_tasks",$data);
	}
	
	public function apply_leave(){
		$end=$_POST['end_date'];
		$start=$_POST['start_date'];//date("Y-m-d",strtotime($data['start_date']));
		//echo json_encode(array("status"=>0,"msg"=>$end."Please Select Correct Dates.".$start,"laid"=>0));exit;
		if($end<$start){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Please Select Correct Dates.</div>');
		}
		$apr_user=$this->db->get_where("employees",array("emp_id"=>$this->session->userdata("user")))->row();
		
		$diff = ((strtotime($_POST['end_date'])- strtotime($_POST['start_date']))/24/3600);
		  
		  $l=$this->db->get_where("leaves",array("leave_id"=>$_POST['leave_type']))->row();
			//echo json_encode($l);exit;
		  $this->db->select_sum('total_days');  
		  $this->db->where("empid",$this->session->userdata("user")); 
		  $this->db->where("lid",$_POST['leave_type']); 
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
			 if($diff>$left){ $this->session->set_flashdata('msg', '<div class="alert alert-danger">You are asking for '.$diff.' days leaves and have only '.$left.' leaves available.</div>');
			 }else
		if($this->db->insert("leave_apply",array("empid"=>$this->session->userdata("user"),"l_from"=>$_POST['start_date'],"l_to"=>$_POST['end_date'],"reason"=>$_POST['reason'],"applied_date"=>date("Y-m-d"),"lid"=>$_POST['leave_type'],"total_days"=>$diff,"l_status"=>"Pending","apr_emp"=>$apr_user->reporting_emp))==true){
			
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Leave Request Sent Successfully.</div>');
		}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Couldnot apply leave please try later.</div>');
		}redirect("employee/applied_leaves/Pending");
	}
	
	public function ajax_leave_ap_delete(){
		$this->db->delete("leave_apply",array("laid"=>$_POST['id']));
	}
	
	public function newlead_submit(){
		if($this->db->get_where("leads",array("contact_phone1"=>$_POST['mobile']))->num_rows()>0){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Mobile Already registered.</div>');
			redirect("employee/newlead");		
		}else{
			$query=$this->db->insert("leads",array("contact_phone1"=>$_POST['mobile'],"lead_date"=>date("Y-m-d"),"contact_person"=>$_POST['name'],
			"created_user"=>$this->session->userdata("user"),"lead_src"=>$_POST['lead_src'],"lead_remark"=>$_POST['lead_remark'],"email"=>$_POST['email']));
			if($query==true){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Added Successfully.</div>');		
			}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Lead Couldnot be Added.</div>');		
			}
			redirect("employee/newlead");
		}
	}
	
	public function myleads(){
//		$this->db->select("*");
		$data=array();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/myleads',$data,true);
		$this->emplayout();	
	}
	
	public function applied_leaves($type=false){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leaves.leave_id=leave_apply.lid");
		$this->db->join("employees","employees.emp_id=leave_apply.empid");
		if($type==true){
		$this->db->where("leave_apply.l_status","Pending");
		}else{
		$this->db->where("leave_apply.l_status!=","Pending");
		}
		$this->db->where("leave_apply.empid",$this->session->userdata("user"));
		$data['leaves']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/list_leaves',$data,true);
		$this->emplayout();	
	}
	
	public function approved_leaves(){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leaves.leave_id=leave_apply.lid");
		$this->db->join("employees","employees.emp_id=leave_apply.empid");
		$this->db->where("leave_apply.l_status!=","Pending");
		$this->db->where("leave_apply.empid",$this->session->userdata("user"));
		$data['leaves']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/list_leaves',$data,true);
		$this->emplayout();	
	}
	
	public function save_checklist(){
		parse_str($_POST['formdata'],$form);
		//print_r($form);exit;
		$this->db->where("chklid",$form['chklid']);
		$this->db->update("checklists",array("chk_remark"=>$form['chk_remark'],"chk_status"=>$form['chk_status']));
		echo "Status Updated";
	}	
	
	public function ajax_task_checklist(){
		$data['task']=$this->db->get_where("tasks",array("tsk_id"=>$_POST['id']))->row();
		$data['checklist']=$this->db->get_where("checklists",array("tsk_id"=>$_POST['id'],"emp_id"=>$this->session->userdata("user")))->result();	
		$this->load->view("employee/ajax/ajax_task_checklist",$data);
	}
	
	public function tasks($type){
		$data['type']=$type;
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/tasks_list',$data,true);
		$this->emplayout(); 
	}
	public function ajax_tasks_list(){
		$this->db->select("*");
		$this->db->from("tasks");
		$this->db->join("task_emps","task_emps.tsk_id=tasks.tsk_id");
		$this->db->where("task_emps.emp_id",$this->session->userdata("user"));
		$this->db->order_by("tasks.tsk_id","desc");
		$data['tasks']=$this->db->get()->result();
		//print_r($data);exit;
		$this->load->view("employee/ajax/task_list",$data);
	}
	
	
	public function convert_sale(){
		$this->db->where("lead_id",$_POST['id']);
		$this->db->update("leads",array("is_converted"=>"yes"));
		echo "Lead Converted to Sale Successfully.";	
	}
	
	public function new_contracts(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->order_by("leads.lead_id","desc");
		$this->db->where("leads.is_converted","yes");
		$this->db->where("leads.contracted","");
		$data['leads']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/new_contracts',$data,true);
		$this->emplayout();	
	}
	
	public function lead_details(){
		$this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->order_by("leads.lead_id","desc");
		$this->db->where("leads.lead_id",$_POST['id']);
		$data['lead']=$this->db->get()->row();
		
		$this->db->order_by("lead_id","desc");
		$data['history']=$this->db->get_where("followups",array("lead_id"=>$_POST['id']))->result();
		$this->load->view('employee/lead_details',$data);
	}
	
	
	public function clead_details(){
		if($_POST['id']!="new_contract"){
		$this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->order_by("leads.lead_id","desc");
		$this->db->where("leads.lead_id",$_POST['id']);
		$data['edit']=$this->db->get()->row();
		$this->db->order_by("lead_id","desc");
		$data['history']=$this->db->get_where("followups",array("lead_id"=>$_POST['id']))->result();
		$this->load->view('employee/clead_details',$data);
		}else{
		$data=array();
		$this->load->view('employee/ajax_new_contract',$data);
		}
		//print_r($data);exit;
		
	}
	public function clead_details_edit(){
		$this->db->select("*");
		$this->db->from("contracts");
		//$this->db->join("state_list","contracts.c_stateid=state_list.state_id");
		$this->db->where("contracts.cont_id",$_POST['id']);
		$data['edit']=$this->db->get()->row();
		//print_r($data);exit;
		$this->load->view('employee/clead_details_edit',$data);
	}
	
	public function update_contract_submit(){
		$c_gst_percent=$_POST['c_value']*$_POST['c_gst']/100;
		$data=array("c_value"=>$_POST['c_value'],"c_gst"=>$_POST['c_gst'],"c_bs_type"=>$_POST['bs_type'],"c_bs_title"=>$_POST['bs_title'],"c_pincode"=>$_POST['pincode'],"c_address"=>$_POST['address'],"c_company"=>$_POST['company'],"c_contact_person"=>$_POST['contact_person'],"c_contact_phone2"=>$_POST['contact_phone2'],"c_contact_phone1"=>$_POST['contact_phone1'],"c_lead_src"=>$_POST['lead_src'],"c_stateid"=>$_POST['state'],"c_city"=>$_POST['city'],"c_email"=>$_POST['email'],"c_comp_gst"=>$_POST['comp_gst'],"c_remark"=>$_POST['lead_remark'],"c_gst_percent"=>$c_gst_percent,"lead_id"=>$_POST['lead_id'],"created_date"=>date("Y-m-d"));
		$this->db->where("cont_id",$_POST['cont_id']);
		if($this->db->update("contracts",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Contract Details Updated Successfully.</div>');		
		}else{
		$this->session->set_flashdata('msg', '<div class="alert alert-danger">Contract Details couldnot be Updated.</div>');		
		}redirect("employee/contracts");
	}
	
	public function new_contract_add(){
		$c_gst_percent=$_POST['c_value']*$_POST['c_gst']/100;
		$this->db->where("lead_id",$_POST['lead_id']);
		$this->db->update("leads",array("contracted"=>"yes"));
		$data=array("c_advance"=>$_POST['c_advance'],"c_empid"=>$this->session->userdata("user"),"c_balance"=>$_POST['c_balance'],"c_value"=>$_POST['c_value'],"c_gst"=>$_POST['c_gst'],"c_bs_type"=>$_POST['bs_type'],"c_bs_title"=>$_POST['bs_title'],"c_pincode"=>$_POST['pincode'],"c_address"=>$_POST['address'],"c_company"=>$_POST['company'],"c_contact_person"=>$_POST['contact_person'],"c_contact_phone2"=>$_POST['contact_phone2'],"c_contact_phone1"=>$_POST['contact_phone1'],"c_lead_src"=>$_POST['lead_src'],"c_stateid"=>$_POST['state'],"c_city"=>$_POST['city'],"c_email"=>$_POST['email'],"c_comp_gst"=>$_POST['comp_gst'],"c_remark"=>$_POST['lead_remark'],"c_gst_percent"=>$c_gst_percent,"lead_id"=>$_POST['lead_id'],"created_date"=>date("Y-m-d"));
		if($this->db->insert("contracts",$data)==true){
			$lid=$this->db->insert_id();
			$this->db->insert("cpayments",array("contid"=>$lid,"paid_amt"=>$_POST['c_advance'],"total_paid"=>$_POST['c_advance'],"paid_date"=>$_POST['paid_date'],"pay_mode"=>$_POST['c_paymode'],"bank_name"=>$_POST['bank_name'],"trans_id"=>$_POST['trans_id'],"pay_remarks"=>$_POST['pay_remarks'],"pdate"=>date("Y-m-d")));
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Contract Created Successfully.</div>');		
		}else{
		$this->session->set_flashdata('msg', '<div class="alert alert-danger">Contract couldnot be Created.</div>');		
		}redirect("employee/contracts");
	}
	
	public function contracts(){
			$this->db->select("*");
			$this->db->from("leads");
			//$this->db->join("state_list","leads.stateid=state_list.state_id");
			//$this->db->limit($_POST['limit']);
			//$this->db->where("leads.lead_status!=","");	
			$this->db->where("leads.is_converted","yes");	
			$this->db->order_by("leads.lead_id","desc");  
		//}
		$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$data['contracts']=$this->db->get()->result();
		//$this->db->select("*");
//		$this->db->from("contracts");
//		//$this->db->join("state_list","contracts.c_stateid=state_list.state_id");
//		$this->db->order_by("contracts.cont_id","desc");
//		$data['contracts']=$this->db->get()->result();
//		//print_r($data);exit;
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/contracts',$data,true);
		$this->emplayout();	
	}
	
	public function ajax_fdelete(){
		$this->db->delete("followups",array("foid"=>$_POST['id']));
	}
	
	public function contract_payment_history(){
		$data['cont']=$this->db->get_where("leads",array("lead_id"=>$_POST['id']))->row();
		$this->db->order_by("payid","desc");
		$data['payment']=$this->db->get_where("cpayments",array("contid"=>$_POST['id']))->result();
		$this->db->order_by("payid","desc");
		$data['total_paid']=$this->db->get_where("cpayments",array("contid"=>$_POST['id']))->row();
		$this->load->view("employee/contract_payment_history",$data);
	}
	
	public function report(){
		$this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
		$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$this->db->where("leads.lead_status!=","");
		$this->db->order_by("leads.lead_id","desc");
		$data['leads']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/report',$data,true);
		$this->emplayout();
    }
	
	public function ajax_add_paymemt(){
		parse_str($_POST['formdata'],$form);
		$this->db->order_by("payid","desc");
		$pre=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->row();
		$new_pay=$form['paid_amt']+$pre->total_paid;
		if($this->db->insert("cpayments",array("pay_month"=>date("M-Y"),"contid"=>$form['contid'],"paid_amt"=>$form['paid_amt'],"total_paid"=>$new_pay,"paid_date"=>$form['paid_date'],"pay_mode"=>$form['pay_mode'],"trans_id"=>$form['trans_id'],"pay_remarks"=>$form['pay_remarks'],"pdate"=>date("Y-m-d"),"bank_name"=>$form['bank_name']))==true){
			$data['cont']=$this->db->get_where("contracts",array("cont_id"=>$form['contid'],"pemp_id"=>$this->session->userdata("user")))->row();
			$this->db->order_by("payid","desc");
			$data['payment']=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->result();
			$this->db->order_by("payid","desc");
			$data['total_paid']=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->row();
			$this->load->view("employee/contract_payment_history",$data);
			}else{echo 0;}
		
	}
	
	public function contract_delete(){
		$this->db->delete("contracts",array("cont_id"=>$_POST['id']));
	}
	
	public function ajax_lead_update(){
		parse_str($_POST['formdata'],$form);
		//echo "<pre>";print_r($form);exit;
		//if($form['next_date']>date("Y-m-d")){
			$next_time="";
			$next_date="";	
			if(isset($form['nextcall'])){
			$next_time=$form['next_time'];
			$next_date=$form['next_date'];	
			}
			//$chk=$this->db->get_where("followups",array("action_date"=>date("Y-m-d"),"lead_id"=>$form['lead_id']));
			//if($chk->num_rows()>0){
				//$this->db->where("action_date",date("Y-m-d"));
//				$this->db->where("lead_id",$form['lead_id']);
//				$this->db->update("followups",array("action_user"=>$this->session->userdata("user"),"action_date"=>date("Y-m-d"),"lremark"=>$form['lremark'],
//				"next_remark"=>$form['next_remark'],"pro_type"=>$form['pro_type'],"next_date"=>$next_date,"next_time"=>$next_time,
//				"action_time"=>date("Y-m-d H:i:s"),"f_status"=>$form['f_status']));
//				echo '<div class="alert alert-warning">Followup Details Updated Successfully.</div>';	
//			}else{
				$query=$this->db->insert("followups",array("action_user"=>$this->session->userdata("user"),"next_date"=>$next_date,"lead_id"=>$form['lead_id'],
				"action_date"=>date("Y-m-d"),"lremark"=>$form['lremark'],"next_remark"=>$form['next_remark'],"pro_type"=>$form['pro_type'],"next_time"=>$next_time,
				"action_time"=>date("Y-m-d H:i:s"),"f_status"=>$form['f_status']));
				if($query==true){
			$this->db->where("lead_id",$form['lead_id']);
			$this->db->update("leads",array("lead_status"=>$form['f_status'],"last_update"=>date("Y-m-d"),"last_update_mon"=>date("M-Y"),"lead_week"=>date('W')));
				echo '<div class="alert alert-success">Followup Details Saved Successfully.</div>';	
				
	}else{
			echo '<div class="alert alert-success">Couldnot be saved.</div>';	
		}
	}
	
	public function oldleads(){
		
			$this->db->select("*");
			$this->db->from("leads");
			//$this->db->join("state_list","leads.stateid=state_list.state_id");
			//$this->db->limit($_POST['limit']);
			$this->db->where("leads.lead_status!=","");	
			$this->db->where("leads.lead_status!=","Follow Up");
			$this->db->where("leads.lead_status!=","Free Trial");	
			$this->db->order_by("leads.lead_id","desc");
		//}
		$this->db->where("leads.is_converted","");
		$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$data['leads']=$this->db->get()->result();
		
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/oldleads',$data,true);
		$this->emplayout();
	}
	
	public function ajax_lead_list(){
		//echo "<pre>";print_r($_POST);exit;
		if($_POST['followups']!=""){
			$this->db->select("*");
			$this->db->from("followups");
			$this->db->join("leads","leads.lead_id=followups.lead_id");
			$this->db->where("leads.is_converted","");
			$this->db->group_start();
			$this->db->where("leads.lead_status","Free Trial");
			$this->db->or_where("leads.lead_status","Follow Up");
			$this->db->group_end();
			//$this->db->join("state_list","leads.stateid=state_list.state_id");
			if(isset($_POST['type']) && $_POST['type']=="past_leads"){
				$this->db->where("followups.next_date<=",date("Y-m-d"));	
			}else if(isset($_POST['type']) && $_POST['type']=="all_leads"){
				$this->db->where("followups.next_date>=",date("Y-m-d"));	
			}else if(isset($_POST['date'])){
				$this->db->where("followups.next_date",$_POST['date']);	
			}else {
				$this->db->where("followups.next_date>=",date("Y-m-d"));	
			}
			$this->db->order_by("followups.foid","desc");
		}else{
			$this->db->select("*");
			$this->db->from("leads");
			//$this->db->join("state_list","leads.stateid=state_list.state_id");
			//$this->db->limit($_POST['limit']);
			$this->db->where("leads.lead_status","");	
			$this->db->order_by("leads.lead_id","desc");
		}
		$this->db->where("leads.is_converted","");
		$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$data['leads']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;
		$this->load->view("employee/ajax/list_leads",$data);
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect("employee");
	}
}
