<?php
include('session.php'); // Ensure the session is active
include('dbcon.php');  // Database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $date = $_POST['D'];
    $materialType = $_POST['MT'];
    $materialCode = $_POST['MC'];
    $rackNumber = $_POST['RN1'];
    $binNumber = $_POST['BN'];
    $actualQuantity = $_POST['actualquantity'];
    $poQuantity = $_POST['poqty'];

    // Validate essential fields
    if (empty($date) || empty($materialCode) || empty($rackNumber) || empty($actualQuantity) || empty($poQuantity)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit();
    }

    // Roll details
    $rollNumbers = $_POST['RN'] ?? [];  // Roll numbers array
    $quantities = $_POST['Q'] ?? [];   // Quantities array
    $widths = $_POST['WN'] ?? [];      // Widths array
    $shades = $_POST['S'] ?? [];       // Shades array

    // Ensure roll details are valid
    if (count($rollNumbers) !== count($quantities) || count($quantities) !== count($widths) || count($widths) !== count($shades)) {
        echo "<script>alert('Mismatch in roll details. Please check your entries.'); window.history.back();</script>";
        exit();
    }

    // Insert the main fabric inward entry
    $query = "INSERT INTO fabric_inward (date, material_type, material_code, rack_number, bin_number, actual_quantity, po_quantity) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssiii', $date, $materialType, $materialCode, $rackNumber, $binNumber, $actualQuantity, $poQuantity);

    if ($stmt->execute()) {
        $fabricInwardId = $stmt->insert_id; // Get the inserted record ID for roll linkage

        // Insert each roll's details
        $queryRoll = "INSERT INTO roll_details (fabric_inward_id, roll_number, quantity, width, shade) 
                      VALUES (?, ?, ?, ?, ?)";
        $stmtRoll = $con->prepare($queryRoll);

        foreach ($rollNumbers as $index => $rollNumber) {
            $quantity = $quantities[$index];
            $width = $widths[$index];
            $shade = $shades[$index];

            // Skip empty roll entries
            if (empty($rollNumber) || empty($quantity) || empty($width) || empty($shade)) {
                continue;
            }

            $stmtRoll->bind_param('isiss', $fabricInwardId, $rollNumber, $quantity, $width, $shade);
            $stmtRoll->execute();
        }

        echo "<script>alert('Fabric inward details saved successfully.'); window.location.href='fabric_inward_list.php';</script>";
    } else {
        echo "<script>alert('Failed to save fabric inward details. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $con->close();
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
    exit();
}
?>
