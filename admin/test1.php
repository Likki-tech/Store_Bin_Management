<?php
include('session.php'); // Manages user session
include('header.php');  // Includes the header section
include('dbcon.php');   // Database connection
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FABRIC INWARD</title>
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
      backdrop-filter: blur(5px);
      background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;
      margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    }
    form {
      max-width: 1600px;
      margin: auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #f9f9f9;
    }
    .form-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
    }
    .form-group {
      display: flex;
      flex-direction: column;
    }
    .form-group label {
      margin-bottom: 5px;
      font-weight: bold;
    }
    .form-group input {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    .form-group button {
      padding: 12px 20px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background-color: #007BFF;
      color: white;
      cursor: pointer;
      margin-top: 10px;
    }
    .form-group button:hover {
      background-color: #0056b3;
    }
    .form-actions {
      grid-column: span 2;
      text-align: center;
    }
    .form-actions button {
      padding: 14px 30px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      background-color: #007BFF;
      color: white;
      cursor: pointer;
      margin: 10px;
    }
    .form-actions button:hover {
      background-color: #0056b3;
    }
    #rollNumberContainer {
      margin-top: 15px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
      background-color: #f3f3f3;
      grid-column: span 2;
    }
    .roll-info {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 10px;
      margin-bottom: 10px;
      align-items: center;
    }
    .roll-info input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .roll-info input::placeholder {
      color: #999;
    }
    .roll-info button {
      padding: 8px 12px;
      font-size: 14px;
      border: none;
      border-radius: 5px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
    }
    .roll-info button:hover {
      background-color: #218838;
    }
    .red-border {
      border: 3px solid red !important;
      background-color: #ffdddd !important;
    }
    .green-border {
      border: 3px solid green !important;
      background-color: #ddffdd !important;
    }
  </style>
  <!-- Include QR Code library from CDN -->
  <script src="js/qrcode.min.js"></script>
</head>
<body>
  <form id="fabricForm" action="save_candidate.php" method="post" enctype="multipart/form-data">
    <h2 style="text-align: center;">FABRIC INWARD</h2>
    
    <div class="form-container">
      <!-- Date Field -->
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="D" class="D" required>
      </div>
      
      <!-- Material Type Field -->
      <div class="form-group">
        <label for="materialtype">Material Type:</label>
        <input type="text" id="materialtype" name="MT" class="MT">
      </div>
      
      <!-- Material Code Field -->
      <div class="form-group">
        <label for="materialcode">Material Code:</label>
        <input type="text" id="materialcode" name="MC" class="MC" required>
      </div>
      
      <!-- Rack Number Field -->
      <div class="form-group">
        <label for="racknumber">Rack Number:</label>
        <input type="text" id="racknumber" name="RN1" class="RN1" required>
      </div>
      
      <!-- Bin Number Field -->
      <div class="form-group">
        <label for="binname">Bin Number:</label>
        <input type="text" id="binname" name="BN" class="BN" required>
      </div>
      
      <!-- Number of Rolls Field -->
      <div class="form-group">
        <label for="rolls">Number of Rolls:</label>
        <input type="number" id="rollInput" min="1" name="rolls" class="rolls" required>
        <button type="button" onclick="generateRollNumbers()">Generate Rolls</button>
      </div>

      <!-- Container for Dynamically Generated Rolls -->
      <div id="rollNumberContainer"></div>

      <!-- Actual Quantity Field -->
      <div class="form-group">
        <label for="actualquantity">Actual Quantity:</label>
        <input type="text" id="actualquantity" name="AQ" required oninput="checkQuantities()" readonly step="0.01">
      </div>

      <!-- PO Quantity Field -->
      <div class="form-group">
        <label for="poquantity">PO Quantity:</label>
        <input type="number" id="poquantity" name="poqty" required>
      </div>
    </div>

    <!-- JavaScript for QR Code Generation and Form Handling -->
    <script>
      let totalRollQuantity = 0;

      /**
       * Generates input fields for each roll based on the number entered.
       */
      function generateRollNumbers() {
        const numberOfRolls = parseInt(document.getElementById('rollInput').value, 10);
        const materialCode = document.getElementById('materialcode').value.trim();
        const container = document.getElementById('rollNumberContainer');

        // Clear previous roll inputs and reset total quantity
        container.innerHTML = '';
        totalRollQuantity = 0;

        // Validate Material Code
        if (!materialCode) {
          alert("Please enter a Material Code before generating rolls.");
          return;
        }

        // Validate Number of Rolls
        if (isNaN(numberOfRolls) || numberOfRolls <= 0) {
          alert("Please enter a valid number of rolls.");
          return;
        }

        // Optional: Display Material Code at the top of the rolls section
        /*
        const materialCodeInfo = document.createElement('div');
        materialCodeInfo.className = 'roll-info';
        const materialCodeInput = document.createElement('input');
        materialCodeInput.type = 'text';
        materialCodeInput.placeholder = 'Material Code';
        materialCodeInput.value = materialCode;
        materialCodeInput.readOnly = true;
        materialCodeInfo.appendChild(materialCodeInput);
        container.appendChild(materialCodeInfo);
        */

        // Add Heading for Rolls Details
        const heading = document.createElement('h3');
        heading.textContent = "Rolls Details";
        heading.style.textAlign = "center";
        container.appendChild(heading);

        // Generate Roll Input Fields
        for (let i = 0; i < numberOfRolls; i++) {
          const rollInfoDiv = document.createElement('div');
          rollInfoDiv.className = 'roll-info';

          // Roll Number Input
          const rollInput = document.createElement('input');
          rollInput.type = 'number';
          rollInput.name = 'RN[]';
          rollInput.className = 'text-box';
          rollInput.placeholder = `Roll Number ${i + 1}`;
          rollInfoDiv.appendChild(rollInput);

          // Quantity Input
          const quantityInput = document.createElement('input');
          quantityInput.type = 'text';
          quantityInput.name = 'Q[]';
          quantityInput.placeholder = 'Quantity';
          quantityInput.min = '1';
          quantityInput.oninput = updateTotalQuantity;
          rollInfoDiv.appendChild(quantityInput);

          // Width Input
          const widthInput = document.createElement('input');
          widthInput.type = 'text';
          widthInput.name = 'WD[]';
          widthInput.placeholder = 'Width';
          rollInfoDiv.appendChild(widthInput);

          // Shade Input
          const shadeInput = document.createElement('input');
          shadeInput.type = 'text';
          shadeInput.name = 'S[]';
          shadeInput.placeholder = 'Shade';
          rollInfoDiv.appendChild(shadeInput);

          // Generate QR Code Button
          const qrButton = document.createElement('button');
          qrButton.textContent = 'Generate QR Code';
          qrButton.type = 'button';
          qrButton.onclick = () => generateRollQRCode(i + 1, materialCode, rollInput.value.trim(), quantityInput.value.trim(), widthInput.value.trim(), shadeInput.value.trim());
          rollInfoDiv.appendChild(qrButton);

          // Append Roll Info to Container
          container.appendChild(rollInfoDiv);
        }
      }

      /**
       * Updates the total quantity based on individual roll quantities.
       */
      function updateTotalQuantity() {
        const quantities = document.querySelectorAll('input[name="Q[]"]');
        let total = 0;
        quantities.forEach(input => {
          const val = parseFloat(input.value, 10);
          if (!isNaN(val)) {
            total += val;
          }
        });
        totalRollQuantity = total;
        const actualQuantityField = document.getElementById('actualquantity');
        if (actualQuantityField) {
    // Find the maximum decimal places from input values
    let maxDecimalPlaces = 0;
    quantities.forEach(input => {
      const value = input.value.trim();
      if (value.includes('.')) {
        const decimalPlaces = value.split('.')[1].length;
        maxDecimalPlaces = Math.max(maxDecimalPlaces, decimalPlaces);
      }
    });

    // If no decimal point is found, default to 2 decimals
    if (maxDecimalPlaces === 0) {
      maxDecimalPlaces = 2;
    }

    // Set the value of "Actual Quantity" field with the calculated total
    actualQuantityField.value = total.toFixed(maxDecimalPlaces); // Display total with appropriate decimal places
  }

        checkQuantities();
      }

      /**
       * Checks if the actual quantity matches the total roll quantities.
       */
      function checkQuantities() {
        const actualQuantityInput = document.getElementById('actualquantity');
        const actualQuantity = parseFloat(actualQuantityInput.value, 10);

        if (isNaN(actualQuantity)) {
          actualQuantityInput.classList.remove('red-border', 'green-border');
          return;
        }

        if (actualQuantity !== totalRollQuantity) {
          actualQuantityInput.classList.add('red-border');
          actualQuantityInput.classList.remove('green-border');
        } else {
          actualQuantityInput.classList.add('green-border');
          actualQuantityInput.classList.remove('red-border');
        }
      }

      /**
       * Generates and downloads the QR code for an individual roll.
       * @param {number} rollIndex - The index of the roll.
       * @param {string} materialCode - The material code.
       * @param {string} rollNumber - The roll number.
       * @param {string} quantity - The quantity of the roll.
       * @param {string} width - The width of the roll.
       * @param {string} shade - The shade of the roll.
       */
      function generateRollQRCode(rollIndex, materialCode, rollNumber, quantity, width, shade) {
        // Validate all inputs
        if (!rollNumber || !quantity || !width || !shade) {
          alert(`Please complete all details for Roll ${rollIndex} before generating its QR code.`);
          return;
        }

        // Prepare QR data
        const qrData = `Roll: ${rollNumber}\nMaterial Code: ${materialCode}\nQuantity: ${quantity}\nWidth: ${width}\nShade: ${shade}`;

        // Create a temporary canvas element
        const qrCodeCanvas = document.createElement('canvas');

        // Generate QR code on the canvas
        QRCode.toCanvas(qrCodeCanvas, qrData, { width: 150 }, function (error) {
          if (error) {
            console.error("QR Code Generation Error:", error);
            alert("Failed to generate QR Code.");
            return;
          }

          // Convert the canvas to a data URL
          const qrCodeURL = qrCodeCanvas.toDataURL('image/png');

          // Create a temporary link to trigger the download
          const downloadLink = document.createElement('a');
          downloadLink.href = qrCodeURL;
          downloadLink.download = `Roll_${rollNumber}_QRCode.png`;
          
          // Append the link to the body (required for Firefox)
          document.body.appendChild(downloadLink);
          
          // Trigger the download
          downloadLink.click();
          
          // Remove the link from the document
          document.body.removeChild(downloadLink);
        });
      }

      /**
       * Clears the form, including dynamically generated roll inputs and reset styles.
       */
      function clearForm() {
        document.getElementById('fabricForm').reset();
        document.getElementById('rollNumberContainer').innerHTML = '';
        const actualQuantityInput = document.getElementById('actualquantity');
        actualQuantityInput.classList.remove('red-border', 'green-border');
        totalRollQuantity = 0;
      }

      /**
       * Generates and downloads an overall QR code summarizing the form data.
       */
     /**
 * Generates and downloads an overall QR code summarizing the form data.
 */
function generateOverallQRCode() {
  const materialCode = document.getElementById('materialcode').value.trim();
  const date = document.getElementById('date').value.trim();
  const materialType = document.getElementById('materialtype').value.trim();
  const rackNumber = document.getElementById('racknumber').value.trim();
  const binName = document.getElementById('binname').value.trim();
  const actualQuantity = document.getElementById('actualquantity').value.trim();
  const poQuantity = document.getElementById('poquantity').value.trim();

  // Validate essential fields
  if (!materialCode || !date) {
    alert("Please complete the Material Code and Date fields before generating the QR code.");
    return;
  }

  // Prepare QR data
  let qrData = `Material Code: ${materialCode}\nDate: ${date}\nMaterial Type: ${materialType}\n`;
  if (rackNumber) qrData += `Rack Number: ${rackNumber}\n`;
  if (binName) qrData += `Bin Number: ${binName}\n`;
  if (actualQuantity) qrData += `Actual Quantity: ${actualQuantity}\n`;
  if (poQuantity) qrData += `PO Quantity: ${poQuantity}`;

  // Create a temporary canvas element
  const qrCodeCanvas = document.createElement('canvas');

  // Generate QR code on the canvas
  QRCode.toCanvas(qrCodeCanvas, qrData, { width: 200 }, function (error) {
    if (error) {
      console.error("QR Code Generation Error:", error);
      alert("Failed to generate QR Code.");
      return;
    }

    // Convert the canvas to a data URL
    const qrCodeURL = qrCodeCanvas.toDataURL('image/png');

    // Create a temporary link to trigger the download
    const downloadLink = document.createElement('a');
    downloadLink.href = qrCodeURL;
    downloadLink.download = `Overall_QR_${materialCode}.png`;
    
    // Append the link to the body (required for Firefox)
    document.body.appendChild(downloadLink);
    
    // Trigger the download
    downloadLink.click();
    
    // Remove the link from the document
    document.body.removeChild(downloadLink);
  });
}

    </script>

    <!-- Form Action Buttons -->
    <div class="form-actions">
      <button type="submit" name="save">Save</button>
      <button type="button" onclick="clearForm()">Clear</button>
      <button type="button" onclick="generateOverallQRCode()">Download QR Code</button>

    </div>
  </form>
</body>
</html>
