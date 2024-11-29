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
        /* General Styles */
        body {
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: Arial, sans-serif;
        }
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

        .dashboard {
            position: relative;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
            margin: 20px auto;
        }
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
    .table-title {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            color: #0f80dd;
        }
        /* Table Container Styling */
.table-container {
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    background-color: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
    background: #f9f9f9;
}

/* Table Header Styling */
table {
    width: 100%;
    table-layout:fixed;
    border-collapse: collapse;
    font-size: 1em;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

thead th {
    background-color: #007bff; /* Blue background for header */
    color: white;
    padding: 12px 15px;
    text-align: left;
    font-weight: bold;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    border-bottom: 2px solid #ddd;
}

/* Table Body Styling */
tbody tr:nth-child(even) {
    background-color: #f4f7fc; /* Light gray for even rows */
}

tbody tr:nth-child(odd) {
    background-color: #ffffff; /* White for odd rows */
}

tbody td {
    padding: 12px 15px;
    border-bottom: 1px solid #ddd;
    text-align: left;
    font-size: 0.9em;
    color: #333;
    transition: background-color 0.3s ease-in-out;
}

/* Hover Effect for Table Rows */
tbody tr:hover {
    background-color: #e0e7ff; /* Light blue when hovering over row */
}

/* Action Button Styling */
button.fabric-button1 {
    padding: 8px 16px;
    font-size: 0.9em;
    font-weight: bold;
    background-color: #28a745;
    color: #ffffff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
    margin-top: 5px;
}

button.fabric-button1:hover {
    background-color: #218838;
    transform: scale(1.05);
}

button.fabric-button1:active {
    background-color: #1e7e34;
    transform: scale(1);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    table {
        font-size: 0.8em;
    }
    thead th {
        padding: 10px;
    }
    tbody td {
        padding: 10px;
    }
}

        table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd;
    width: auto; /* Ensure columns are not too narrow */
}

table th {
    padding: 10px;
    text-align: center;
    background-color: #2196F3;
    color: white;
}
        tbody tr:hover {
            background-color: #f1f1f1;
        }
        .excel_button {
        text-align: center;
        margin: 20px auto;
    }

    /* Stylish Button */
    .btn-excel {
        background-color: #28a745; /* Green background */
        color: #ffffff; /* White text */
        border: none;
        padding: 12px 25px;
        font-size: 1.2em;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-radius: 8px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Button Hover Effect */
    .btn-excel:hover {
        background-color: #218838; /* Darker green */
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        transform: translateY(-3px);
    }

    /* Button Active Effect */
    .btn-excel:active {
        background-color: #1e7e34; /* Even darker green */
        transform: translateY(0);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
    }

    /* Icon Styling */
    .btn-excel i {
        font-size: 1.5em;
    }
/* Make sure the button is visible and not affected by other styles */
.fabric-button1 {
    padding: 8px 15px;
    font-size: 0.9em;
    font-weight: bold;
    color: #ffffff;
    background-color: #28a745; 
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block !important;  /* Force display */
    text-align: center !important;
    visibility: visible !important;  /* Force visibility */
}

.fabric-button1:hover {
    background-color: #218838;
    transform: scale(1.05);
}

.fabric-button1:active {
    background-color: #1e7e34;
    transform: scale(1);
}


    </style>
</head>
<body>
    <!-- Navigation Buttons -->
    <div class="dashboard">
        <a href="home1.php"><button class="fabric-button">Home</button></a>
        <a href="fabric_dashboard.php"><button class="fabric-button">Fabric</button></a>
        <a href="dashboard.php"><button class="fabric-button">Dashboard</button></a>
        <a href="test1.php"><button class="fabric-button">Add Fabric</button></a>
    </div>
    <div class="search-bar">
            
            <input type="text" id="search-input" placeholder="Search..." onkeyup="fetchSearchResults()">
            
	
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M21.53 20.47l-4.81-4.81a8.5 8.5 0 10-1.06 1.06l4.81 4.81a.75.75 0 101.06-1.06zM10.5 18a7.5 7.5 0 110-15 7.5 7.5 0 010 15z"/>
            </svg>
        </div>
    <!-- Table Container -->
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                // Fetch data from the database
                $query = "SELECT * FROM `fabric`";
                $result = mysqli_query($conn, $query);

                // Loop through each row of the query result
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['DATE']); ?></td>
                        <td><?php echo htmlspecialchars($row['MATERIAL_TYPE']); ?></td>
                        <td><?php echo htmlspecialchars($row['MATERIAL_CODE']); ?></td>
                        <td><?php echo htmlspecialchars($row['RACK_NUM']); ?></td>
                        <td><?php echo htmlspecialchars($row['BIN_NUM']); ?></td>
                        <td><?php echo htmlspecialchars($row['NO_OF_ROLLS']); ?></td>
                        <td><?php echo htmlspecialchars($row['ROLL_NUM']); ?></td>
                        <td><?php echo htmlspecialchars($row['QTY']); ?></td>
                        <td><?php echo htmlspecialchars($row['WIDTH_DETAILS']); ?></td>
                        <td><?php echo htmlspecialchars($row['SHADE']); ?></td>
                        <td><?php echo htmlspecialchars($row['actual_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($row['PO_QTY']); ?></td>
                        <td><?php echo htmlspecialchars($row['STATUS']); ?></td>
                        <td>
                        <form action="generate_qrcode.php" method="POST" style="display:inline;">
                            <input type="hidden" name="material_code" value="<?php echo htmlspecialchars($row['MATERIAL_CODE']); ?>">
                            <input type="hidden" name="RN" value="<?php echo htmlspecialchars($row['ROLL_NUM']); ?>">
                            <input type="hidden" name="Q" value="<?php echo htmlspecialchars($row['QTY']); ?>">
                            <input type="hidden" name="WN" value="<?php echo htmlspecialchars($row['WIDTH_DETAILS']) ; ?>">
                            <input type="hidden" name="S" value="<?php echo htmlspecialchars($row['SHADE']); ?>">
                            <button type="submit" class="fabric-button1">QR Code</button>
                        </form>
                    </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
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
