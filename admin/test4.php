<?php
include('session.php');
include('header.php');
include('dbcon.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fc;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    h2 {
      color: #ffffff;
      margin-bottom: 20px;
    }

    #qr-reader {
      width: 300px;
      border: 2px solid #007bff;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
      background: #ffffff;
      overflow: hidden;
    }

    #qr-reader-results {
      margin-top: 20px;
      padding: 10px;
      background: #fff;
      border-radius: 5px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
      text-align: center;
      max-width: 300px;
      color: #007bff;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <h2>QR Code Scanner</h2>
  <div id="qr-reader"></div>
  <div id="qr-reader-results">No QR code scanned yet</div>
  
  <script>
    // Function to handle successful QR code scans
    function onScanSuccess(decodedText, decodedResult) {
      // Display scanned QR code result
      const resultContainer = document.getElementById('qr-reader-results');
      resultContainer.innerHTML = `<p>Scanned QR Code: ${decodedText}</p>`;
      console.log(`Scanned Result: ${decodedText}`, decodedResult);
    }

    // Function to handle scan failures (optional logging)
    function onScanFailure(error) {
      console.warn(`QR Code scanning error: ${error}`);
    }

    // Initialize the QR code scanner
    const qrReader = new Html5Qrcode("qr-reader");

    qrReader
      .start(
        { facingMode: "environment" }, // Use the device's back camera
        {
          fps: 10, // Frames per second for scanning
          qrbox: 250, // Scanning area size in pixels
        },
        onScanSuccess,
        onScanFailure
      )
      .catch((err) => {
        console.error("Failed to start QR code scanner:", err);
      });
  </script>
</body>
</html>
