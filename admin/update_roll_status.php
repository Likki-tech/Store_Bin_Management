<?php
include("dbcon.php");

if (isset($_POST['rollNumber'])) {
    $rollNumber = $_POST['rollNumber'];

    // Update the roll status to 'Issued'
    $query = "UPDATE roll SET status = 'Issued' WHERE roll_number = '$rollNumber'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update status"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Roll number not provided"]);
}
?>
