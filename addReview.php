<?php
session_start();
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
include_once("connection.php");

// GET এবং POST হ্যান্ডলিং
$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : null);
$name = isset($_GET['name']) ? $_GET['name'] : 'Product';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = mysqli_real_escape_string($mysqli, $_POST['comment']);
    $user_id = $_SESSION['id'];
    
    if(!empty($comment)) {
        $result = mysqli_query($mysqli, "INSERT INTO `reviews`(`productid`, `userid`, `comment`) VALUES ($id, $user_id, '$comment')");
        $success = "Review added successfully!";
    } else {
        $error = "Comment cannot be empty!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px; }
        .review-card { background:#fff; padding:35px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:100%; max-width:500px; }
        .product-info { background:#e8f5e9; padding:15px; border-radius:10px; margin-bottom:20px; border-left:5px solid #2ecc71; }
        .product-info h3 { color:#2e7d32; font-size:18px; }
        textarea { width:100%; padding:15px; border:1px solid #ddd; border-radius:10px; resize:none; margin-bottom:20px; font-size:14px; }
        .btn-submit { width:100%; padding:12px; background:#2ecc71; color:white; border:none; border-radius:8px; font-weight:600; cursor:pointer; transition:0.3s; }
        .btn-submit:hover { background:#27ae60; }
        .alert { padding:12px; border-radius:8px; margin-bottom:20px; text-align:center; font-size:14px; }
        .alert-success { background:#e8f5e9; color:#2e7d32; }
        .alert-error { background:#ffebee; color:#c62828; }
        .nav-links { text-align:center; margin-top:20px; }
        .nav-links a { text-decoration:none; color:#3498db; font-size:14px; margin:0 10px; }
    </style>
</head>
<body>
<div class="review-card">
    <h2 style="margin-bottom:20px; text-align:center;">Write a Review</h2>
    
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-error'>$error</div>"; ?>

    <div class="product-info">
        <p style="font-size:12px; color:#666;">Product ID: #<?php echo $id; ?></p>
        <h3><?php echo $name; ?></h3>
    </div>

    <form method="post" action="">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label style="display:block; margin-bottom:10px; font-weight:500;">Your Experience:</label>
        <textarea name="comment" rows="5" placeholder="Share your thoughts about this product..." required></textarea>
        <button type="submit" class="btn-submit">Post Review</button>
    </form>

    <div class="nav-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="order.php"><i class="fa-solid fa-basket-shopping"></i> My Orders</a>
    </div>
</div>
</body>
</html>