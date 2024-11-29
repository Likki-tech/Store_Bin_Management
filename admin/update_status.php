<?php
include('dbcon.php');

// Log errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rollNumber = $_POST['RN'];

    // Log the roll number received
    error_log("Roll Number Received: " . $rollNumber);

    if (!empty($rollNumber)) {
        $query = "UPDATE fabric SET status = 'Issued' WHERE ROLL_NUM = ?";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param('i', $rollNumber);
            if ($stmt->execute()) {
                // Log successful update
                error_log("Status updated successfully for Roll Number: $rollNumber");
                echo json_encode(['status' => 'success', 'message' => 'Status updated successfully']);
            } else {
                // Log query execution failure
                error_log("Failed to execute query for Roll Number: $rollNumber");
                echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
            }
            $stmt->close();
        } else {
            // Log statement preparation failure
            error_log("Failed to prepare statement");
            echo json_encode(['status' => 'error', 'message' => 'Failed to prepare statement']);
        }
    } else {
        error_log("Invalid Roll Number");
        echo json_encode(['status' => 'error', 'message' => 'Invalid roll number']);
    }
} else {
    error_log("Invalid Request Method");
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

$conn->close();
?>
