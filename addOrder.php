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
    <title>Order Processing | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background:#f4f7f6; font-family:'Poppins', sans-serif; display:flex; justify-content:center; align-items:center; min-height:100vh; }
        .process-card { background:#fff; padding:40px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.1); text-align:center; max-width:400px; width:100%; }
        .icon { font-size: 50px; margin-bottom: 20px; }
        .success-icon { color: #2ecc71; }
        .error-icon { color: #e74c3c; }
        .btn-back { display:inline-block; margin-top:20px; padding:10px 25px; background:#3498db; color:white; text-decoration:none; border-radius:8px; font-weight:600; }
    </style>
</head>
<body>

<div class="process-card">
<?php
include_once("connection.php");

if(isset($_POST['Submit'])) {
    $productid = mysqli_real_escape_string($mysqli, $_POST['id']);
    $qty = mysqli_real_escape_string($mysqli, $_POST['qty']);
    $loginId = $_SESSION['id'];

    // ১. প্রোডাক্টের বর্তমান তথ্য আনা
    $query = "SELECT name, price, qty FROM products WHERE id=$productid";
    $result = mysqli_query($mysqli, $query);
    $product = mysqli_fetch_array($result);

    if(!$product) {
        echo "<div class='icon error-icon'>❌</div><h3>Product not found!</h3>";
    } 
    else {
        $product_name = $product['name'];
        $unit_price = $product['price'];
        $stock_available = $product['qty'];
        $total_price = $unit_price * $qty; // মোট দাম হিসাব করা
        $remaining_qty = $stock_available - $qty; // স্টক আপডেট হিসাব

        // ২. স্টক চেক এবং অর্ডার প্রসেস করা
        if($qty <= 0) {
            echo "<div class='icon error-icon'>⚠️</div><h3>Invalid quantity!</h3>";
        }
        else if($remaining_qty >= 0) { 
            // অর্ডার ইনসার্ট করা
            $insert_order = "INSERT INTO orders(name, qty, login_id, price) VALUES('$product_name', '$qty', '$loginId', '$total_price')";
            
            // প্রোডাক্টের স্টক কমানো
            $update_stock = "UPDATE products SET qty = '$remaining_qty' WHERE id=$productid";
            
            if(mysqli_query($mysqli, $insert_order) && mysqli_query($mysqli, $update_stock)) {
                echo "<div class='icon success-icon'>✅</div>";
                echo "<h3>Order Successful!</h3>";
                echo "<p>You ordered $qty unit(s) of $product_name.</p>";
            } else {
                echo "<div class='icon error-icon'>❌</div><h3>Database Error!</h3>";
            }
        }
        else {
            echo "<div class='icon error-icon'>🚫</div>";
            echo "<h3>Insufficient Stock!</h3>";
            echo "<p>Only $stock_available items left in stock.</p>";
        }
    }
}
?>
    <a href="order.php" class="btn-back">View My Orders</a>
</div>

</body>
</html>