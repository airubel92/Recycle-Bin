<?php 
session_start(); 
// ইউজার লগইন চেক
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}
include_once("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Item | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            padding: 20px; 
        }
        
        .add-card { 
            background: #fff; 
            padding: 40px; 
            border-radius: 15px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            width: 100%; 
            max-width: 500px; 
        }
        
        .add-card h2 { 
            text-align: center; 
            color: #2c3e50; 
            margin-bottom: 25px; 
            font-weight: 600; 
        }

        .form-group { margin-bottom: 20px; }
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
            font-size: 14px; 
            transition: 0.3s; 
        }
        .form-group input:focus { 
            border-color: #27ae60; 
            outline: none; 
            box-shadow: 0 0 5px rgba(39, 174, 96, 0.2); 
        }
        
        .btn-submit { 
            width: 100%; 
            padding: 12px; 
            background: #27ae60; 
            border: none; 
            color: white; 
            font-weight: 600; 
            border-radius: 8px; 
            cursor: pointer; 
            transition: 0.3s; 
            font-size: 16px; 
        }
        .btn-submit:hover { 
            background: #219150; 
            transform: translateY(-2px); 
        }
        
        .msg { 
            padding: 12px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
            text-align: center; 
            font-size: 14px; 
        }
        .error { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
        .success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        
        .nav-links { text-align: center; margin-top: 25px; }
        .nav-links a { 
            text-decoration: none; 
            color: #3498db; 
            font-size: 14px; 
            margin: 0 10px; 
        }
        .info-text { 
            font-size: 12px; 
            color: #888; 
            margin-top: 5px; 
        }
    </style>
</head>
<body>

<div class="add-card">
    <h2><i class="fa-solid fa-plus-circle"></i> Post New Item</h2>

    <?php
    if(isset($_POST['Submit'])) {	
        $name = mysqli_real_escape_string($mysqli, $_POST['name']);
        $qty = mysqli_real_escape_string($mysqli, $_POST['qty']);
        $price = mysqli_real_escape_string($mysqli, $_POST['price']);
        $loginId = $_SESSION['id']; // লগইন করা ইউজারের আইডি
            
        // ফিল্ড খালি আছে কিনা চেক করা
        if(empty($name) || empty($qty)) {
            echo "<div class='msg error'>Item name and quantity are required!</div>";
        } else { 
            // ডাটাবেসে ইনসার্ট করা
            $query = "INSERT INTO products(name, qty, price, login_id) VALUES('$name', '$qty', '$price', '$loginId')";
            
            if(mysqli_query($mysqli, $query)) {
                echo "<div class='msg success'>Item listed successfully!</div>";
                // দাম ০ হলে giveaway পেজে যাবে, নাহলে sale পেজে
                $redirect = ($price == 0) ? "giveaway.php" : "sale.php";
                echo "<script>setTimeout(() => { window.location.href = '$redirect'; }, 1500);</script>";
            } else {
                echo "<div class='msg error'>Error: " . mysqli_error($mysqli) . "</div>";
            }
        }
    }
    ?>

    <form action="add.php" method="post">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="name" placeholder="e.g. Scientific Calculator" required>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="qty" placeholder="Enter number of items" min="1" required>
        </div>
        <div class="form-group">
            <label>Price (BDT)</label>
            <input type="number" name="price" placeholder="Enter 0 to list as Giveaway" step="0.01" value="0">
            <p class="info-text"><i class="fa-solid fa-circle-info"></i> Leaving it 0 will show it in the Giveaway section.</p>
        </div>
        <button type="submit" name="Submit" class="btn-submit">List Item Now</button>
    </form>

    <div class="nav-links">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="sale.php"><i class="fa-solid fa-store"></i> Marketplace</a>
    </div>
</div>

</body>
</html>