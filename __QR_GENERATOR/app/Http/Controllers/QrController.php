<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\student_table;
use App\Models\college;
use App\Models\exam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class QrController extends Controller
{
    public function generateQrCodeDetails(Request $request)
    {
        $prn = $request->input('prn');
        if (Student_table::where('prn', $prn)->exists()) {
            $student_details = Student_table::where('prn', $prn)->get();
            return response()->json($student_details);
        } else {
            return response()->json(['error' => 'No data found']);
        }
    }

    // public function generateQrCode(Request $request)
    // {
    //     $fallsNumber = $request->input('falls_number');
    //     $collegeName = $request->input('college_name');
    //     $courseName = $request->input('course_name');
    //     $renderer = new Png();
    //     $renderer->setHeight(300);
    //     $renderer->setWidth(300);
    //     $writer = new Writer($renderer);
    //     $qrCode = QrCode::create($fallsNumber . "\n" . $collegeName . "\n" . $courseName);
        
    //     $dataUrl = 'data:' . $renderer->getMimeType() . ';base64,' . base64_encode($writer->writeString($qrCode));

    //     return response()->json(['data_url' => $dataUrl]);
    // }

    public function generateQrCode(Request $request)
    {
        try {
            $prnValue = $request->input('prn');

            // Assuming you have a method to generate the QR code object
            $qrCode = $this->generateQRCodeObject($prnValue);

            // Use DataUriWriter to get the data URI of the QR code image
            $writer = new DataUriWriter();
            $qrCodeDataUri = $writer->write($qrCode);

            return response($qrCodeDataUri);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error($e->getMessage());

            // Return an error response
            return response()->json(['error' => 'Error generating QR code.']);
        }
    }

    // Additional method to generate the QR code object
    private function generateQRCodeObject($prnValue)
    {
        // Use your logic to generate the QR code object based on the PRN value
        $qrCode = QrCode::create($prnValue);
        return $qrCode;
    }
}
