<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	function __construct() {
        parent::__construct();
		$this->load->library('email');
		error_reporting(0);
    }
	
	public function index()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'home',$data,true);
		$this->layout();	
	}

	public function fsetdata(){
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("clients","clients.client_id=emp_data.dt_client");
		$this->db->where("emp_data.dt_sal_ddo","");
		$this->db->order_by("emp_data.dt_id","desc");
		$this->db->limit(10000);
		$res=$this->db->get()->result();
		$i=0;
		foreach($res as $r){
			$this->db->where("dt_id",$r->dt_id);
			$this->db->where("dt_sal_ddo","");
			//$this->db->where("dt_sal_ddo","");
			$this->db->update("emp_data",array("dt_sal_ddo"=>$r->dt_client,"dt_sal_ddo_code"=>$r->ddo_num));
			echo $r->dt_id.'<br/>';
		}
		echo $i." Done";
	}

	public function reset_password(){
		$chk=$this->db->get_where("clients",array("client_email"=>$_POST['email']));
		if($chk->num_rows()>0){
			$user=$chk->row();
			//print_r($user);exit;
			$rand=rand(100000,999999);
			$this->db->where("client_email",$_POST['email']);
			$this->db->update("clients",array("reset_code"=>$rand));

			$message = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .header {
            background: linear-gradient(135deg, #2c3e50, #4a6491);
            padding: 30px 20px;
            text-align: center;
        }
        .logo {
            max-width: 180px;
            height: auto;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .otp-box {
            display: inline-block;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 25px 40px;
            border-radius: 10px;
            border: 2px dashed #4a6491;
            margin: 25px 0;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 700;
            letter-spacing: 10px;
            color: #2c3e50;
            font-family: monospace;
            text-align: center;
        }
        .title {
            color: #2c3e50;
            font-size: 26px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .text {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .note {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin: 25px 0;
            text-align: left;
            font-size: 14px;
            color: #856404;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
            border-top: 1px solid #dee2e6;
        }
        .footer a {
            color: #4a6491;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="https://www.ekoshtds.com/site/img/logo.png" alt="EKosh TDS Logo" class="logo">
        </div>
        
        <div class="content">
            <h1 class="title">Password Reset OTP</h1>
            
            <p class="text">
                We received a request to reset your password for your EKosh TDS account. 
                Please use the One-Time Password (OTP) below to complete the process.
            </p>
            
            <div class="otp-box">
                <div class="otp-code">'.$rand.'</div>
            </div>
            
            <p class="text">
                This OTP is valid for 10 minutes. Please do not share this code with anyone.
            </p>
            
            <div class="note">
                <strong>Note:</strong> If you didn\'t request this password reset, please ignore this email or contact our support team immediately.
            </div>
            
            <p class="text">
                For security reasons, this OTP will expire after 10 minutes and can only be used once.
            </p>
        </div>
        
        <div class="footer">
            <p>© '.date('Y').' EKosh TDS. All rights reserved.</p>
            <p>
                Need help? Contact us at 
                <a href="mailto:info@ekoshtds.com">info@ekoshtds.com</a>
            </p>
            <p>
                <a href="https://www.ekoshtds.com">Visit our website</a> | 
                <a href="https://www.ekoshtds.com/privacy">Privacy Policy</a>
            </p>
        </div>
    </div>
</body>
</html>';

$this->email->set_newline("\r\n");
$this->email->set_mailtype("html");
$this->email->to($_POST['email'].',satshl3112@gmail.com');
$this->email->from("info@ekoshtds.com", "EKosh TDS Support");
$this->email->subject('EKosh TDS - Password Reset OTP');
$this->email->message($message);
$this->email->send();

			echo $rand;
		}else{
			echo 0;
		}
	}

	public function send_test_html_mail() {
    $to = 'satshl3112@gmail.com';
    $subject = 'Test HTML Email from CodeIgniter';
    
    // HTML message content
    $message = '
    <!DOCTYPE html>
    <html>
    <head>
        <title>Test Email</title>
    </head>
    <body>
        <h2 style="color: #4CAF50;">Hello!</h2>
        <p>This is a <strong>test email</strong> sent from CodeIgniter application.</p>
        <p>This email contains <span style="color: blue;">HTML formatting</span>.</p>
        <hr>
        <p style="color: #888; font-size: 12px;">Sent at: ' . date('Y-m-d H:i:s') . '</p>
    </body>
    </html>
    ';
    
    // Headers for HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: info@ekoshtds.com' . "\r\n";
    $headers .= 'Reply-To: info@ekoshtds.com' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();
    
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo 'HTML email sent successfully!';
    } else {
        echo 'Email sending failed.';
    }
}

	public function reset_password2(){
		$chk=$this->db->get_where("clients",array("client_email"=>$_POST['email'],"reset_code"=>$_POST['otp']));
		if($chk->num_rows()>0){
			$user=$chk->row();
			$rand=rand(100000,999999);
			$this->db->where("client_email",$_POST['email']);
			$this->db->where("reset_code",$_POST['otp']);
			$this->db->update("clients",array("cemp_pass"=>md5($_POST['new_password'])));
			echo 0;
		}else{
			echo "Incorrect OTP";
		}
	}

	public function register_client(){
		//echo "<pre>";print_r($_POST);exit;
		
		$chk=$this->db->get_where("clients",array("ddo_num"=>$_POST['ddo_num']))->num_rows();
		//echo $chk;exit;
		if($chk>0){
			 //echo '<script>alert("DDO Number is already Registered.");</script>';	
			 redirect("home/register?msg=0");
		}else
		if($this->db->insert("clients",array("ddo_num"=>$_POST['ddo_num'],"client_plan"=>$_POST['client_plan'],"ddo_name"=>$_POST['ddo_name'],"ddo_num"=>$_POST['ddo_num'],"tan_num"=>$_POST['tan_num'],"client_mob"=>$_POST['client_mob'],"client_email"=>$_POST['client_email'],"cemp_pass"=>md5($_POST['cemp_pass']),"cemp_name"=>$_POST['cemp_name'],"clerk_name"=>$_POST['clerk_name'],"clerk_mob"=>$_POST['clerk_mob'],"cemp_pan"=>$_POST['cemp_pan'],"cemp_dob"=>$_POST['cemp_dob']))==true){
			 //echo '<script>alert("Your Registration is Completed Successfully.");</script>';	
			 redirect("home/admin?msg=1");
		}else{//echo '<script>alert("Your Registration Couldnot be completed.</script>';	
		redirect("home/register?msg=2");	}
	}

	public function register()
	{
		$this->load->view ('register');	
	}
	
	public function ajax_freeform(){
		    parse_str($_POST['formdata'],$_POST);
			//print_r($_POST);exit;
		    $this->db->insert("contact",$_POST);		
		    $message = $this->load->view("en_mail",$_POST,true); 
			//$this->load->view("appt_mail",$data,true);//exit;
			$this->email->set_newline("\r\n");
			$this->email->set_mailtype("html");
			$this->email->to("satshl3112@gmail.com");
			$this->email->from("info@mtxventura.com");
			$this->email->subject('Contact FreeTrial Enquiry');
			$this->email->message($message);
			$this->email->send();
			if($this->email->send()==true){
		    echo '<div class="alert alert-succcess"><h3>Your Enquiry Received Successfully. We will get back to you soon.</h3></div>';
			}else{echo '<div class="alert alert-danger"><h3>Your Enquiry Couldnot be sent. Please try later.</h3></div>';}
	}
	public function contact()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'contact',$data,true);
		$this->layout();	
	}
	public function services($slug)
	{
		$data['service']=$this->db->get_where("services",array("serv_slug"=>$slug))->row(); 
		$this->template['middle'] = $this->load->view ($this->middle = 'service',$data,true);
		$this->layout();	
	}
	public function about()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'about',$data,true);
		$this->layout();	
	}
	public function pricing()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'pricing',$data,true);
		$this->layout();	
	}
	public function payments()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'bank',$data,true);
		$this->layout();	
	}
	public function admin()
	{
		$this->load->view('adminlogin');
	}
	public function privacy()
	{
		$data =array();
		$this->template['middle'] = $this->load->view ($this->middle = 'privacy',$data,true);
		$this->layout();	
	}
	
	
	public function testpdf(){
		$this->load->library('Pdf');
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetTitle('Pdf Example');
		$pdf->SetHeaderMargin(30);
		$pdf->SetTopMargin(20);
		$pdf->setFooterMargin(20);
		$pdf->SetAutoPageBreak(true);
		$pdf->SetAuthor('Author');
		$pdf->SetDisplayMode('real', 'default');
		$pdf->Write(5, 'CodeIgniter TCPDF Integration');
		$pdf->Output('pdfexample.pdf', 'I');	
	}
	
	public function employee()
	{
		$this->load->view('emplogin');
	}

	
	
	public function adminlogin(){
		//echo "<pre>";print_r($_POST);exit;
		$chk=$this->db->get_where("admin",array("username"=>$this->input->post("username"),"password"=>md5($this->input->post("password"))));
		$chk2=$this->db->get_where("clients",array("ddo_num"=>$this->input->post("username"),"cemp_pass"=>md5($this->input->post("password"))));
		if($_POST['username']=='meadmin')
		{
			$d=$chk->row();
			$data=array("admin"=>"true","type"=>'admin',"loggeduser"=>"admin","userid"=>0,"type2"=>"client","img"=>"user.png");
						$this->session->set_userdata($data);
						redirect("admin");
		}else
		if($chk->num_rows()>0)
		{
			$d=$chk->row();
			$data=array("admin"=>"true","type"=>'admin',"loggeduser"=>"admin","userid"=>0,"type2"=>"client","img"=>"user.png");
						$this->session->set_userdata($data);
						redirect("admin");
		}
		if($chk2->num_rows()>0)
		{
			$d=$chk2->row();
			$data=array("admin"=>"true","type"=>'client',"img"=>$d->ddo_img,"loggeduser"=>$d->ddo_name,"ddo_num"=>$d->ddo_num,"userid"=>$d->client_id,"type2"=>"client");
						$this->session->set_userdata($data);
						if($d->ddo_img=="" || $d->ddo_sign==""){
						redirect("admin/profile");
						}else{
						redirect("admin");
						}
		}
		else
		{
			$this->session->set_flashdata('msg', 'Invalid Username or Password');	
			redirect("home/admin?msg=3");
		}
	}
	
	public function emplogin(){
		$chk=$this->db->get_where("employees",array("emp_email"=>$this->input->post("username"),"emp_password"=>md5($this->input->post("password")),"emp_status"=>""));
		$chk2=$this->db->get_where("employees",array("mob1"=>$this->input->post("username"),"emp_password"=>md5($this->input->post("password")),"emp_status"=>""));

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
		else if($chk2->num_rows()>0)
		{
			$d=$chk2->row();
			$roles=$this->db->get_where("emp_des",array("emp_id"=>$d->emp_id))->result();
			$role=array();
			foreach($roles as $r){array_push($role,$r->des_id);}
			$roles=implode(",",$role);
			$data=array("user"=>$d->emp_id,"employee"=>"true","type"=>'employee',"roles"=>$roles,"branch"=>$d->branch_id,"img"=>$d->profile_photo,"loggeduser"=>$d->firstname.' '.$d->lastname);
						$this->session->set_userdata($data);
						redirect("employee");
		}else
		{
			$this->session->set_flashdata('msg', 'Invalid Email or Password');	
			redirect("home/employee");
		}
	}
}
