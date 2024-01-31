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
    public function generateQrCode(Request $request)
    {
        $prn = $request->input('prn');
        if (Student_table::where('prn', $prn)->exists()) {
            $student_details = Student_table::where('prn', $prn)->get();
            return response()->json($student_details);
        } else {
            return response()->json(['error' => 'No data found']);
        }
        
        // $fallsNumber = $request->input('falls_number');
        // $collegeName = $request->input('college_name');
        // $courseName = $request->input('course_name');
        $filename = 'qrcode_' . time() . '.png';
        $renderer = new Png();
        $renderer->setHeight(300);
        $renderer->setWidth(300);
        $writer = new Writer($renderer);
        $qrCode = QrCode::create($fallsNumber . "\n" . $collegeName . "\n" . $courseName);
        // ==========================================================================================
        // $storagePath = storage_path('app/public/qrcodes/');
        // if (!file_exists($storagePath)) {
        //     mkdir($storagePath, 0777, true);
        // }
        // $writer->writeFile($qrCode, $storagePath . $filename);
        // ==========================================================================================
        $response = response($writer->writeString($qrCode), 200, [
            'Content-Type' => $renderer->getMimeType(),
        ]);
        return view('qrcode', compact('response', 'fallsNumber', 'collegeName', 'courseName'));

    }
}
