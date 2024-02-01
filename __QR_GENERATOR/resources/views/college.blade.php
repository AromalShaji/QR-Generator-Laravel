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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> {{ Session::get('error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




    <div class="table-container">
        <div class="form-container">
            <form id="qrForm" action="{{ route('generateQrCodeCollege') }}" method="POST">
                @csrf
                <label for="collegeName">College Name:</label>
                <input type="text" id="collegeName" name="collegeName" required>
                <button type="submit" class="btn-success">Submit</button>
            </form>
        </div>
    <br>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    @if (Session::has('studentDetails'))
        <h2>Details</h2>
        <div class="export-btn-container">
            <button id="exportBtn" class="btn btn-success" onclick="exportToPDF()">Export to PDF</button>
        </div>
        <table id="detailsTable">
            <thead>
            <tr>
                <th>PRN</th>
                <th>BARCODE</th>
            </tr>
            </thead>
            <tbody>
                @foreach(Session::get('details') as $details)
                    <tr class="{{ $loop->even ? 'even-row' : 'odd-row' }}">
                        <td><input type="text" value="{{ $details['student_prn'] }}" readonly class="editable"></td>
                        <td> 
                            {!! DNS2D::getBarcodeHTML(
                                $details['false_number'] . '|' . 
                                $details['student_college'] . '|' . 
                                $details['student_course'] . '|' . 
                                $details['student_exam']
                                , 'QRCODE', 2, 2) !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    </div>

    <script>
        function exportToPDF() {
            
            var element = document.getElementById('detailsTable');
            html2pdf(element);
        }
    </script>
    
    <style>
        .table-container {
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            border: 1px solid #ddd;
            margin: 0 auto;
            width: 50%;
            box-sizing: border-box;
            margin-top: 50px
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container label {
            margin-right: 10px;
        }

        .form-container input[type="text"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        .form-container button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
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
            border: none;
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
            margin-right: 5px;
        }

        .update-btn {
            background-color: #4caf50;
            color: white;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

@endsection
