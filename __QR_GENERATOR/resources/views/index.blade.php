@extends('base')
@section('title', 'Home')
@section('body')

    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong> {{ Session::get('success') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-error alert-dismissible fade show" role="alert">
            <strong> {{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>
    
    <style>
        .button-container {
            display: flex;
            align-items: center;
        }
    
        #prnLabel {
            margin-right: 10px;
        }
    
        #prnField {
            flex: 1; /* Allow the PRN field to take up available space */
        }
    
        #submitButton {
            margin-left: 10px; /* Adjust the margin as needed */
        }
    
        .editable {
            pointer-events: auto;
            background-color: #fff;
        }
    
        #qrcodeContainer {
            text-align: center;
            position: relative; /* Add position relative for absolute positioning */
        }
    
        #downloadButton {
            position: absolute;
            bottom: 10px; /* Adjust the distance from the bottom as needed */
            left: 50%; /* Center the button horizontally */
            transform: translateX(-50%); /* Center the button horizontally */
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <div class="table-container">
        <div id="container">
            <form id="qrForm" action="{{ route('generateQrCodeDetails') }}" method="POST">
                @csrf
                <div class="button-container">
                    <label id="prnLabel" for="prnField">PRN:</label>
                    <input type="text" id="prnField" name="prn">
                    <button class="btn btn-success me-3" type="button" id="submitButton" onclick="showQRButton()">Submit</button>
                </div>
                <br>
                <!--<div id="additionalFields" style="display: none;">
                    <label for="studentName">Student Name:</label>
                    <input type="text" id="studentName" class="editable" readonly>
                    <br>
                    <label for="collegeName">College Name:</label>
                    <input type="text" id="collegeName" class="editable" readonly>
                    <br>
                    <label for="courseId">Course Name:</label>
                    <input type="text" id="courseId" class="editable" readonly>
                    <br>
                    <label for="falseNumber">False Number:</label>
                    <input type="text" id="falseNumber" class="editable" readonly>
                    <br>
                </div>-->
                <button class="btn btn-success me-3" id="downloadButton" style="display: none;" onclick="downloadQRCode()">Generate PDF</button>
            </form>
            <div id="loadingMessage" style="display: none;">Loading...</div>
            <div id="errorMessage" style="display: none; color: red;"></div>
            <div id="qrcodeContainer" style="display: none;"></div>
        </div>
    </div>
    
    <script>
        function showQRButton() {
            var prnField = document.getElementById("prnField");
            // var studentName = document.getElementById("studentName");
            // var collegeName = document.getElementById("collegeName");
            // var falseNumber = document.getElementById("falseNumber");
            // var courseId = document.getElementById("courseId");

            document.getElementById("qrcodeContainer").innerHTML = '';
            document.getElementById("loadingMessage").style.display = 'none';
            document.getElementById("errorMessage").style.display = 'none';
            document.getElementById("downloadButton").style.display = 'none';

            if (prnField.value.trim() === '') {
                alert('Please fill in PRN field.');
                return;
            }

            prnField.removeAttribute('readonly');

            $.ajax({
                url: '{{ route("generateQrCodeDetails") }}',
                type: 'POST',
                data: { prn: prnField.value, _token: '{{ csrf_token() }}' },
                success: function (data) {
                    if (data && !data.error) {
                        
                        
                        // studentName.value = data.student_name || 'undefined';
                        // collegeName.value = data.college ? data.college.college_name : 'undefined';
                        // falseNumber.value = data.false_number || 'undefined';
                        // courseId.value = data.course_id || 'undefined';

                        // document.getElementById("additionalFields").style.display = 'block';

                        var additionalData = "Student Name: " + data.student_name + "\n" +
                                            "College Name: " + (data.college ? data.college.college_name : 'undefined') + "\n" +
                                            "False Number: " + data.false_number + "\n" +
                                            "Course ID: " + data.course_id;

                        var qrcode = new QRCode(document.getElementById("qrcodeContainer"), {
                            text: additionalData,
                            width: 128,
                            height: 128,
                        });

                        document.getElementById("qrcodeContainer").style.display = 'block';
                        document.getElementById("downloadButton").style.display = 'inline-block';
                        document.getElementById("qrcodeContainer").querySelector('img').title = '';

                    } else {
                        document.getElementById("errorMessage").innerText = data.error || 'No data found.';
                        document.getElementById("errorMessage").style.display = 'block';

                        // document.getElementById("additionalFields").style.display = 'none';
                    }
                },
                error: function () {
                    document.getElementById("errorMessage").innerText = 'Error fetching data from the server.';
                    document.getElementById("errorMessage").style.display = 'block';

                    // document.getElementById("additionalFields").style.display = 'none';
                }
            });
        }

        function downloadQRCode() {
            var dataUrl = document.getElementById("qrcodeContainer").querySelector('img').src;
    
            var a = document.createElement('a');
            a.href = dataUrl;
            a.download = 'qrcode.png';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }
    
        $(document).ready(function () {
            $('#qrForm').submit(function (e) {
                e.preventDefault();
            });
        });
    </script>
    
    <style>
        #qrcodeContainer img {
            -webkit-user-select: none; 
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .table-container {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #ddd;
            margin: 0 auto; 
            width: 50%; 
            box-sizing: border-box; 
        }

        input[type="text"] {
            border: none;
        }

        .table-container {
            background-color: white;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            margin-top: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: none;
            padding: 10px;
            text-align: left;
        }

        .even-row {
            background-color: #f9f9f9;
        }

        .odd-row {
            background-color: #ffffff;
        }

        input[readonly] {
            background-color: #f4f4f4;
        }

        .update-btn:disabled,
        .delete-btn:disabled {
            background-color: #d3d3d3;
            color: #808080;
            cursor: not-allowed;
        }

        .update-btn,
        .delete-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .update-btn {
            background-color: #4caf50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }
    </style>

@endsection
