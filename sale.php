<?php
session_start();
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
}
include_once("connection.php");

// বর্তমানে লগইন করা ইউজারের প্রোডাক্ট লিস্ট
$result = mysqli_query($mysqli, "SELECT * FROM products WHERE login_id=".$_SESSION['id']." ORDER BY id DESC");

// অন্যদের প্রোডাক্ট দেখার জন্য (Marketplace View)
$all_products = mysqli_query($mysqli, "SELECT products.*, login.name as seller_name FROM products JOIN login ON products.login_id = login.id WHERE products.login_id !=".$_SESSION['id']." ORDER BY products.id DESC");

// সব প্রোডাক্টের মধ্যে সর্বনিম্ন দাম বের করা
$minPriceQuery = mysqli_query($mysqli, "SELECT MIN(price) AS SmallestPrice FROM products");
$minPriceRow = mysqli_fetch_array($minPriceQuery);
$minPrice = $minPriceRow['SmallestPrice'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background-color: #f4f7f6; padding: 40px 5%; }
        
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-section h2 { color: #2c3e50; font-size: 24px; }
        
        .nav-btn { text-decoration: none; padding: 10px 20px; border-radius: 8px; font-weight: 500; font-size: 14px; transition: 0.3s; }
        .btn-home { background: #fff; color: #555; border: 1px solid #ddd; margin-right: 10px; }
        .btn-add { background: #27ae60; color: #fff; }
        
        /* Marketplace Grid */
        .market-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-top: 20px; }
        .product-card { background: #fff; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 4px solid #27ae60; transition: 0.3s; }
        .product-card:hover { transform: translateY(-5px); }
        .price-tag { font-size: 20px; color: #27ae60; font-weight: 700; margin: 10px 0; }
        .seller-info { font-size: 12px; color: #7f8c8d; margin-bottom: 15px; }
        
        .btn-buy { display: block; text-align: center; background: #e67e22; color: white; text-decoration: none; padding: 10px; border-radius: 8px; font-weight: 600; transition: 0.3s; }
        .btn-buy:hover { background: #d35400; }

        .section-title { margin: 40px 0 20px; border-bottom: 2px solid #ddd; padding-bottom: 10px; color: #2c3e50; }

        /* Existing Table Styles */
        .table-container { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.05); margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        thead { background: #2c3e50; color: #fff; }
        th { padding: 18px; text-align: left; }
        td { padding: 15px 18px; border-bottom: 1px solid #eee; font-size: 14px; }
        .qty-badge { background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 12px; }
    </style>
</head>
<body>

<div class="header-section">
    <h2><i class="fa-solid fa-store" style="color:#27ae60; margin-right:10px;"></i> UIU Marketplace</h2>
    <div>
        <a href="index.php" class="nav-btn btn-home"><i class="fa-solid fa-house"></i> Home</a>
        <a href="add.php" class="nav-btn btn-add"><i class="fa-solid fa-plus"></i> Sell Product</a>
    </div>
</div>

<h3 class="section-title">Available Products</h3>
<div class="market-grid">
    <?php while($item = mysqli_fetch_assoc($all_products)) { ?>
        <div class="product-card">
            <div class="seller-info"><i class="fa-solid fa-user"></i> Seller: <?php echo htmlspecialchars($item['seller_name']); ?></div>
            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
            <div class="price-tag">৳ <?php echo number_format($item['price'], 2); ?></div>
            <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Qty Available: <?php echo $item['qty']; ?></p>
            
            <a href="checkout.php?id=<?php echo $item['id']; ?>" class="btn-buy">
                <i class="fa-solid fa-cart-shopping"></i> Buy Now
            </a>
        </div>
    <?php } ?>
</div>

<hr style="margin-top: 50px; opacity: 0.2;">

<h3 class="section-title">My Listed Items (Manage)</h3>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($result, 0); // রেজাল্ট পয়েন্টার রিসেট
            if (mysqli_num_rows($result) > 0) {
                while($res = mysqli_fetch_array($result)) {		
                    echo "<tr>";
                    echo "<td><strong>".$res['name']."</strong></td>";
                    echo "<td><span class='qty-badge'>".$res['qty']." Units</span></td>";
                    echo "<td>৳ ".number_format($res['price'], 2)."</td>";	
                    echo "<td>
                            <a href=\"edit.php?id=$res[id]\" style='color:#3498db; margin-right:10px; text-decoration:none;'><i class='fa-solid fa-pen'></i> Edit</a>
                            <a href=\"delete.php?id=$res[id]\" style='color:#e74c3c; text-decoration:none;' onClick=\"return confirm('Delete?')\"><i class='fa-solid fa-trash'></i> Delete</a>
                          </td>";
                    echo "</tr>";		
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; padding:20px;'>No items listed by you.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>