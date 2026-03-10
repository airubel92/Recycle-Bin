<?php 
session_start(); 
include_once("connection.php");
// Found টেবিল থেকে পোস্টকারীর তথ্যসহ ডাটা সংগ্রহ
$result = mysqli_query($mysqli, "SELECT found.*, login.name as owner_name FROM found JOIN login ON found.login_id = login.id ORDER BY found.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found Items | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; padding-top: 80px; padding-left: 10%; padding-right: 10%; }
        
        /* Navbar Style */
        .navbar { position: fixed; top: 0; left: 0; width: 100%; background: #fff; padding: 15px 10%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1); z-index: 1000; }
        .nav-links { display: flex; gap: 20px; list-style: none; }
        .nav-links a { text-decoration: none; color: #555; font-size: 14px; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #27ae60; font-weight: 600; }

        .header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; margin-top: 20px; flex-wrap: wrap; }
        .btn-add { background:#27ae60; color:white; padding:10px 20px; text-decoration:none; border-radius:8px; font-weight:600; }
        
        /* Card Design */
        .card-container { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .item-card { background:#fff; padding:25px; border-radius:15px; box-shadow:0 4px 15px rgba(0,0,0,0.05); border-top:5px solid #27ae60; }
        
        /* Owner info */
        .owner-info { font-size: 13px; color: #27ae60; font-weight: 600; margin-bottom: 3px; }
        .post-time { font-size: 11px; color: #999; margin-bottom: 10px; }

        .action-links { margin-top:20px; display:flex; justify-content: space-between; align-items: center; border-top: 1px solid #eee; padding-top: 15px; }

        @media (max-width: 768px) { .nav-links { display: none; } body { padding-left: 5%; padding-right: 5%; } }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="logo"><strong>UIU</strong> RecycleBin</div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="sale.php">Marketplace</a></li>
        <li><a href="lost.php">Lost</a></li>
        <li><a href="found.php" class="active">Found</a></li>
        <li><a href="giveaway.php">Giveaway</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
    </ul>
</nav>

<div class="header">
    <h2><i class="fa-solid fa-hands-holding" style="color:#27ae60;"></i> Found Items</h2>
    <a href="addFound.php" class="btn-add">Report Found</a>
</div>

<div class="card-container">
    <?php while($res = mysqli_fetch_array($result)) { ?>
        <div class="item-card">
            <div class="owner-info"><i class="fa-solid fa-user"></i> Posted by: <?php echo htmlspecialchars($res['owner_name']); ?></div>
            <div class="post-time"><i class="fa-solid fa-clock"></i> <?php echo date('M d, Y - h:i A', strtotime($res['created_at'])); ?></div>
            
            <h3><?php echo htmlspecialchars($res['name']); ?></h3>
            <p style="font-size:13px; color:#7f8c8d;"><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($res['place']); ?></p>
            
            <div class="action-links">
                <div>
                    <?php if(isset($_SESSION['id']) && $res['login_id'] == $_SESSION['id']): ?>
                        <a href="editFound.php?id=<?php echo $res['id']; ?>" style="color:#3498db;"><i class="fa-solid fa-edit"></i></a>
                        <a href="deleteFound.php?id=<?php echo $res['id']; ?>" style="color:#e74c3c; margin-left:10px;" onclick="return confirm('Delete?')"><i class="fa-solid fa-trash"></i></a>
                    <?php endif; ?>
                </div>
                <a href="post_details.php?id=<?php echo $res['id']; ?>&type=found" style="text-decoration:none; color:#e67e22; font-weight:600;">Claim!</a>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>