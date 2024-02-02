<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\student_table;
use App\Models\college;
use App\Models\exam;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DavidGorges\PHPZxing\PHPZxingDecoder;


class QrController extends Controller
{
    public function generateQrCodeDetails(Request $request){
        try {
            $prn = $request->input('prn');
    
            $studentDetails = Student_table::with('college')->where('prn', $prn)->first();
    
            if (isset($studentDetails)) {
                return response()->json($studentDetails);
            } else {
                $error='No data found';
                return response()->json($error, 404);
            }
        } catch (\Exception $e) {
            \Log::error('Exception in generateQrCodeDetails: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function generateQrCodeCollege(Request $request)
    {
        $collegeName = $request->input('collegeName');
        $collegeDetails = College::where('college_name', $collegeName)->first();
        $details = [];

        if (isset($collegeDetails)) {
            $studentDetails = Student_table::with('college')->where('college_id', $collegeDetails->id)->get();

            if ($studentDetails->isNotEmpty()) {
                foreach ($studentDetails as $student) {
                    $examDetails = Exam::where('id', $student->exam_id)->first();
                    $details[] = [
                        "status" => "success",
                        "message" => "Found",
                        "student_prn" => $student['prn'],
                        "student_name" => $student['student_name'],
                        "student_college" => $collegeDetails['college_name'],
                        "student_course" => $collegeDetails['course_id'],
                        "student_exam" => $examDetails['exam_name'],
                        "exam_course" => $examDetails['subject_name'],
                        "false_number" => $student['false_number'],
                        // "qrcode" => $this->createQRImage($student['false_number'])
                    ];
                }
                return redirect(route('college'))
                    ->with('studentDetails', $studentDetails)
                    ->with('details', $details);
            }else{
                return redirect(route('college'))->with('error', 'No Data Available!');
            }
        }

        return redirect(route('college'))->with('error', 'Error');
    }

    
}
