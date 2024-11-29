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
    <title>Cards with Data Entry Table</title>
    <style>
        /* General styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #f4f4f4;
    padding-top: 30px;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
    backdrop-filter: blur(5px);
    
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}

.main-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    width: 90%;
    max-width: 1200px;
    margin-bottom: 20px;
}
.dashboard {
             position: fixed; /* Fixes the buttons on the left */
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

    /* Responsive Design for Smaller Screens */
    @media (max-width: 600px) {
        .dashboard {
            flex-direction: column; /* Stack buttons vertically */
            gap: 10px; /* Reduce space between buttons */
        }

        .fabric-button {
            width: 80%; /* Full width for smaller screens */
        }
    }

/* Button styles */
/*.fabric-button {
    display: inline-block;
    margin-bottom: 10px;
    padding: 10px 20px;
    font-size: 1em;
    color: #ffffff;
    background-color: #4CAF50; /* Green background */
  /*  border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    
}

/* Hover effect for the button */
/*.fabric-button:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Main card styles */
.main-card {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 45%;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.main-card-header {
    margin-bottom: 20px;
}

.main-card h2 {
    margin: 0;
    font-size: 1.8em;
    color: #333;
}

/* Hover effect for the main card */
.main-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Sub-card container */
.sub-card-container {
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

/* Sub-card styles */
.sub-card {
    border-radius: 8px;
    padding: 15px;
    width: 30%;
    text-align: center;
    color: #fff; /* White text for contrast */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Background colors for sub-cards */   
.sub-card:nth-child(1) {
    background-color: #81ff87; /* Green for Total Inward */
}

.sub-card:nth-child(2) {
    background-color: #ef251b; /* Red for Total Issued */
}

.sub-card:nth-child(3) {
    background-color: #6db7f4; /* Blue for Balance */
}

/* Hover effect for sub-cards */
.sub-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.sub-card h3 {
    margin: 0;
    font-size: 1.2em;
    color: #fff; /* White text for headings */
}

.sub-card p {
    margin: 10px 0 0;
    font-size: 1.1em;
    color: #fff; /* White text for numbers */
    font-weight: bold;
}

/* Table container styles */
.table-container {
    width: 100%;
    max-width: 1200px;
    margin-top: 20px;
    background-color: #ffffff;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9em;
    margin-top: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #2196F3;
    color: #fff;
    font-weight: bold;
}

td {
    background-color: #f9f9f9;
}
/*.dashboard {
    padding-top: 10px;
    background-color: #f4f4f4;
    padding-left:10px;
    
}*/
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
     

@media screen and (max-width: 768px) {
    .main-card {
        width: 100%;
    }

    .sub-card-container {
        flex-direction: column;
    }

    .sub-card {
        width: 100%;
    }
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
</div>

<body>
    <div class="main-container">
        <!-- Fabric Card -->
        <div class="main-card">
            <!-- Fabric Button (at the top of the card) -->
            
            
            <div class="main-card-header">
                <h2>Fabric</h2>
            </div>
            <div class="sub-card-container">
                <div class="sub-card">
                    <h3>Total Inward</h3>
                    <p>120000</p>
                </div>
                <div class="sub-card">
                    <h3>Total Issued</h3>
                    <p>90000</p>
                </div>
                <div class="sub-card">
                    <h3>Balance</h3>
                    <p>30000</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shared Table for Data Entry -->
    <div class="table-container">
       <div class="search-bar">
            
            <input type="text" id="search-input" placeholder="Search..." onkeyup="fetchSearchResults()">
            
	
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.53 20.47l-4.81-4.81a8.5 8.5 0 10-1.06 1.06l4.81 4.81a.75.75 0 101.06-1.06zM10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/>
            </svg>
        </div>
    
        <table>
        
            <thead>
                
                <tr>
                    <th>Date</th>
                    <th>Material Type</th>
                    <th>Material Code</th>
                    <th>Rack Number</th>
                    <th>Bin Number</th>
                    <th>PO Quantity</th>
                    <th>Actual Quantity</th>
                    <th>No. of Rolls/Packages</th>
                    <th>Difference</th>
                    <th>Issued Date</th>
                    <th>Issued WO Number</th>
                    <th>Qty Issued</th>
                    <th>Balance Quantity</th>
                    <th>Transmit Time</th>
                </tr>
            </thead>
            <tbody id="table-body">
            <?php 
                $fabric_query = mysqli_query($conn, "SELECT * FROM fabric");
                while($fabric_rows = mysqli_fetch_array($fabric_query)) { 
                    $id = $fabric_rows['BIN_NUM'];
                    $fl = $fabric_rows['MATERIAL_CODE'];
                ?>
                <tr class="del<?php echo $id; ?>">
                <!-- Empty rows for data entry -->
                    <td text-align="center" ><?php echo $fabric_rows['DATE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['MATERIAL_TYPE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['MATERIAL_CODE']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['RACK_NUM']; ?></td>
                    <td text-align="center"><?php echo $fabric_rows['BIN_NUM']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['PO_QTY']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['actual_quantity']; ?></td>
                    <td text-align="center" ><?php echo $fabric_rows['NO_OF_ROLLS']; ?></td>
                    
                </tr>
                <?php } ?>
            </tbody>
            <script>
        // AJAX for live search
        function fetchSearchResults() {
            const query = document.getElementById('search-input').value;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'search1.php', true);
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
        </table>
    </div>
</body>
</html>
