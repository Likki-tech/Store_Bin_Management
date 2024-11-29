<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        video {
            width: 100%;
            max-width: 400px;
            border: 2px solid #000;
            margin: 10px auto;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            margin: 10px;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>QR Code Scanner</h1>
    
    <!-- Video Stream -->
    <video id="videoElement" autoplay muted playsinline></video>
    
    <!-- Camera Switch Button -->
    <button id="switchCameraButton">Switch Camera</button>
    
    <!-- Table Display -->
    <h2>Fabric Table</h2>
    <table>
        <thead>
            <tr>
                <th>Roll Number</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>12345</td>
                <td id="status-12345">Pending</td>
            </tr>
            <tr>
                <td>67890</td>
                <td id="status-67890">Pending</td>
            </tr>
        </tbody>
    </table>

    <!-- Include jsQR Library -->
    <script src="js/jsQR.min.js"></script>
    
    <script>
        let videoStream = null; // Store the current video stream
        let currentCamera = 'environment'; // Default to back camera
        let lastScanned = ''; // Store the last scanned QR code to prevent duplicates

        // Start the QR Code scanner
        function startQRCodeScanner() {
            const video = document.getElementById('videoElement');
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            // Initialize the camera
            function initializeCamera() {
                if (videoStream) {
                    // Stop existing camera stream
                    videoStream.getTracks().forEach((track) => track.stop());
                }

                navigator.mediaDevices
                    .getUserMedia({ video: { facingMode: currentCamera } })
                    .then((stream) => {
                        videoStream = stream;
                        video.srcObject = stream;

                        // Ensure that the video is played and rendered on mobile
                        video.onloadedmetadata = () => {
                            video.play();
                            // Resize the video element for better mobile support
                            video.width = window.innerWidth;
                        };

                        scanQRCode(); // Start scanning the QR code
                    })
                    .catch((error) => {
                        console.error('Camera access error:', error);
                        alert('Unable to access the camera. Please check your permissions.');
                    });
            }

            // Scan the video feed for QR codes
            function scanQRCode() {
                if (video.readyState === video.HAVE_ENOUGH_DATA) {
                    canvas.height = video.videoHeight;
                    canvas.width = video.videoWidth;
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                    const decoded = jsQR(imageData.data, canvas.width, canvas.height);

                    if (decoded && decoded.data !== lastScanned) {
                        lastScanned = decoded.data.trim(); // Extract and store the scanned data
                        console.log('Scanned Roll Number:', lastScanned);

                        // Update the roll status dynamically
                        issueRoll(lastScanned);
                    }
                }

                setTimeout(() => requestAnimationFrame(scanQRCode), 500); // Scan every 500ms
            }

            // Switch cameras
            document.getElementById('switchCameraButton').addEventListener('click', () => {
                currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
                initializeCamera(); // Reinitialize the camera with the new mode
            });

            initializeCamera(); // Start the camera
        }

        // Send the scanned roll number to the server
        function issueRoll(rollNumber) {
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `rollNumber=${encodeURIComponent(rollNumber)}`,
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        alert(`Roll ${rollNumber} issued successfully!`);
                        const statusCell = document.getElementById(`status-${rollNumber}`);
                        if (statusCell) {
                            statusCell.textContent = 'Issued'; // Update the table dynamically
                        }
                    } else {
                        alert(`Error: ${data.message}`);
                    }
                })
                .catch((error) => {
                    console.error('Server error:', error);
                });
        }

        // Start scanner on page load
        document.addEventListener('DOMContentLoaded', startQRCodeScanner);
    </script>
</body>
</html>
