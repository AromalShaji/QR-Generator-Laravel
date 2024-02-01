function showQRButton() {
    var prnField = document.getElementById("prnField");
    var studentName = document.getElementById("studentName");
    var collegeName = document.getElementById("collegeName");
    var falseNumber = document.getElementById("falseNumber");
    var courseId = document.getElementById("courseId");

    // Clear existing data and messages
    document.getElementById("qrcodeContainer").innerHTML = '';
    document.getElementById("loadingMessage").style.display = 'none';
    document.getElementById("errorMessage").style.display = 'none';
    document.getElementById("downloadButton").style.display = 'none';

    if (prnField.value.trim() === '') {
        alert('Please fill in PRN field.');
        return;
    }

    prnField.removeAttribute('readonly');

    // Use AJAX to fetch data from the controller
    $.ajax({
        url: '{{ route("generateQrCodeDetails") }}',
        type: 'POST',
        data: { prn: prnField.value, _token: '{{ csrf_token() }}' },
        success: function (data) {
            if (data && !data.error) {
                // Update the fields with the received data
                studentName.value = data.student_name || 'undefined';
                collegeName.value = data.college ? data.college.college_name : 'undefined';
                falseNumber.value = data.false_number || 'undefined';
                courseId.value = data.course_id || 'undefined';

                // Show additional fields and QR code button
                document.getElementById("additionalFields").style.display = 'block';

                // Generate QR code using qrcode.js library
                var qrcode = new QRCode(document.getElementById("qrcodeContainer"), {
                    text: data.false_number,
                    width: 128,
                    height: 128,
                });

                // Show QR code container and download button
                document.getElementById("qrcodeContainer").style.display = 'block';
                document.getElementById("downloadButton").style.display = 'inline-block';
            } else {
                // Show error message
                document.getElementById("errorMessage").innerText = data.error || 'No data found.';
                document.getElementById("errorMessage").style.display = 'block';

                // Hide additional fields
                document.getElementById("additionalFields").style.display = 'none';
            }
        },
        error: function () {
            // Show error message
            document.getElementById("errorMessage").innerText = 'Error fetching data from the server.';
            document.getElementById("errorMessage").style.display = 'block';

            // Hide additional fields
            document.getElementById("additionalFields").style.display = 'none';
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