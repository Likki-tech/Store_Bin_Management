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
    <title>Styled Table with Search</title>
    <style>
        /* (Your existing styles go here) */
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Buttons for navigation -->
        <a href="home1.php"><button class="fabric-button">Home</button></a>
        <a href="fabric_dashboard.php"><button class="fabric-button">Fabric</button></a>
        <a href="dashboard.php"><button class="fabric-button">Dashboard</button></a>
        <a href="test1.php"><button class="fabric-button">Add Fabric</button></a>
    </div>
    
    <div class="table-container">
        <h1 class="table-title">Fabric Dashboard</h1>

        <!-- Excel Download Button -->
        <div class="excel_button">
            <form method="POST" action="excel_download.php">
                <button id="excel" class="btn-excel" name="save">
                    <i class="icon-download icon-large"></i>Download Excel File
                </button>
            </form>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="search-input" placeholder="Search..." onkeyup="fetchSearchResults()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.53 20.47l-4.81-4.81a8.5 8.5 0 10-1.06 1.06l4.81 4.81a.75.75 0 101.06-1.06zM10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/>
            </svg>
        </div>

        <!-- Table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Material Type</th>
                    <th>Material Code</th>
                    <th>Rack Number</th>
                    <th>Bin Number</th>
                    <th>No. of Rolls</th>
                    <th>Roll Number</th>
                    <th>Quantity</th>
                    <th>Width</th>
                    <th>Shade</th>                    
                    <th>Actual Quantity</th>
                    <th>PO Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php 
                    $fabric_query = mysqli_query($conn, "SELECT * FROM fabric");
                    while($fabric_rows = mysqli_fetch_array($fabric_query)) { 
                        $id = $fabric_rows['BIN_NUM'];
                ?>
                <tr class="del<?php echo $id; ?>">
                    <td><?php echo $fabric_rows['DATE']; ?></td>
                    <td><?php echo $fabric_rows['MATERIAL_TYPE']; ?></td>
                    <td><?php echo $fabric_rows['MATERIAL_CODE']; ?></td>
                    <td><?php echo $fabric_rows['RACK_NUM']; ?></td>
                    <td><?php echo $fabric_rows['BIN_NUM']; ?></td>
                    <td><?php echo $fabric_rows['NO_OF_ROLLS']; ?></td>
                    <td><?php echo $fabric_rows['ROLL_NUM']; ?></td>
                    <td><?php echo $fabric_rows['QTY']; ?></td>
                    <td><?php echo $fabric_rows['WIDTH_DETAILS']; ?></td>
                    <td><?php echo $fabric_rows['SHADE']; ?></td>
                    <td><?php echo $fabric_rows['actual_quantity']; ?></td>
                    <td><?php echo $fabric_rows['PO_QTY']; ?></td>
                    <td width="240" align="center">
                        <!-- Correctly placing the QR Code button -->
                        <button class="btn btn-success" onclick="generateQRCode('<?php echo $id; ?>')">
                            <i class="icon-edit icon-large"></i>&nbsp;Qr Code
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Script for QR Code Generation -->
    <script>
        function generateQRCode(id) {
            // Open the QR code generation page in a new tab
            window.open('generate_qr.php?id=' + id, '_blank', 'width=400, height=400');
        }

        // AJAX for live search
        function fetchSearchResults() {
            const query = document.getElementById('search-input').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'search.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('table-body').innerHTML = xhr.responseText;
                }
            };

            xhr.send('query=' + encodeURIComponent(query));
        }

        // Load all data on page load
        window.onload = fetchSearchResults;
    </script>
</body>
</html>
