<?php
ob_start();
include('session.php');
include('header.php');
include('dbcon.php');
?>

<html>
    <head>
        <style>
            body{
                min-height: 100vh;
                margin: 0;
                padding: 0;
                background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg');
                backdrop-filter: blur(5px);
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                background-attachment: fixed;
                transition: background-image 0.3s ease, background-size 0.3s ease, transform 0.3s ease;
            } 
            p{
                color:white;
            }
            .a2{
                text-decoration: none;
                color: white;
            }
            .login-box {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 400px;
                padding: 40px;
                margin: 20px auto;
                transform: translate(-50%, -55%);
                background: rgba(0,0,0,.9);
                box-sizing: border-box;
                box-shadow: 0 15px 25px rgba(0,0,0,.6);
                border-radius: 10px;
            }

            .login-box p:first-child {
                margin: 0 0 30px;
                padding: 0;
                color: #fff;
                text-align: center;
                font-size: 1.5rem;
                font-weight: bold;
                letter-spacing: 1px;
            }

            .login-box .user-box {
                position: relative;
            }

            .login-box .user-box input {
                width: 100%;
                padding: 10px 0;
                font-size: 16px;
                color: #fff;
                margin-bottom: 15px;
                border: none;
                border-bottom: 1px solid #fff;
                outline: none;
                background: transparent;
            }

            .login-box .user-box label {
                position: absolute;
                top: 0;
                left: 0;
                padding: 10px 0;
                font-size: 16px;
                color: #fff;
                pointer-events: none;
                transition: .5s;
            }

            .login-box .user-box input:focus ~ label,
            .login-box .user-box input:valid ~ label {
                top: -20px;
                left: 0;
                color: #fff;
                font-size: 12px;
            }

            .login-box form button {
                position: relative;
                display: inline-block;
                padding: 10px 20px;
                font-weight: bold;
                color: #fff;
                font-size: 16px;
                text-transform: uppercase;
                overflow: hidden;
                border: none;
                background: transparent;
                cursor: pointer;
                transition: 0.5s;
                margin-top: 40px;
                letter-spacing: 3px;
            }

            .login-box form button:hover {
                background: #fff;
                color: #272727;
                border-radius: 5px;
            }

            .login-box form button span {
                position: absolute;
                display: block;
            }

            .login-box form button span:nth-child(1) {
                top: 0;
                left: -100%;
                width: 100%;
                height: 2px;
                background: linear-gradient(90deg, transparent, #fff);
                animation: btn-anim1 1.5s linear infinite;
            }

            @keyframes btn-anim1 {
                0% {
                    left: -100%;
                }

                50%, 100% {
                    left: 100%;
                }
            }

            .login-box form button span:nth-child(2) {
                top: -100%;
                right: 0;
                width: 2px;
                height: 100%;
                background: linear-gradient(180deg, transparent, #fff);
                animation: btn-anim2 1.5s linear infinite;
                animation-delay: 0.375s;
            }

            @keyframes btn-anim2 {
                0% {
                    top: -100%;
                }

                50%, 100% {
                    top: 100%;
                }
            }

            .login-box form button span:nth-child(3) {
                bottom: 0;
                right: -100%;
                width: 100%;
                height: 2px;
                background: linear-gradient(270deg, transparent, #fff);
                animation: btn-anim3 1.5s linear infinite;
                animation-delay: 0.75s;
            }

            @keyframes btn-anim3 {
                0% {
                    right: -100%;
                }

                50%, 100% {
                    right: 100%;
                }
            }

            .login-box form button span:nth-child(4) {
                bottom: -100%;
                left: 0;
                width: 2px;
                height: 100%;
                background: linear-gradient(360deg, transparent, #fff);
                animation: btn-anim4 1.5s linear infinite;
                animation-delay: 1.125s;
            }

            @keyframes btn-anim4 {
                0% {
                    bottom: -100%;
                }

                50%, 100% {
                    bottom: 100%;
                }
            }
        </style>
    </head>
    <body> 
        <div class="login-box">
            <p>Registration</p>
            <form method="POST"> <!-- Added POST method here -->
                <div class="user-box">
                    <input required="" name="emp_id" type="text">
                    <label>Employee ID</label>
                </div>
                <div class="user-box">
                    <input required="" name="username" type="text">
                    <label>User Name</label>
                </div>
                <div class="user-box">
                    <input required="" name="email" type="email">
                    <label>Email</label>
                </div>
                <div class="user-box">
                    <input required="" name="Password" type="password">
                    <label>Password</label>
                </div>
                <button name="register"> <!-- Changed name from 'login' to 'register' -->
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Submit
                </button>
            </form>
            <p>Already have an account? <a href="login.php" class="a2" >Login</a></p>
        </div>

        <?php
        if (isset($_POST['register'])){ // Checking for 'register' button click
            // Retrieve form data
            $emp = $_POST['emp_id'];
            $U = $_POST['username'];
            $P = $_POST['Password'];
            $E = $_POST['email'];

            // Sanitize inputs
            $emp = htmlspecialchars($emp);
            $U = htmlspecialchars($U);
            $P = htmlspecialchars($P);
            $E = htmlspecialchars($E);

            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO `users`(`User_id`, `UserName`, `Password`, `email`) VALUES (?,?,?,?)");

            if ($stmt === false) {
                die("Error preparing statement: " . $conn->error);
            }

            // Bind parameters and execute
            $stmt->bind_param("ssss", $emp, $U, $P, $E);

            if ($stmt->execute()) {
                // Redirect to login page upon success
                header('Location: login.php');
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else {
            // Error message if the form is not submitted properly
            echo "Error: Required data not provided.";
        }
        ?>
    </body>
</html>
