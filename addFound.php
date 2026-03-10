<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); exit(); }
include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Item | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px; }
        .form-card { background:#fff; padding:35px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:100%; max-width:450px; border-top: 5px solid #27ae60; }
        .form-card h2 { text-align:center; color:#27ae60; margin-bottom:25px; }
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:8px; font-weight:500; color:#555; }
        .form-group input { width:100%; padding:12px; border:1px solid #ddd; border-radius:8px; outline:none; }
        .form-group input:focus { border-color: #27ae60; }
        .btn-submit { width:100%; padding:12px; background:#27ae60; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; transition:0.3s; }
        .btn-submit:hover { background:#219150; transform: translateY(-2px); }
        .alert { padding:12px; border-radius:8px; margin-bottom:20px; text-align:center; font-size:14px; }
        .alert-success { background:#e8f5e9; color:#2e7d32; }
        .alert-error { background:#ffebee; color:#c62828; }
        .back-link { display:block; text-align:center; margin-top:20px; text-decoration:none; color:#7f8c8d; font-size:14px; }
    </style>
</head>
<body>

<div class="form-card">
    <a href="index.php" style="text-decoration:none; color:#7f8c8d; font-size:13px;"><i class="fa-solid fa-arrow-left"></i> Home</a>
    <h2 style="margin-top:10px;"><i class="fa-solid fa-hand-holding-heart"></i> Report Found Item</h2>

    <?php
    if(isset($_POST['Submit'])) {	
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $place = mysqli_real_escape_string($mysqli, $_POST['place']);
        $loginId = $_SESSION['id'];
        
        if(empty($name) || empty($place)) {
            echo "<div class='alert alert-error'>All fields are required!</div>";
        } else { 
            // নতুন 'found' টেবিলে ডাটা ইনসার্ট করা
            $query = "INSERT INTO found(name, place, login_id) VALUES('$name', '$place', '$loginId')";
            
            if(mysqli_query($mysqli, $query)) {
                echo "<div class='alert alert-success'>Found item reported successfully!</div>";
                echo "<script>setTimeout(() => { window.location.href = 'found.php'; }, 1500);</script>";
            } else {
                echo "<div class='alert alert-error'>Error: " . mysqli_error($mysqli) . "</div>";
            }
        }
    }
    ?>

    <form action="addFound.php" method="post">
        <div class="form-group">
            <label>What did you find?</label>
            <input type="text" name="name" placeholder="e.g. Scientific Calculator" required>
        </div>
        <div class="form-group">
            <label>Where did you find it?</label>
            <input type="text" name="place" placeholder="e.g. Room 402, Cafeteria" required>
        </div>
        <button type="submit" name="Submit" class="btn-submit">Submit Found Report</button>
    </form>
    
    <a href="found.php" class="back-link">← Back to Found Items List</a>
</div>

</body>
</html>