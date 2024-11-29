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
    <title>Store Management</title>
    
    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
   body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    
    background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
    backdrop-filter: blur(5px); 
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}
.fcard-container {
    display: flex;
    justify-content: space-between;
    
    width: 80%;
    max-width: 1200px;
    flex-direction: row;
}
.fabric-card {
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 30%;
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease;
}

/* Specific card styles */
.fabric-input-card {
    background-color: #e8f5e9; /* Light Green */
}

.fabric-issue-card {
    background-color: #ffebee; /* Light Red */
}


/* Card title styles */
.fabric-card h3 {
    font-size: 1.5em;
    color: #333;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Icon styles */
.fabric-card i {
    margin-right: 10px;
    font-size: 1.8em;
}

/* Specific icon colors */
.fabric-input-icon {
    color: #4CAF50; /* Green for "Fabric input" */
}

.fabric-issue-icon {
    color: #F44336; /* Red for "Fabric issue" */
}


/* Hover effect */
.fabric-card:hover {
    transform: translateY(-10px);
}
a{
    text-decoration: none;
}

/* Responsive design */
@media screen and (max-width: 768px) {
    .fcard-container {
        flex-direction: column;
        align-items: center;
    }

    .fabric-card {
        width: 80%;
        margin-bottom: 20px;
    }
}

    </style>
</head>
<body>
    <div class="fcard-container">
        <div class="fabric-card fabric-input-card">
        <a href="test1.php" >  <h3>Fabric Inward&nbsp;<i class="fas fa-plus-circle fabric-input-icon"></i></h3></a>
        </div>
        <div class="fabric-card fabric-issue-card">
        <a href="fabricissuance.php"> <h3>Fabric Issuance&nbsp;<i class="fas fa-minus-circle fabric-issue-icon"></i></h3></a>
        </div>
        
    </div>
</body>
</html>