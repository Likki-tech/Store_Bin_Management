<?php
include('session.php');
include('header.php');
include('dbcon.php');
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Layout</title>
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
           @media only screen and (max-width: 400px) {
    body {
        font-size: 16px;
    }
    .container {
        padding: 5px;
    }
}
       body {
            display: flex;
            justify-content: center;
            align-items: center;
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

        /* Wrapper to center the layout */
        .container {
            display: flex;
            flex-direction: column; /* Layout as a column */
            align-items: center;
            gap: 20px; /* Gap between cards */
        }

        /* Fabric and Trims container */
        .fabric-body {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Gap between Fabric and Trims */
        }

        .fabric-card,
        .trims-card {
            position: relative;
            width: 288px;
            height: 352px;
            background-size: cover;
            background-position: center;
            color: #1f2937;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.7s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .fabric-card:hover,
        .trims-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2);
        }

        .fabric-card-back,
        .trims-card-back {
            position: absolute;
            bottom: -76px;
            width: 100%;
            background-color: #d9e4e4;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: bottom 0.5s ease-in-out;
        }

        .fabric-card:hover .fabric-card-back,
        .trims-card:hover .trims-card-back {
            bottom: 0;
        }
        /* Dashboard Card */
        .dashboard-card {
            background-color: #aac3c3;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 450px; /* Increased width */
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .dashboard-card h3 {
            font-size: 1.5em;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-icon {
            color: #2196F3;
            margin-left: 10px;
            font-size: 1.8em;
        }
        a{
            color: black;
            text-decoration: none;
        }
        a:hover{
            color: purple;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Fabric and Trims cards -->
        <div class="fabric-body">
            <!-- Fabric Card -->
            <a href="fabric.php" >  <div class="fabric-card" style="background-image: url('images/fabric.jpg');">
                <div class="fabric-card-front">
                    <!-- Front content unchanged -->
                </div>
                <div class="fabric-card-back">
                   <span class="fabric-title" style="font-size: 22px;"><b>Fabric</b></span>
                    <p class="fabric-description">This card contains information about fabric materials and styles.</p>
                </div>
            </div></a>

            <!-- Trims Card -->
            <div class="trims-card" style="background-image: url('images/trims.jpg');">
                <div class="trims-card-front">
                    <!-- Front content unchanged -->
                </div>
                <div class="trims-card-back">
                    <span class="trims-title" style="font-size: 22px;"><b>Trims</b></span>
                    <p class="trims-description">This card contains information about trims and finishing touches.</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Card below Fabric and Trims -->
        <div class="dashboard-card">
        <a href="dashboard.php"> <h3>Dashboard&nbsp;<i class="fas fa-bars dashboard-icon"></i></h3></a>
        </div>
    </div>
</body>
</html>