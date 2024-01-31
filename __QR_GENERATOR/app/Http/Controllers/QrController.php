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


class QrController extends Controller
{
    public function generateQrCodeDetails(Request $request)
    {
        try {
            $prn = $request->input('prn');

            if (Student_table::where('prn', $prn)->exists()) {
                $student_details = Student_table::with('college')->where('prn', $prn)->get();
                return response()->json($student_details);
            } else {
                return response()->json(['error' => 'No data found']);
            }
        } catch (\Exception $e) {
            \Log::error('Exception in generateQrCodeDetails: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
