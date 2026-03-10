<?php 
session_start(); 
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Login Page Background & Layout */
        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            /* আপনি চাইলে এখানে ব্যাকগ্রাউন্ড ইমেজ যোগ করতে পারেন */
            /* background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('image/login-bg.jpg'); */
            background-color: #f0f2f5; 
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-card h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #2c3e50;
            font-size: 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #2ecc71;
            outline: none;
            box-shadow: 0 0 5px rgba(46, 204, 113, 0.3);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2ecc71;
            border: none;
            color: white;
            font-weight: 600;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #27ae60;
        }

        .msg {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        
        .footer-links {
            text-align: center;
            margin-top: 20px;
        }

        .footer-links a {
            text-decoration: none;
            color: #3498db;
            font-size: 14px;
        }
    </style>
</head>
<body class="login-page">

<div class="login-card">
    <h1>Login</h1>

    <?php
    if(isset($_POST['submit'])) {
        $user = mysqli_real_escape_string($mysqli, $_POST['username']);
        $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

        if($user == "admin") {
            echo "<div class='msg error'>Please use the Admin Portal.<br><a href='admin/login.php'>Go to Admin Login</a></div>";
        } elseif(empty($user) || empty($pass)) {
            echo "<div class='msg error'>Username or Password cannot be empty!</div>";
        } else {
            $query = "SELECT * FROM login WHERE username='$user' AND password='$pass'";
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_assoc($result);

            if(is_array($row) && !empty($row)) {
                $_SESSION['valid'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['role'] = $row['role']; // অ্যাডমিন না ইউজার তা চেনার জন্য

                header('Location: index.php');
            } else {
                echo "<div class='msg error'>Invalid username or password!</div>";
            }
        }
    }
    ?>

    <form name="form1" method="post" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" name="submit" class="btn-login">Login</button>
    </form>

    <div class="footer-links">
        <a href="register.php">Don't have an account? Register</a> <br><br>
        <a href="index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>