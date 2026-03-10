<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); }
include_once("connection.php");

$product_id = mysqli_real_escape_string($mysqli, $_GET['id']);

// ইউজার নেমসহ রিভিউ আনা (JOIN Query)
$query = "SELECT reviews.*, login.name FROM reviews 
          JOIN login ON reviews.userid = login.id 
          WHERE reviews.productid = $product_id 
          ORDER BY reviews.id DESC";
$result = mysqli_query($mysqli, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Reviews | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; padding:40px 10%; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; }
        .review-box { background:#fff; padding:20px; border-radius:12px; margin-bottom:15px; box-shadow:0 4px 10px rgba(0,0,0,0.05); display:flex; gap:15px; }
        .user-avatar { width:50px; height:50px; background:#2ecc71; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0; }
        .review-content h4 { color:#2c3e50; font-size:16px; margin-bottom:5px; }
        .review-content p { color:#555; font-size:14px; line-height:1.5; }
        .no-reviews { text-align:center; padding:50px; color:#888; }
        .btn-back { text-decoration:none; color:#555; font-weight:500; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2><i class="fa-solid fa-comments" style="color:#2ecc71;"></i> Product Reviews</h2>
        <a href="index.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back</a>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
        <?php while($res = mysqli_fetch_array($result)): ?>
            <div class="review-box">
                <div class="user-avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="review-content">
                    <h4><?php echo htmlspecialchars($res['name']); ?></h4>
                    <p><?php echo htmlspecialchars($res['comment']); ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-reviews">
            <i class="fa-solid fa-comment-slash fa-3x" style="margin-bottom:15px; opacity:0.3;"></i>
            <p>No reviews yet for this product.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>