<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library('session');
    }

    public function index() {
        // Load the view with iframe
        $data['records'] = $this->db->order_by('emp_id', 'DESC')->get('emps')->result();
        $this->load->view('employee_iframe', $data);
    }

    // Proxy the DDO website - handles both GET and POST
    public function proxy() {
        $url = 'https://ekoshonline.cg.gov.in/epayroll/frmempdetails.aspx';
        
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
        curl_setopt($ch, CURLOPT_REFERER, 'https://ekoshonline.cg.gov.in/epayroll/frmempdetails.aspx');
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        
        // Handle POST data from the form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post_data = $_POST;
            error_log('Proxy POST data: ' . print_r($post_data, true));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        }
        
        // Get headers and remove X-Frame-Options
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) {
            $len = strlen($header);
            $header_parts = explode(':', $header, 2);
            if (count($header_parts) < 2) return $len;
            
            $header_name = strtolower(trim($header_parts[0]));
            if ($header_name !== 'x-frame-options') {
                header($header_parts[0] . ':' . $header_parts[1]);
            }
            return $len;
        });
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response === false) {
            echo "Error fetching the page";
            return;
        }
        
        // Modify the response
        $base_url = 'https://ekoshonline.cg.gov.in/epayroll/';
        $proxy_url = base_url('employee/proxy');
        
        // Replace form action
        $response = str_replace('action="./frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('action="frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('action="' . $base_url . 'frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('action="/epayroll/frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        
        // Fix relative URLs
        $response = str_replace('src="/epayroll/', 'src="' . $base_url, $response);
        $response = str_replace('src="/', 'src="' . $base_url, $response);
        $response = str_replace('href="/epayroll/', 'href="' . $base_url, $response);
        $response = str_replace('href="/', 'href="' . $base_url, $response);
        
        // Fix CSS and image paths
        $response = str_replace('url(/epayroll/', 'url(' . $base_url, $response);
        $response = str_replace('url(/', 'url(' . $base_url, $response);
        
        // Remove scripts that try to break out of iframe
        $response = preg_replace('/top\.location\s*=/', '//top.location=', $response);
        $response = preg_replace('/parent\.location\s*=/', '//parent.location=', $response);
        $response = preg_replace('/window\.top\.location/', '//window.top.location', $response);
        $response = preg_replace('/self\.parent\.location/', '//self.parent.location', $response);
        
        // Add base tag for relative URLs
        $base_tag = '<base href="' . $base_url . '">';
        $response = str_replace('<head>', '<head>' . $base_tag, $response);
        
        echo $response;
    }

    // Import data from the page via AJAX
   // Import data from the page via AJAX
public function import_data() {
    // Get JSON input from frontend
    $input = json_decode(file_get_contents('php://input'), true);
    //echo json_encode($input);exit;//"<pre>";print_r($input);exit;
    // REMOVE THIS: echo "<pre>";print_r($input);exit;
    
    if (!$input || !isset($input['employees']) || empty($input['employees'])) {
        echo json_encode([
            'success' => false,
            'message' => 'No employee data received'
        ]);
        return;
    }

    

    
    try {
        $employees = $input['employees'];
        
        // Debug: Use error_log instead of echo
        error_log('First employee data: ' . print_r($employees[0] ?? 'No employee', true));
        
        // Get parameters from frontend
        $payroll_type = trim($input['payroll_type'] ?? '');
        $month_year = trim($input['month_year'] ?? '');
        $fin_year = trim($input['fin_year'] ?? '');
        $ddo_num = trim($input['ddo_num'] ?? '');
      //  echo $input['fin_year'];exit;
        $mm=explode("/",$input['month_year']);
        $month2=$mm[1].'-'.$mm[0].'-01';
        //$dt_month=$mdd
        //echo $month2;exit;
        // Validate required parameters
        if (empty($month_year) || empty($fin_year)) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing required parameters: payroll_type, month_year, fin_year'
            ]);
            return;
        }
        
        if($this->session->userdata("ddo_num")!=$ddo_num){
            echo json_encode([
                'success' => false,
                'message' => $ddo_num.'-'.$this->session->userdata("ddo_num"). 'Error: DDO Number is Not Valid'
            ]);
            return;
        }
        
        // Get emp_client from session
        $emp_client = $this->session->userdata('userid') ?? '';
        
        // Start transaction
        $this->db->trans_start();
        
        $imported_count = 0;
        $updated_count = 0;
        $salary_imported = 0;
        $salary_updated = 0;
        
        foreach ($employees as $emp) {
           
            // Extract all data from the row
            $emp_code = trim((int)$emp['emp_code'] ?? '');
            $emp_name = trim($emp['emp_name'] ?? '');
            $emp_bill = floatval($emp['emp_bill'] ?? 0);
            if($emp_bill>0){
            $dt_btr=$emp['dt_btr'];
            $dt_basic=$emp['dt_basic'];
            $dt_da=$emp['dt_da'];
            $dt_fix_ta=$emp['dt_fix_ta'];
            $dt_house=$emp['dt_house'];
            $dt_hre_recv=$emp['dt_hre_recv'];
            $dt_city=$emp['dt_city'];
            $dt_wash=$emp['dt_wash'];
            $dt_medical=$emp['dt_medical'];
            $dt_other=$emp['dt_other'];
            $dt_dues=$emp['dt_dues'];
            $dt_gpf=$emp['dt_gpf'];
            $dt_gpf_recv=$emp['dt_gpf_recv'];
            $dt_fest=$emp['dt_fest'];
            $dt_water=$emp['dt_water'];
            $dt_gis=$emp['dt_gis'];
            $dt_tax=$emp['dt_tax'];
            $dt_ded=$emp['dt_ded'];
            
            // Skip if emp_code is empty
            if (empty($emp_code)) {
                continue;
            }
            
            // Get the employee data array (all columns)
            $data = $emp['data'] ?? [];
            
            // REMOVE THIS: echo "<pre>";print_r($data);exit;
            
            // Debug using error_log
            error_log('Processing employee: ' . $emp_code);
            error_log('Data array has ' . count($data) . ' columns');
            
            // Check if employee already exists in emps table
            $this->db->where('emp_code', $emp_code);
            $existing = $this->db->get('emps')->row();
            
            $emp_id = null;
            
            if ($existing) {
                // Update existing record in emps table
                $emp_data = [
                    'emp_name' => $emp_name,
                    'emp_bill' => $emp_bill,
                    'emp_client' => $emp_client
                ];
                $this->db->where('emp_code', $emp_code);
                $this->db->update('emps', $emp_data);
                $emp_id = $existing->emp_id;
                $updated_count++;
            } else {
                // Insert new record in emps table
                $emp_data = [
                    'emp_code' => $emp_code,
                    'emp_name' => $emp_name,
                    'emp_bill' => $emp_bill,
                    'emp_client' => $emp_client
                ];
                $this->db->insert('emps', $emp_data);
                $emp_id = $this->db->insert_id();
                $imported_count++;
            }

            $sal_mon = DateTime::createFromFormat('m/Y', $month_year);
            $dt_mon=$sal_mon->format('M-Y');
            $sal_mon='Salary-'.$sal_mon->format('M-Y'); 
            $net_sal=$dt_dues-$dt_ded;
            $chk = $this->db->get_where("emp_data", array("dt_client"=>$this->session->userdata("userid"), "dt_type_mon"=>$sal_mon, "dt_emp_id"=>$emp_id));
                            if($chk->num_rows()>0){
                                $dtr = $chk->row();
                                $this->db->where("dt_id", $dtr->dt_id);
                                $this->db->update("emp_data", array(
                                    //"dt_bill_no"=>$data[4],
                                    "dt_btr"=>$dt_btr,"dt_bill_no"=>$emp_bill,
                                    "dt_basic"=>$dt_basic,
                                    "dt_da"=>$dt_da,
                                    "dt_fix_ta"=>$dt_fix_ta,
                                    "dt_house"=>$dt_house,
                                    "dt_hre_recv"=>$dt_hre_recv,
                                    "dt_city"=>$dt_city,
                                    "dt_wash"=>$dt_wash,
                                    "dt_medical"=>$dt_medical,
                                    "dt_other"=>$dt_other,
                                    "dt_dues"=>$dt_dues,
                                    "dt_gpf"=>$dt_gpf,
                                    "dt_gpf_recv"=>$dt_gpf_recv,
                                    "dt_fest"=>$dt_fest,
                                    "dt_gis"=>$dt_gis,
                                    "dt_tax"=>$dt_tax,
                                    "dt_ded"=>$dt_ded,
                                    "dt_water"=>$dt_water,
                                    "dt_net_salary"=>$net_sal
                                ));
                            } else {
                                $this->db->insert("emp_data", array(
                                    "dt_client"=>$this->session->userdata("userid"),
                                    "dt_type"=>"Salary","dt_bill_no"=>$emp_bill,
                                    "dt_fnyr"=>$fin_year,
                                    "dt_sal_ddo_code"=>$this->session->userdata("ddo_num"),
                                    "dt_sal_ddo"=>$this->session->userdata("userid"),
                                    "dt_emp_id"=>$emp_id,
                                    "dt_emp_code"=>$emp_code,
                                    "dt_btr"=>$dt_btr,
                                    "dt_basic"=>$dt_basic,
                                    "dt_da"=>$dt_da,
                                    "dt_fix_ta"=>$dt_fix_ta,
                                    "dt_house"=>$dt_house,
                                    "dt_hre_recv"=>$dt_hre_recv,
                                    "dt_city"=>$dt_city,
                                    "dt_wash"=>$dt_wash,
                                    "dt_medical"=>$dt_medical,
                                    "dt_other"=>$dt_other,
                                    "dt_dues"=>$dt_dues,
                                    "dt_gpf"=>$dt_gpf,
                                    "dt_gpf_recv"=>$dt_gpf_recv,
                                    "dt_fest"=>$dt_fest,
                                    "dt_gis"=>$dt_gis,
                                    "dt_tax"=>$dt_tax,
                                    "dt_ded"=>$dt_ded,
                                    "dt_water"=>$dt_water,
                                    "dt_net_salary"=>$net_sal,
                                    "dt_type_mon"=>$sal_mon,
                                    "dt_month2"=>$month2,"dt_month"=>$dt_mon,
                                    "dt_grp"=>'Salary-'.$emp_id.'-'.$fin_year
                                ));
                            }
            
        }}
        
        // Complete transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            throw new Exception('Database transaction failed');
        }
        
        $message = "Successfully imported {$imported_count} new employees and {$salary_imported} salary records";
        if ($updated_count > 0 || $salary_updated > 0) {
            $message .= " (Updated: {$updated_count} employees, {$salary_updated} salary records)";
        }
        
        echo json_encode([
            'success' => true,
            'message' => $message,
            'imported' => $imported_count,
            'updated' => $updated_count,
            'salary_imported' => $salary_imported,
            'salary_updated' => $salary_updated
        ]);
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        echo json_encode([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}

    public function export_csv() {
        $this->load->dbutil();
        $this->load->helper('download');
        
        // Optional: Filter by client
        $emp_client = $this->session->userdata('userid');
        if ($emp_client) {
            $this->db->where('emp_client', $emp_client);
        }
        
        $query = $this->db->get('emps');
        $csv = $this->dbutil->csv_from_result($query);
        force_download('employees_' . date('Y-m-d') . '.csv', $csv);
    }

    public function clear_data() {
        $emp_client = $this->session->userdata('userid');
        
        if ($emp_client) {
            $this->db->where('emp_client', $emp_client);
            $this->db->delete('emps');
        } else {
            $this->db->truncate('emps');
        }
        
        $this->session->set_flashdata('msg', 'All data cleared successfully!');
        $this->session->set_flashdata('type', 'warning');
        redirect('employee');
    }
}