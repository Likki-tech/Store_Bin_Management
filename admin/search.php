<?php
include('dbcon.php'); // Database connection

// Get the search query
$query = isset($_POST['query']) ? $_POST['query'] : '';

// SQL query to search the database based on the query
if ($query != '') {
    // Search query: searching in MATERIAL_CODE, MATERIAL_TYPE, and ROLL_NUM fields
    $sql = "SELECT * FROM fabric WHERE MATERIAL_CODE LIKE ? OR MATERIAL_TYPE LIKE ? OR ROLL_NUM LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = '%' . $query . '%'; // Add wildcards for partial matching
    $stmt->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
} else {
    // If no query, return all rows
    $sql = "SELECT * FROM fabric";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

// Loop through the rows and display them
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['DATE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['MATERIAL_TYPE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['MATERIAL_CODE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['RACK_NUM']) . "</td>";
    echo "<td>" . htmlspecialchars($row['BIN_NUM']) . "</td>";
    echo "<td>" . htmlspecialchars($row['NO_OF_ROLLS']) . "</td>";
    echo "<td>" . htmlspecialchars($row['ROLL_NUM']) . "</td>";
    echo "<td>" . htmlspecialchars($row['QTY']) . "</td>";
    echo "<td>" . htmlspecialchars($row['WIDTH_DETAILS']) . "</td>";
    echo "<td>" . htmlspecialchars($row['SHADE']) . "</td>";
    echo "<td>" . htmlspecialchars($row['actual_quantity']) . "</td>";
    echo "<td>" . htmlspecialchars($row['PO_QTY']) . "</td>";
    echo "<td>" . htmlspecialchars($row['STATUS']) . "</td>";
    echo "</tr>";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
