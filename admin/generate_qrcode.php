<?php
require('phpqrcode/qrlib.php'); // Include the PHP QR Code library

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data using null coalescing operator to avoid undefined index errors
    $material_code = $_POST['material_code'] ?? '';
    $rollNumber = $_POST['RN'] ?? '';
    $quantity = $_POST['Q'] ?? '';
    $width = $_POST['WD'] ?? '';
    $shade = $_POST['S'] ?? '';

    // Check if all fields are filled
    
        // Generate QR code data
        $qr_data = "Material Code: $material_code, Roll No: $rollNumber, Qty: $quantity, Width: $width, Shade: $shade";

        // Create QR code and save it to a temporary file
        $temp_file = 'temp_qr_' . uniqid() . '.png';
        QRcode::png($qr_data, $temp_file, QR_ECLEVEL_L, 5);

        // Set headers to force download of the QR code
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="qrcode_' . $material_code . '.png"');
        
        // Output the QR code image
        readfile($temp_file);

        // Remove the temporary file after serving it
        unlink($temp_file);
        exit;
  
} else {
    echo "Invalid request.";
}
?>
