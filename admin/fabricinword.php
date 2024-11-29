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
  <title>FABRIC INWARD</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
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
      grid-template-columns: repeat(6, 1fr);
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
</head>
<body>
  <form id="fabricForm" action="save_candidate.php" method="post" enctype="multipart/form-data">
    <h2 style="text-align: center;">FABRIC INWARD</h2>
    <div class="form-container">
      <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="D" required>
      </div>
      <div class="form-group">
        <label for="materialtype">Material Type:</label>
        <input type="text" id="materialtype" name="MT">
      </div>
      <div class="form-group">
        <label for="materialcode">Material Code:</label>
        <input type="text" id="materialcode" name="MC" required>
      </div>
      <div class="form-group">
        <label for="racknumber">Rack Number:</label>
        <input type="text" id="racknumber" name="RN1" required>
      </div>
      <div class="form-group">
        <label for="binname">Bin Number:</label>
        <input type="text" id="binname" name="BN">
      </div>
      <div class="form-group">
        <label for="rolls">Number of Rolls:</label>
        <input type="number" id="rollInput" min="1" name="rolls" required>
        <button type="button" onclick="generateRollNumbers()">Generate</button>
      </div>
      <div id="rollNumberContainer"></div>
      <div class="form-group">
        <label for="actualquantity">Actual Quantity:</label>
        <input type="number" id="actualquantity" name="actualquantity" required oninput="checkQuantities()">
      </div>
      <div class="form-group">
        <label for="poquantity">PO Quantity:</label>
        <input type="number" id="poquantity" name="poqty" required>
      </div>
    </div>
    <script type="text/javascript" src="/js/qrcode.js"></script>
    <script>
      let totalRollQuantity = 0;

      function generateRollNumbers() {
        const numberOfRolls = parseInt(document.getElementById('rollInput').value);
        const materialCode = document.getElementById('materialcode').value.trim();
        const container = document.getElementById('rollNumberContainer');

        container.innerHTML = '';
        totalRollQuantity = 0;

        if (!materialCode) {
          alert("Please enter a material code before generating rolls.");
          return;
        }

        if (numberOfRolls <= 0) {
          alert("Please enter a valid number of rolls.");
          return;
        }

        const heading = document.createElement('h3');
        heading.textContent = "Rolls Details";
        heading.style.textAlign = "center";
        container.appendChild(heading);

        for (let i = 0; i < numberOfRolls; i++) {
          const rollInfoDiv = document.createElement('div');
          rollInfoDiv.className = 'roll-info';

          const rollInput = document.createElement('input');
          rollInput.type = 'text';
          rollInput.name = 'RN[]';
          rollInput.placeholder = `Roll Number ${i + 1}`;
          rollInfoDiv.appendChild(rollInput);

          const quantityInput = document.createElement('input');
          quantityInput.type = 'number';
          quantityInput.name = 'Q[]';
          quantityInput.placeholder = 'Quantity';
          quantityInput.min = '1';
          quantityInput.oninput = updateTotalQuantity;
          rollInfoDiv.appendChild(quantityInput);

          const widthInput = document.createElement('input');
          widthInput.type = 'text';
          widthInput.name = 'WN[]';
          widthInput.placeholder = 'Width';
          rollInfoDiv.appendChild(widthInput);

          const shadeInput = document.createElement('input');
          shadeInput.type = 'text';
          shadeInput.name = 'S[]';
          shadeInput.placeholder = 'Shade';
          rollInfoDiv.appendChild(shadeInput);

          const qrButton = document.createElement('button');
          qrButton.textContent = 'Generate QR Code';
          qrButton.type = 'button';
          qrButton.onclick = () => generateRollQRCode(i + 1, materialCode, rollInput.value.trim(), quantityInput.value.trim(), widthInput.value.trim(), shadeInput.value.trim());
          rollInfoDiv.appendChild(qrButton);

          container.appendChild(rollInfoDiv);
        }
      }

      function updateTotalQuantity() {
        totalRollQuantity = Array.from(document.querySelectorAll('#rollNumberContainer input[name="Q[]"]'))
          .reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);
        checkQuantities();
      }

      function checkQuantities() {
        const actualQuantityInput = document.getElementById('actualquantity');
        if (parseInt(actualQuantityInput.value) !== totalRollQuantity) {
          actualQuantityInput.classList.add('red-border');
          actualQuantityInput.classList.remove('green-border');
        } else {
          actualQuantityInput.classList.add('green-border');
          actualQuantityInput.classList.remove('red-border');
        }
      }

      function generateRollQRCode(index) {
        const rollNumber = document.getElementById(`rollNumber${index}`).value;
        const quantity = document.getElementById(`quantity${index}`).value;
        const width = document.getElementById(`width${index}`).value;
        const shade = document.getElementById(`shade${index}`).value;
        
        if (!rollNumber || !quantity || !width || !shade) {
          alert(`Please complete all details for Roll ${index} before generating its QR code.`);
          return;
        }

        const materialCode = document.getElementById('materialCode').value.trim();
        const qrData = `Material Code: ${materialCode}\n Roll No: ${rollNumber}\n Qty: ${quantity}\n  Width: ${width}\n Shade: ${shade}\n`;
        QRCode.toCanvas(document.getElementById('qrContainer'), qrData, { width: 150 }, function (error) {
        if (error) {
          console.error("QR Code Generation Error:", error);
          alert("Failed to generate QR Code.");
        }
      });

        qrCode._oDrawing._elImage.onload = function () {
          const link = document.createElement('a');
          link.href = qrCode._oDrawing._elImage.src;
          link.download = `QR_Roll_${rollNumber}.png`;
          link.click();
        };
      }
                function generateOverallQRCode() {
                const materialCode = document.getElementById('materialcode').value.trim();
                const date = document.getElementById('date').value.trim();
                const materialType = document.getElementById('materialtype').value.trim();
                const rackNumber = document.getElementById('racknumber').value.trim();
                const binName = document.getElementById('binname').value.trim();
                const actualQuantity = document.getElementById('actualquantity').value.trim();
                const poQuantity = document.getElementById('poquantity').value.trim();

                const qrData = `Material Code: ${materialCode}\nDate: ${date}\nMaterial Type: ${materialType}\nRack Number: ${rackNumber}\nBin Number: ${binName}\nActual Quantity: ${actualQuantity}\nPO Quantity: ${poQuantity}`;
                const qrCodeCanvas = document.createElement('canvas');

                QRCode.toCanvas(qrCodeCanvas, qrData, { width: 200 }, function (error) {
                    if (error) {
                        console.error(error);
                        alert("Failed to generate QR Code.");
                        return;
                    }

                    const link = document.createElement('a');
                    link.href = qrCodeCanvas.toDataURL('image/png');
                    link.download = `${materialCode}_QRCode.png`;
                    link.click();
                });
            }
    </script>
    <div class="form-actions">
      <button type="submit">Save</button>
      <button type="reset" onclick="clearRolls()">Clear Form</button>
    </div>
  </form>
</body>
</html>
