<?php
session_start();
// লগইন চেক
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include_once("connection.php");

// URL থেকে প্রোডাক্ট আইডি নিয়ে তথ্য আনা
$id = mysqli_real_escape_string($mysqli, $_GET['id']);
$result = mysqli_query($mysqli, "SELECT name, qty, price, id FROM products WHERE id=$id");
$product = mysqli_fetch_array($result);

// প্রোডাক্ট না পাওয়া গেলে ব্যাক করা
if (!$product) {
    header("Location: order.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Order | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        
        .cart-card { background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
        .cart-card h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; font-weight: 600; }
        
        .product-details { background: #f9f9f9; padding: 20px; border-radius: 10px; margin-bottom: 25px; border-left: 4px solid #2ecc71; }
        .product-details p { margin-bottom: 10px; color: #555; font-size: 14px; }
        .product-details span { font-weight: 600; color: #333; float: right; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #444; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; }
        
        .btn-confirm { width: 100%; padding: 14px; background: #2ecc71; border: none; color: white; font-weight: 600; border-radius: 8px; cursor: pointer; transition: 0.3s; font-size: 16px; }
        .btn-confirm:hover { background: #27ae60; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3); }
        
        .nav-links { text-align: center; margin-top: 25px; }
        .nav-links a { text-decoration: none; color: #3498db; font-size: 13px; margin: 0 10px; }
        .stock-msg { color: #e74c3c; font-size: 12px; margin-top: 5px; font-weight: 500; }
    </style>
</head>
<body>

<div class="cart-card">
    <h2><i class="fa-solid fa-cart-shopping"></i> Confirm Order</h2>

    <div class="product-details">
        <p>Item Name: <span><?php echo $product['name']; ?></span></p>
        <p>Price (Unit): <span>৳ <?php echo number_format($product['price'], 2); ?></span></p>
        <p>In Stock: <span><?php echo $product['qty']; ?> Units</span></p>
    </div>

    <form action="addOrder.php" method="post" id="orderForm">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
        
        <div class="form-group">
            <label for="qty">Order Quantity</label>
            <input type="number" name="qty" id="qty" min="1" max="<?php echo $product['qty']; ?>" placeholder="Enter quantity" required>
            <p class="stock-msg" id="stockMsg"></p>
        </div>
        
        <button type="submit" name="Submit" class="btn-confirm">Confirm & Add Order</button>
    </form>

    <div class="nav-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="order.php"><i class="fa-solid fa-list-check"></i> View Orders</a>
    </div>
</div>

<script>
    // জাভাস্ক্রিপ্ট দিয়ে রিয়েল-টাইম স্টক চেক
    const qtyInput = document.getElementById('qty');
    const stockMsg = document.getElementById('stockMsg');
    const maxStock = <?php echo $product['qty']; ?>;

    qtyInput.addEventListener('input', function() {
        if (this.value > maxStock) {
            stockMsg.innerText = "Error: Only " + maxStock + " units available!";
            this.style.borderColor = "#e74c3c";
        } else {
            stockMsg.innerText = "";
            this.style.borderColor = "#ddd";
        }
    });
</script>

</body>
</html>