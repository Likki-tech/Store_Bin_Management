<?php
include('session.php');
include('dbcon.php');

// Check if necessary POST data is provided
if (isset($_POST['RN'], $_POST['Q'], $_POST['S'], $_POST['WD'])) {
    // Retrieve and sanitize shared form data
    $D = trim($_POST['D']);        
    $MT = trim($_POST['MT']);
    $MC = trim($_POST['MC']);
    $RN1 = trim($_POST['RN1']);
    $BN = isset($_POST['BN']) ? trim($_POST['BN']) : ''; // BIN_NUM
    $rolls = intval($_POST['rolls']);
    $AQ = floatval($_POST['AQ']);
    $poqty = floatval($_POST['poqty']);

    // Debug BIN_NUM
    error_log("BIN_NUM Value: " . $BN);

    // Ensure BIN_NUM is provided
    if (empty($BN)) {
        die("Error: BIN_NUM cannot be empty.");
    }

    // Array inputs
    $RN = $_POST['RN'];  // Roll Numbers
    $Q = $_POST['Q'];    // Quantities
    $WD = $_POST['WD'];  // Width Details
    $S = $_POST['S'];    // Shades

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO fabric(
        `DATE`, `MATERIAL_TYPE`, `MATERIAL_CODE`, `RACK_NUM`, `BIN_NUM`, 
        `NO_OF_ROLLS`, `ROLL_NUM`, `QTY`, `WIDTH_DETAILS`, `SHADE`, 
        `actual_quantity`, `PO_QTY`
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Loop through each entry in the arrays
    for ($i = 0; $i < count($RN); $i++) {
        $roll_num = isset($RN[$i]) ? trim($RN[$i]) : null;
        $quantity = isset($Q[$i]) ? floatval($Q[$i]) : 0;
        $width_detail = isset($WD[$i]) ? trim($WD[$i]) : '';
        $shade = isset($S[$i]) ? trim($S[$i]) : '';

        // Skip if roll number is missing or empty
        if (!empty($roll_num)) {
            $stmt->bind_param(
                "sssssissssss",
                $D, $MT, $MC, $RN1, $BN, $rolls,
                $roll_num, $quantity, $width_detail, $shade, $AQ, $poqty
            );

            if (!$stmt->execute()) {
                // Log the error for debugging
                error_log("Error executing statement: " . $stmt->error);
            }
        }
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();

    // Redirect to the desired page
    header('Location: test1.php');
    exit;
} else {
    // Show an error message if required data is missing
    echo "Error: Required data not provided.";
}
?>
