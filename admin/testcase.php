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
    <title>Fabric Dashboard</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        .dashboard {
             position: relative; /* Fixes the buttons on the left */
             top: 20px; /* Adjust the top position as needed */
             left: 20px; /* Adjust the left position for spacing */
             display: flex;
             flex-direction: row;
             gap: 10px;
             z-index: 10;
             margin: 20px auto;
             padding: 10px 0;
             border-radius: 10px;
             box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Fabric Button Styles */
    .fabric-button {
        padding: 12px 25px;
        font-size: 1.1em;
        font-weight: bold;
        color: #ffffff;
        background-color: #007bff; /* Vibrant blue */
        border: none;
        border-radius: 8px;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Button Hover Effect */
    .fabric-button:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: translateY(-3px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
    }

    /* Button Active Effect */
    .fabric-button:active {
        background-color: #003d82; /* Even darker blue on click */
        transform: translateY(0);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
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
        }
        .table-title {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            color: #0f80dd;
            margin-bottom: 10px;
        }
        .fabric-button1 {
            padding: 10px 20px;
            font-size: 0.9em;
            font-weight: bold;
            color: #ffffff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        .fabric-button1:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.9em;
            background-color: #f9f9f9;
        }
        thead th {
            background-color: #2196F3;
            color: #fff;
            padding: 10px;
        }
        tbody tr {
            border: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        td, th {
            padding: 10px;
            text-align: center;
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
        <h1 class="table-title">Fabric Dashboard</h1>
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
            <tbody>
            <?php 
            $fabric_query = mysqli_query($conn, "SELECT * FROM fabric");
            while ($fabric_rows = mysqli_fetch_array($fabric_query)) {
                $id = $fabric_rows['BIN_NUM'];
            ?>
                <tr>
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
                    <td>
                        <form action="generate_qrcode.php" method="POST" style="display:inline;">
                            <input type="hidden" name="material_code" value="<?php echo $fabric_rows['MATERIAL_CODE']; ?>">
                            <input type="hidden" name="RN" value="<?php echo $fabric_rows['ROLL_NUM']; ?>">
                            <input type="hidden" name="Q" value="<?php echo $fabric_rows['QTY']; ?>">
                            <input type="hidden" name="WN" value="<?php echo $fabric_rows['WIDTH_DETAILS']; ?>">
                            <input type="hidden" name="S" value="<?php echo $fabric_rows['SHADE']; ?>">
                            <button type="submit" class="fabric-button1">QR Code</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
