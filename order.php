<?php 
session_start(); 
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
include_once("connection.php");

// Products for sale (MySQL Join)
$result1 = mysqli_query($mysqli, "SELECT products.login_id, products.name, products.qty, products.price, products.id, login.username FROM products INNER JOIN login ON products.login_id=login.id ORDER BY products.id DESC");

// User's Orders
$result = mysqli_query($mysqli, "SELECT * FROM orders WHERE login_id=".$_SESSION['id']." ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders & Marketplace | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Poppins', sans-serif; }
        .container { max-width: 1200px; margin: 30px auto; padding: 20px; }
        
        .section-title { 
            color: #2c3e50; 
            margin: 40px 0 20px; 
            padding-bottom: 10px; 
            border-bottom: 3px solid #27ae60;
            display: inline-block;
        }

        /* Table Styling */
        .order-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .order-table th { background: #2c3e50; color: #fff; padding: 15px; text-align: left; }
        .order-table td { padding: 15px; border-bottom: 1px solid #eee; }
        .order-table tr:hover { background: #f9f9f9; }

        /* Buttons Styling */
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }
        .btn-order { background: #27ae60; color: white; }
        .btn-order:hover { background: #219150; }
        .btn-review { background: #3498db; color: white; margin-right: 5px; }
        .btn-view { background: #f1c40f; color: #333; }
        .btn-edit { color: #3498db; margin-right: 10px; }
        .btn-delete { color: #e74c3c; }
        
        .stock-out { color: #e74c3c; font-weight: 600; }
        .nav-top { margin-bottom: 20px; }
        .nav-top a { text-decoration: none; color: #555; font-weight: 500; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav-top">
        <a href="index.php"><i class="fa-solid fa-house"></i> Home</a> | 
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <h2 class="section-title">Products for Sale</h2>
    <table class="order-table">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Seller</th>
                <th>Quantity</th>
                <th>Price (BDT)</th>
                <th>Action</th>
                <th>Reviews</th>
            </tr>
        </thead>
        <tbody>
            <?php while($res1 = mysqli_fetch_array($result1)) { ?>
                <tr>
                    <td><strong><?php echo $res1['name']; ?></strong></td>
                    <td><i class="fa-solid fa-user-circle"></i> <?php echo $res1['username']; ?></td>
                    <td>
                        <?php echo ($res1['qty'] == 0) ? '<span class="stock-out">Stock Out!</span>' : $res1['qty']; ?>
                    </td>
                    <td>৳ <?php echo number_format($res1['price'], 2); ?></td>
                    <td>
                        <?php if($res1['qty'] > 0) { ?>
                            <a href="cart.php?id=<?php echo $res1['id']; ?>" class="btn btn-order">Order Now</a>
                        <?php } else { ?>
                            <span class="stock-out">N/A</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="addReview.php?id=<?php echo $res1['id']; ?>&name=<?php echo $res1['name']; ?>" class="btn btn-review" title="Add Review"><i class="fa-solid fa-pen"></i></a>
                        <a href="reviews.php?id=<?php echo $res1['id']; ?>" class="btn btn-view" title="View Reviews"><i class="fa-solid fa-eye"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2 class="section-title">My Orders</h2>
    <table class="order-table">
        <thead>
            <tr>
                <th>Ordered Item</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            <?php while($res = mysqli_fetch_array($result)) { ?>
                <tr>
                    <td><?php echo $res['name']; ?></td>
                    <td><?php echo $res['qty']; ?></td>
                    <td>৳ <?php echo number_format($res['price'], 2); ?></td>
                    <td>
                        <a href="editOrder.php?id=<?php echo $res['id']; ?>" class="btn-edit"><i class="fa-solid fa-edit"></i> Edit</a>
                        <a href="deleteOrder.php?id=<?php echo $res['id']; ?>" class="btn-delete" onClick="return confirm('Are you sure you want to delete this order?')"><i class="fa-solid fa-trash"></i> Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>