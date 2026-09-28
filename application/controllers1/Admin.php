<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct() {
        parent::__construct();
		if(!$this->session->userdata("admin")){redirect("home");}	
		date_default_timezone_set("Asia/Kolkata");

    }
	
	public function index()
	{
		$data=array();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/dashboard',$data,true);
		$this->adminlayout();
	}	

	public function tickets()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/tickets');
	}
	public function ticketshistory()
	{
		$this->load->view('admin/header');
		$this->load->view('admin/ticketshistory');
	}
	
	
	public function clead_details(){
		if($_POST['id']!="new_contract"){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->order_by("leads.lead_id","desc");
		$this->db->where("leads.lead_id",$_POST['id']);
		$data['edit']=$this->db->get()->row();
		$this->db->order_by("lead_id","desc");
		$data['history']=$this->db->get_where("followups",array("lead_id"=>$_POST['id']))->result();
		$this->load->view('employee/clead_details',$data);
		}else{
		$data['admin']='admin';
		$this->load->view('employee/ajax_new_contract',$data);
		}
		//print_r($data);exit;
		
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
		}redirect("admin/contracts");
	}
	
	public function contracts(){
		$this->db->select("*");
		$this->db->from("contracts");
		$this->db->join("state_list","contracts.c_stateid=state_list.state_id");
		$this->db->order_by("contracts.cont_id","desc");
		$data['contracts']=$this->db->get()->result();
		//print_r($data);exit;
		$this->template['middle'] = $this->load->view ($this->middle = 'employee/contracts',$data,true);
		$this->adminlayout();	
	}
	
	public function leave_status(){
		$id=explode("-",$_POST['id']);
		$data['leave']=$this->db->get_where("leave_apply",array("laid"=>$id[0]))->row();
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leaves.leave_id=leave_apply.lid");
		$this->db->where("leave_apply.empid",$id[1]);
		$data['pleaves']=$this->db->get()->result();
		$this->load->view("admin/leave_status",$data);	
	}
	
	public function tasks($id=false){
		if($id==true){
		$data['edit']=$this->db->get_where("tasks",array("tsk_id"=>$id))->row();	
		}else{
		$data=array();
		}
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/tasks_list',$data,true);
		$this->adminlayout(); 
	}
	
	
	
	public function add_task(){
		$data=array("tsk_contract"=>$_POST['contract'],"tsk_subject"=>$_POST['tsk_subject'],"tsk_title"=>$_POST['tsk_title'],"tsk_desc"=>$_POST['tsk_desc'],"tsk_start"=>$_POST['tsk_start'],"tsk_end"=>$_POST['tsk_end'],"tsk_priority"=>$_POST['tsk_priority'],"tsk_created_date"=>date("Y-m-d"),"tsk_created_time"=>date("Y-m-d H:i:s"));
		if($this->db->insert("tasks",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Task Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Task Couldnot be Added.</div>');	}
		redirect("admin/tasks");
	}
	public function update_task(){
		$data=array("tsk_contract"=>$_POST['contract'],"tsk_subject"=>$_POST['tsk_subject'],"tsk_title"=>$_POST['tsk_title'],"tsk_desc"=>$_POST['tsk_desc'],"tsk_start"=>$_POST['tsk_start'],"tsk_end"=>$_POST['tsk_end'],"tsk_priority"=>$_POST['tsk_priority'],"tsk_created_date"=>date("Y-m-d"),"tsk_created_time"=>date("Y-m-d H:i:s"));
		$this->db->where("tsk_id",$_POST['tsk_id']);
		if($this->db->update("tasks",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Task Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Task Couldnot be Updated.</div>');	}
		redirect("admin/tasks");
	}
	
	public function search_contract(){
		$data['conts']=$this->db->get_where("contracts",array("cont_id"=>$_POST['id']))->result();
		$this->load->view("admin/search_contract",$data);
	}	
	
	public function ajax_tasks_list(){
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
		$this->load->view("admin/ajax/task_list",$data);
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
		$this->load->view("admin/ajax/ajax_emp_assign",$data);
	}
	
	
	public function delemp_task(){
		$this->db->delete("task_emps",array("tsk_emp_id"=>$_POST['id']));
		$this->db->delete("checklists",array("tsk_emp_id"=>$_POST['id']));
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
			$this->load->view("admin/ajax/ajax_emp_assign",$data);
		}
		//$this->db->where("tsk_id",$form['task_id']);	
//		if($this->db->update("tasks",array("tsk_emp"=>$form['emp']))==true){
//			$emp=$this->db->get_where("employees",array("emp_id"=>$form['emp']))->row();	
//			echo $emp->emp_id.'-'.$emp->firstname.' '.$emp->lastname;
//		}else{
//			echo 0;	
//		}
	}
	
	public function logout(){
		$this->session->sess_destroy();
		redirect("admin");
	}
	
	public function assign_leads(){
	//	echo "<pre>";print_r($_POST);exit;	
		foreach($_POST['leads'] as $l){
			$this->db->where("lead_id",$l);
			$this->db->update("leads",array("lead_emp"=>$_POST['emp']));
		}
		redirect("admin/list_leads");
	}
  
  	public function add_lead_submit(){
		//echo "<pre>";print_r($_POST);
		//exit;
		if($this->db->insert("leads",array("bs_type"=>$_POST['bs_type'],"bs_title"=>$_POST['bs_title'],"pincode"=>$_POST['pincode'],"address"=>$_POST['address'],"lead_date"=>date("Y-m-d"),"company"=>$_POST['company'],"contact_person"=>$_POST['contact_person'],"contact_phone2"=>$_POST['contact_phone2'],"contact_phone1"=>$_POST['contact_phone1'],"lead_src"=>$_POST['lead_src'],"stateid"=>$_POST['state'],"city"=>$_POST['city'],"email"=>$_POST['email'],"comp_gst"=>$_POST['comp_gst'],"lead_remark"=>$_POST['lead_remark']))==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Lead Couldnot be Added.</div>');	}
		redirect("admin/list_leads");
	}
  
	public function add_lead($id=false)
	{
		if($id==true){
		$data['edit']=$this->db->get_where("leads",array("lead_id"=>$id))->row();	
		}else{
		$data=array();
		}
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/add_lead',$data,true);
		$this->adminlayout();
	}
	
	public function update_lead_submit(){
		$this->db->where("lead_id",$_POST['lead_id']);
		if($this->db->update("leads",array("bs_type"=>$_POST['bs_type'],"bs_title"=>$_POST['bs_title'],"pincode"=>$_POST['pincode'],"address"=>$_POST['address'],"company"=>$_POST['company'],"contact_person"=>$_POST['contact_person'],"contact_phone2"=>$_POST['contact_phone2'],"contact_phone1"=>$_POST['contact_phone1'],"lead_src"=>$_POST['lead_src'],"stateid"=>$_POST['state'],"city"=>$_POST['city'],"email"=>$_POST['email'],"comp_gst"=>$_POST['comp_gst'],"lead_remark"=>$_POST['lead_remark']))==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Lead Couldnot be Updated.</div>');	}
		redirect("admin/list_leads");
	}
	
	public function leaves(){
		$this->db->select("*");
		$this->db->from("leaves");
		$data['leaves']=$this->db->get()->result();
	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/leaves',$data,true);
		$this->adminlayout();	
	}
	public function settings(){
		$data['admin']=$this->db->get('admin')->row();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/working_days',$data,true);
		$this->adminlayout();	
	}
	
	public function fin_yr(){
		$this->db->update("admin",array("fin_yr_start"=>$_POST['fin_yr_start'],"fin_yr_end"=>$_POST['fin_yr_end']));
		redirect("admin/settings");
	}	
	
	
	
	public function ajax_leave_ap_delete(){
		$this->db->delete("leave_apply",array("laid"=>$_POST['id']));
	}
	public function task_delete(){
		$this->db->delete("tasks",array("tsk_id"=>$_POST['id']));
	}
	public function ajax_fdelete(){
		$this->db->delete("followups",array("foid"=>$_POST['id']));
	}
	
	
	public function leave_status_update(){
		parse_str($_POST['formdata'],$form);
		$this->db->where("laid",$form['laid']);
		$diff = ((strtotime($form['l_to'])- strtotime($form['l_from']))/24/3600)+1;
		if($diff<1){echo "Please Select Correct Dates.";exit;}
		//echo $diff;
		if($this->db->update("leave_apply",array("l_from"=>$form['l_from'],"l_to"=>$form['l_to'],"l_status"=>$form['l_status'],"l_remarks"=>$form['l_remarks'],"st_date"=>date("Y-m-d")))==true){echo "Status Updated";}else{echo "Status couldnot be updated.";}
	}
	
	public function applied_leaves(){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leaves.leave_id=leave_apply.lid");
		$this->db->join("employees","employees.emp_id=leave_apply.empid");
		$this->db->where("leave_apply.l_status","Pending");
		$data['leaves']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/list_leaves',$data,true);
		$this->adminlayout();	
	}
	
	public function approved_leaves(){
		$this->db->select("*");
		$this->db->from("leave_apply");
		$this->db->join("leaves","leaves.leave_id=leave_apply.lid");
		$this->db->join("employees","employees.emp_id=leave_apply.empid");
		$this->db->where("leave_apply.l_status","Approve");
		$data['leaves']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/list_leaves',$data,true);
		$this->adminlayout();	
	}
	
	public function update_workdays(){
		if(isset($_POST['monday'])){$monday="yes";}else{$monday="";}
		if(isset($_POST['sunday'])){$sunday="yes";}else{$sunday="";}
		if(isset($_POST['tuesday'])){$tuesday="yes";}else{$tuesday="";}
		if(isset($_POST['wednesday'])){$wednesday="yes";}else{$wednesday="";}
		if(isset($_POST['thursday'])){$thursday="yes";}else{$thursday="";}
		if(isset($_POST['friday'])){$friday="yes";}else{$friday="";}
		if(isset($_POST['saturday'])){$saturday="yes";}else{$saturday="";}
		$this->db->update("admin",array("sunday"=>$sunday,"monday"=>$monday,"tuesday"=>$tuesday,"wednesday"=>$wednesday,"thursday"=>$thursday,"friday"=>$friday,"saturday"=>$saturday));
		redirect("admin/settings");
	}
	public function holidays(){
		$data['holidays']=array();//$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/holidays',$data,true);
		$this->adminlayout();	
	}
	
	public function change_month(){
		$cur=$_POST['id'];//echo $cur;exit;
		$data['hlist']=$this->db->get_where("holidays",array("hmonth"=>$cur))->result();
		$this->load->view("admin/change_month",$data);
	}
	
	public function add_holiday(){
		//print_r($_POST);
		$start=date("Y-m-d",strtotime($_POST['start']));
		$end=date("Y-m-d",strtotime($_POST['end']));
		$month=date("M-Y",strtotime($_POST['start']));
		$chk=$this->db->insert("holidays",array("hfrom_date"=>$start,"hto_date"=>$end,"htitle"=>$_POST['htitle'],"hdesc"=>$_POST['hdesc'],"hmonth"=>$month));
		redirect("admin/holidays");
	}
	
	public function update_profile1(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		if($_POST['oldpass']==""){
			$pass=md5($_POST['mob1']);
		}else{$pass=$_POST['oldpass'];}
		$data=array("emp_email"=>$_POST['emp_email'],"mob1"=>$_POST['mob1'],"mob2"=>$_POST['mob2'],"l_add"=>$_POST['l_add'],"l_state"=>$_POST['l_state'],"l_city"=>$_POST['l_city'],"emp_password"=>$pass);
		$this->db->where("emp_id",$_POST['emp_id']);
		if($this->db->update("employees",$data)==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Couldnot be Updated.</div>');	}
		redirect("admin/list_employees");
	}
	public function update_bank(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		$data=array("bank_name"=>$_POST['bank_name'],"bank_branch"=>$_POST['bank_branch'],"acc_name"=>$_POST['acc_name'],"acc_type"=>$_POST['acc_type'],"acc_number"=>$_POST['acc_number'],"ifsc_code"=>$_POST['ifsc_code']);
		$this->db->where("emp_id",$_POST['emp_id']);
		if($this->db->update("employees",$data)==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Couldnot be Updated.</div>');	}
		redirect("admin/list_employees");
	}
	public function update_emp_details(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		$data=array("pre_comp"=>$_POST['pre_comp'],"last_salary"=>$_POST['last_salary'],"pre_position"=>$_POST['pre_position'],"wfrom_date"=>$_POST['wfrom_date'],"wto_date"=>$_POST['wto_date'],prob_from);
		$this->db->where("emp_id",$_POST['emp_id']);
		if($this->db->update("employees",$data)==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Couldnot be Updated.</div>');	}
		redirect("admin/list_employees");
	}
	
	public function list_leads($type=false){
		//$this->db->select("*");
//		$this->db->from("leads");
//		$this->db->join("state_list","leads.stateid=state_list.state_id");
//		$this->db->order_by("leads.lead_id","desc");
//		$this->db->where("leads.lead_emp","");
//		$data['leads']=$this->db->get()->result();
		if($type==true){
			$data['type']=$type;
		}else{
			$data['type']='';
		}
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/list_leads',$data,true);
		$this->adminlayout();	
	}
	public function followups(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->join("followups","leads.lead_id=followups.lead_id");
		if(isset($_GET['date'])){
		$this->db->where("followups.next_date",$_GET['date']);
		}else{
		$this->db->where("followups.next_date >=",date("Y-m-d"));
		}
		$this->db->order_by("leads.lead_id","desc");
		$data['leads']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/followups',$data,true);
		$this->adminlayout();	
	}
	
	public function ajax_emp_list(){
		$this->db->select("*");
		$this->db->from("employees");
		$this->db->join("branches","branches.br_id=employees.branch_id","left");
		$this->db->order_by("employees.emp_id","desc");
		$data['comps']=$this->db->get()->result();	
		
		//$this->db->order_by("emp_id","desc");
		//$data['comps']=$this->db->get("employees")->result();
		//print_r($data);exit;
		$this->load->view("admin/ajax/list_emps",$data);
	}
	
	public function ajax_designation(){
		$desg=$this->db->get_where("designations",array("dep_id"=>$_POST['id']))->result();
		echo '<option value="">Select Designation</option>';
        foreach($desg as $d){echo '<option value="'.$d->des_id.'">'.$d->des_name.'</option>';}
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
	
	public function ajax_branches_list(){
		$this->db->select("*");
		$this->db->from("branches");
		//$this->db->join("companies","companies.comp_id=branches.comp_id");
		$this->db->join("state_list","branches.br_state=state_list.state_id");
		$this->db->order_by("branches.br_id","desc");
		$data['brs']=$this->db->get()->result();
		//print_r($data);exit;
		$this->load->view("admin/ajax/branches_list",$data);
	}
	
	public function ajax_emp_delete(){
		$this->db->delete("employees",array("emp_id"=>$_POST['id']));
	}
	public function ajax_del_lead(){
		$this->db->delete("leads",array("lead_id"=>$_POST['id']));
		$this->db->delete("followups",array("lead_id"=>$_POST['id']));
	}
	public function ajax_leaves_delete(){
		$this->db->delete("leaves",array("leave_id"=>$_POST['id']));
	}
	public function ajax_branch_delete(){
		$this->db->delete("branches",array("br_id"=>$_POST['id']));
	}
	public function ajax_dept_delete(){
		$this->db->delete("departments",array("dep_id"=>$_POST['id']));
		$this->db->delete("designations",array("dep_id"=>$_POST['id']));
	}
	public function ajax_desg_delete(){
		$this->db->delete("designations",array("des_id"=>$_POST['id']));
	}	
	
	public function branches($brid=false){
		if($brid==true){
			$this->db->select("*");
			$this->db->from("branches");
			$this->db->join("state_list","branches.br_state=state_list.state_id");
			$this->db->where("branches.br_id",$brid);
			$data['edit']=$this->db->get()->row();
		}
		$this->db->order_by("state","asc");
		$data['states']=$this->db->get("state_list")->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/branches',$data,true);
		$this->adminlayout();
	}
	
	public function add_branch(){
		if($this->db->insert("branches",$_POST)==$true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Branch Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Branch Couldnot be Added.</div>');	}
		redirect("admin/branches");
	}
	
	public function update_branch(){
		$this->db->where("br_id",$_POST['br_id']);
		if($this->db->update("branches",array("br_code"=>$_POST['br_code'],"br_name"=>$_POST['br_name'],"br_mail"=>$_POST['br_mail'],"br_phone1"=>$_POST['br_phone1'],"br_phone2"=>$_POST['br_phone2'],"br_address"=>$_POST['br_address'],"br_city"=>$_POST['br_city'],"br_state"=>$_POST['br_state']))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Branch Details Updated Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Branch Details couldnot be Updated.</div>');	
		}redirect("admin/branches");
	}
	
	public function departments(){
		$this->db->select("*");
		$this->db->from("departments");
		$data['deps']=$this->db->get()->result();
		
		$this->db->select("*");
		$this->db->from("designations");
		$this->db->join("departments","departments.dep_id=designations.dep_id");
		$data['des']=$this->db->get()->result();
		
		
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/departments',$data,true);
		$this->adminlayout();
	}
	
	public function add_dept(){
		if($this->db->insert("departments",array("dep_name"=>$_POST['dep_name']))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Department Added Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Department couldnot be added.</div>');	
		}redirect("admin/departments");
	}
	public function add_leave(){
		if($this->db->insert("leaves",array("leave_type"=>$_POST['leave_type'],"max_days"=>$_POST['max_days']))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Leave Added Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Leave couldnot be added.</div>');	
		}redirect("admin/leaves");
	}
	public function update_leave(){
		$this->db->where("leave_id",$_POST['leave_id']);
		if($this->db->update("leaves",array("leave_type"=>$_POST['leave_type'],"max_days"=>$_POST['max_days']))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Leave Updated Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Leave couldnot be Updated.</div>');	
		}redirect("admin/leaves");
	}
	
	public function update_dept(){
		$this->db->where("dep_id",$_POST['dep_id']);
		if($this->db->update("departments",array("dep_name"=>$_POST['dep_name']))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Department Updated Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Department couldnot be Updated.</div>');	
		}redirect("admin/departments");
	}
	
	public function add_emp_submit(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		if($_POST['gender']=="Male"){$profile_photo="male_emp.jpg";}else{$profile_photo="female_emp.jpg";}
		if(!empty($_FILES["profile_photo"]["name"])){
				$config['upload_path'] = './assets/images/emps/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
				$config['max_size']	= '1000000';
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('profile_photo'))
				{
				echo $this->upload->display_errors();
				}
				else
				{	
				$pic = $this->upload->data();
				$profile_photo=$pic['file_name'];
				}
		} 
		//"pf_number"=>$_POST['pf_number'],"esic_number"=>$_POST['esic_number'],"uan_number"=>md5($_POST['uan_number']),
		$data=array("job_desc"=>$_POST['job_desc'],"pan_number"=>$_POST['pan_number'],"aadhar_number"=>$_POST['aadhar_number'],"branch_id"=>$_POST['branch_id'],"firstname"=>$_POST['firstname'],"lastname"=>$_POST['lastname'],"father"=>$_POST['father'],"gender"=>$_POST['gender'],"dob"=>$_POST['dob'],"marital"=>$_POST['marital'],"profile_photo"=>$profile_photo,"emp_added_date"=>date("Y-m-d"));//"emp_email"=>$_POST['emp_email'],"emp_password"=>md5($_POST['emp_password']),"emp_added_date"=>date("Y-m-d"),"mob1"=>$_POST['mob1'],"mob2"=>$_POST['mob2']);
		
		
		
		if($this->db->insert("employees",$data)==true){
			$lid=$this->db->insert_id();
			foreach($_POST['des'] as $d){
				$this->db->insert("emp_des",array("emp_id"=>$lid,"des_id"=>$d));
			}
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Employee Details Couldnot be Added.</div>');	}
		redirect("admin/list_employees");	
	}
	
	public function upload_lead_excel(){
			//print_r($_POST);exit;
			$file = $_FILES['excel']['tmp_name'];
			$handle = fopen($file, "r");
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				
				if($filesop[0]!="S.No.")
				{
			$data=array("lead_date"=>date("Y-m-d"),"company"=>$filesop[2],"contact_person"=>$filesop[4],"contact_phone1"=>$filesop[5],"contact_phone2"=>$filesop[6],"lead_src"=>$filesop[1],"stateid"=>$filesop[9],"city"=>$filesop[8],"email"=>$filesop[5],"comp_gst"=>$filesop[3],"lead_remark"=>$filesop[10]);
			$this->db->insert("leads",$data);
					}
			}
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Data Imported Successfully.</div>');
			redirect("admin/list_leads");
	}
	
	public function ajax_lead_list(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("state_list","leads.stateid=state_list.state_id");
		if($_POST['assign']!=""){
		$this->db->join("employees","employees.emp_id=leads.lead_emp");
		}
		else{
		$this->db->where("leads.lead_emp","");	
		}
		
		$this->db->order_by("leads.lead_id","desc");
		$this->db->limit($_POST['limit']);
		$data['leads']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;
		$this->load->view("admin/ajax/list_leads",$data);
	}
	
	public function update_emp_submit(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		$profile_photo=$_POST['oldphoto'];
		if(!empty($_FILES["profile_photo"]["name"])){
				$config['upload_path'] = './assets/images/emps/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
				$config['max_size']	= '1000000';
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('profile_photo'))
				{
				echo $this->upload->display_errors();
				}
				else
				{	
				$pic = $this->upload->data();
				$profile_photo=$pic['file_name'];
				}
		} 
		//"pf_number"=>$_POST['pf_number'],"esic_number"=>$_POST['esic_number'],"uan_number"=>md5($_POST['uan_number']),
		$data=array("job_desc"=>$_POST['job_desc'],"pan_number"=>$_POST['pan_number'],"aadhar_number"=>$_POST['aadhar_number'],"branch_id"=>$_POST['branch_id'],"firstname"=>$_POST['firstname'],"lastname"=>$_POST['lastname'],"father"=>$_POST['father'],"gender"=>$_POST['gender'],"dob"=>$_POST['dob'],"marital"=>$_POST['marital'],"profile_photo"=>$profile_photo,"emp_added_date"=>date("Y-m-d"));//"emp_email"=>$_POST['emp_email'],"emp_password"=>md5($_POST['emp_password']),"emp_added_date"=>date("Y-m-d"),"mob1"=>$_POST['mob1'],"mob2"=>$_POST['mob2']);
		$this->db->where("emp_id",$_POST['emp_id']);
		if($this->db->update("employees",$data)==true){
			//$lid=$this->db->insert_id();
			$this->db->delete("emp_des",array("emp_id"=>$_POST['emp_id']));
			foreach($_POST['des'] as $d){
				$this->db->insert("emp_des",array("emp_id"=>$_POST['emp_id'],"des_id"=>$d));
			}
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Employee Details Couldnot be Updated.</div>');	}
		redirect("admin/list_employees");	
	}
	
	public function ajax_comp_dept(){
		$dept=$this->db->get_where("departments",array("comp_id"=>$_POST['id']))->result();
		echo '<option value="">Select Dept</option>';
		foreach($dept as $d){echo '<option value="'.$d->dep_id.'">'.$d->dep_name.'</option>';}
	}
	
	public function update_emp_details2(){
		//echo "<pre>";print_r($_POST);print_r($_FILES);exit;
		if($_POST['reporting_emp']!=""){
		$rid=$_POST['reporting_emp'];	
		}else{
		$rid=$_POST['old_report_user'];	
		}
		$data=array("reporting_emp"=>$rid,"joining_date"=>$_POST['joining_date'],"salary"=>$_POST['salary'],"pf_ded"=>$_POST['pf_ded'],"tot_salary"=>$_POST['tot_salary'],"education"=>$_POST['education'],"prob_from"=>$_POST['prob_from'],"prob_to"=>$_POST['prob_to']);
		$this->db->where("emp_id",$_POST['emp_id']);
		if($this->db->update("employees",$data)==true){
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Joining Details Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Joining Details Couldnot be Updated.</div>');	}
		redirect("admin/list_employees");
	}
	
	public function ajax_comp_branches(){
		$branch=$this->db->get_where("branches",array("comp_id"=>$_POST['id']))->result();
		echo '<option value="">Select Branch</option>';
		foreach($branch as $d){echo '<option value="'.$d->br_id.'">'.$d->br_name.'</option>';}
	}
	public function ajax_dep_des(){
		$data['cid']=$_POST['id'];
		//print_r($data);exit;
		$this->load->view("admin/ajax/ajax_dep_des",$data);	
	}
	
	public function ajax_tsk_wt(){
		$this->db->where("tsk_emp_id",$_POST['id']);
		$this->db->update("task_emps",array("tsk_wt"=>$_POST['wt']));	
	}
	
	public function add_desg(){
		if(isset($_POST['roles'])){
		$roles=implode(",",$_POST['roles']);	
		}else{$roles="";}
		if($this->db->insert("designations",array("dep_id"=>$_POST['dep_id'],"des_name"=>$_POST['des_name'],"roles"=>$roles))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Designation Added Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Designation couldnot be added.</div>');	
		}redirect("admin/departments");
	}
	public function update_desg(){
		if(isset($_POST['roles'])){
		$roles=implode(",",$_POST['roles']);	
		}else{$roles="";}
		$this->db->where("des_id",$_POST['des_id']);
		if($this->db->update("designations",array("dep_id"=>$_POST['dep_id'],"des_name"=>$_POST['des_name'],"roles"=>$roles))==true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Designation Added Successfully.</div>');	
		}else{
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Designation couldnot be added.</div>');	
		}redirect("admin/departments");
	}
	
	public function add_employee(){
		//echo "Under Construction";exit;
		$data=array();//['comps']=$this->db->get("companies")->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/add_employee',$data,true);
		$this->adminlayout();
	}
	
	public function ajax_lead_update(){
		parse_str($_POST['formdata'],$form);
		if($form['next_date']>date("Y-m-d")){
			$chk=$this->db->get_where("followups",array("next_date"=>$form['next_date'],"lead_id"=>$form['lead_id']));
			if($chk->num_rows()>0){
				$this->db->where("next_date",$form['next_date']);
				$this->db->where("lead_id",$form['lead_id']);
				$this->db->update("followups",array("action_date"=>date("Y-m-d"),"lremark"=>$form['lremark'],"next_remark"=>$form['next_remark'],"pro_type"=>$form['pro_type'],"action_time"=>date("Y-m-d H:i:s"),"f_status"=>$form['f_status']));
				echo '<div class="alert alert-warning">Followup Details Updated Successfully.</div>';	
			}else{
				$this->db->insert("followups",array("next_date"=>$form['next_date'],"lead_id"=>$form['lead_id'],"action_date"=>date("Y-m-d"),"lremark"=>$form['lremark'],"next_remark"=>$form['next_remark'],"pro_type"=>$form['pro_type'],"action_time"=>date("Y-m-d H:i:s"),"f_status"=>$form['f_status']));
				echo '<div class="alert alert-success">Followup Details Saved Successfully.</div>';	
			}
		}else{
			echo '<div class="alert alert-success">Please Select Future Date.</div>';	
		}
	}	
	
	public function lead_details(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("state_list","leads.stateid=state_list.state_id");
		$this->db->order_by("leads.lead_id","desc");
		$this->db->where("leads.lead_id",$_POST['id']);
		$data['lead']=$this->db->get()->row();
		
		$this->db->order_by("lead_id","desc");
		$data['history']=$this->db->get_where("followups",array("lead_id"=>$_POST['id']))->result();
		
		$this->load->view('admin/lead_details',$data);
	}
	
	
	
	
	public function list_employees(){
		//echo "Under Construction";exit;
		$this->db->select("*");
		$this->db->from("employees");
		$this->db->join("branches","branches.br_id=employees.branch_id");
		$this->db->order_by("emp_id","desc");
		$data['emps']=$this->db->get()->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/list_employees',$data,true);
		$this->adminlayout();
	}
 
	public function tickets_delete ($id)
	{
		$this->db->delete("tickets",array("tk_id"=>$id));
		redirect("Admin/ticketslist");
	}
	public function tickets_update()
	{
		

		$this->db->where("tk_id",$_POST['tk_id']);
   
		  $this->db->update('tickets',array("tk_tittle"=>$_POST['tk_tittle'],
		  "tk_des"=>$_POST['tk_des'],
		  "tk_status"=>$_POST['tk_status'],
		  "tk_date"=>$_POST['tk_date'],
		  
		  
	  
		
		 
								 ));
			
		 redirect("admin/tickets");
		
		}

		public function tickets_submit ()
		{

			
	   
		
							$this->db->insert("tickets",array("tk_tittle"=>$_POST['tk_tittle'],
												"tk_des"=>$_POST['tk_des'],
												"tk_status"=>$_POST['tk_status'],
												"tk_date"=>$_POST['tk_date'],
																								

														   
																					));

					

					redirect("admin/tickets");
			}       
			
			public function ticketshistory_delete ($id)
	{
		$this->db->delete("ticketshistory",array("tk_id"=>$id));
		redirect("Admin/ticketslist");
	}

	public function ticketshistory_update()
	{
		

		$this->db->where("tkh_id",$_POST['tkh_id']);
   
		  $this->db->update('ticketshistory',array("tkh_history"=>$_POST['tkh_history'],
		  "tkh_tkid"=>$_POST['tkh_tkid'],
		  "tkh_remark"=>$_POST['tkh_remark'],
		  "tkh_status"=>$_POST['tkh_status'],
		  "tkh_user"=>$_POST['tkh_user'],
		  "tkh_date"=>$_POST['tkh_date'],
		  
		  
		  
	  
		
		 
								 ));
			
		 redirect("admin/ticketshistory");
		
		}

		public function ticketshistory_submit ()
		{

			
	   
		
							$this->db->insert("ticketshistory",array("tkh_history"=>$_POST['tkh_history'],
																		"tkh_tkid"=>$_POST['tkh_tkid'],
																		"tkh_remark"=>$_POST['tkh_remark'],
																		"tkh_status"=>$_POST['tkh_status'],
																		"tkh_user"=>$_POST['tkh_user'],
																		"tkh_date"=>$_POST['tkh_date'],
																								

														   
																					));

					

					redirect("admin/ticketshistory");
			}   

	
}
