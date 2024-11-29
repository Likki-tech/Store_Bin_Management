<?php
include('dbcon.php');

// Check if a POST request was made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = isset($_POST['query']) ? $_POST['query'] : '';
    $query = $conn->real_escape_string($query);

    // SQL query for filtering
    $sql = "SELECT * FROM fabric 
            WHERE MATERIAL_CODE LIKE '%$query%' 
            OR MATERIAL_TYPE LIKE '%$query%' 
            OR RACK_NUM LIKE '%$query%'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['DATE']}</td>
                    <td>{$row['MATERIAL_TYPE']}</td>
                    <td>{$row['MATERIAL_CODE']}</td>
                    <td>{$row['RACK_NUM']}</td>
                    <td>{$row['BIN_NUM']}</td>
                    <td>{$row['PO_QTY']}</td>
                    <td>{$row['actual_quantity']}</td>
                    <td>{$row['NO_OF_ROLLS']}</td>
                    
                    
                    
                    
                </tr>";
        }
    } else {
        echo "<tr class='no-results'><td colspan='12'>No matching records found</td></tr>";
    }
}
?>
