<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
    
class PDFController extends Controller
{
    public function generatePDF()
    {
        $qrcode = base64_encode(QrCode::format('svg')->size(200)->errorCorrection('H')->generate('string'));

        $data = [
            'title' => 'Welcome to Online Web Tutor',
            'qrcode' => $qrcode
        ];  
              
        $pdf = PDF::loadView('my-pdf', $data);
  
        return $pdf->download('onlinewebtutor.pdf');
    }
}