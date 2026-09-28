<?php defined('BASEPATH') OR exit('No direct script access allowed');//Ekosh
class Admin extends MY_Controller {
	function __construct() {
        parent::__construct();
		if(!$this->session->userdata("admin")){redirect("home/admin");}	
		date_default_timezone_set("Asia/Kolkata");
		error_reporting(0);
    }

	public function download_database() {
		//exit;
		// 1. Load the database utility and download helper
		$this->load->dbutil();
		$this->load->helper('download');

		// 2. Configure backup settings
		$prefs = array(
			'format'   => 'zip',             // zip, gzip, txt
			'filename' => 'ekosh_database_'.date('d-M-Y').'.sql'    // File name inside the zip
		);

		// 3. Backup the database and assign to a variable
		$backup = $this->dbutil->backup($prefs);

		// 4. Load the file helper and download the file to your desktop
		$db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
		force_download($db_name, $backup);
	}

	public function profile(){
		$data['edit']=$this->db->get_where("clients",array("client_id"=>$this->session->userdata("userid")))->row();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/profile',$data,true);
		$this->adminlayout(); 
	}

	public function showdata(){
		 $this->db->order_by("dt_month2","desc");
		 $mon=$this->db->get_where("emp_data",array("dt_fnyr"=>"2025_26","dt_emp_id"=>2237))->row();
		 echo "<pre>";print_r($mon);
	}

	public function translate_api() {
        // Your Sarvam API key
        $api_key = 'sk_a96g35y0_Dz1bXuttoMElmjEBAPBv7RJa';
        
        // API endpoint
        $url = 'https://api.sarvam.ai/translate';
        
        // Data to be sent
        $data = array(
            'input' => $_GET['text'],//'Hello Friends, How are you today',
            'source_language_code' => 'auto',
            'target_language_code' => 'hi-IN'
        );
        
        // Initialize cURL
        $ch = curl_init($url);
        
        // Convert data to JSON
        $json_data = json_encode($data);
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'api-subscription-key: ' . $api_key,
            'Content-Length: ' . strlen($json_data)
        ));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Set to true in production
        
        // Execute cURL request
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            $error = 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            
            // Handle error
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(array('error' => $error)));
        }
        
        // Get HTTP status code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Close cURL
        curl_close($ch);
        
        // Decode response
        $response_data = json_decode($response, true);
        
        // Check if request was successful
        if ($http_code == 200) {
            // Success - return or process the response
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output($response);
        } else {
            // Error handling
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header($http_code)
                ->set_output($response);
        }
    }

	public function export_csv_emp() {
    // Display labels for headers
    $header_labels = ['S.No.', 'Code', 'Employee Name', 'PAN', 'Email', 'Bill Unit', 'Phone', 'Office', 'Sub Office', 'Designation', 'GPF Type', 'Tax Regime', 'Status'];
    
    // Database column names (for SELECT query) - removed empty element
    $db_columns = ['emp_code', 'emp_name', 'emp_pan', 'emp_email', 'emp_bill', 'emp_mob', 'emp_school', 'emp_sankul', 'emp_desg', 'emp_gpf', 'emp_tax', 'emp_status'];
    
    // Fetch data
    $this->db->select(implode(',', $db_columns));
    $this->db->from('emps');
	$this->db->where("emp_client",$this->session->userdata("userid"));
    $query = $this->db->get();
    $data = $query->result_array();
    
    // Output CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="employees_' . date('Ymd_His') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fputs($output, "\xEF\xBB\xBF");
    
    // Write custom header labels
    fputcsv($output, $header_labels);
    
    // Write data with serial number
    $serial = 1;
    foreach ($data as $row) {
        $csv_row = [];
        
        // Add serial number as first column
        $csv_row[] = $serial;
        
        // Add data from database columns
        foreach ($db_columns as $col) {
            $csv_row[] = $row[$col] ?? '';
        }
        
        fputcsv($output, $csv_row);
        $serial++;
    }
    
    fclose($output);
    exit;
}

	public function generate_multiple_pdfs(){
        // 1️⃣ Fetch records from database
        $query = $this->db->get('clients'); // Example table, change as needed
        $records = $query->result();

        if (empty($records)) {
            show_error("No records found.");
            return;
        }

        // 2️⃣ Create a temporary folder for PDFs
        $tempDir = FCPATH . 'assets/pdfs/';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $pdfFiles = [];

        // 3️⃣ Generate individual PDFs
        foreach ($records as $row) {

            // Prepare HTML content using a view
            // The view file: application/views/pdf_template.php
            $html = $this->load->view('pdf_template', ['record' => $row], TRUE);

            // Create new TCPDF instance
            $pdf = new TCPDF();
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('CodeIgniter System');
            $pdf->SetTitle('Record PDF - ' . $row->id);
            $pdf->SetMargins(10, 10, 10, true);
            $pdf->AddPage();
            $pdf->writeHTML($html, true, false, true, false, '');
            
            $filename = 'record_' . $row->id . '.pdf';
            $filepath = $tempDir . $filename;
            
            $pdf->Output($filepath, 'F'); // Save to file system

            $pdfFiles[] = $filepath;
        }

        // 4️⃣ Create ZIP file
        $zip = new ZipArchive();
        $zipName = 'records_' . date('Ymd_His') . '.zip';
        $zipPath = $tempDir . $zipName;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($pdfFiles as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
        } else {
            show_error("Could not create ZIP file.");
            return;
        }

        // 5️⃣ Force download of ZIP file
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipName . '"');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);

        // 6️⃣ Cleanup temporary files after download
        foreach ($pdfFiles as $file) {
            unlink($file);
        }
        unlink($zipPath);
    }



	public function auto_itr12($fnyr){

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("dt_client",$this->session->userdata("userid"));
		//$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
		$this->db->where("dt_fnyr",$fnyr);
		$this->db->where("dt_itr","");
		$this->db->group_by("dt_emp_id");
		$this->db->limit(100);
		$emps= $this->db->get()->result();
		//echo "<pre>";print_r($emps);exit;
		$i=0;
		foreach($emps as $empd){
	//$this->db->delete("emp_itr",array("itr_emp"=>$empd->dt_emp_id,"itr_client"=>$this->session->userdata("userid")));
	if($this->db->get_where("emp_itr",array("itr_emp"=>$empd->dt_emp_id,"itr_client"=>$this->session->userdata("userid")))->num_rows()==0){
	$chkemp=$this->db->get_where("emps",array("emp_id"=>$empd->dt_emp_id,"emp_client"=>$this->session->userdata("userid")))->num_rows();
	
					// $this->db->select_sum('dt_dues');  
					// $this->db->where("dt_emp_id",$empd->dt_emp_id); 
					// $this->db->where("dt_fnyr",$fnyr); 
					// if($chkemp==0){
					// 	$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
					// }
					// $this->db->where("dt_type!=",'PayArear'); 
					// $lll=$this->db->get('emp_data')->row();
					$ddouid=$this->session->userdata('userid');
					$lll=$this->db->query("SELECT SUM(dt_dues)
FROM emp_data
WHERE dt_emp_id=$empd->dt_emp_id
AND dt_fnyr=$fnyr
AND (dt_sal_ddo=$ddouid OR dt_sal_ddo='' OR dt_sal_ddo IS NULL)
AND dt_type!='PayArear'")->row();
					$total_dues=$lll->dt_dues; 

					// $this->db->select_sum('dt_tax');  
					// $this->db->where("dt_emp_id",$empd->dt_emp_id); 
					// $this->db->where("dt_fnyr",$fnyr);  
					// if($chkemp==0){
					// 	$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
					// }
					// $this->db->where("dt_type!=",'PayArear'); 
					//$lll=$this->db->get('emp_data')->row();
					$lll=$this->db->query("SELECT SUM(dt_tax)
FROM emp_data
WHERE dt_emp_id=$empd->dt_emp_id
AND dt_fnyr=$fnyr
AND (dt_sal_ddo=$ddouid OR dt_sal_ddo='' OR dt_sal_ddo IS NULL)
AND dt_type!='PayArear'")->row();
					$dt_tax=$lll->dt_tax; 
					
					$admin = $this->db->get("admin")->row();

					$total_income=$total_dues-$admin->stn_ded;

					$tax = 0;
					$income = $total_income;

					$slabs = array();
					$rate = array();
					$slab_tax = array();
					$slab_income = array();

// Calculate tax slab-wise from highest to lowest
if ($income > 2400000) {
    $slab_amount = $income - 2400000;
    $slab_tax_amount = $slab_amount * 0.30;
    $tax += $slab_tax_amount;
    array_push($slabs, "Above 24L");
    array_push($rate, "30%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 2400000;
}
if ($income > 2000000) {
    $slab_amount = $income - 2000000;
    $slab_tax_amount = $slab_amount * 0.25;
    $tax += $slab_tax_amount;
    array_push($slabs, "20L - 24L");
    array_push($rate, "25%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 2000000;
}
if ($income > 1600000) {
    $slab_amount = $income - 1600000;
    $slab_tax_amount = $slab_amount * 0.20;
    $tax += $slab_tax_amount;
    array_push($slabs, "16L - 20L");
    array_push($rate, "20%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 1600000;
}
if ($income > 1200000) {
    $slab_amount = $income - 1200000;
    $slab_tax_amount = $slab_amount * 0.15;
    $tax += $slab_tax_amount;
    array_push($slabs, "12L - 16L");
    array_push($rate, "15%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 1200000;
}
if ($income > 800000) {
    $slab_amount = $income - 800000;
    $slab_tax_amount = $slab_amount * 0.10;
    $tax += $slab_tax_amount;
    array_push($slabs, "8L - 12L");
    array_push($rate, "10%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 800000;
}
if ($income > 400000) {
    $slab_amount = $income - 400000;
    $slab_tax_amount = $slab_amount * 0.05;
    $tax += $slab_tax_amount;
    array_push($slabs, "4L - 8L");
    array_push($rate, "5%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 400000;
}
// The first 4L is tax-free
if ($income > 0) {
    array_push($slabs, "0L - 4L");
    array_push($rate, "0%");
    array_push($slab_income, $income);
    array_push($slab_tax, 0);
}

// Reverse the arrays to show slabs from lowest to highest
$slabs = array_reverse($slabs);
$rate = array_reverse($rate);
$slab_income = array_reverse($slab_income);
$slab_tax = array_reverse($slab_tax);
//echo $tax;
//exit;
$totalTax=$tax;
$marginalRelief = $taxAfterRebate =0;
$rebate87A = 0;
    if ($tax <= 60000) {
        $rebate87A = $tax;
        $tax = 0;
    }

	$tax_income=array_sum($slab_income);
	if ($tax_income > 1200000 && $tax_income <= 1275000) {
		$excess = $tax_income - 1200000;
		$calculatedRebate = round($totalTax - $excess);

		$rebate87A = $calculatedRebate;
		// Tax After Rebate u/s 87A is same as original tax
		$taxAfterRebate = $totalTax-$calculatedRebate;

		if ($calculatedRebate > 0) {
			$marginalRelief = $calculatedRebate;
			$taxAfterMarginalRelief = $excess;
			$tax=$taxAfterMarginalRelief;
		} 
	} 

	$surcharge = 0;
    if ($tax >= 5000000) {
        $surcharge = $tax * 0.1;
    }

	$cess = round($tax * 0.04);
    $tax =$tax+$cess;
	$tax=$tax-$dt_tax;
	if($tax==0){$finalTaxLiability="Nil";}else if($tax>0){$finalTaxLiability="Payable";}else{$finalTaxLiability="Refundable";}

	if($total_dues>=$admin->stn_ded){
		$less=$admin->stn_ded;
	}else{
		$less=$total_dues;
	}
	//echo $dt_tax.'='.$tax;exit;
	$this->db->insert("emp_itr",array("netincome"=>$total_dues-$admin->stn_ded,"itr_emp"=>$empd->dt_emp_id,"itr_yr"=>str_replace("_","-",$fnyr),"sal_head"=>$total_dues,"house_status"=>"Self","income_house"=>0," home_loan_int"=>0,"less"=>$less,"net_hincome"=>0,"other_sources"=>0,"gross_total"=>$total_income,"nps_80ccd2"=>0,"agniveer_80cch2"=>0,"taxable"=>$total_income,"totalTax"=>round($totalTax),"rebate87A"=>$rebate87A,"surcharge"=>$surcharge,"cess"=>round($cess),"advanceTax"=>round($dt_tax),"rebate_89"=>0,"finalTaxLiability"=>round($tax),"paytype"=>$finalTaxLiability,"itr_client"=>$this->session->userdata("userid"),"slab_income"=>implode("|",$slab_income),"rates"=>implode("|",$rate),"slabs"=>implode("|",$slabs),"slab_tax"=>implode("|",$slab_tax)));
		
	
	$this->db->where("dt_emp_id",$empd->dt_emp_id);
	if($empd->dt_sal_ddo!=""){
	$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
	}else{
	$this->db->where("dt_client",$this->session->userdata("userid"));
	}
	$this->db->where("dt_emp_id",$empd->dt_emp_id);
	
	$this->db->where("dt_fnyr",$fnyr);
	$this->db->update("emp_data",array("dt_itr"=>"yes"));
	$i++;
	}
	}
	redirect("admin/itr1/".$fnyr);
	}



	public function auto_itr($fnyr){

    $this->db->select("dt_emp_id,dt_client");
    $this->db->from("emp_data");
    $this->db->group_by("dt_emp_id");
    $this->db->where("dt_client",$this->session->userdata("userid"));
    //$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
    $this->db->where("dt_fnyr",$fnyr);
    $this->db->where("dt_itr","");
    $this->db->limit(100);

    $emps = $this->db->get()->result();

    $i = 0;

    foreach($emps as $empd){

        if(
            $this->db->get_where(
                "emp_itr",
                array(
                    "itr_emp"    => $empd->dt_emp_id,
                    "itr_yr"     => str_replace("_","-",$fnyr),
                    "itr_client" => $this->session->userdata("userid")
                )
            )->num_rows() == 0
        ){

            /*
            |--------------------------------------------------------------------------
            | GET ACTUAL SALARY TOTAL
            |--------------------------------------------------------------------------
            */

            $row = $this->db
                ->select_sum('dt_dues')
                ->where("dt_emp_id", $empd->dt_emp_id)
                ->where("dt_fnyr", $fnyr)
                ->where("dt_type !=", 'PayArear')
                ->get('emp_data')
                ->row();

            $actual_dues = !empty($row->dt_dues)
                ? (float)$row->dt_dues
                : 0;


            /*
            |--------------------------------------------------------------------------
            | COUNT AVAILABLE SALARY MONTHS
            |--------------------------------------------------------------------------
            */

            $month_count_row = $this->db
                ->select('COUNT(DISTINCT dt_month2) AS total_months', false)
                ->where("dt_emp_id", $empd->dt_emp_id)
                ->where("dt_fnyr", $fnyr)
                ->where("dt_type !=", 'PayArear')
                ->get('emp_data')
                ->row();

            $available_months = !empty($month_count_row->total_months)
                ? (int)$month_count_row->total_months
                : 0;


            /*
            |--------------------------------------------------------------------------
            | FIND LATEST AVAILABLE MONTH
            |--------------------------------------------------------------------------
            */

            $latest_month_row = $this->db
                ->select_max('dt_month2')
                ->where("dt_emp_id", $empd->dt_emp_id)
                ->where("dt_fnyr", $fnyr)
                ->where("dt_type !=", 'PayArear')
                ->get('emp_data')
                ->row();

            $latest_month = !empty($latest_month_row->dt_month2)
                ? $latest_month_row->dt_month2
                : null;


            /*
            |--------------------------------------------------------------------------
            | GET SALARY OF LATEST AVAILABLE MONTH
            |--------------------------------------------------------------------------
            */

            $last_month_dues = 0;

            if(!empty($latest_month)){

                $last_month_row = $this->db
                    ->select_sum('dt_dues')
                    ->where("dt_emp_id", $empd->dt_emp_id)
                    ->where("dt_fnyr", $fnyr)
                    ->where("dt_month2", $latest_month)
                    ->where("dt_type !=", 'PayArear')
                    ->get('emp_data')
                    ->row();

                $last_month_dues = !empty($last_month_row->dt_dues)
                    ? (float)$last_month_row->dt_dues
                    : 0;
            }


            /*
            |--------------------------------------------------------------------------
            | PROJECT REMAINING MONTHS
            |--------------------------------------------------------------------------
            */

            $remaining_months = 12 - $available_months;

            if($remaining_months < 0){
                $remaining_months = 0;
            }

            $projected_dues = $last_month_dues * $remaining_months;


            /*
            |--------------------------------------------------------------------------
            | FINAL SALARY FOR FULL FINANCIAL YEAR
            |--------------------------------------------------------------------------
            */

            $total_dues = $actual_dues + $projected_dues;


            /*
            |--------------------------------------------------------------------------
            | GET ACTUAL TAX DEDUCTED
            |--------------------------------------------------------------------------
            */

            $this->db->select_sum('dt_tax');
            $this->db->where("dt_emp_id",$empd->dt_emp_id);
            $this->db->where("dt_fnyr",$fnyr);
            $this->db->where("dt_type!=",'PayArear');

            $lll = $this->db->get('emp_data')->row();

            $dt_tax = !empty($lll->dt_tax)
                ? (float)$lll->dt_tax
                : 0;


            /*
            |--------------------------------------------------------------------------
            | EXISTING ITR CALCULATION
            |--------------------------------------------------------------------------
            */

            $admin = $this->db->get("admin")->row();

            $total_income = $total_dues - $admin->stn_ded;

            $tax = 0;
            $income = $total_income;

            $slabs = array();
            $rate = array();
            $slab_tax = array();
            $slab_income = array();


            // Calculate tax slab-wise from highest to lowest
            if ($income > 2400000) {

                $slab_amount = $income - 2400000;
                $slab_tax_amount = $slab_amount * 0.30;

                $tax += $slab_tax_amount;

                array_push($slabs, "Above 24L");
                array_push($rate, "30%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 2400000;
            }


            if ($income > 2000000) {

                $slab_amount = $income - 2000000;
                $slab_tax_amount = $slab_amount * 0.25;

                $tax += $slab_tax_amount;

                array_push($slabs, "20L - 24L");
                array_push($rate, "25%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 2000000;
            }


            if ($income > 1600000) {

                $slab_amount = $income - 1600000;
                $slab_tax_amount = $slab_amount * 0.20;

                $tax += $slab_tax_amount;

                array_push($slabs, "16L - 20L");
                array_push($rate, "20%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 1600000;
            }


            if ($income > 1200000) {

                $slab_amount = $income - 1200000;
                $slab_tax_amount = $slab_amount * 0.15;

                $tax += $slab_tax_amount;

                array_push($slabs, "12L - 16L");
                array_push($rate, "15%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 1200000;
            }


            if ($income > 800000) {

                $slab_amount = $income - 800000;
                $slab_tax_amount = $slab_amount * 0.10;

                $tax += $slab_tax_amount;

                array_push($slabs, "8L - 12L");
                array_push($rate, "10%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 800000;
            }


            if ($income > 400000) {

                $slab_amount = $income - 400000;
                $slab_tax_amount = $slab_amount * 0.05;

                $tax += $slab_tax_amount;

                array_push($slabs, "4L - 8L");
                array_push($rate, "5%");
                array_push($slab_income, round($slab_amount));
                array_push($slab_tax, round($slab_tax_amount));

                $income = 400000;
            }


            // First 4L is tax-free
            if ($income > 0) {

                array_push($slabs, "0L - 4L");
                array_push($rate, "0%");
                array_push($slab_income, $income);
                array_push($slab_tax, 0);
            }


            // Reverse arrays to show slabs from lowest to highest
            $slabs = array_reverse($slabs);
            $rate = array_reverse($rate);
            $slab_income = array_reverse($slab_income);
            $slab_tax = array_reverse($slab_tax);


            $totalTax = $tax;

            $marginalRelief = 0;
            $taxAfterRebate = 0;
            $rebate87A = 0;


            if ($tax <= 60000) {

                $rebate87A = $tax;
                $tax = 0;
            }


            $tax_income = array_sum($slab_income);


            if ($tax_income > 1200000 && $tax_income <= 1275000) {

                $excess = $tax_income - 1200000;

                $calculatedRebate = round(
                    $totalTax - $excess
                );

                $rebate87A = $calculatedRebate;

                $taxAfterRebate =
                    $totalTax - $calculatedRebate;

                if ($calculatedRebate > 0) {

                    $marginalRelief = $calculatedRebate;

                    $taxAfterMarginalRelief = $excess;

                    $tax = $taxAfterMarginalRelief;
                }
            }


            $surcharge = 0;

            if ($tax >= 5000000) {
                $surcharge = $tax * 0.1;
            }


            $cess = round($tax * 0.04);

            $tax = $tax + $cess;

            $tax = $tax - $dt_tax;


            if($tax == 0){

                $finalTaxLiability = "Nil";

            }else if($tax > 0){

                $finalTaxLiability = "Payable";

            }else{

                $finalTaxLiability = "Refundable";
            }


            if($total_dues >= $admin->stn_ded){

                $less = $admin->stn_ded;

            }else{

                $less = $total_dues;
            }


            /*
            |--------------------------------------------------------------------------
            | INSERT GENERATED ITR
            |--------------------------------------------------------------------------
            */

            $this->db->insert(
                "emp_itr",
                array(

                    "netincome" =>
                        $total_dues - $admin->stn_ded,

                    "itr_emp" =>
                        $empd->dt_emp_id,

                    "itr_yr" =>
                        str_replace("_","-",$fnyr),

                    "sal_head" =>
                        $total_dues,

                    "house_status" =>
                        "Self",

                    "income_house" =>
                        0,

                    "home_loan_int" =>
                        0,

                    "less" =>
                        $less,

                    "net_hincome" =>
                        0,

                    "other_sources" =>
                        0,

                    "gross_total" =>
                        $total_income,

                    "nps_80ccd2" =>
                        0,

                    "agniveer_80cch2" =>
                        0,

                    "taxable" =>
                        $total_income,

                    "totalTax" =>
                        round($totalTax),

                    "rebate87A" =>
                        $rebate87A,

                    "surcharge" =>
                        $surcharge,

                    "cess" =>
                        round($cess),

                    "advanceTax" =>
                        round($dt_tax),

                    "rebate_89" =>
                        0,

                    "finalTaxLiability" =>
                        round($tax),

                    "paytype" =>
                        $finalTaxLiability,

                    "itr_client" =>
                        $this->session->userdata("userid"),

                    "slab_income" =>
                        implode("|",$slab_income),

                    "rates" =>
                        implode("|",$rate),

                    "slabs" =>
                        implode("|",$slabs),

                    "slab_tax" =>
                        implode("|",$slab_tax)
                )
            );


            /*
            |--------------------------------------------------------------------------
            | MARK EMPLOYEE DATA AS ITR GENERATED
            |--------------------------------------------------------------------------
            */

            if(
                $this->db->get_where(
                    "emps",
                    array(
                        "emp_id" =>
                            $empd->dt_emp_id,

                        "emp_client" =>
                            $this->session->userdata("userid")
                    )
                )->num_rows() > 0
            ){

                $this->db->where(
                    "dt_emp_id",
                    $empd->dt_emp_id
                );

            }else{

                $this->db->where(
                    "dt_client",
                    $this->session->userdata("userid")
                );

                $this->db->where(
                    "dt_emp_id",
                    $empd->dt_emp_id
                );
            }


            $this->db->where(
                "dt_fnyr",
                $fnyr
            );

            $this->db->update(
                "emp_data",
                array(
                    "dt_itr" => "yes"
                )
            );


            $i++;

        }

    }


    redirect("admin/itr1/".$fnyr);
}



public function auto_itr_old($fnyr){

		$this->db->select("dt_emp_id,dt_client");
		$this->db->from("emp_data");
		$this->db->group_by("dt_emp_id");
		$this->db->where("dt_client",$this->session->userdata("userid"));
		//$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
		$this->db->where("dt_fnyr",$fnyr);
		$this->db->where("dt_itr","");
		$this->db->limit(100);
		$emps= $this->db->get()->result();
		//echo "<pre>";print_r($emps);exit;
		$i=0;
		foreach($emps as $empd){
			if($this->db->get_where("emp_itr",array("itr_emp"=>$empd->dt_emp_id,"itr_yr"=>str_replace("_","-",$fnyr),"itr_client"=>$this->session->userdata("userid")))->num_rows()==0){
				 //   echo $empd->emp_id;exit;
					$this->db->select_sum('dt_dues');  
					$this->db->where("dt_emp_id",$empd->dt_emp_id); 
					$this->db->where("dt_fnyr",$fnyr);   
					
					$this->db->where("dt_type!=",'PayArear'); 
					$lll=$this->db->get('emp_data')->row();
					$total_dues=$lll->dt_dues; 
					$this->db->select_sum('dt_tax');  
					$this->db->where("dt_emp_id",$empd->dt_emp_id); 
					$this->db->where("dt_fnyr",$fnyr);  
					$this->db->where("dt_type!=",'PayArear'); 
					$lll=$this->db->get('emp_data')->row();
					$dt_tax=$lll->dt_tax; 
					//echo $total_dues.'<br/>';
					$admin = $this->db->get("admin")->row();

					$total_income=$total_dues-$admin->stn_ded;

					$tax = 0;
					$income = $total_income;

					$slabs = array();
					$rate = array();
					$slab_tax = array();
					$slab_income = array();

// Calculate tax slab-wise from highest to lowest
if ($income > 2400000) {
    $slab_amount = $income - 2400000;
    $slab_tax_amount = $slab_amount * 0.30;
    $tax += $slab_tax_amount;
    array_push($slabs, "Above 24L");
    array_push($rate, "30%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 2400000;
}
if ($income > 2000000) {
    $slab_amount = $income - 2000000;
    $slab_tax_amount = $slab_amount * 0.25;
    $tax += $slab_tax_amount;
    array_push($slabs, "20L - 24L");
    array_push($rate, "25%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 2000000;
}
if ($income > 1600000) {
    $slab_amount = $income - 1600000;
    $slab_tax_amount = $slab_amount * 0.20;
    $tax += $slab_tax_amount;
    array_push($slabs, "16L - 20L");
    array_push($rate, "20%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 1600000;
}
if ($income > 1200000) {
    $slab_amount = $income - 1200000;
    $slab_tax_amount = $slab_amount * 0.15;
    $tax += $slab_tax_amount;
    array_push($slabs, "12L - 16L");
    array_push($rate, "15%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 1200000;
}
if ($income > 800000) {
    $slab_amount = $income - 800000;
    $slab_tax_amount = $slab_amount * 0.10;
    $tax += $slab_tax_amount;
    array_push($slabs, "8L - 12L");
    array_push($rate, "10%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 800000;
}
if ($income > 400000) {
    $slab_amount = $income - 400000;
    $slab_tax_amount = $slab_amount * 0.05;
    $tax += $slab_tax_amount;
    array_push($slabs, "4L - 8L");
    array_push($rate, "5%");
    array_push($slab_income, round($slab_amount));
    array_push($slab_tax, round($slab_tax_amount));
    $income = 400000;
}
// The first 4L is tax-free
if ($income > 0) {
    array_push($slabs, "0L - 4L");
    array_push($rate, "0%");
    array_push($slab_income, $income);
    array_push($slab_tax, 0);
}

// Reverse the arrays to show slabs from lowest to highest
$slabs = array_reverse($slabs);
$rate = array_reverse($rate);
$slab_income = array_reverse($slab_income);
$slab_tax = array_reverse($slab_tax);
//echo $tax;
//exit;
$totalTax=$tax;
$marginalRelief = $taxAfterRebate =0;
$rebate87A = 0;
    if ($tax <= 60000) {
        $rebate87A = $tax;
        $tax = 0;
    }

$tax_income=array_sum($slab_income);
if ($tax_income > 1200000 && $tax_income <= 1275000) {//
    $excess = $tax_income - 1200000;
    $calculatedRebate = round($totalTax - $excess);

	$rebate87A = $calculatedRebate;
    // Tax After Rebate u/s 87A is same as original tax
    $taxAfterRebate = $totalTax-$calculatedRebate;

    if ($calculatedRebate > 0) {
        $marginalRelief = $calculatedRebate;
        $taxAfterMarginalRelief = $excess;
        $tax=$taxAfterMarginalRelief;
    } 
} 
	$surcharge = 0;
    if ($tax >= 5000000) {
        $surcharge = $tax * 0.1;
    }

	$cess = round($tax * 0.04);
    $tax =$tax+$cess;
	$tax=$tax-$dt_tax;
	if($tax==0){$finalTaxLiability="Nil";}else if($tax>0){$finalTaxLiability="Payable";}else{$finalTaxLiability="Refundable";}

	if($total_dues>=$admin->stn_ded){
		$less=$admin->stn_ded;
	}else{
		$less=$total_dues;
	}
	//echo $dt_tax.'='.$tax;exit;
					$this->db->insert("emp_itr",array("netincome"=>$total_dues-$admin->stn_ded,"itr_emp"=>$empd->dt_emp_id,"itr_yr"=>str_replace("_","-",$fnyr),"sal_head"=>$total_dues,"house_status"=>"Self","income_house"=>0," home_loan_int"=>0,"less"=>$less,"net_hincome"=>0,"other_sources"=>0,"gross_total"=>$total_income,"nps_80ccd2"=>0,"agniveer_80cch2"=>0,"taxable"=>$total_income,"totalTax"=>round($totalTax),"rebate87A"=>$rebate87A,"surcharge"=>$surcharge,"cess"=>round($cess),"advanceTax"=>round($dt_tax),"rebate_89"=>0,"finalTaxLiability"=>round($tax),"paytype"=>$finalTaxLiability,"itr_client"=>$this->session->userdata("userid"),"slab_income"=>implode("|",$slab_income),"rates"=>implode("|",$rate),"slabs"=>implode("|",$slabs),"slab_tax"=>implode("|",$slab_tax)));
		
		if($this->db->get_where("emps",array("emp_id"=>$empd->dt_emp_id,"emp_client"=>$this->session->userdata("userid")))->num_rows()>0){
		$this->db->where("dt_emp_id",$empd->dt_emp_id);
		}else{
		$this->db->where("dt_client",$this->session->userdata("userid"));
		$this->db->where("dt_emp_id",$empd->dt_emp_id);
		}
		$this->db->where("dt_fnyr",$fnyr);
		$this->db->update("emp_data",array("dt_itr"=>"yes"));
		$i++;
		//if($i==50){ break;}
				}
		}
		redirect("admin/itr1/".$fnyr);
	}

	
	public function reset_emps(){
		$this->db->delete("emps",array("emp_client"=>$this->session->userdata("userid")));
		$this->db->delete("emp_itr",array("itr_client"=>$this->session->userdata("userid")));
		$this->db->delete("emp_data",array("dt_client"=>$this->session->userdata("userid")));
		redirect("admin/list_employees/");
	}

	public function reset_itr($fnyr){
		$this->db->where("itr_client",$this->session->userdata("userid"));
		$this->db->where("itr_yr",str_replace("_","-",$fnyr));
		$this->db->delete("emp_itr");

		
		$this->db->where("dt_client",$this->session->userdata("userid"));
		$this->db->where("dt_fnyr",$fnyr);
		$this->db->update("emp_data",array("dt_itr"=>""));

		redirect("admin/itr1/".$fnyr);
	}



public function bulk_itr0($yr)
{
    $financial_year = $yr;
    $tempDir = FCPATH . 'assets/pdfs/itr_pdfs_' . uniqid();

    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0755, true);
    }

    $pdfFiles = [];

    // ✅ Loop through posted employee IDs
    if (!empty($_POST['itr']) && is_array($_POST['itr'])) {
        foreach ($_POST['itr'] as $emp_id) {
            // Clean employee ID
            $emp_id = trim($emp_id);
            if (empty($emp_id)) continue;

            // Prepare data
            $data = [];
            $emp = $this->db->get_where("emps", ["emp_id" => $emp_id])->row();
            if (!$emp) continue; // skip invalid employee

            $data['empd'] = $emp;
            $data['ddo'] = $this->db->get_where("clients", ["client_id" => $this->session->userdata("userid")])->row();
            $data['fnyr'] = $financial_year;

            // Get ITR data
            $itr_data = $this->db->get_where("emp_itr", [
                "itr_emp" => $emp_id,"itr_client"=>$this->session->userdata("userid"),
                "itr_yr" => str_replace("_", "-", $financial_year)
            ])->row_array();

            $data['other'] = $itr_data ? $itr_data : [];

            // ✅ Prepare filename and filepath
            $filename = 'ITR_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $emp->emp_code) . '_' . $emp_id . '_' . $financial_year . '.pdf';
            $filepath = $tempDir . '/' . $filename;

            // ✅ Load view
            $html = $this->load->view('pdf_template', $data, TRUE);

            // ✅ Generate PDF
            $this->load->library('Pdf');
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator('Your App');
            $pdf->SetTitle('ITR Report - ' . $emp->emp_code);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML($html);

            // ✅ Save to file
            $pdf->Output($filepath, 'F');

            $pdfFiles[] = $filepath;
        }
    }

    // ✅ Create ZIP
    $zipFilename = 'Computation_Report_' . $financial_year . '.zip';
    $zipPath = $tempDir . '/' . $zipFilename;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
        throw new Exception("Cannot create ZIP file");
    }

    foreach ($pdfFiles as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();

    // ✅ Force download
    if (file_exists($zipPath)) {
        // Clean output buffer before sending headers
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);

        // Optional: cleanup temporary folder after download
        array_map('unlink', glob("$tempDir/*.pdf"));
        // unlink($zipPath); // uncomment to delete zip after download
        rmdir($tempDir);
        exit;
    } else {
        throw new Exception('ZIP file creation failed');
    }
}
















	public function bulk_itr($yr){

    $financial_year = $yr;
    $tempDir = FCPATH . 'assets/pdfs/itr_pdfs_' . uniqid();
    if (!is_dir($tempDir)) {
        mkdir($tempDir, 0755, true);
    }

    $pdfFiles = [];

	foreach ($_POST['itr'] as $emp_id) {

			$emp_id = trim($emp_id);
            if(empty($emp_id)) continue;
            
            $data = [];
			$emp= $this->db->get_where("emps", array("emp_id" => $emp_id))->row();
            $data['empd'] =$emp;
            $ddo = $this->db->get_where("clients", array("client_id" => $this->session->userdata("userid")))->row();
			$data['ddo']=$ddo;
            $data['fnyr'] = $financial_year;
            
            // Get ITR data if exists
            $itr_data = $this->db->get_where("emp_itr", array(
                "itr_emp" => $emp_id,"itr_client"=>$this->session->userdata("userid"),
                "itr_yr" => str_replace("_", "-", $financial_year)
            ))->row_array();
            
            $data['other'] = $itr_data;
			//echo "<pre>";print_r($data);

			$html = $this->load->view('pdf_template', $data, TRUE);

			$this->load->library('Pdf');
			$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
			$pdf->SetCreator('Your App');
			$pdf->SetTitle('ITR Report - ' . $itr_data['itr_emp']);
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->AddPage();
			$pdf->writeHTML($html);

			// Define a valid file path
          //  $filename = str_replace(" ","-",$emp->emp_name).'_'. preg_replace('/[^A-Za-z0-9_-]/', '_', $emp->emp_code) . '_'.str_replace(" ","-",////$emp->emp_sankul).'_'.str_replace(" ","-",$emp->emp_school).'_'. $financial_year . '.pdf';
$filename = str_replace(" ","-",$emp->emp_sankul).'_'.str_replace(" ","-",$emp->emp_school).'_'.str_replace(" ","-",$emp->emp_bill).'_'.str_replace(" ","-",$emp->emp_name).'_'.$emp->emp_code.'_'.$financial_year . '.pdf';
			$filepath = $tempDir . '/' . $filename;
			// Save the PDF file
			$pdf->Output($filepath, 'F');

			$pdfFiles[] = $filepath;
    }
	

    // Create ZIP file
    $zipFilename = 'Computation_Report_'.str_replace(" ","_",$ddo->ddo_name).'_'.$ddo->ddo_num.'_'.$financial_year . '.zip';
    $zipPath = $tempDir . '/' . $zipFilename;

    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
        throw new Exception("Cannot create ZIP file");
    }

    foreach ($pdfFiles as $file) {
        $zip->addFile($file, basename($file));
    }
    $zip->close();

    // Force download ZIP
    if (file_exists($zipPath)) {
        // Clean any previous output
        ob_end_clean();
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
        header('Content-Length: ' . filesize($zipPath));
        readfile($zipPath);
        exit;
    } else {
        throw new Exception('ZIP file creation failed');
    }
}


	public function bulk_itr2($yr) {

    $financial_year = $yr;//$this->input->post('financial_year');
    
    $tempDir =  './assets/pdfs/itr_pdfs_' . uniqid();
    mkdir($tempDir, 0755, true);
		
    try {
        $pdfFiles = [];
        
        foreach ($_POST['itr'] as $emp_id) {
            // Clean the employee ID
            $emp_id = trim($emp_id);
            if(empty($emp_id)) continue;
            
            $data = [];
			$emp= $this->db->get_where("emps", array("emp_id" => $emp_id))->row();
            $data['empd'] =$emp;
            $data['ddo'] = $this->db->get_where("clients", array("client_id" => $this->session->userdata("userid")))->row();
            $data['fnyr'] = $financial_year;
            
            // Get ITR data if exists
            $itr_data = $this->db->get_where("emp_itr", array(
                "itr_emp" => $emp_id,"itr_client"=>$this->session->userdata("userid"),
                "itr_yr" => str_replace("_", "-", $financial_year)
            ))->row_array();
            
            $data['other'] = $itr_data ? $itr_data : [];
            
            // Generate PDF for this employee
            $filename = 'ITR_' . $emp->emp_code . '_' . $emp_id . '_' . $financial_year . '.pdf';
            $filepath = $tempDir . '/' . $filename;
            
            $html = $this->load->view('admin/pdf_template', $data, TRUE);
            
            $this->load->library('Pdf');
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator('Your App');
            $pdf->SetTitle('ITR Report - ' . $emp_id);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->AddPage();
            $pdf->writeHTML($html);
            
            // Save to temporary file instead of outputting
            $pdf->Output($filepath, 'F');
            
            $pdfFiles[] = $filepath;
        }

        if(empty($pdfFiles)) {
            throw new Exception('No PDFs were generated');
        }

        // Create ZIP archive
        $zipFilename = 'Computation_Report_' . $financial_year . '.zip';
        $zipPath = $tempDir . '/' . $zipFilename;
        
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new Exception("Cannot create ZIP file");
        }

        // Add files to zip
        foreach ($pdfFiles as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();

        // Force download
        if (file_exists($zipPath)) {
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . basename($zipPath) . '"');
            header('Content-Length: ' . filesize($zipPath));
            readfile($zipPath);
            
            // Clean up
            //$this->rrmdir($tempDir);
            //exit;
        } else {
            throw new Exception('ZIP file creation failed');
        }

    } catch (Exception $e) {
        // Clean up even if error occurs
        if (isset($tempDir) && is_dir($tempDir)) {
           // $this->rrmdir($tempDir);
        }
        die('Error: ' . $e->getMessage());
    }
}

// Helper function to recursively delete directory
private function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir."/".$object)) {
                    $this->rrmdir($dir."/".$object);
                } else {
                    unlink($dir."/".$object);
                }
            }
        }
        rmdir($dir);
    }
}

	public function bulk_itr1(){
		//echo "<pre>";print_r($_POST);exit;
		foreach($_POST['itr'] as $itr){

		}
	}

	
public function export_ann_itr($yr){
		
	    $this->db->select("*");
		$this->db->from("emp_itr");
		$this->db->join("emps","emps.emp_id=emp_itr.itr_emp");
		
		$this->db->where("emp_itr.itr_client",$this->session->userdata("userid"));
		$this->db->where("emp_itr.itr_yr",str_replace("_","-",$yr));
		$this->db->order_by("emp_itr.itr_id","desc");
		$data['itrs']=$this->db->get()->result();
		$ddo=$this->db->get_where("clients",array("client_id"=>$this->session->userdata("userid")))->row();
		$data['title']="Computation Report_FY_".str_replace("_","-",$yr)."_".$ddo->ddo_name."_".$ddo->ddo_num."_".$ddo->tan_num;

		$this->load->view("admin/excel_ann_salary",$data);
	}

	public function ajax_itr1(){
		//echo "<pre>";print_r($_POST);exit;

	$total_rows=$this->db->get_where("emp_itr",array("itr_yr"=>str_replace("_","-",$_POST['yr']),"itr_client"=>$this->session->userdata("userid")))->num_rows();
	//echo $total_rows;exit;
    $this->db->select("*");
    $this->db->from("emp_itr");
    $this->db->join("emps","emps.emp_id=emp_itr.itr_emp");
    $this->db->where("emp_itr.itr_yr",str_replace("_","-",$_POST['yr']));
    $this->db->where("emp_itr.itr_client",$this->session->userdata("userid"));
    
    // Add search functionality
    if(isset($_POST['search']) && !empty($_POST['search'])) {
        $search = $_POST['search'];
        $this->db->group_start();
        $this->db->like("emps.emp_name", $search);
        $this->db->or_like("emps.emp_code", $search);
        $this->db->or_like("emps.emp_pan", $search);
        $this->db->group_end();
    }
    
    $this->db->order_by("emp_itr.itr_id","desc");
    
    // Get total count for pagination
   // $total_query = $this->db->get();
    //$this->db->get();
	//$total_rows=$dd->num_rows();
    
    $this->db->limit(50, $_POST['offset']);
    $data['itrs'] = $this->db->get()->result();

	//echo "<pre>";print_r($data);exit;


    $data['total_rows'] = $total_rows;
    $data['yr'] =str_replace("_","-",$_POST['yr']);
	$data['yrr']=$_POST['yr'];
    $data['current_offset'] = $_POST['offset'];
    //echo "<pre>";print_r($data);exit;
    $this->load->view("admin/ajax_itr1",$data);
}

	public function itr1($yr){
        // $this->db->select("*");
		// $this->db->from("emp_itr");
		// $this->db->join("emps","emps.emp_id=emp_itr.itr_emp");
		// $this->db->where("emp_itr.itr_yr",str_replace("_","-",$yr));
		
		// $this->db->where("emp_itr.itr_client",$this->session->userdata("userid"));
		// $this->db->order_by("emp_itr.itr_id","desc");
		// $this->db->limit(100);
		// $data['itrs']=$this->db->get()->result();
		
	
		$data['total_rows']=$total_rows=$this->db->get_where("emp_itr",array("itr_yr"=>str_replace("_","-",$yr),"itr_client"=>$this->session->userdata("userid")))->num_rows();
		//print_r($data);exit;
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/itr_list',$data,true);
		$this->adminlayout();
	}

	public function change_pass(){
		parse_str($_POST['formdata'],$form);
		if($form['npass']!=$form['cpass'])
		{
			echo "Your Passwords Doesnot match";exit;
		}
		
		//$this->db->where("ag_id",$this->session->userdata("userid"));
		if($this->session->userdata("type")=="admin"){
		if($this->db->update("admin",array("password"=>md5($form['npass'])))){echo "Password Changed Successfully.";}
		}else{
			$this->db->where("uid",$this->session->userdata("userid"));
			if($this->db->update("emps",array("u_password"=>md5($form['npass'])))){echo "Password Changed Successfully.";}
		}
		
	}

	public function itr_pdf(){
		//echo "<pre>";print_r($_POST);exit;
		$m=explode("-",$_REQUEST['empid']);
		$emp=$this->db->get_where("emps",array("emp_id"=>$m[0]))->row();
		$data['empd']=$emp;
		$ddo=$this->db->get_where("clients",array("client_id"=>$this->session->userdata("userid")))->row();
		$data['ddo']=$ddo;
		$data['fnyr']=$m[1];
		if($_POST){
		$data['other']=$_POST;
		//echo "<pre>";print_r($_POST);exit;
		$postData = $this->input->post();
		$insertData = array();
        
        // Fields that should be converted to JSON
        $jsonFields = array('slabs', 'rates', 'slab_income', 'slab_tax');
        
        // Process empid field separately
        if (isset($postData['empid'])) {
            $empidParts = explode('-', $postData['empid']);
            if (count($empidParts) >= 2) {
                $insertData['itr_emp'] = $empidParts[0]; // First part before -
                $insertData['itr_yr'] = str_replace("_","-",$empidParts[1]);  // Second part after -
            }
            // Remove original empid field as we've split it
            unset($postData['empid']);
        }
        
        foreach ($postData as $key => $value) {
            if (in_array($key, $jsonFields)) {
                // Convert array fields to JSON
                $insertData[$key] = implode("|",$value);
            } else {
                // Add regular fields
                $insertData[$key] = $value;
            }
        }
        
        // Insert data into database
		//echo "<pre>";print_r($insert_data);exit;
		$chk=$this->db->get_where("emp_itr",array("itr_emp"=>$empidParts[0],"itr_client"=>$this->session->userdata("userid"),"itr_yr"=>str_replace("_","-",$empidParts[1])));
		if($chk->num_rows()>0){
			$this->db->where("itr_emp",$empidParts[0]);
			$this->db->where("itr_client",$this->session->userdata("userid"));
			$this->db->where("itr_yr",str_replace("_","-",$empidParts[1]));
			$this->db->update("emp_itr",$insertData);
		}else{
            $this->db->insert('emp_itr', $insertData);
		}
		//echo "<pre>";print_r($_POST);exit;
		$data['other']=$this->db->get_where("emp_itr",array("itr_emp"=>$empidParts[0],"itr_client"=>$this->session->userdata("userid"),"itr_yr"=>str_replace("_","-",$empidParts[1])))->row_array();
	}else{
		$data['other']=$this->db->get_where("emp_itr",array("itr_emp"=>$m[0],"itr_client"=>$this->session->userdata("userid"),"itr_yr"=>str_replace("_","-",$m[1])))->row_array();
	}
		
	$this->load->library('Pdf');

	$data['title'] = "PDF ITR"; // Sample data
	$html = $this->load->view('pdf_template', $data, TRUE); // TRUE returns as string

	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

	$pdf->SetCreator('Your App');
	$pdf->SetTitle('Generated Report');
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	$pdf->AddPage();
	$pdf->writeHTML($html);
	$filename = str_replace(" ","-",$emp->emp_sankul).'_'.str_replace(" ","-",$emp->emp_school).'_'.str_replace(" ","-",$emp->emp_bill).'_'.str_replace(" ","-",$emp->emp_name).'_'.$emp->emp_code.'_'.$m[1]. '.pdf';
	$pdf->Output($filename, 'I');

	}



	public function ajax_stn_ded(){
		$this->db->update("admin",array("stn_ded"=>$_POST['v']));
		//redirect("admin/settings");//
	}	

	public function switch_client($id){
		$d=$this->db->get_where("clients",array("client_id"=>$id))->row();
		//$data=array("admin"=>"true","type"=>'client',"loggeduser"=>$d->ddo_name,"userid"=>$d->client_id,"type2"=>"admin","ddo_num"=>$d->ddo_num);
		$data=array("admin"=>"true","type"=>'client',"img"=>$d->ddo_img,"loggeduser"=>$d->ddo_name,"ddo_num"=>$d->ddo_num,"userid"=>$d->client_id,"type2"=>"admin");
		$this->session->set_userdata($data);
		redirect("admin");
	}
	
	public function switch_admin(){
	    $data=array("admin"=>"true","type"=>'admin',"loggeduser"=>"admin","userid"=>0,"type2"=>"client");
		$this->session->set_userdata($data);
		redirect("admin");
    }

	public function plan_submit (){
		$plan_desc=implode(", ",$_POST['pfeatures']);
		$this->db->insert("plan",array("plan_name"=>$_POST['plan_name'],"plan_price"=>$_POST['plan_price'],"plan_duration"=>$_POST['plan_duration'],"plan_desc"=>$plan_desc));
		redirect("admin/plans");
    }

	public function ajax_search_emp(){
		//echo "<pre>";print_r($_POST);exit;
		$chk=$this->db->get_where("emps",array("emp_code"=>$_POST['code'],"emp_client"=>$this->session->userdata("userid")));
		if($chk->num_rows()>0){
			$chk2=$this->db->get_where("emp_data",array("dt_emp_code"=>$_POST['code'],"dt_type"=>$_POST['type'],"dt_month"=>$_POST['month']));
			$emp=$chk->row();
			//if($chk2->num_rows()>0){
			echo $emp->emp_id.'-'.$emp->emp_name.'-'.$chk2->num_rows();
			//}else{            
			//echo $emp->emp_id.'-'.$emp->emp_name.'-0';
		    //}
		}else{
           echo 0;
		}
	}

	public function emp_details($id){
		$data['emp']=$this->db->get_where("emps",array("emp_id"=>$id))->row();
		//print_r($data);exit;
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/emp',$data,true);
		$this->adminlayout(); 
	}

	public function ajax_emp_data(){ 
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("clients","clients.client_id=emp_data.dt_sal_ddo","left");
		$this->db->where("emp_data.dt_emp_id",$_POST['emp']);//$_POST['emp']);
		$this->db->where("emp_data.dt_fnyr",$_POST['yr']);//$_POST['yr']);
		$this->db->order_by("emp_data.dt_month2","asc");
		$this->db->order_by("emp_data.dt_type","desc");
		$data['empdata']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;
		$this->load->view('admin/ajax_emp_data',$data); 
	}

	public function salary($yr,$type=false){ 
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->order_by("emp_data.dt_month2","asc");
		$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_fnyr",$yr);
		$this->db->where("emp_data.dt_type","Salary");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$type);//
		$data['months']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;//
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/salary',$data,true);
		$this->adminlayout(); 
	}

	public function annual_sal_report($yr,$type=false){ 
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->order_by("emp_data.dt_month2","asc");
		$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_fnyr",$yr);
		$this->db->where("emp_data.dt_type","Salary");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$type);//
		$data['months']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;//
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/annual_sal_report',$data,true);
		$this->adminlayout(); 
	}

	public function tds_reports($yr,$q=1){ 
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->order_by("emp_data.dt_month2","asc");
		$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_fnyr",$yr);
		$this->db->where("emp_data.dt_type","Salary");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$type);//
		$year=explode("_",$yr);
		if($_GET['from']){
		$d1=$_GET['from'];
		$d2=$_GET['to'];
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==1){
		$d1=$year[0].'-03-01';
		$d2=$year[0].'-06-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==2){
		$d1=$year[0].'-07-01';
		$d2=$year[0].'-09-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==3){
		$d1=$year[0].'-10-01';
		$d2=$year[0].'-12-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==4){
		$d1=$year[0]+1 .'-01-01';
		$d2=$year[0]+1 .'-02-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}
		$data['months']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;//
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/tds_reports',$data,true);
		$this->adminlayout(); 
	}

	public function plans(){ 
		$data=array();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/plans',$data,true);
		$this->adminlayout(); 
	}
	
	public function ajax_itr_delete(){
		$itr=$this->db->get_where("emp_itr",array("itr_id"=>$_POST['id']))->row();
        $this->db->delete("emp_itr",array("itr_id"=>$_POST['id']));

		$this->db->where("dt_emp_id",$itr->itr_emp);
		$this->db->where("dt_sal_ddo",$this->session->userdata("userid"));
        $this->db->update("emp_data",array("dt_itr"=>""));
        //redirect("/welcome/student");
    }
	public function ajax_plan_delete(){
        $this->db->delete("plan",array("plan_id"=>$_POST['id']));
        //redirect("/welcome/student");
    }
	public function ajax_empd_delete2(){
        $this->db->delete("emp_data",array("dt_type_mon"=>$_POST['id'],"dt_client"=>$this->session->userdata("userid")));
        //redirect("/welcome/student");
    }
	

	public function plan_update (){
	   $plan_desc=implode("|",$_POST['pfeatures']);
	   $this->db->where("plan_id",$_POST['plan_id']);
       $this->db->update('plan',array("plan_name"=>$_POST['plan_name'],"plan_price"=>$_POST['plan_price'],"plan_duration"=>$_POST['plan_duration'],"plan_desc"=>$plan_desc));
       redirect("admin/plans");
    }

	public function ajax_exclude_data(){	
	  $this->db->where("dt_id",$_POST['id']);
	  $this->db->update('emp_data',array("dt_exclude"=>$_POST['v']));
    }

	public function upload_empexcel(){
		$entry=0;
        if (!empty($_FILES['pfile']['tmp_name'])) {
			$fileType = $_FILES['pfile']['type'];
			if($fileType!='text/csv'){
				echo "<h2>Upload Only CSV File</h2>";exit;
			}
            $file = $_FILES['pfile']['tmp_name'];

            // Open CSV file from temporary location
            if (($handle = fopen($file, "r")) !== FALSE) {
                $insert_data = [];
                $row = 0;
				  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if ($row == 0) { 
                        $row++; // Skip the header row
                        continue;
                    }
					$chk=$this->db->get_where("emps",array("emp_code"=>$data[1]));
					if($chk->num_rows()>0){
						$this->db->where("emp_code",$data[1]);
						$this->db->update("emps",array("emp_name"=>$data[2],"emp_email"=>$data[4],"emp_bill"=>$data[5],"emp_pan"=>$data[3],"emp_school"=>$data[7],"emp_desg"=>$data[9],"emp_sankul"=>$data[8],"emp_mob"=>$data[6],"emp_gpf"=>$data[10],"emp_tax"=>$data[11]));
						$entry++;
					}	else	{
						// $empcode= $data[1];
						// $empcodec=strlen($data[1]);
						// if ($empcodec<=10) { 
						// 	//$empcode= '0'.$data[1];
                        // 	$empcode = str_pad($data[1], 11, "0", STR_PAD_LEFT);
                        // }
						$this->db->insert("emps",array("emp_code"=>$data[1],"emp_email"=>$data[4],"emp_bill"=>$data[5],"emp_client"=>$this->session->userdata("userid"),"emp_pan"=>$data[3],"emp_name"=>$data[2],"emp_pan"=>$data[3],"emp_school"=>$data[7],"emp_desg"=>$data[9],"emp_sankul"=>$data[8],"emp_mob"=>$data[6],"emp_gpf"=>$data[10],"emp_tax"=>$data[11]));
						$entry++;
					}
                    
			}

                fclose($handle);
				$msg=$entry. ' Recored Updated/Imported.';
            } else {
                $msg='Error opening file.';
            }
        } else {
            $msg='No file uploaded.';
        }

        redirect('admin/list_employees?msg='.$msg);
    
	}

	public function upload_excel(){
    //echo $this->session->userdata("userid");exit;
    //echo "<pre>";print_r($_POST);exit;	
    $entry=0;
    if (!empty($_FILES['pfile']['tmp_name'])) {
        $file = $_FILES['pfile']['tmp_name'];
        $fileType = $_FILES['pfile']['type'];
        if($fileType!='text/csv'){
            echo "<h2>Upload Only CSV File</h2>";exit;
        }
        // Open CSV file from temporary location
        if (($handle = fopen($file, "r")) !== FALSE) {
            $insert_data = [];
            $row = 0;
            while (($data = fgetcsv($handle, 3000, ",")) !== FALSE) {
                if ($row>0) { 
                    
                    // Remove or comment out the print_r and exit
                    // print_r($data);exit; // <-- THIS IS STOPPING EXECUTION
                    
                    // Example input
                    $date = DateTime::createFromFormat('M-Y', $_POST['dt_month']);
                    $output = $date->format('Y-m').'-01'; // Converts to "02-2025"
                    $empcode = $data[1];
                    // $empcodec = strlen($data[1]);
                    // if ($empcodec <= 10) { 
                    //     $empcode = str_pad($data[1], 11, "0", STR_PAD_LEFT);
                    // }
                    
                    $chk = $this->db->get_where("emps", array("emp_code"=>$empcode));
                    
                    if($_POST['dt_type']=='Salary'){
                        $net_sal = $data[88] - $data[87];
                        if($chk->num_rows()>0){
                            $emp = $chk->row();
                            $lid = $emp->emp_id;
							$pp=explode("-",$_POST['dt_month']);
			// 		if($pp[0]=='Mar'){
			// $this->db->where("emp_id",$lid);
			// $this->db->update("emps",array("emp_client"=>$this->session->userdata("userid")));
			// $this->db->where("dt_emp_id",$lid);
			// $this->db->update("emp_data",array("dt_client"=>$this->session->userdata("userid")));						
			// 		}
                            $chk = $this->db->get_where("emp_data", array("dt_client"=>$this->session->userdata("userid"), "dt_type_mon"=>$_POST['dt_type'].'-'.$_POST['dt_month'], "dt_emp_id"=>$lid));
                            if($chk->num_rows()>0){
                                $dtr = $chk->row();
                                $this->db->where("dt_id", $dtr->dt_id);
                                $this->db->update("emp_data", array(
                                    "dt_bill_no"=>$data[4],
                                    "dt_btr"=>$data[75],
                                    "dt_basic"=>$data[5],
                                    "dt_da"=>$data[41],
                                    "dt_fix_ta"=>$data[40],
                                    "dt_house"=>$data[43],
                                    "dt_city"=>$data[45],
                                    "dt_wash"=>$data[48],
                                    "dt_medical"=>$data[71],
                                    "dt_other"=>$data[59],
                                    "dt_dues"=>$data[88],
                                    "dt_hre_recv"=>$data[14],
                                    "dt_gpf"=>$data[12],
                                    "dt_gpf_recv"=>$data[20],
                                    "dt_fest"=>$data[26],
                                    "dt_gis"=>$data[11],
                                    "dt_tax"=>$data[9],
                                    "dt_ded"=>$data[87],
                                    "dt_water"=>$data[15],
                                    "dt_net_salary"=>$net_sal
                                ));
                            } else {
                                $this->db->insert("emp_data", array(
                                    "dt_client"=>$this->session->userdata("userid"),
                                    "dt_type"=>$_POST['dt_type'],
                                    "dt_fnyr"=>$data[70],"dt_sal_ddo"=>$this->session->userdata("userid"),
                                    "dt_emp_id"=>$lid,
                                    "dt_emp_code"=>$empcode,
                                    "dt_bill_no"=>$data[4],
                                    "dt_btr"=>$data[75],
                                    "dt_basic"=>$data[5],
                                    "dt_da"=>$data[41],
                                    "dt_fix_ta"=>$data[40],
                                    "dt_house"=>$data[43],
                                    "dt_hre_recv"=>$data[14],
                                    "dt_city"=>$data[45],
                                    "dt_wash"=>$data[48],
                                    "dt_medical"=>$data[71],
                                    "dt_other"=>$data[59],
                                    "dt_dues"=>$data[88],
                                    "dt_gpf"=>$data[12],
                                    "dt_gpf_recv"=>$data[21],
                                    "dt_fest"=>$data[26],
                                    "dt_gis"=>$data[11],
                                    "dt_tax"=>$data[9],
                                    "dt_ded"=>$data[87],
                                    "dt_month"=>$_POST['dt_month'],
                                    "dt_net_salary"=>$net_sal,
                                    "dt_type_mon"=>$_POST['dt_type'].'-'.$_POST['dt_month'],
                                    "dt_water"=>$data[15],
                                    "dt_month2"=>$output,
                                    "dt_grp"=>$_POST['dt_type'].'-'.$lid.'-'.$data[70]
                                ));
                                $entry++;
                            }
                        } else {
                            $this->db->insert("emps", array(
                                "emp_name"=>$data[2],
                                "emp_code"=>$empcode,
                                "emp_client"=>$this->session->userdata("userid")
                            ));
                            $lid = $this->db->insert_id();
                            $this->db->insert("emp_data", array(
                                "dt_hre_recv"=>$data[14],
                                "dt_client"=>$this->session->userdata("userid"),
                                "dt_sal_ddo"=>$this->session->userdata("userid"),
                                "dt_type"=>$_POST['dt_type'],
                                "dt_fnyr"=>$_POST['finyr'],
                                "dt_emp_id"=>$lid,
                                "dt_emp_code"=>$empcode,
                                "dt_bill_no"=>$data[4],
                                "dt_btr"=>$data[75],
                                "dt_basic"=>$data[5],
                                "dt_da"=>$data[41],
                                "dt_house"=>$data[43],
                                "dt_city"=>$data[45],
                                "dt_wash"=>$data[48],
                                "dt_medical"=>$data[71],
                                "dt_other"=>$data[59],
                                "dt_dues"=>$data[88],
                                "dt_gpf"=>$data[12],
                                "dt_gpf_recv"=>$data[21],
                                "dt_fest"=>$data[26],
                                "dt_gis"=>$data[11],
                                "dt_tax"=>$data[9],
                                "dt_ded"=>$data[87],
                                "dt_month"=>$_POST['dt_month'],
                                "dt_net_salary"=>$net_sal,
                                "dt_type_mon"=>$_POST['dt_type'].'-'.$_POST['dt_month'],
                                "dt_water"=>$data[15],
                                "dt_month2"=>$output,
                                "dt_grp"=>$_POST['dt_type'].'-'.$lid.'-'.$data[70]
                            ));
                            $entry++;
                        }
                    } else {
                        $net_sal = $data[13] - $data[19];
                        if($chk->num_rows()>0){
                            $emp = $chk->row();
                            $lid = $emp->emp_id;
                            
                            $this->db->insert("emp_data", array(
                                "dt_hre_recv"=>$data[7],
                                "dt_client"=>$this->session->userdata("userid"),
                                "dt_sal_ddo"=>$this->session->userdata("userid"),
                                "dt_type"=>$_POST['dt_type'],
                                "dt_fnyr"=>$_POST['finyr'],
                                "dt_emp_id"=>$lid,
                                "dt_emp_code"=>$empcode,
                                "dt_bill_no"=>$data[3],
                                "dt_btr"=>$data[4],
                                "dt_basic"=>$data[5],
                                "dt_da"=>$data[6],
                                "dt_fix_ta"=>$data[11],
                                "dt_house"=>$data[7],
                                "dt_city"=>$data[8],
                                "dt_wash"=>$data[9],
                                "dt_medical"=>$data[10],
                                "dt_other"=>$data[12],
                                "dt_dues"=>$data[13],
                                "dt_gpf"=>$data[14],
                                "dt_gpf_recv"=>$data[15],
                                "dt_fest"=>$data[16],
                                "dt_gis"=>$data[17],
                                "dt_tax"=>$data[18],
                                "dt_ded"=>$data[19],
                                "dt_month"=>$_POST['dt_month'],
                                "dt_net_salary"=>$net_sal,
                                "dt_type_mon"=>$_POST['dt_type'].'-'.$_POST['dt_month'],
                                "dt_month2"=>$output,
                                "dt_grp"=>$_POST['dt_type'].'-'.$lid.'-'.$data[70]
                            ));
                            $entry++;
                        } else {
                            $this->db->insert("emps", array(
                                "emp_name"=>$data[2],
                                "emp_code"=>$empcode,
                                "emp_client"=>$this->session->userdata("userid")
                            ));
                            $lid = $this->db->insert_id();
                            $this->db->insert("emp_data", array(
                                "dt_hre_recv"=>$data[7],
                                "dt_client"=>$this->session->userdata("userid"),
                                "dt_sal_ddo"=>$this->session->userdata("userid"),
                                "dt_type"=>$_POST['dt_type'],
                                "dt_fnyr"=>$_POST['finyr'],
                                "dt_emp_id"=>$lid,
                                "dt_emp_code"=>$empcode,
                                "dt_bill_no"=>$data[3],
                                "dt_btr"=>$data[4],
                                "dt_basic"=>$data[5],
                                "dt_da"=>$data[6],
                                "dt_fix_ta"=>$data[11],
                                "dt_house"=>$data[7],
                                "dt_city"=>$data[8],
                                "dt_wash"=>$data[9],
                                "dt_medical"=>$data[10],
                                "dt_other"=>$data[12],
                                "dt_dues"=>$data[13],
                                "dt_gpf"=>$data[14],
                                "dt_gpf_recv"=>$data[15],
                                "dt_fest"=>$data[16],
                                "dt_gis"=>$data[17],
                                "dt_tax"=>$data[18],
                                "dt_ded"=>$data[19],
                                "dt_month"=>$_POST['dt_month'],
                                "dt_net_salary"=>$net_sal,
                                "dt_type_mon"=>$_POST['dt_type'].'-'.$_POST['dt_month'],
                                "dt_month2"=>$output,
                                "dt_grp"=>$_POST['dt_type'].'-'.$lid.'-'.$data[70]
                            ));
                            $entry++;
                        }
                    }
					
                }
                $row++; // Increment row counter
            }

            fclose($handle);
            $msg = $entry . ' Records Imported.';
        } else {
            $msg = 'Error opening file.';
        }
    } else {
        $msg = 'No file uploaded.';
    }

    redirect('admin/empdata/'.$_POST['syr'].'?msg='.$msg);
}


















































	public function bankdelete(){
		$this->db->delete("banks",array("bid"=>$_POST['id']));
	}
	public function admin_banking(){
		$this->db->insert("banks",array("bank_name"=>$_POST['bank_name'],"acc_name"=>$_POST['acc_holder'],"acc_number"=>$_POST['acc_no'],"ifsc_code"=>$_POST['ifsc'],"acc_type"=>$_POST['acc_type']));
		redirect("admin/banks");
	}

	public function importdata(){
		$data['records'] = $this->db->order_by('emp_id', 'DESC')->get('emps')->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/import_emp',$data,true);
		$this->adminlayout();
	}

	public function import_data() {
    // Get JSON input from frontend
    $input = json_decode(file_get_contents('php://input'), true);
    echo json_encode($input);exit;//"<pre>";print_r($input);exit;
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
      //  echo $input['fin_year'];exit;
        $mm=explode("/",$input['month_year']);
        $month2=$mm[1].'-'.$mm[0].'-01';
        //echo $month2;exit;
        // Validate required parameters
        if (empty($payroll_type) || empty($month_year) || empty($fin_year)) {
            echo json_encode([
                'success' => false,
                'message' => 'Missing required parameters: payroll_type, month_year, fin_year'
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
            $emp_code = trim($emp['emp_code'] ?? '');
            $emp_name = trim($emp['emp_name'] ?? '');
            $emp_bill = floatval($emp['emp_bill'] ?? 0);

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
            $sal_mon='Salary-'.$sal_mon->format('M-Y'); 
            $net_sal=$dt_dues-$dt_ded;
            $chk = $this->db->get_where("emp_data", array("dt_client"=>$this->session->userdata("userid"), "dt_type_mon"=>$sal_mon, "dt_emp_id"=>$emp_id));
                            if($chk->num_rows()>0){
                                $dtr = $chk->row();
                                $this->db->where("dt_id", $dtr->dt_id);
                                $this->db->update("emp_data", array(
                                    //"dt_bill_no"=>$data[4],
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
                                    "dt_net_salary"=>$net_sal
                                ));
                            } else {
                                $this->db->insert("emp_data", array(
                                    "dt_client"=>$this->session->userdata("userid"),
                                    "dt_type"=>"Salary",
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
                                    "dt_month2"=>$month2,
                                    "dt_grp"=>'Salary-'.$emp_id.'-'.$fin_year
                                ));
                            }
            
        }
        
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


	public function enquiries(){
		$this->db->order_by("id","desc");
		$data['list']=$this->db->get("contact")->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/enquiries',$data,true);
		$this->adminlayout(); 
	}

	public function emp($id){
		//$this->db->order_by("id","desc");
		$data['emp']=$this->db->get_where("emps",array("emp_id"=>$id))->row();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/emp_details',$data,true);
		$this->adminlayout(); 
	}
	
	public function datalist(){
		$data=array();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/empd',$data,true);
		$this->adminlayout(); 
	}
	 
	public function services($id=false){
		if($id==true){
		$data['edit']=$this->db->get_where("services",array("serv_id"=>$id))->row();	
		}
		$data['services']=$this->db->get("services")->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/services',$data,true);
		$this->adminlayout(); 
	}
	public function banks($id=false){
		
		$data=array();//['services']=$this->db->get("services")->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/banks',$data,true);
		$this->adminlayout(); 
	}
	
	public function add_service(){
		$data=array("serv_title"=>$_POST['serv_title'],"serv_sdesc"=>$_POST['serv_sdesc'],"serv_desc"=>$_POST['serv_desc'],"serv_price"=>$_POST['serv_price'],
		"serv_slug"=>str_replace(" ","-",strtolower($_POST['serv_title'])),"serv_tab1"=>$_POST['serv_tab1'],"serv_tab2"=>$_POST['serv_tab2'],"serv_tab3"=>$_POST['serv_tab3']);
		if($this->db->insert("services",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Service Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Service Couldnot be Added.</div>');	}
		redirect("admin/services");
	}
	public function update_service(){
		$data=array("serv_title"=>$_POST['serv_title'],"serv_sdesc"=>$_POST['serv_sdesc'],"serv_tab1"=>$_POST['serv_tab1'],"serv_tab2"=>$_POST['serv_tab2'],"serv_tab3"=>$_POST['serv_tab3'],
		"serv_desc"=>$_POST['serv_desc'],"serv_slug"=>str_replace(" ","-",strtolower($_POST['serv_title'])),"serv_price"=>$_POST['serv_price']);
		$this->db->where("serv_id",$_POST['serv_id']);
		if($this->db->update("services",$data)==true){
		$this->session->set_flashdata('msg', '<div class="alert alert-success">Service Updated Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Service Couldnot be Updated.</div>');	}
		redirect("admin/services");
	}
	
	public function report(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
		
		$this->db->where("leads.lead_status!=","");
		$this->db->order_by("leads.lead_id","desc");
		$data['leads']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/report',$data,true);
		$this->adminlayout();	
    }
	public function followups(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
		$this->db->join("followups","leads.lead_id=followups.lead_id");
		if(isset($_GET['date'])){
		$this->db->where("followups.next_date",$_GET['date']);
		}else{
		$this->db->where("followups.next_date >=",date("Y-m-d"));
		}
		$this->db->where("leads.lead_status","Follow Up");
		$this->db->order_by("leads.lead_id","desc");
		$data['leads']=$this->db->get()->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/followups',$data,true);
		$this->adminlayout();	
	}
	public function post(){
		$query=$this->db->insert("call_alerts",array("call_desc"=>$_POST['message'],"call_time"=>date("H:i a"),"call_date"=>date("Y-m-d")));
			if($query==true){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Call Posted Successfully.</div>');		
			}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Call Couldnot be Posted.</div>');		
			}
			redirect("admin/calls");
	}
	public function calls(){
		$this->db->order_by("call_id","desc");
		$data['calls']=$this->db->get("call_alerts")->result();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/calls',$data,true);
		$this->adminlayout();	
	}
	
	public function oldleads(){
		
			$this->db->select("*");
			$this->db->from("leads");
			$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
			//$this->db->limit($_POST['limit']);
			$this->db->where("leads.lead_status!=","");	
			$this->db->where("leads.lead_status!=","Follow Up");	
			$this->db->order_by("leads.lead_id","desc");
		//}
		$this->db->where("leads.is_converted","");
		//this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$data['leads']=$this->db->get()->result();
		
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/oldleads',$data,true);
		$this->adminlayout();
	}
	
	
	public function index()
	{
		$data=array();
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/dashboard',$data,true);
		$this->adminlayout();
	}	
	
	public function newlead_update(){
		if($this->db->get_where("leads",array("contact_phone1"=>$_POST['mobile'],"lead_id!="=>$_POST['lead_id']))->num_rows()>0){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Mobile Already registered.</div>');
			redirect("admin/list_leads");		
		}else{
			$this->db->where("lead_id",$_POST['lead_id']);
			$query=$this->db->update("leads",array("contact_phone1"=>$_POST['mobile'],"lead_date"=>date("Y-m-d"),"contact_person"=>$_POST['name'],
			"lead_src"=>$_POST['lead_src'],"lead_remark"=>$_POST['lead_remark'],"email"=>$_POST['email'],"lead_type"=>$_POST['lead_type'],"lead_emp"=>$_POST['state']));
			if($query==true){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Updated Successfully.</div>');		
			}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Lead Couldnot be Updated.</div>');		
			}
			redirect("admin/list_leads");
		}
	}
	public function newlead_submit(){
		if($this->db->get_where("leads",array("contact_phone1"=>$_POST['mobile']))->num_rows()>0){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Mobile Already registered.</div>');
			redirect("admin/list_leads");		
		}else{
			//echo "<pre>";print_r($_POST);exit;	
			$query=$this->db->insert("leads",array("lead_type"=>$_POST['lead_type'],"contact_phone1"=>$_POST['mobile'],"lead_date"=>date("Y-m-d"),"contact_person"=>$_POST['name'],
			"lead_src"=>$_POST['lead_src'],"lead_remark"=>$_POST['lead_remark'],"email"=>$_POST['email'],"lead_emp"=>$_POST['state']));
			if($query==true){
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Added Successfully.</div>');		
			}else{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">Lead Couldnot be Added.</div>');		
			}
			redirect("admin/list_leads");
		}
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
	
	public function contract_payment_history(){
		$data['cont']=$this->db->get_where("leads",array("lead_id"=>$_POST['id']))->row();
		$this->db->order_by("payid","desc");
		$data['payment']=$this->db->get_where("cpayments",array("contid"=>$_POST['id']))->result();
		$this->db->order_by("payid","desc");
		$data['total_paid']=$this->db->get_where("cpayments",array("contid"=>$_POST['id']))->row();
		$this->load->view("admin/contract_payment_history",$data);
	}
	
	public function ajax_add_paymemt(){
		parse_str($_POST['formdata'],$form);
		$this->db->order_by("payid","desc");
		$pre=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->row();
		$new_pay=$form['paid_amt']+$pre->total_paid;
		if($this->db->insert("cpayments",array("contid"=>$form['contid'],"paid_amt"=>$form['paid_amt'],"total_paid"=>$new_pay,"paid_date"=>$form['paid_date'],
		"pay_mode"=>$form['pay_mode'],"trans_id"=>$form['trans_id'],"pay_remarks"=>$form['pay_remarks'],"pdate"=>date("Y-m-d"),"bank_name"=>$form['bank_name']))==true){
			$data['cont']=$this->db->get_where("contracts",array("cont_id"=>$form['contid']))->row();
			$this->db->order_by("payid","desc");
			$data['payment']=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->result();
			$this->db->order_by("payid","desc");
			$data['total_paid']=$this->db->get_where("cpayments",array("contid"=>$form['contid']))->row();
			$this->load->view("admin/contract_payment_history",$data);
			}else{echo 0;}
		
	}
	
	public function contracts(){
		$this->db->select("*");
		$this->db->from("leads");
		$this->db->join("employees","leads.lead_emp=employees.emp_id","left");
			//$this->db->limit($_POST['limit']);
			//$this->db->where("leads.lead_status!=","");	
		$this->db->where("leads.is_converted","yes");	
		$this->db->order_by("leads.lead_id","desc");  
		//}
		//$this->db->where("leads.lead_emp",$this->session->userdata("user"));
		$data['contracts']=$this->db->get()->result();		//print_r($data);exit;
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

	
	
	public function ajax_empd_delete(){
		$this->db->delete("emp_data",array("dt_id"=>$_POST['id']));
	}
	public function ajax_enq_delete(){
		$this->db->delete("contact",array("id"=>$_POST['id']));
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

	public function ajax_submit_edit(){
		parse_str($_POST['formdata'],$form);
		//echo "<pre>";print_r($form);exit;
		$dt = $this->db->get_where("emp_data", array("dt_id" => $form['dt_id']))->row();
$date = DateTime::createFromFormat('M-Y', $dt->dt_month);
$output = $date->format('Y-m') . '-01';
//echo $output;exit;
$dt_grp=$dt->dt_type.'-'.$dt->dt_emp_id.'-'.$dt->dt_fnyr;
$form = array_merge($form, array("dt_month2" => $output,"dt_grp"=>$dt_grp));
		//echo "<pre>";print_r($form);exit;
	    $this->db->where("dt_id",$form['dt_id']);
		if($this->db->update("emp_data",$form)==true){
          echo 0;
		}else{
			echo "Data Couldnot be Updated";
	    }
	}

	public function ajax_chk_ddo(){
		$ddo=$this->db->get_where("clients",array("ddo_num"=>$_POST['code']));
		if($ddo->num_rows()>0){
			$ddo=$ddo->row();
			echo $ddo->ddo_num;
		}else{
			echo 0;
		}
	}

	public function ajax_chk_ddo2(){
		$ddo=$this->db->get_where("clients",array("ddo_num"=>$_POST['code']));
		if($ddo->num_rows()>0 && $_POST['code']!=$this->session->userdata("ddo_num")){
			$ddo=$ddo->row();
			echo $ddo->ddo_name;
		}else{
			echo 0;
		}
	}

	public function ajax_submit_add(){
		parse_str($_POST['formdata'],$form);
		//echo "<pre>";print_r($form);exit;
	    //$this->db->where("dt_id",$form['dt_id']);
		$date = DateTime::createFromFormat('M-Y', $form['dt_month']);
    	$output = $date->format('Y-m').'-01';

	//	$ddo=$this->db->get_where("clients",array(""))
	
$dt_grp=$form['dt_type'].'-'.$form['dt_emp_id'].'-'.$form['dt_fnyr'];
$form = array_merge($form, array("dt_month2" => $output,"dt_grp"=>$dt_grp));
	//	echo "<pre>";print_r($form);exit;
		$chk2=$this->db->get_where("emp_data",array("dt_emp_id"=>$form['dt_emp_id'],"dt_type"=>$form['dt_type'],"dt_month"=>$form['dt_month']));
		if($chk2->num_rows()>0 && $form['dt_type']=='Salary'){
           $this->db->where("dt_emp_id",$form['dt_emp_id']);
           $this->db->where("dt_type_mon",$form['dt_type'].'-'.$form['dt_month']);
		   $this->db->update("emp_data",$form);
		   echo 1;
		}else if($this->db->insert("emp_data",$form)==true){
          echo 1;
		}else{
			echo "Data Couldnot be Added";
	    }
	}

	public function change_month(){
		$cur=$_POST['id'];//echo $cur;exit;
		$data['hlist']=$this->db->get_where("holidays",array("hmonth"=>$cur))->result();
		$this->load->view("admin/change_month",$data);
	}


	public function ajax_edit_emp_data(){
		$data['edit']=$this->db->get_where("emp_data",array("dt_id"=>$_POST['id']))->row();
		$this->load->view("admin/emp_data_edit",$data);
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

	
	public function empdata($yr){
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("dt_fnyr",str_replace("-","_",$yr));
		$this->db->where("dt_type","Salary");
		$this->db->where("dt_client",$this->session->userdata("userid"));
		$this->db->group_by("dt_type_mon");
		$this->db->order_by("dt_month2","asc");
		$data['salary']=$this->db->get()->result();

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("dt_fnyr",str_replace("-","_",$yr));
		$this->db->where("dt_type","Arear");
		$this->db->where("dt_client",$this->session->userdata("userid"));
		$this->db->group_by("dt_type_mon");
		$this->db->order_by("dt_month2","asc");
		$data['arear']=$this->db->get()->result();

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("dt_fnyr",str_replace("-","_",$yr));
		$this->db->where("dt_type","PayArear");
		$this->db->where("dt_client",$this->session->userdata("userid"));
		$this->db->group_by("dt_type_mon");
		$this->db->order_by("dt_month2","asc");
		$data['parear']=$this->db->get()->result();

		$this->template['middle'] = $this->load->view ($this->middle = 'admin/emp_data',$data,true);
		$this->adminlayout();	
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
	
	public function ajax_emp_list(){
		$this->db->select("*");
		$this->db->from("emps");
		$this->db->join("clients","clients.client_id=emps.emp_client","left");
		if($this->session->userdata("type")=='client'){
			$this->db->where("emps.emp_client",$this->session->userdata("userid"));
		}
		if($_POST['name']){	
			$this->db->group_start();
			$this->db->like("emps.emp_code",$_POST['name']);
			$this->db->or_like("emps.emp_name",$_POST['name']);
		    $this->db->or_like("emps.emp_mob",$_POST['name']);
			$this->db->group_end();
		}
		$this->db->limit(10,$_POST['limit']);
		$this->db->order_by("emps.emp_id","desc");
		$data['comps']=$this->db->get()->result();	
		$data['num']=$_POST['limit'];
		//echo "<pre>";print_r($data);
		//$this->db->order_by("emp_id","desc");
		//$data['comps']=$this->db->get("employees")->result();
	    //print_r($data);exit;
		$this->load->view("admin/ajax/list_emps",$data);
	}

	public function ajax_oldemp_list(){
		$this->db->select("*");
		$this->db->from("emp_history");
		$this->db->join("emps","emps.emp_id=emp_history.emp_old");
		$this->db->where("emp_history.emp_hddo1",$this->session->userdata("userid"));
		//$this->db->join("clients","clients.client_id=emps.emp_client","left");
		//if($this->session->userdata("type")=='client'){
			//$this->db->where("emps.emp_client",$this->session->userdata("userid"));
		//}
		if($_POST['name']){			
			$this->db->group_start();
			$this->db->like("emps.emp_code",$_POST['name']);
			$this->db->or_like("emps.emp_name",$_POST['name']);
		    $this->db->or_like("emps.emp_mob",$_POST['name']);
			$this->db->group_end();
		}
		$this->db->limit(10,$_POST['limit']);
		$this->db->order_by("emps.emp_id","desc");
		$data['comps']=$this->db->get()->result();	
		$data['num']=$_POST['limit'];
		//echo "<pre>";print_r($data);
		//$this->db->order_by("emp_id","desc");
		//$data['comps']=$this->db->get("employees")->result();
	    //print_r($data);exit;
		$this->load->view("admin/ajax/oldlist_emps",$data);
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
		$this->db->from("clients");
		//$this->db->join("companies","companies.comp_id=branches.comp_id");
		///$this->db->join("state_list","branches.br_state=state_list.state_id");
		if($_POST['name']){
			
			$this->db->group_start();
			$this->db->like("clients.ddo_name",$_POST['name']);
			$this->db->or_like("clients.ddo_num",$_POST['name']);
			$this->db->group_end();
		}
		$this->db->order_by("client_id","desc");
		$data['brs']=$this->db->get()->result();
		//print_r($data);exit;
		$this->load->view("admin/ajax/branches_list",$data);
	}

	public function delete_all_emp(){
		$this->db->delete("emps",array("emp_client"=>$this->session->userdata("userid")));
		$this->db->delete("emp_data",array("dt_client"=>$this->session->userdata("userid")));
		$this->db->delete("emp_itr",array("itr_client"=>$this->session->userdata("userid")));
		//$this->db->delete("emp_itr",array("itr_client"=>$this->session->userdata("userid")));
		redirect("admin/list_employees");
	}
	
	public function ajax_emp_delete(){
		$this->db->delete("emps",array("emp_id"=>$_POST['id']));
		$this->db->delete("emp_data",array("dt_emp_id"=>$_POST['id']));
		$this->db->delete("emp_itr",array("itr_emp"=>$_POST['id']));
		$this->db->delete("emp_history",array("emp_code"=>$_POST['code']));
	}
	public function ajax_del_lead(){
		$this->db->delete("leads",array("lead_id"=>$_POST['id']));
		$this->db->delete("followups",array("lead_id"=>$_POST['id']));
	}
	public function ajax_leaves_delete(){
		$this->db->delete("leaves",array("leave_id"=>$_POST['id']));
	}
	public function ajax_branch_delete(){
		$this->db->delete("clients",array("client_id"=>$_POST['id']));
		$this->db->delete("emps",array("emp_client"=>$_POST['id']));
		$this->db->delete("emp_data",array("dt_client"=>$_POST['id']));
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
			$this->db->from("clients");
			//$this->db->join("state_list","branches.br_state=state_list.state_id");
			$this->db->where("client_id",$brid);
			$data['edit']=$this->db->get()->row();
		}else{
		$data=array();//['states']=$this->db->get("state_list")->result();
	    }
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/branches',$data,true);
		$this->adminlayout();
	}
	
	public function add_branch(){
		if($this->db->insert("clients",$_POST)==$true){
			 $this->session->set_flashdata('msg', '<div class="alert alert-success">Client Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Client Couldnot be Added.</div>');	}
		redirect("admin/branches");
	}    
	public function update_branch2(){
	 $ddo_sign=$_POST['oldddo_sign'];
	 if(!empty($_FILES["ddo_sign"]["name"])){
		$config['upload_path'] = './assets/images/signs/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
		$config['max_size']	= '1000000';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('ddo_sign'))
		{
		echo $this->upload->display_errors();
		}
		else
		{	
		$pic = $this->upload->data();
		$ddo_sign=$pic['file_name'];
		}
	 } 
	 $ddo_img=$_POST['oldddo_img'];
	 if(!empty($_FILES["ddo_img"]["name"])){
		$config['upload_path'] = './assets/images/signs/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
		$config['max_size']	= '1000000';
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('ddo_img'))
		{
		echo $this->upload->display_errors();
		}
		else
		{	
		$pic = $this->upload->data();
		$ddo_img=$pic['file_name'];
		}
	 } 
	 $this->session->set_userdata("img",$ddo_img);
	 $this->db->where("client_id",$_POST['client_id']);
	 $this->db->update("clients",array("ddo_name"=>$_POST['ddo_name'],"clerk_name"=>$_POST['clerk_name'],"ddo_img"=>$ddo_img,"ddo_sign"=>$ddo_sign,"ddo_num"=>$_POST['ddo_num'],"tan_num"=>$_POST['tan_num'],"client_mob"=>$_POST['client_mob'],"client_email"=>$_POST['client_email'],"cemp_name"=>$_POST['cemp_name'],"cemp_pan"=>$_POST['cemp_pan'],"clerk_mob"=>$_POST['clerk_mob'],"cemp_dob"=>$_POST['cemp_dob']));
	 redirect("admin/profile");
    } 
	
	public function update_branch(){
		$this->db->where("client_id",$_POST['client_id']);
		if($this->db->update("clients",$_POST)==true){
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
	
  public function in_calling(){
	$this->db->where("emp_id",$_POST['id']);
	$this->db->update("employees",array("emp_call"=>$_POST['v']));  
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
		$data=array("job_desc"=>$_POST['job_desc'],"pan_number"=>$_POST['pan_number'],"aadhar_number"=>$_POST['aadhar_number'],
		"branch_id"=>$_POST['branch_id'],"firstname"=>$_POST['firstname'],"lastname"=>$_POST['lastname'],
		"father"=>$_POST['father'],"gender"=>$_POST['gender'],"dob"=>$_POST['dob'],"marital"=>$_POST['marital'],
		"profile_photo"=>$profile_photo,"emp_added_date"=>date("Y-m-d"),"emp_email"=>$_POST['emp_email'],"emp_password"=>md5($_POST['emp_password']),
		"emp_added_date"=>date("Y-m-d"),"mob1"=>$_POST['mob1'],"mob2"=>$_POST['mob2']);
		
		
		
		if($this->db->insert("employees",$data)==true){
			$lid=$this->db->insert_id();
			foreach($_POST['des'] as $d){
				$this->db->insert("emp_des",array("emp_id"=>$lid,"des_id"=>$d));
			}
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Details Added Successfully.</div>');	
		}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Employee Details Couldnot be Added.</div>');	}
		redirect("admin/list_employees");	
	}

	public function ajax_trns_form(){
		parse_str($_POST['formdata'],$form);
		//echo "<pre>";print_r($form);exit;
		//echo $form['ddo_num'];exit;
		$chk=$this->db->get_where("clients",array("ddo_num"=>$form['ddo']));
		if($chk->num_rows()>0){
			$ddo=$chk->row();		
		//$this->db->delete("emp_history",aarray("emp_hddo1"=>$this->session->userdata("userid"),"emp_hddo2"=>$ddo->client_id,"emp_code"=>$form['emp_code']));
		if($this->db->get_where("emp_history",array("emp_hddo1"=>$this->session->userdata("userid"),"emp_hddo2"=>$ddo->client_id,"emp_code"=>$form['emp_code']))->num_rows()==0){
		$this->db->insert("emp_history",array("emp_old"=>$form['emp_id'],"emp_hddo1"=>$this->session->userdata("userid"),"emp_hddo2"=>$ddo->client_id,"emp_code"=>$form['emp_code'],"emp_hdate"=>date("Y-m-d")));
			
			$this->db->where("emp_id",$form['emp_id']);
			$this->db->update("emps",array("emp_client"=>$ddo->client_id));
			
			$this->db->where("dt_emp_id",$form['emp_id']);
			$this->db->update("emp_data",array("dt_client"=>$ddo->client_id));
			
			//$this->db->where("itr_emp",$form['emp_id']);
			//$this->db->update("emp_itr",array("itr_client"=>$ddo->client_id));

			echo "Transfer Successful";
		}else{
			echo "Already Transferred";
		}
		}else{
			echo "DDO Number Invalid";
		}
	}


	public function add_emp(){
		$chk=$this->db->get_where("emps",array("emp_code"=>$_POST['emp_code']));
			if($chk->num_rows()==0){
				$chk=$this->db->insert("emps",$_POST);
				//$lid=$this->db->insert_id();
		 		$msg='Employee Added Successfully';	
			}else{$msg='Employee Couldnot be Added';}
			redirect("admin/list_employees?msg=".$msg);	
	}

	public function update_emp(){
		//$chk=$this->db->get_where("emps",array("emp_code"=>$_POST['emp_code']));
			//if($chk->num_rows()==0){
				$this->db->where("emp_id",$_POST['emp_id']);
				$chk=$this->db->update("emps",$_POST);
		 $this->session->set_flashdata('msg', '<div class="alert alert-success">Employee Added Successfully.</div>');	
		//}else{$this->session->set_flashdata('msg', '<div class="alert alert-danger">Employee Couldnot be Added.</div>');	}
		redirect("admin/list_employees");	
	}
	
	public function ajax_lead_dmodal(){
		$data['unlead']=$this->db->get_where("leads",array("lead_emp"=>""))->num_rows();
		$this->load->view("admin/ajax/lead_dist",$data);
	}
	
	public function dist_form_submit(){
		parse_str($_POST['formdata'],$form);
		//echo "<pre>";print_r($form);exit;
		$i=0;$tot=0;$offset=0;
		foreach($form['data'] as $val){
			if($val!=''){
			$tot=$tot+$val;
			$offset=$tot-$val;
			//echo $val.'-'.$offset.'<br/>';
			//print_r($val);
			$d=explode("-",$val);	
			$this->db->select("*");
			$this->db->from("leads");
			$this->db->where("lead_emp","");
			$this->db->limit($val,$offset);
			//$this->db->offset($offset);
			$this->db->order_by("lead_id","desc");
			$ldd=$this->db->get();
			
			$ld=$ldd->result();
			//echo "<pre>";print_r($ld);
			foreach($ld as $l){
		//echo $form['emps'][$i].'-'.$l->lead_id.'<br/>';
				//echo $l->contact_phone1.'-'.$form['emps'][$i].'<br/>';
				//$lll=$this->db->get_where("leads",array("lead_id"=>$l->lead_id))->row();
		//echo $l->lead_id.'<br/>';
				$this->db->where("lead_id",$l->lead_id);
				$this->db->update("leads",array("lead_emp"=>$form['emps'][$i]));
				
			}//echo '<hr/>';
			
			//$start=$val;			
			//$start=$val;//-$tot;
			//echo $limit.' - '.$start.'<br/>';
			$i++;}
		}
		echo $tot.' Total Leads Assigned';
	}
	
	public function upload_lead_excel(){
			//print_r($_POST);exit;
			$file = $_FILES['excel']['tmp_name'];
			$handle = fopen($file, "r");
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				
				if($filesop[0]!="S.No.")
				{
			$data=array("lead_date"=>date("Y-m-d"),"contact_person"=>$filesop[2],"contact_phone1"=>$filesop[4],"contact_phone2"=>$filesop[5],
			"lead_src"=>$filesop[1],"email"=>$filesop[3],"lead_remark"=>$filesop[6],"lead_type"=>$_POST['lead_type']);
			$this->db->insert("leads",$data);
					}
			}
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Lead Data Imported Successfully.</div>');
			redirect("admin/list_leads");
	}

	
	public function ajax_emp_data_list(){	
		//echo "<pre>";print_r($_POST);exit;	
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("emps","emps.emp_id=emp_data.dt_emp_id");
		$this->db->where("emp_data.dt_type_mon",$_POST['month']);
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		$this->db->order_by("emp_data.dt_bill_no","asc");
		if($_POST['name']){			
			$this->db->group_start();
			$this->db->like("emps.emp_code",$_POST['name']);
			$this->db->or_like("emps.emp_name",$_POST['name']);
		    $this->db->or_like("emps.emp_mob",$_POST['name']);
			$this->db->group_end();
		}
		$this->db->limit(10,$_POST['limit']);
		$data['list']=$this->db->get()->result();
		$data['num']=$_POST['limit'];
		//echo "<pre>";printajax_emp_sdata_list
		// _r($data);exit;
		$this->load->view("admin/ajax_emp_data_list",$data);
	}

	public function ajax_load_emp_data(){
		//echo "<pre>";print_r($_POST);exit;
		$data['empd']=$this->db->get_where("emp_data",array("dt_id"=>$_POST['id'],"dt_type"=>$_POST['dt_type']))->row();
		///echo "<pre>";print_r($data);exit;
		$this->load->view("admin/ajax_load_emp_data",$data);
	}	

	public function ajax_load_tax(){
		$m=explode("-",$_POST['id']);
		$data['empd']=$this->db->get_where("emps",array("emp_id"=>$m[0]))->row();
		//
		$data['fnyr']=$m[1];
		//echo "<pre>";print_r($data);exit;
		$this->load->view("admin/tax_calc",$data);
	}	
	
	public function ajax_emp_sdata_list(){
	//	echo "<pre>";print_r($_POST);exit;
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("emps","emps.emp_id=emp_data.dt_emp_id");
		$this->db->where("emp_data.dt_fnyr",$_POST['yr']);
		$this->db->order_by("emp_data.dt_id","desc");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$_POST['type']);
		$this->db->group_by("emp_data.dt_emp_id");

		if($_POST['name']){			
			$this->db->group_start();
			$this->db->like("emps.emp_code",$_POST['name']);
			$this->db->or_like("emps.emp_name",$_POST['name']);
		    $this->db->or_like("emps.emp_mob",$_POST['name']);
			$this->db->group_end();
		}

		$this->db->limit(10,$_POST['limit']);
		$data['list']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_type","Salary");
		//$this->db->where("emp_data.dt_type",$_POST['type']);
		//$this->db->like("emp_data.dt_type_mon",$year);
		$this->db->order_by("emp_data.dt_month2","asc");
		$data['months']=$this->db->get()->result();
		$data['num']=$_POST['limit'];
		$this->load->view("admin/ajax_emp_sdata_list",$data);
	}


public function testemp(){
$empdata=$this->db->get("emp_data")->result();
foreach($empdata as $emp){
$this->db->where("dt_id",$emp->dt_id);
$this->db->update("emp_data",array("dt_grp"=>$emp->dt_type.'-'.$emp->dt_emp_id.'-'.$emp->dt_fnyr));
}
}




public function export_itr($yr,$qtr=false){
	
	
		$year=explode("_",$yr);
	//	echo "<pre>";print_r($_POST);exit;
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("emps","emps.emp_id=emp_data.dt_emp_id");
		$this->db->where("emp_data.dt_fnyr",$yr);
		$this->db->where("emp_data.dt_bill_no!=","");
		//$this->db->order_by("emp_data.dt_id","desc");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$_POST['type']);

		if($_GET['from']){
		$d1=$_GET['from'];//$year[0].'-'.$_GET['from'].'-01';
		$d2=$_GET['to'];//$year[0].'-'.$_GET['to'].'-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		$qtr="";
		}else if($qtr==1){
		$d1=$year[0].'-03-01';
		$d2=$year[0].'-06-01';
		$data['title']="Quarterly Report for Financial Year ".str_replace("_","-",$yr);
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==2){
		$d1=$year[0].'-07-01';
		$d2=$year[0].'-09-01';
		$data['title']="Quarterly Report for Financial Year ".str_replace("_","-",$yr);
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==3){
		$d1=$year[0].'-10-01';
		$d2=$year[0].'-12-01';
		$data['title']="Quarterly Report for Financial Year ".str_replace("_","-",$yr);
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==4){
		$d1=$year[0]+1 .'-01-01';
		$d2=$year[0]+1 .'-02-01';
		$data['title']="Quarterly Report for Financial Year ".str_replace("_","-",$yr);
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}
		//$this->db->group_by('emp_data.dt_grp');
		$this->db->group_by('emp_data.dt_emp_id, emp_data.dt_type');
		//$this->db->group_by("emp_data.dt_type");
		//$this->db->group_by("emp_data.dt_emp_id");

		
		//$this->db->limit(10,$_POST['limit']);
		$this->db->order_by("emp_data.dt_type","desc");
		$data['list']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_bill_no!=","");
		///$this->db->where("emp_data.dt_type","Salary");
		//$this->db->where("emp_data.dt_type",$_POST['type']);
		//$this->db->like("emp_data.dt_type_mon",$year);
		if($_GET['from']){
		$d1=$_GET['from'];//$year[0].'-'.$_GET['from'].'-01';
		$d2=$_GET['to'];//$year[0].'-'.$_GET['to'].'-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==1){
		$d1=$year[0].'-03-01';
		$d2=$year[0].'-06-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==2){
		$d1=$year[0].'-07-01';
		$d2=$year[0].'-09-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==3){
		$d1=$year[0].'-10-01';
		$d2=$year[0].'-12-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($qtr==4){
		$d1=$year[0]+1 .'-01-01';
		$d2=$year[0]+1 .'-02-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}
		
		$this->db->order_by("emp_data.dt_month2","asc");
		$this->db->group_by("emp_data.dt_month");
		$data['months']=$this->db->get()->result();

		$ddo=$this->db->get_where("clients",array("client_id"=>$this->session->userdata("userid")))->row();
		$data['title']="TDS Report_Q".$qtr."_FY_".str_replace("_","-",$yr)."_".$ddo->ddo_name."_".$ddo->ddo_num."_".$ddo->tan_num;

		$this->load->view("admin/ajax_emp_tds_report_excel",$data);
	}


public function ajax_emp_tds_report(){
		
		$q=$_POST['qtr'];
		$year=explode("_",$_POST['yr']);
		//echo "<pre>";print_r($_POST);exit;
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("emps","emps.emp_id=emp_data.dt_emp_id");
		$this->db->where("emp_data.dt_fnyr",$_POST['yr']);
		$this->db->where("emp_data.dt_bill_no!=","");
		//$this->db->order_by("emp_data.dt_id","desc");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->where("emp_data.dt_type",$_POST['type']);
		if($_POST['typ']=='f'){
		$dd=explode("|",$q);
		$d1=$dd[0];//.'-01';
		$d2=$dd[1];//.'-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else
		if($q==1){
		$d1=$year[0].'-03-01';
		$d2=$year[0].'-06-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==2){
		$d1=$year[0].'-07-01';
		$d2=$year[0].'-09-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==3){
		$d1=$year[0].'-10-01';
		$d2=$year[0].'-12-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==4){
		$d1=$year[0]+1 .'-01-01';
		$d2=$year[0]+1 .'-02-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}
		$this->db->group_by('emp_data.dt_emp_id, emp_data.dt_type');

		if($_POST['name']){			
			$this->db->group_start();
			$this->db->like("emps.emp_code",$_POST['name']);
			$this->db->or_like("emps.emp_name",$_POST['name']);
		    $this->db->or_like("emps.emp_mob",$_POST['name']);
			$this->db->group_end();
		}

		$this->db->limit(10,$_POST['limit']);
		$this->db->order_by("emp_data.dt_emp_code","asc");
		$data['list']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		//$this->db->group_by("emp_data.dt_type_mon");
		$this->db->where("emp_data.dt_bill_no!=","");
		///$this->db->where("emp_data.dt_type","Salary");
		//$this->db->where("emp_data.dt_type",$_POST['type']);
		//$this->db->like("emp_data.dt_type_mon",$year);
		if($_POST['typ']=='f'){
		$dd=explode("|",$q);
		$d1=$dd[0];//.'-01';
		$d2=$dd[1];
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==1){
		$d1=$year[0].'-03-01';
		$d2=$year[0].'-06-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==2){
		$d1=$year[0].'-07-01';
		$d2=$year[0].'-09-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==3){
		$d1=$year[0].'-10-01';
		$d2=$year[0].'-12-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}else if($q==4){
		$d1=$year[0]+1 .'-01-01';
		$d2=$year[0]+1 .'-02-01';
		$this->db->where("emp_data.dt_month2>=",$d1);
		$this->db->where("emp_data.dt_month2<=",$d2);
		}
		
		$this->db->group_by("emp_data.dt_month");
		$this->db->order_by("emp_data.dt_month2","asc");
		$data['months']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;
		$data['num']=$_POST['limit'];
		$this->load->view("admin/ajax_emp_tds_report",$data);
	}








	public function ajax_search_name(){
		//echo "<pre>";print_r($_POST);exit;
		
		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->join("emps","emps.emp_id=emp_data.dt_emp_id");
		$this->db->where("emp_data.dt_fnyr",$_POST['yr']);
		$this->db->order_by("emp_data.dt_id","desc");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		$this->db->group_by("emp_data.dt_emp_id");
		 $this->db->group_start();
		 $this->db->like("emp_data.dt_emp_code",$_POST['name']);
		 $this->db->or_like("emps.emp_name",$_POST['name']);
		// $this->db->or_like("emps.emp_mob",$_POST['name']);
		$this->db->group_end();
		$this->db->limit(10);
		$data['list']=$this->db->get()->result();
	//	echo "<pre>";print_r($data);exit;

		$this->db->select("*");
		$this->db->from("emp_data");
		$this->db->order_by("emp_data.dt_id","asc");
		$this->db->where("emp_data.dt_client",$this->session->userdata("userid"));
		$this->db->group_by("emp_data.dt_type_mon");
		
		$data['months']=$this->db->get()->result();
		//echo "<pre>";print_r($data);exit;
		$this->load->view("admin/ajax_emp_sdata_list",$data);
	}


	public function ajax_lead_list(){
		$this->db->select("*");
		$this->db->from("leads");
		//$this->db->join("state_list","leads.stateid=state_list.state_id","left");
		//
		$this->db->join("employees","employees.emp_id=leads.lead_emp","left");
		//}
		if($_POST['assign']==""){
		$this->db->where("leads.lead_emp","");	
		}
		
		$this->db->order_by("leads.lead_id","desc");
		//$this->db->limit($_POST['limit']);
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
	
	public function ajax_update_emp(){
		$ids=explode("-",$_POST['id']);
		$this->db->where("emp_code",$ids[1]);
		$this->db->update("emps",array("emp_status"=>$_POST['st']));
		$this->db->where("dt_id",$ids[0]);
		$this->db->update("emp_data",array("dt_status"=>$_POST['st']));	
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
	public function change_pass_client(){
		//echo "<pre>";print_r($_POST);exit;	
		if($_POST['pass']!=$_POST['cpass']){

			echo "Your Both Password must match and atleast of 6 characters.";

		}else{

		$this->db->where("client_id",$_POST['id']);	

		$this->db->update("clients",array("cemp_pass"=>md5($_POST['pass'])));

		echo "Password changed successfully.";

		}

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
		
		$this->load->view('admin/lead_details',$data);
	}
	
	
	
	
	public function list_employees(){
		//echo "Under Construction";exit;
		
		$data=array();//$this->db->get()->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/list_employees',$data,true);
		$this->adminlayout();
	}

	public function old_employees(){
		$data=array();//$this->db->get()->result();	
		$this->template['middle'] = $this->load->view ($this->middle = 'admin/prev_emps',$data,true);
		$this->adminlayout();
	}
}
