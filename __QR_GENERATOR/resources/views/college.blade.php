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
<div class="table-container">
    <div id="container">
        <label for="collegeName">College Name:</label>
        <input type="text" id="collegeName">
        <br>
        <button class="btn btn-success me-3" id="submitButton" onclick="showQRTable()">Submit</button>
        <table id="qrCodeTable" style="display: none;">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>PRN</th>
                    <th>Course Name</th>
                    <th>QR Code</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <button class="btn btn-primary me-3" id="printAllButton" style="display: none;" onclick="printAllQR()">Print All QR Codes</button>
    </div>
</div>

<script>
    function showQRTable() {
        var collegeName = document.getElementById("collegeName");
        if (collegeName.value.trim() === '') {
            alert('Please fill in College Name field.');
            return;
        }
        collegeName.setAttribute('readonly', true);
        document.getElementById("qrCodeTable").style.display = 'table';
        document.getElementById("printAllButton").style.display = 'inline-block';
    }

    function printAllQR() {
        alert('Printing all QR codes...');
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
