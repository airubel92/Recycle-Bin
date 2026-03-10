<?php
include("connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Registration Page Specific Styles */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background: #f0f2f5;
        }
        .auth-card {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
        .auth-card h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #2ecc71;
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn-submit:hover {
            background: #27ae60;
        }
        .msg {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
        }
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        <h1>Register</h1>

        <?php
        if(isset($_POST['submit'])) {
            $name = mysqli_real_escape_string($mysqli, $_POST['name']);
            $email = mysqli_real_escape_string($mysqli, $_POST['email']);
            $user = mysqli_real_escape_string($mysqli, $_POST['username']);
            $pass = mysqli_real_escape_string($mysqli, $_POST['password']);

            // Input Validation
            if (empty($user) || empty($pass) || empty($name) || empty($email)) {
                echo "<div class='msg error'>All fields are required!</div>";
                echo "<a href='register.php' class='back-link'>Go Back</a>";
            } 
            elseif ($user == "admin") {
                echo "<div class='msg error'>Username 'admin' is not allowed!</div>";
                echo "<a href='register.php' class='back-link'>Go Back</a>";
            } 
            else {
                // UIU Email Validation Logic
                $allowedDomains = ["bscse.uiu.ac.bd", "cse.uiu.ac.bd", "bseee.uiu.ac.bd", "eee.uiu.ac.bd", "bba.uiu.ac.bd", "uiu.ac.bd"];
                $emailParts = explode('@', $email);
                $domain = end($emailParts);

                if (in_array($domain, $allowedDomains)) {
                    $query = "INSERT INTO login(name, email, username, password, role) VALUES('$name', '$email', '$user', '$pass', 'user')";
                    
                    if(mysqli_query($mysqli, $query)) {
                        echo "<div class='msg success'>Registration Successful!</div>";
                        echo "<a href='login.php' class='btn-submit' style='display:block; text-align:center; text-decoration:none;'>Login Now</a>";
                    } else {
                        echo "<div class='msg error'>Error: Could not register. Username or Email might already exist.</div>";
                    }
                } else {
                    echo "<div class='msg error'>Invalid UIU Email Address!</div>";
                    echo "<a href='register.php' class='back-link'>Try Again</a>";
                }
            }
        } else {
        ?>
            <form action="" method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                    <label>UIU Email</label>
                    <input type="email" name="email" placeholder="example@bscse.uiu.ac.bd" required>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" name="submit" class="btn-submit">Create Account</button>
            </form>
            <a href="index.php" class="back-link">Back to Home</a>
        <?php } ?>
    </div>
</div>

</body>
</html>