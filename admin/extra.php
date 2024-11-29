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
        /* Table Container Styles */
      body{  min-height: 100vh;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
            backdrop-filter: blur(5px);
            
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
      }

        .table-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            position: relative;
        }

        /* Centered Heading Styles */
        .table-title {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            color: #0f80dd;
            margin-bottom: 10px;
        }

        /* Search Bar Styles */
        .search-bar {
            position: absolute;
            top: 15px;
            right: 20px;
            display: flex;
            align-items: center;
            background-color: #f9f9f9;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease, background-color 0.3s ease;
        }

        .search-bar:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            background-color: #f1f1f1;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: none;
            font-size: 0.9em;
            padding: 5px;
            margin-left: 5px;
            width: 150px;
        }

        .search-bar input::placeholder {
            color: #aaa;
        }

        .search-bar svg {
            width: 16px;
            height: 16px;
            fill: #2196F3;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
            text-align: center;
            background-color: #f9f9f9;
            margin-top: 20px;
        }

        /* Table Header */
        thead th {
            background-color: #2196F3;
            color: #fff;
            font-weight: bold;
            padding: 10px;
        }

        /* Table Rows */
        tbody tr {
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        /* Hover Effect for Rows */
        tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .dashboard {
    padding-top: 10px;
    background-color: transperant;
    padding-left:10px;
}
.fabric-button {
    display: inline-block;
    margin-bottom: 10px;
    padding: 10px 20px;
    font-size: 1em;
    color: #ffffff;
   
    background-color: teal; /* Green background */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    
}

/* Hover effect for the button */
.fabric-button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    background-color: darkgray; /* Slightly darker gray on hover */
}

        /* Table Cells */
        td, th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        /* Empty Cells */
        tbody td {
            background-color: #fff;
        }
    </style>
</head>
<div class="dashboard">
    <a href="home1.php">
    <button  class="fabric-button">Home</button>&nbsp;&nbsp;
    </a> 
    <a href="fabric_dashboard.php">
    <button  class="fabric-button">Fabric</button>&nbsp;&nbsp;
    </a>
    
    <a href="dashboard.php">
        <button class="fabric-button">Dashboard</button>
    </a>
    <a href="test1.php">
        <button class="fabric-button">Add Fabric</button>
    </a>
</div>
<body>
    <div class="table-container">
        <!-- Centered Title -->
        <h1 class="table-title">Fabric Dashboard</h1>
        
        <!-- Search Bar -->
        <div class="search-bar">
            
            <input type="text" placeholder="Search..." onkeyup="fetchSearchResults()">
            
	
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.53 20.47l-4.81-4.81a8.5 8.5 0 10-1.06 1.06l4.81 4.81a.75.75 0 101.06-1.06zM10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/>
            </svg>
        </div>
        <script>
            function fetchSearchResults() {
    const searchQuery = document.getElementById('search-input').value;

    // Send AJAX request to fetch filtered data
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'search.php', true); // Backend script for searching
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.querySelector('tbody').innerHTML = xhr.responseText;
        }
    };
    xhr.send('query=' + encodeURIComponent(searchQuery));
}

        </script>

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
                    
                </tr>
            </thead>
            <tbody>
            <?php 
                $fabric_query = mysqli_query($conn, "SELECT * FROM fabric");
                while($fabric_rows = mysqli_fetch_array($fabric_query)) { 
                    $id = $fabric_rows['BIN_NUM'];
                    $fl = $fabric_rows['MATERIAL_CODE'];
                ?>
                <tr class="del<?php echo $id; ?>">
                    <td text-align="center" ><?php echo $fabric_rows['DATE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['MATERIAL_TYPE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['MATERIAL_CODE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['RACK_NUM']; ?></td>
                    <td text-align="center"><?php echo $fabric_rows['BIN_NUM']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['NO_OF_ROLLS']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['ROLL_NUM']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['QTY']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['WIDTH_DETAILS']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['SHADE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['actual_quantity']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['PO_QTY']; ?></td>
                   <!-- <td width="240" align="center">
                        <a class="btn btn-success" href="edit_candidate.php<?php echo '?id='.$id; ?>"><i class="icon-edit icon-large"></i>&nbsp;Edit</a>&nbsp;
                        <a href="#" class="btn btn-info" id="viewCandidate" data-id="<?php echo $id; ?>"><i class="icon-list icon-large"></i>&nbsp;View </a>
                        <a class="btn btn-danger1" id="<?php echo $id; ?>"><i class="icon-trash icon-large"></i>&nbsp;Delete</a>&nbsp;
                    </td>-->
                </tr>

                <!-- Modal for candidate information -->
                <!--<div class="modal hide fade" id="<?php echo $id; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1>Candidate Information</h1>
                    </div>
                    <div class="modal-body">
                        <div class="pull-right-modal">
                            <p><strong>BIN NUM:</strong> <?php echo $fabric_rows['BIN NUM']; ?></p>
                            <p><strong>PO QTY:</strong> <?php echo $fabric_rows['PO QTY']; ?></p>
                            <p><strong>MATERIAL TYPE:</strong> <?php echo $fabric_rows['MATERIAL TYPE']; ?></p>
                            <p><strong>MATERIAL CODE:</strong> <?php echo $fabric_rows['MATERIAL_CODE']; ?></p>
                            <p><strong>NO. OF ROLLS:</strong> <?php echo $fabric_rows['NO.OF ROLLS']; ?></p>
                            <p><strong>ROLL NUM:</strong> <?php echo $fabric_rows['ROLL NUM']; ?></p>
                            <p><strong>WIDTH DETAILS:</strong> <?php echo $fabric_rows['WIDTH DETAILS']; ?></p>
                            <p><strong>QTY:</strong> <?php echo $fabric_rows['QTY']; ?></p>
                            <p><strong>SHADE:</strong> <?php echo $fabric_rows['SHADE']; ?></p>
                            <p><strong>RACK NUM:</strong> <?php echo $fabric_rows['RACK NUM']; ?></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn" data-dismiss="modal">Close</a>
                    </div>
                </div>-->
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
