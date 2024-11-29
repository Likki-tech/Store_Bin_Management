<?php
include("dbcon.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FABRIC INWARD</title>
  <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.js"></script> <!-- jsQR for QR code reading -->
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg');
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

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #ccc;
      text-align: center;
      padding: 10px;
    }

    button {
      padding: 8px 12px;
      font-size: 14px;
      border: none;
      border-radius: 5px;
      background-color: #28a745;
      color: white;
      cursor: pointer;
    }

    button:disabled {
      background-color: #d6d6d6;
    }

    button:hover {
      background-color: #218838;
    }

    #scannerContainer {
      position: absolute;
      top: 20px;
      left: 20px;
      z-index: 9999;
      width: 300px;
      height: 300px;
      border: 2px solid #000;
      background-color: rgba(255, 255, 255, 0.5);
    }
  </style>
</head>
<body>
  <form id="fabricForm" action="save_candidate.php" method="post" enctype="multipart/form-data">
    <h2 style="text-align: center;">FABRIC INWARD</h2>

    <!-- Table for managing roll status -->
    <table id="rollTable">
      <thead>
        <tr>
          <th>Roll Number</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        // Fetch data from the database and populate the table dynamically
        $roll_query = mysqli_query($conn, "SELECT * FROM roll");
        while($roll_rows = mysqli_fetch_array($roll_query)) { 
        ?>
          <tr id="roll-row-<?php echo $roll_rows['roll_number']; ?>">
            <td><?php echo $roll_rows['roll_number']; ?></td>
            <td id="status-<?php echo $roll_rows['roll_number']; ?>">
              <?php echo $roll_rows['status']; ?>  <!-- Display the current status from the DB -->
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- QR Scanner Container -->
    <div id="scannerContainer">
      <video id="videoElement" width="100%" height="100%" autoplay></video>
    </div>

    <script>
      const scanner = new Html5QrcodeScanner(
        "scanner", { fps: 10, qrbox: 250 }
    );

    scanner.render(
        (decodedText, decodedResult) => {
            // Send the decoded text to the backend to update status
            fetch("update_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `material_code=${encodeURIComponent(decodedText)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("status-msg").textContent = "Status updated successfully!";
                    document.getElementById(`status-${decodedText}`).textContent = "Issued";
                } else {
                    document.getElementById("status-msg").textContent = "Failed to update status.";
                }
            })
            .catch(error => {
                console.error("Error:", error);
                document.getElementById("status-msg").textContent = "Error updating status.";
            });
        },
        (errorMessage) => {
            console.log(errorMessage);
        }
    );
      // Function to start QR Code scanning
      function startQRCodeScanner() {
        const video = document.getElementById('videoElement');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        // Set up the camera feed
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
          .then(stream => {
            video.srcObject = stream;
            video.play();

            // Function to scan the video feed
            function scanQRCode() {
              if (video.readyState === video.HAVE_ENOUGH_DATA) {
                canvas.height = video.videoHeight;
                canvas.width = video.videoWidth;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const decoded = jsQR(imageData.data, canvas.width, canvas.height);

                if (decoded) {
                  const rollNumberScanned = parseInt(decoded.data);
                  // Call issueRoll with the scanned roll number
                  issueRoll(rollNumberScanned);
                }
              }

              requestAnimationFrame(scanQRCode);
            }

            scanQRCode(); // Start scanning the video feed
          })
          .catch(error => console.error('Error accessing camera: ', error));
      }

      // Function to issue a roll (change its status to 'Issued')
      function issueRoll(rollNumber) {
        fetch('update_roll_status.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: `rollNumber=${rollNumber}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            alert(`Roll ${rollNumber} issued successfully!`);
            
            // Dynamically update the status in the table
            const statusCell = document.getElementById(`status-${rollNumber}`);
            if (statusCell) {
              statusCell.textContent = 'Issued';  // Update the status cell text
            }
          } else {
            alert(data.message);
          }
        })
        .catch(error => console.error('Error issuing roll:', error));
      }

      // Start the QR Code scanner as soon as the page loads
      startQRCodeScanner();
    </script>
  </form>
</body>
</html>
