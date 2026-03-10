<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); }
include_once("connection.php");

if(isset($_POST['update'])) {	
    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $qty = mysqli_real_escape_string($mysqli, $_POST['qty']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);	
    
    if(empty($name) || empty($qty) || empty($price)) {
        $error = "All fields are required!";
    } else {	
        mysqli_query($mysqli, "UPDATE orders SET name='$name', qty='$qty', price='$price' WHERE id=$id");
        header("Location: order.php");
    }
}

$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM orders WHERE id=$id");
while($res = mysqli_fetch_array($result)) {
    $name = $res['name'];
    $qty = $res['qty'];
    $price = $res['price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; }
        .edit-card { background:#fff; padding:35px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:100%; max-width:450px; }
        .edit-card h2 { text-align:center; color:#27ae60; margin-bottom:25px; }
        .form-group { margin-bottom:15px; }
        .form-group label { display:block; margin-bottom:5px; font-weight:500; }
        .form-group input { width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; }
        .btn-update { width:100%; padding:12px; background:#27ae60; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer; }
        .back-link { display:block; text-align:center; margin-top:15px; text-decoration:none; color:#7f8c8d; font-size:14px; }
    </style>
</head>
<body>
<div class="edit-card">
    <h2>Edit Order Details</h2>
    <form name="form1" method="post" action="editOrder.php">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="name" value="<?php echo $name;?>" readonly>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="qty" value="<?php echo $qty;?>" required>
        </div>
        <div class="form-group">
            <label>Total Price (BDT)</label>
            <input type="number" name="price" value="<?php echo $price;?>" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <button type="submit" name="update" class="btn-update">Update Order</button>
    </form>
    <a href="order.php" class="back-link">Back to My Orders</a>
</div>
</body>
</html>