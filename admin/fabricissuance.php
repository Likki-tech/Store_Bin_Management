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
  
  <title>FABRIC ISSUANCE</title>
  <link rel="stylesheet" href="style1.css">
  <style>
    /* Basic styles for form container */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fc;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
    backdrop-filter: blur(5px); 
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
    }

    .form-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      max-width: 900px;
      margin: 30px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 14px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .form-group input:focus {
      border-color: #007bff;
      outline: none;
    }

    .roll-container {
      grid-column: span 2;
      margin-top: 20px;
    }

    .roll-group {
      display: grid;
      gap: 15px;
      margin-bottom: 20px;
    }

    .roll-group input {
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .roll-group label {
      font-size: 14px;
      font-weight: bold;
    }

    .form-actions {
      grid-column: span 2;
      display: flex;
      justify-content: center;
      gap: 20px;
      align-items: center;
      margin-top: 20px;
    }

    .form-actions button {
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      background-color: #007bff;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      width: 100px;
    }

    .form-actions button:hover {
      background-color: #0056b3;
    }

    .form-actions button[type="reset"] {
      background-color: #e05e5e;
    }

    .form-actions button[type="reset"]:hover {
      background-color: #fd0505;
    }

    h2 {
      text-align: center;
      font-size: 24px;
      margin-bottom: 30px;
    }

    /* Mobile responsiveness */
    @media (max-width: 600px) {
      .form-container {
        grid-template-columns: 1fr;
      }

      .form-actions {
        flex-direction: column;
        align-items: flex-start;
      }

      .form-actions button {
        width: 100%;
        margin-bottom: 10px;
      }
    }

    /* Search and Employee ID fields container */
    .search-input-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-bottom: 20px;
      text-align: center;
    }

    .search-input-container input {
      padding: 10px;
      width: 60%;
      margin-left: 100px;
      font-size: 14px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .search-input-container input:focus {
      border-color: #007bff;
    }

    /* QR Scanner container */
    .qr-scanner-container {
      grid-column: span 2;
      text-align: center;
      margin-top: 20px;
      border: 2px dashed #007bff;
      padding: 10px;
      border-radius: 8px;
      background-color: #e9f7fe;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: center;
      width: 400px;
      height: 310px;
      margin: auto;
    }

    #qr-video {
      width: 100%;
      height: 250px;
      border: 1px solid #ccc;
      border-radius: 8px;
      object-fit: cover;
    }

    /* Work Order fields container (2 columns layout) */
    .work-order-container {
      display: grid;
      grid-template-columns: 1fr 1fr; /* Two columns layout for date and work order */
      gap: 20px;
      margin-top: 20px;
    }

    .work-order-container .form-group {
      margin-bottom: 15px;
    }

    /* Ensure last item takes full row if needed (for responsive layout) */
    .work-order-container .form-group:last-child {
      grid-column: span 2;
    }

    /* For Number of Rolls and Quantity to be displayed in columns */
    .roll-quantity-container {
      display: grid;
      grid-template-columns: 1fr 1fr; /* Two columns layout for rolls and quantity */
      gap: 20px;
      margin-top: 20px;
    }


     /* Styling for dynamic roll fields */
     .roll-container {
      grid-column: span 2;
      margin-top: 20px;
    }

    .roll-group {
      display: grid;
      gap: 15px;
      margin-bottom: 20px;
    }

    .roll-group input {
      padding: 8px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .roll-group label {
      font-size: 14px;
      font-weight: bold;
    }

    .roll-group{
        grid-template-columns: repeat(3,1fr);
    }
    @media (min-width:600){
        .roll-group{
            grid-template-columns: repeat(3,1fr);
        }
    }
    @media only screen and (max-width: 600px) {
    body {
        font-size: 16px;
    }
    .container {
        padding: 10px;
    }
}
  </style>

  <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script>
  
  <script>
    // Function to start the QR scanner
    function startQRScanner() {
      const videoElement = document.getElementById('qr-video');
      const canvasElement = document.createElement('canvas');
      const canvasContext = canvasElement.getContext('2d');
      
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
          .then((stream) => {
            videoElement.srcObject = stream;
            videoElement.setAttribute("playsinline", true); // required for iOS
            videoElement.play();
            requestAnimationFrame(scanQRCode);
          })
          .catch((err) => {
            console.log('Error accessing webcam: ', err);
          });
      }

      function scanQRCode() {
        if (videoElement.readyState === videoElement.HAVE_ENOUGH_DATA) {
          canvasElement.height = videoElement.videoHeight;
          canvasElement.width = videoElement.videoWidth;
          canvasContext.drawImage(videoElement, 0, 0, canvasElement.width, canvasElement.height);

          const imageData = canvasContext.getImageData(0, 0, canvasElement.width, canvasElement.height);
          const qrCode = jsQR(imageData.data, imageData.width, imageData.height);

          if (qrCode) {
            alert('QR Code scanned: ' + qrCode.data);
          }
        }
        requestAnimationFrame(scanQRCode);
      }
    }

    // Start QR scanner when page is loaded
    window.onload = () => {
      startQRScanner();
    };
  </script>

<script>
  // Function to generate roll details dynamically based on the number of rolls
function generateRollFields() {
 const numberOfRolls = document.getElementById("rolls").value;
 const rollsContainer = document.getElementById("rolls-container");
 rollsContainer.innerHTML = ''; // Clear previous roll fields

 // Calculate the number of columns needed (up to 3 per row)
 const columns = Math.min(numberOfRolls, 3); // Maximum 3 columns per row
 const rows = Math.ceil(numberOfRolls / columns); // Calculate how many rows are needed

 // Loop to create fields for each roll
 for (let i = 1; i <= rows; i++) {
   const rollDiv = document.createElement("div");
   rollDiv.classList.add("roll-group");

   // Create roll input fields for the current row
   for (let j = 1; j <= columns; j++) {
     const rollIndex = (i - 1) * columns + j;
     if (rollIndex > numberOfRolls) break; // Exit if we've created enough fields

     rollDiv.innerHTML += `
       <div class="form-group">
         <label for="rollNumber${rollIndex}">Roll Number ${rollIndex}:</label>
         <input type="text" id="rollNumber${rollIndex}" name="rollNumber${rollIndex}" required>
       </div>
     `;
   }

   rollsContainer.appendChild(rollDiv);
 }
}

 </script>
</head>
<body>

  <form action="#" method="post">
    <h2>FABRIC ISSUANCE</h2>

    <!-- Search and Employee ID Fields Container -->
    <div class="search-input-container">
      <div class="form-group">
        <label for="employeeId"><b>Employee ID</b></label>
        <input type="text" id="employeeId" name="employeeId" placeholder="Enter employee ID" required />
      </div>
      <div class="form-group">
        <label for="search"><b>Fabric Code</b></label>
        <input type="text" id="search" name="search" placeholder="Search fabric code..." />
      </div>
    </div>

    <!-- QR Scanner Container -->
    <div class="qr-scanner-container">
      <h3>QR Code Scanner</h3>
      <video id="qr-video"></video>
    </div>

    <!-- Work Order Number, Number of Rolls, and Quantity Fields in 2 Columns -->
    <div class="form-container">
      <!-- Column 1 -->
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
      </div>

      <!-- Column 2 -->
      <div class="form-group">
        <label for="workorder">Work Order Number:</label>
        <input type="text" id="workorder" name="workorder" required>
      </div>

      <!-- Column 1 -->
      <div class="form-group">
        <label for="rolls">Number Of Rolls:</label>
        <input type="number" id="rolls" name="rolls" required onchange="generateRollFields()">
      </div>

      <!-- Column 2 -->
      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
      </div>
    </div>

     <!-- Container for dynamically added roll fields -->
     <div id="rolls-container" class="roll-container"></div>

    <div class="form-actions">
      <button type="submit">Update</button>
      <button type="reset">Clear</button>
    </div>
  </form>
</body>
</html>