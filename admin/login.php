<?php 
ob_start();
session_start(); 
 include('dbcon.php');
?>
<html>
<head>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            padding: 0;
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/bg.jpg'); /* Replace with your actual image path */
            backdrop-filter: blur(5px);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            transition: background-image 0.3s ease, background-size 0.3s ease, transform 0.3s ease;
        }

        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 400px;
            padding: 40px;
            transform: translate(-50%, -55%);
            background: rgba(0, 0, 0, 0.9);
            box-sizing: border-box;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
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
            margin-bottom: 30px;
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
            transition: 0.5s;
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
        <p>Login</p>
        <form method="POST">
            <div class="user-box">
                <input required="" name="email" type="text">
                <label>Email</label>
            </div>
            <div class="user-box">
                <input required="" name="Password" type="password">
                <label>Password</label>
            </div>
            <button type="submit" name="login">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                Submit
            </button>
        </form>
    </div>
    <?php

if (isset($_POST['login'])){

$email=$_POST['email'];
$Password=$_POST['Password'];

$login_query=mysqli_query($conn,"select * from users where email='$email' and Password='$Password'");
$count=mysqli_num_rows($login_query);
$row=mysqli_fetch_array($login_query);
$f=$row['FirstName'];
$l=$row['LastName'];

if ($count > 0){
$_SESSION['id']=$row['User_id'];
$_SESSION['email']=$row['email'];
$type=$row['email'];

mysqli_query($conn,"INSERT INTO history (data,action,date,user)VALUES('$f $l', 'Login', NOW(),'$type')")or die(mysqli_error());
header('Location: home1.php');
exit;
}else{
?>
    <div class="alert alert-error">
    <button class="close" data-dismiss="alert">�</button>
   Please check your UserName and Password
    </div>
<?php } 

}

?>	
</body>
</html>