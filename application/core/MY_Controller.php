<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 

 { 

   var $template  = array();
   var $data      = array();

   public function layout() {
 
     $this->template['header']   = $this->load->view('layout/header', $this->data, true);
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
     $this->template['footer'] = $this->load->view('layout/footer', $this->data, true);
     $this->load->view('layout/index', $this->template);

   }

   
   
	public function adminlayout() {
     $this->template['header']   = $this->load->view('admin/header', $this->data, true);
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
     $this->load->view('admin/index', $this->template);
   }
   
	public function emplayout() {
     $this->template['header']   = $this->load->view('employee/header', $this->data, true);
     $this->template['middle'] = $this->load->view($this->middle, $this->data, true);
     $this->load->view('employee/index', $this->template);
   }
   

}

?>