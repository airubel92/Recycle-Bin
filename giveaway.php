<?php 
session_start(); 
include_once("connection.php");
// শুধুমাত্র ফ্রি (Price = 0) প্রোডাক্টগুলো আনা
$result = mysqli_query($mysqli, "SELECT * FROM products WHERE price = 0 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giveaway Items | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f0f2f5; padding: 40px 5%; }
        
        .header-box { text-align:center; margin-bottom:40px; }
        .header-box h1 { color:#2c3e50; font-size:2.5rem; margin-bottom:10px; }
        .header-box h1 span { color:#27ae60; }
        
        .nav-buttons { display:flex; justify-content:center; gap:15px; margin-bottom:40px; }
        .btn { padding:12px 25px; border-radius:30px; text-decoration:none; font-weight:600; transition:0.3s; display:flex; align-items:center; gap:8px; }
        .btn-home { background:#fff; color:#555; border:1px solid #ddd; }
        .btn-post { background:#27ae60; color:#fff; box-shadow:0 4px 15px rgba(39, 174, 96, 0.3); }
        .btn:hover { transform:translateY(-3px); }

        .grid-container { display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:25px; }
        
        .item-card { background:#fff; border-radius:15px; padding:25px; text-align:center; transition:0.3s; border:1px solid #eee; position:relative; overflow:hidden; }
        .item-card:hover { transform:translateY(-10px); box-shadow:0 15px 35px rgba(0,0,0,0.1); }
        
        .gift-icon { font-size:3rem; color:#27ae60; margin-bottom:15px; opacity:0.8; }
        .item-card h3 { color:#2c3e50; margin-bottom:10px; font-size:1.4rem; }
        .badge { background:#e8f5e9; color:#27ae60; padding:5px 15px; border-radius:20px; font-size:0.8rem; font-weight:600; display:inline-block; margin-bottom:15px; }
        
        .qty-info { color:#7f8c8d; font-size:0.9rem; margin-bottom:20px; display:block; }
        .btn-claim { background:#2c3e50; color:#fff; padding:10px 0; width:100%; border-radius:8px; text-decoration:none; font-weight:600; transition:0.3s; display:block; }
        .btn-claim:hover { background:#27ae60; }

        /* Empty State */
        .empty-msg { text-align:center; grid-column: 1 / -1; padding:100px; color:#95a5a6; }
    </style>
</head>
<body>

    <div class="header-box">
        <h1>🎁 UIU <span>Giveaway</span></h1>
        <p>Sharing is Caring. Get items for free from your fellow UIUians!</p>
    </div>

    <div class="nav-buttons">
        <a href="index.php" class="btn btn-home"><i class="fa-solid fa-house"></i> Home</a>
        <a href="add.php" class="btn btn-post"><i class="fa-solid fa-plus-circle"></i> Post a Free Item</a>
    </div>

    <div class="grid-container">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($res = mysqli_fetch_array($result)): ?>
                <div class="item-card">
                    <div class="gift-icon"><i class="fa-solid fa-gift"></i></div>
                    <span class="badge">FREE ITEM</span>
                    <h3><?php echo htmlspecialchars($res['name']); ?></h3>
                    <span class="qty-info"><i class="fa-solid fa-boxes-stack"></i> Available: <?php echo $res['qty']; ?> units</span>
                    <a href="cart.php?id=<?php echo $res['id']; ?>" class="btn-claim">Claim This Item</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-msg">
                <i class="fa-solid fa-face-meh fa-4x"></i>
                <h2 style="margin-top:20px;">No Giveaway items available right now.</h2>
                <p>Be the first to donate something!</p>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>