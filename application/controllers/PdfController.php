<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Suppress deprecation warnings for TCPDF
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

class PdfController extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->helper('file');
        
        // Load TCPDF with error suppression
        $old_error_reporting = error_reporting();
        error_reporting($old_error_reporting & ~E_DEPRECATED & ~E_USER_DEPRECATED);
        
        require_once(APPPATH . 'libraries/tcpdf/tcpdf.php');
        
        // Restore error reporting
        error_reporting($old_error_reporting);
        
        // Create upload directory
        $upload_dir = FCPATH . 'uploads/pdfs/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
    }
    
    public function index() {
        $this->load->view('pdf_unlocker');
    }
    
    public function unlock_pdf() {
        header('Content-Type: application/json');
        
        // Check if file uploaded
        if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] != 0) {
            echo json_encode([
                'success' => false,
                'message' => 'Please select a PDF file to upload'
            ]);
            return;
        }
        
        // Validate file type
        $file_info = pathinfo($_FILES['pdf_file']['name']);
        $extension = strtolower($file_info['extension']);
        
        if ($extension != 'pdf') {
            echo json_encode([
                'success' => false,
                'message' => 'Only PDF files are allowed'
            ]);
            return;
        }
        
        $password = $this->input->post('password');
        
        if (empty($password)) {
            echo json_encode([
                'success' => false,
                'message' => 'Please enter the PDF password'
            ]);
            return;
        }
        
        // Generate unique filenames
        $upload_dir = FCPATH . 'uploads/pdfs/';
        $original_name = $_FILES['pdf_file']['name'];
        $unique_id = uniqid();
        $input_path = $upload_dir . $unique_id . '_' . basename($original_name);
        $output_filename = 'unlocked_' . $unique_id . '_' . basename($original_name);
        $output_path = $upload_dir . $output_filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['pdf_file']['tmp_name'], $input_path)) {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to upload file'
            ]);
            return;
        }
        
        try {
            // Try multiple methods to unlock
            $result = false;
            
            // Method 1: Try using QPDF (best method)
            $result = $this->unlock_with_qpdf($input_path, $password, $output_path);
            
            // Method 2: If QPDF fails, try Ghostscript
            if (!$result) {
                $result = $this->unlock_with_ghostscript($input_path, $password, $output_path);
            }
            
            // Method 3: Try using TCPDF
            if (!$result) {
                $result = $this->unlock_with_tcpdf($input_path, $password, $output_path);
            }
            
            // Method 4: Manual PDF processing (for simple PDFs)
            if (!$result) {
                $result = $this->unlock_pdf_manual($input_path, $password, $output_path);
            }
            
            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'PDF unlocked successfully!',
                    'download_url' => base_url('index.php/pdfcontroller/download/' . $output_filename),
                    'filename' => 'unlocked_' . $original_name,
                    'filesize' => $this->format_file_size(filesize($output_path))
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Failed to unlock PDF. Please check the password or try a different method.'
                ]);
            }
            
            // Clean up input file
            if (file_exists($input_path)) {
                @unlink($input_path);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
            
            if (file_exists($input_path)) @unlink($input_path);
            if (file_exists($output_path)) @unlink($output_path);
        }
    }
    
    /**
     * Method 1: Unlock using QPDF (Most reliable)
     */
    private function unlock_with_qpdf($input_path, $password, $output_path) {
        // Check if qpdf is available
        $qpdf_path = $this->find_command('qpdf');
        if (!$qpdf_path) {
            return false;
        }
        
        // Build command with proper escaping
        $cmd = escapeshellcmd($qpdf_path) . ' --password=' . escapeshellarg($password) . 
               ' --decrypt ' . escapeshellarg($input_path) . ' ' . escapeshellarg($output_path) . ' 2>&1';
        
        exec($cmd, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($output_path) && filesize($output_path) > 100) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Method 2: Unlock using Ghostscript
     */
    private function unlock_with_ghostscript($input_path, $password, $output_path) {
        // Check if ghostscript is available
        $gs_path = $this->find_command('gs');
        if (!$gs_path) {
            return false;
        }
        
        // Build command
        $cmd = escapeshellcmd($gs_path) . ' -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite ' .
               '-sPDFPassword=' . escapeshellarg($password) . ' ' .
               '-sOutputFile=' . escapeshellarg($output_path) . ' ' .
               escapeshellarg($input_path) . ' 2>&1';
        
        exec($cmd, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($output_path) && filesize($output_path) > 100) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Method 3: Unlock using TCPDF
     */
    private function unlock_with_tcpdf($input_path, $password, $output_path) {
        try {
            // Suppress warnings for TCPDF
            $old_error_reporting = error_reporting();
            error_reporting($old_error_reporting & ~E_DEPRECATED & ~E_USER_DEPRECATED);
            
            // Create new TCPDF instance
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            
            // Set document information
            $pdf->SetCreator('PDF Unlocker');
            $pdf->SetTitle('Unlocked PDF');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            
            // Check if TCPDF supports importing
            if (!method_exists($pdf, 'setSourceFile')) {
                error_reporting($old_error_reporting);
                return false;
            }
            
            // Set the source file with password
            $pageCount = $pdf->setSourceFile($input_path, $password);
            
            if ($pageCount && $pageCount > 0) {
                // Import all pages
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $pdf->AddPage();
                    $templateId = $pdf->importPage($pageNo);
                    $pdf->useTemplate($templateId);
                }
                
                // Save the unlocked PDF
                $pdf->Output($output_path, 'F');
                
                error_reporting($old_error_reporting);
                
                return file_exists($output_path) && filesize($output_path) > 100;
            }
            
            error_reporting($old_error_reporting);
            return false;
            
        } catch (Exception $e) {
            log_message('error', 'TCPDF Error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Method 4: Manual PDF unlocking (for basic PDFs)
     */
    private function unlock_pdf_manual($input_path, $password, $output_path) {
        // Read the PDF content
        $content = file_get_contents($input_path);
        
        if ($content === false) {
            return false;
        }
        
        // Check if PDF is encrypted
        if (strpos($content, '/Encrypt') === false) {
            // Not encrypted, just copy
            return copy($input_path, $output_path);
        }
        
        // Try to remove encryption (works for some PDFs)
        $decrypted = $this->remove_pdf_encryption($content);
        
        if ($decrypted !== false) {
            // Save the decrypted content
            if (file_put_contents($output_path, $decrypted) !== false) {
                // Verify it's a valid PDF
                if ($this->validate_pdf($output_path)) {
                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Remove PDF encryption (manual method)
     */
    private function remove_pdf_encryption($content) {
        // Remove encryption dictionary
        $content = preg_replace('/\/Encrypt\s+<<[^>]*>>/', '', $content);
        $content = preg_replace('/\/Encrypt\s+\d+\s+\d+\s+R/', '', $content);
        $content = preg_replace('/\/EncryptMetadata\s+\w+/', '', $content);
        
        // Remove encryption objects
        $content = preg_replace('/\d+\s+\d+\s+obj\s+<<\s*\/Filter\s*\/Standard.*?>>\s+endobj/s', '', $content);
        
        // Fix object references
        $content = preg_replace('/\/Length\s+\d+\s+/', '/Length 0 ', $content);
        $content = preg_replace('/\/ID\s+\[[^\]]*\]/', '/ID []', $content);
        
        // Verify PDF structure
        if (strpos($content, '%PDF-') !== false && strpos($content, '%%EOF') !== false) {
            return $content;
        }
        
        return false;
    }
    
    /**
     * Find command in system path
     */
    private function find_command($command) {
        // Check if command exists
        $paths = [
            '/usr/bin/',
            '/usr/local/bin/',
            '/bin/',
            '/usr/sbin/',
            '/usr/local/sbin/',
            '/sbin/'
        ];
        
        // Try which command first
        $which = shell_exec('which ' . escapeshellarg($command) . ' 2>/dev/null');
        if ($which && trim($which) != '') {
            return trim($which);
        }
        
        // Try common paths
        foreach ($paths as $path) {
            if (file_exists($path . $command)) {
                return $path . $command;
            }
        }
        
        // Try Windows
        $where = shell_exec('where ' . escapeshellarg($command) . ' 2>nul');
        if ($where && trim($where) != '') {
            return trim($where);
        }
        
        return false;
    }
    
    /**
     * Validate PDF file
     */
    private function validate_pdf($file_path) {
        if (!file_exists($file_path) || filesize($file_path) < 100) {
            return false;
        }
        
        $content = file_get_contents($file_path, false, null, 0, 100);
        if ($content === false) {
            return false;
        }
        
        // Check PDF header
        if (strpos($content, '%PDF-') !== 0) {
            return false;
        }
        
        // Check EOF marker
        $end = file_get_contents($file_path, false, null, -10);
        if ($end === false || strpos($end, '%%EOF') === false) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Format file size
     */
    private function format_file_size($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
    
    /**
     * Download unlocked PDF
     */
    public function download($filename) {
        $file_path = FCPATH . 'uploads/pdfs/' . $filename;
        
        if (file_exists($file_path)) {
            // Clean filename
            $download_name = str_replace('unlocked_', '', $filename);
            
            // Force download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $download_name . '"');
            header('Content-Length: ' . filesize($file_path));
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
            
            readfile($file_path);
            
            // Delete after download
            @unlink($file_path);
            
            // Clean old files
            $this->clean_temp_files();
            exit;
        } else {
            show_404();
        }
    }
    
    /**
     * Clean temporary files
     */
    private function clean_temp_files() {
        $upload_dir = FCPATH . 'uploads/pdfs/';
        if (is_dir($upload_dir)) {
            $files = glob($upload_dir . '*.pdf');
            foreach ($files as $file) {
                if (time() - filemtime($file) > 1800) {
                    @unlink($file);
                }
            }
        }
    }
}