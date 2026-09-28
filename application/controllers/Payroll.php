<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payroll extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url', 'file', 'download']);
        $this->load->library(['session', 'form_validation']);
    }

    public function index() {
        $data['records'] = $this->db->order_by('id', 'DESC')->get('payroll_data')->result();
        $data['fin_years'] = $this->get_financial_years();
        $this->load->view('payroll_tool', $data);
    }

    private function get_financial_years() {
        $years = [];
        for ($y = 2026; $y >= 2010; $y--) {
            $next = $y + 1;
            $years[] = [
                'value' => $y . '_' . substr($next, -2),
                'label' => $y . '_' . substr($next, -2)
            ];
        }
        return $years;
    }

    // Proxy the DDO website - works with iframe
    public function proxy() {
        $url = 'https://ekoshonline.cg.gov.in/epayroll/frmempdetails.aspx';
        
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
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
        }
        
        // Remove X-Frame-Options header
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
        curl_close($ch);
        
        if ($response === false) {
            echo "Error fetching the page";
            return;
        }
        
        // Fix form action and URLs
        $base_url = 'https://ekoshonline.cg.gov.in/epayroll/';
        $proxy_url = base_url('payroll/proxy');
        
        $response = str_replace('action="./frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('action="frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('action="' . $base_url . 'frmempdetails.aspx"', 'action="' . $proxy_url . '"', $response);
        $response = str_replace('src="/epayroll/', 'src="' . $base_url, $response);
        $response = str_replace('src="/', 'src="' . $base_url, $response);
        $response = str_replace('href="/epayroll/', 'href="' . $base_url, $response);
        $response = str_replace('href="/', 'href="' . $base_url, $response);
        
        // Remove break-out scripts
        $response = preg_replace('/top\.location\s*=/', '//top.location=', $response);
        $response = preg_replace('/parent\.location\s*=/', '//parent.location=', $response);
        
        // Add base tag
        $base_tag = '<base href="' . $base_url . '">';
        $response = str_replace('<head>', '<head>' . $base_tag, $response);
        
        echo $response;
    }

    // Extract data from iframe and import to database
    public function extract_data() {
        $html = $this->input->post('html');
        
        if (empty($html)) {
            echo json_encode(['success' => false, 'message' => 'No HTML received']);
            return;
        }
        
        // Get month and fin_year from form
        $month = $this->input->post('month') ?: '03/2026';
        $fin_year = $this->input->post('fin_year') ?: '2026_27';
        $ddo_code = $this->input->post('ddo_code') ?: '0820007';
        
        // Parse HTML to extract table data
        $employees = [];
        
        // Find GridView1 table
        preg_match('/<table[^>]*id="GridView1"[^>]*>(.*?)<\/table>/is', $html, $table_match);
        
        if (empty($table_match[1])) {
            echo json_encode(['success' => false, 'message' => 'Table not found. Please search for data first.']);
            return;
        }
        
        // Extract rows
        preg_match_all('/<tr[^>]*>(.*?)<\/tr>/is', $table_match[1], $rows);
        
        $skip_first = true;
        foreach ($rows[1] as $row_html) {
            if ($skip_first) {
                $skip_first = false;
                continue;
            }
            
            preg_match_all('/<td[^>]*>(.*?)<\/td>/is', $row_html, $cols);
            
            if (empty($cols[1])) continue;
            
            $values = array_map(function($v) {
                return trim(strip_tags($v));
            }, $cols[1]);
            
            // Skip empty rows
            if (empty($values[0]) || $values[0] == '' || $values[0] == '&nbsp;') {
                continue;
            }
            
            // Skip if column 4 (Bill No) is empty
            if (empty($values[4]) || $values[4] == '' || $values[4] == '&nbsp;') {
                continue;
            }
            
            // Determine payroll type from the page (we'll get it from the form)
            $payroll_type = $this->input->post('payroll_type') ?: 'PAYROLL_CPS_CGPF';
            
            $employees[] = [
                'employee_id' => $values[0] ?? '',
                'employee_code' => $values[1] ?? '',
                'name' => $values[2] ?? '',
                'pran' => $values[3] ?? '',
                'basic' => str_replace(',', '', $values[5] ?? '0'),
                'total_deductions' => str_replace(',', '', $values[92] ?? '0'),
                'total_dues' => str_replace(',', '', $values[93] ?? '0'),
                'payroll_type' => $payroll_type,
                'fin_year' => $fin_year,
                'month' => $month,
                'ddo_code' => $ddo_code
            ];
        }
        
        if (empty($employees)) {
            echo json_encode(['success' => false, 'message' => 'No employee data found in the table']);
            return;
        }
        
        // Import to database
        $imported = 0;
        foreach ($employees as $emp) {
            $data = [
                'employee_id' => $emp['employee_id'],
                'employee_code' => $emp['employee_code'],
                'name' => $emp['name'],
                'pran' => $emp['pran'],
                'basic' => floatval($emp['basic']),
                'payroll_type' => $emp['payroll_type'],
                'fin_year' => $emp['fin_year'],
                'month' => $emp['month'],
                'ddo_code' => $emp['ddo_code'],
                'total_deductions' => floatval($emp['total_deductions']),
                'total_dues' => floatval($emp['total_dues']),
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            if (!empty($data['employee_code'])) {
                $this->db->where('employee_code', $data['employee_code']);
                $this->db->where('month', $data['month']);
                $exists = $this->db->get('payroll_data')->row();
                
                if ($exists) {
                    $this->db->where('employee_code', $data['employee_code']);
                    $this->db->where('month', $data['month']);
                    $this->db->update('payroll_data', $data);
                } else {
                    $this->db->insert('payroll_data', $data);
                }
                $imported++;
            }
        }
        
        // Generate CSV
        $filename = $this->generate_csv($employees, $ddo_code, $month);
        
        echo json_encode([
            'success' => true,
            'imported' => $imported,
            'filename' => $filename,
            'message' => "Successfully imported $imported records"
        ]);
    }

    private function generate_csv($data, $ddo_code, $month) {
        if (empty($data)) return '';
        
        $dt = DateTime::createFromFormat('m/Y', $month);
        if (!$dt) {
            $dt = new DateTime();
        }
        $month_index = $dt->format('m');
        $month_index_int = intval($month_index) - 2;
        if ($month_index_int <= 0) {
            $month_index_int = $month_index_int + 12;
        }
        $month_index_str = sprintf("%02d", $month_index_int);
        $label = $dt->format('M-Y');
        $filename = "salary_data_import_template_{$month_index_str}_{$label}_{$ddo_code}.csv";
        
        // Create CSV
        if (!empty($data)) {
            $headers = array_keys($data[0]);
            $csv_content = implode(',', $headers) . "\n";
            foreach ($data as $row) {
                $csv_content .= implode(',', array_values($row)) . "\n";
            }
        } else {
            $csv_content = "No data found\n";
        }
        
        $downloads_path = FCPATH . 'downloads/';
        if (!is_dir($downloads_path)) {
            mkdir($downloads_path, 0777, true);
        }
        
        $filepath = $downloads_path . $filename;
        file_put_contents($filepath, $csv_content);
        
        return $filename;
    }

    public function download_csv($filename = '') {
        if (empty($filename)) {
            $filename = $this->session->flashdata('download_file');
        }
        
        if (empty($filename)) {
            show_error('No file to download');
        }
        
        $filepath = FCPATH . 'downloads/' . $filename;
        if (!file_exists($filepath)) {
            show_error('File not found: ' . $filename);
        }
        
        $this->load->helper('download');
        force_download($filename, file_get_contents($filepath));
        @unlink($filepath);
    }

    public function export_db() {
        $this->load->dbutil();
        $this->load->helper('download');
        $query = $this->db->get('payroll_data');
        $csv = $this->dbutil->csv_from_result($query);
        force_download('payroll_data_' . date('Y-m-d') . '.csv', $csv);
    }

    public function clear_data() {
        $this->db->empty_table('payroll_data');
        $this->session->set_flashdata('msg', 'All data cleared!');
        $this->session->set_flashdata('type', 'warning');
        redirect('payroll');
    }
}