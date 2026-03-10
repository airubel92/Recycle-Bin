<?php 
session_start(); 
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Processing | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* addOrder.php এর মতো একই স্টাইল */
        body { background:#f4f7f6; font-family:'Poppins', sans-serif; display:flex; justify-content:center; align-items:center; min-height:100vh; margin:0; }
        .process-card { background:#fff; padding:40px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1); text-align:center; max-width:450px; width:100%; }
        .icon { font-size: 60px; margin-bottom: 20px; }
        .success-icon { color: #2ecc71; }
        .error-icon { color: #e74c3c; }
        .btn-home { display:inline-block; margin-top:25px; padding:12px 30px; background:#27ae60; color:white; text-decoration:none; border-radius:8px; font-weight:600; transition: 0.3s; }
        .btn-home:hover { background: #219150; }
        .trx-box { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-top: 15px; border: 1px dashed #ddd; }
    </style>
</head>
<body>

<div class="process-card">
<?php
include_once("connection.php");

if(isset($_POST['submit_payment'])) {
    // ফর্ম থেকে ডেটা রিসিভ করা
    $product_id = mysqli_real_escape_string($mysqli, $_POST['product_id']);
    $method = mysqli_real_escape_string($mysqli, $_POST['method']);
    $sender = mysqli_real_escape_string($mysqli, $_POST['sender_number']);
    $trx_id = mysqli_real_escape_string($mysqli, $_POST['trx_id']);
    $loginId = $_SESSION['id'];

    // ১. প্রোডাক্টের তথ্য এবং স্টকের অবস্থা চেক করা
    $query = "SELECT name, price, qty FROM products WHERE id=$product_id";
    $result = mysqli_query($mysqli, $query);
    $product = mysqli_fetch_array($result);

    if(!$product) {
        echo "<div class='icon error-icon'>❌</div><h3>Product not found!</h3>";
    } 
    else {
        $product_name = $product['name'];
        $total_price = $product['price'];
        $stock_available = $product['qty'];

        // ২. স্টক চেক করা
        if($stock_available > 0) { 
            // ৩. পেমেন্ট এবং অর্ডার তথ্য ডাটাবেসে ইনসার্ট করা
            $insert_order = "INSERT INTO orders (product_id, user_id, payment_method, trx_id, sender_number, status) 
                             VALUES ('$product_id', '$loginId', '$method', '$trx_id', '$sender', 'Success')";
            
            // ৪. প্রোডাক্টের স্টক ১ কমানো (যেহেতু চেকআউট থেকে ১টি করে কেনা হচ্ছে)
            $new_qty = $stock_available - 1;
            $update_stock = "UPDATE products SET qty = '$new_qty' WHERE id=$product_id";
            
            if(mysqli_query($mysqli, $insert_order) && mysqli_query($mysqli, $update_stock)) {
                // পেমেন্ট সফল হওয়ার মেসেজ
                echo "<div class='icon success-icon'>✅</div>";
                echo "<h3>Payment Successful!</h3>";
                echo "<p>আপনার <strong>$product_name</strong> এর অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে।</p>";
                echo "<div class='trx-box'><strong>TrxID:</strong> <span style='color:#27ae60;'>$trx_id</span></div>";
            } else {
                echo "<div class='icon error-icon'>❌</div><h3>Database Error!</h3>";
                echo "<p>দুঃখিত, তথ্য সংরক্ষণে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।</p>";
            }
        }
        else {
            // স্টক না থাকলে এরর মেসেজ
            echo "<div class='icon error-icon'>🚫</div>";
            echo "<h3>Stock Out!</h3>";
            echo "<p>দুঃখিত, এই পণ্যটি বর্তমানে স্টকে নেই।</p>";
        }
    }
} else {
    // সরাসরি অ্যাক্সেস করলে রিডাইরেক্ট
    header('Location: index.php');
}
?>
    <br>
    <a href="index.php" class="btn-home"><i class="fa-solid fa-house"></i> Back to Home</a>
</div>

</body>
</html>