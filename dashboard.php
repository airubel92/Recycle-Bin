<?php 
session_start(); 
include_once("connection.php");

if(!isset($_SESSION['valid'])) { header('Location: login.php'); exit(); }

$user_id = $_SESSION['id'];

// ইউজারের পোস্ট সংখ্যা গণনা করা
$lost_count = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) as total FROM lost WHERE login_id = $user_id"))['total'];
$found_count = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT COUNT(*) as total FROM found WHERE login_id = $user_id"))['total'];

// ইউজারের করা সব পোস্টের তালিকা আনা (Activity Log)
$activities = mysqli_query($mysqli, "
    (SELECT id, name, 'Lost' as type, created_at FROM lost WHERE login_id = $user_id)
    UNION
    (SELECT id, name, 'Found' as type, created_at FROM found WHERE login_id = $user_id)
    ORDER BY created_at DESC LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f0f2f5; display: flex; min-height: 100vh; }
        
        /* Sidebar Design */
        .sidebar { width: 260px; background: #2c3e50; color: white; padding: 30px 20px; transition: 0.3s; }
        .sidebar h2 { font-size: 20px; margin-bottom: 40px; text-align: center; color: #3498db; }
        .nav-menu { list-style: none; }
        .nav-menu li { margin-bottom: 15px; }
        .nav-menu a { color: #bdc3c7; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px; border-radius: 8px; transition: 0.3s; }
        .nav-menu a:hover, .nav-menu a.active { background: #34495e; color: white; }

        /* Main Content */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .user-profile { display: flex; align-items: center; gap: 10px; background: white; padding: 8px 15px; border-radius: 50px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }

        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border-bottom: 4px solid #3498db; }
        .stat-card i { font-size: 30px; margin-bottom: 10px; color: #3498db; }
        .stat-card h3 { font-size: 28px; color: #2c3e50; }
        .stat-card p { color: #7f8c8d; font-size: 14px; }

        /* Activity Table */
        .activity-section { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .activity-section h4 { margin-bottom: 20px; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-size: 14px; color: #7f8c8d; }
        .type-badge { padding: 5px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; }
        .type-lost { background: #fff5f5; color: #e74c3c; }
        .type-found { background: #f0fdf4; color: #27ae60; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 70px; padding: 20px 10px; }
            .sidebar h2, .sidebar span { display: none; }
            .main-content { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>UIU Recycle</h2>
        <ul class="nav-menu">
            <li><a href="index.php"><i class="fa-solid fa-house"></i> <span>Home</span></a></li>
            <li><a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> <span>Dashboard</span></a></li>
            <li><a href="lost.php"><i class="fa-solid fa-search"></i> <span>Lost Items</span></a></li>
            <li><a href="found.php"><i class="fa-solid fa-hands-holding"></i> <span>Found Items</span></a></li>
            <li><a href="sale.php"><i class="fa-solid fa-store"></i> <span>Marketplace</span></a></li>
            <li><a href="logout.php" style="margin-top: 50px; color: #e74c3c;"><i class="fa-solid fa-sign-out"></i> <span>Logout</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div>
                <h1>Dashboard</h1>
                <p style="color: #7f8c8d;">Welcome back, <?php echo $_SESSION['name']; ?>!</p>
            </div>
            <div class="user-profile">
                <i class="fa-solid fa-user-circle fa-2x" style="color: #3498db;"></i>
                <strong>Student ID: <?php echo $_SESSION['id']; ?></strong>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fa-solid fa-file-circle-question"></i>
                <h3><?php echo $lost_count; ?></h3>
                <p>My Lost Reports</p>
            </div>
            <div class="stat-card" style="border-color: #27ae60;">
                <i class="fa-solid fa-clipboard-check" style="color: #27ae60;"></i>
                <h3><?php echo $found_count; ?></h3>
                <p>My Found Reports</p>
            </div>
            <div class="stat-card" style="border-color: #f1c40f;">
                <i class="fa-solid fa-star" style="color: #f1c40f;"></i>
                <h3>Standard</h3>
                <p>Account Status</p>
            </div>
        </div>

        <div class="activity-section">
            <h4><i class="fa-solid fa-history"></i> Your Recent Activity</h4>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Type</th>
                        <th>Date Posted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($activities)): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                        <td>
                            <span class="type-badge <?php echo ($row['type'] == 'Lost') ? 'type-lost' : 'type-found'; ?>">
                                <?php echo $row['type']; ?>
                            </span>
                        </td>
                        <td style="font-size: 13px; color: #7f8c8d;"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="post_details.php?id=<?php echo $row['id']; ?>&type=<?php echo strtolower($row['type']); ?>" style="color: #3498db; text-decoration: none; font-size: 13px;">View Details</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <?php if(mysqli_num_rows($activities) == 0): ?>
                        <tr><td colspan="4" style="text-align: center; padding: 20px; color: #999;">No activities yet. Start reporting!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>