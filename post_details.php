<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); exit(); }
include_once("connection.php");

// URL থেকে আইডি এবং টাইপ নেওয়া
if(!isset($_GET['id'])) { header('Location: index.php'); exit(); }
$post_id = mysqli_real_escape_string($mysqli, $_GET['id']);
$type = isset($_GET['type']) ? mysqli_real_escape_string($mysqli, $_GET['type']) : '';

$post = null;
$category_name = "";

// ১. যদি টাইপ 'lost' হয়
if ($type == 'lost') {
    $query = "SELECT lost.*, login.name as username FROM lost JOIN login ON lost.login_id = login.id WHERE lost.id = $post_id";
    $category_name = "LOST ITEM";
    $is_market = false;
} 
// ২. যদি টাইপ 'found' হয়
elseif ($type == 'found') {
    $query = "SELECT found.*, login.name as username FROM found JOIN login ON found.login_id = login.id WHERE found.id = $post_id";
    $category_name = "FOUND ITEM";
    $is_market = false;
} 
// ৩. ডিফল্ট বা 'product' টাইপ হলে Marketplace চেক করা
else {
    $query = "SELECT p.*, l.name as username FROM products p JOIN login l ON p.login_id = l.id WHERE p.id = $post_id";
    $category_name = "MARKETPLACE";
    $is_market = true;
}

$result = mysqli_query($mysqli, $query);
$post = mysqli_fetch_assoc($result);

// যদি নির্দিষ্ট টাইপে না পাওয়া যায়, তবে ব্যাকআপ হিসেবে অন্য টেবিলগুলোতে একবার চেক করা (বড় পরিবর্তন)
if (!$post && empty($type)) {
    // এই অংশটি শুধু তখনই কাজ করবে যখন টাইপ প্যারামিটার থাকবে না
    $tables = ['lost', 'found', 'products'];
    foreach ($tables as $t) {
        $q = "SELECT $t.*, login.name as username FROM $t JOIN login ON $t.login_id = login.id WHERE $t.id = $post_id";
        $r = mysqli_query($mysqli, $q);
        if ($post = mysqli_fetch_assoc($r)) {
            $is_market = ($t == 'products');
            $category_name = strtoupper($t) . " ITEM";
            break;
        }
    }
}

if(!$post) { 
    echo "<div style='text-align:center; padding:50px; font-family:Poppins;'><h2>Item details not found!</h2><p>The post might have been deleted.</p><br><a href='index.php'>Go Back</a></div>"; 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['name']); ?> | Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f0f2f5; padding: 40px 5%; }
        .container { max-width: 900px; margin: 0 auto; }
        
        .details-card { background:#fff; padding:30px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); margin-bottom:25px; border-top: 6px solid <?php echo $is_market ? '#27ae60' : '#e74c3c'; ?>; }
        .badge { display:inline-block; padding:6px 15px; border-radius:20px; font-size:12px; font-weight:600; background:#f8f9fa; color:#555; margin-bottom:15px; border: 1px solid #ddd; }
        
        h1 { color:#2c3e50; font-size: 2rem; margin-bottom: 10px; }
        .post-info { color:#7f8c8d; font-size: 14px; margin-bottom: 20px; display: flex; gap: 15px; flex-wrap: wrap; }
        
        .reward-box { background:#fff3cd; padding:15px; border-radius:12px; color:#856404; display:flex; align-items:center; gap:12px; border: 1px solid #ffeeba; }
        
        .comment-section { background:#fff; padding:30px; border-radius:15px; box-shadow:0 10px 25px rgba(0,0,0,0.05); }
        .comment-section h3 { margin-bottom: 20px; color: #2c3e50; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        
        .comment-box { padding:15px; background:#f8fafc; border-radius:10px; margin-bottom:15px; border: 1px solid #edf2f7; }
        .comment-box strong { color:#27ae60; display: block; margin-bottom: 5px; }
        
        textarea { width:100%; padding:15px; border:2px solid #edf2f7; border-radius:10px; margin-bottom:15px; outline: none; transition: 0.3s; }
        textarea:focus { border-color: #3498db; }
        .btn-post { background:#27ae60; color:white; border:none; padding:12px 25px; border-radius:10px; width:100%; cursor:pointer; font-weight:600; transition: 0.3s; }
        .btn-post:hover { background: #219150; transform: translateY(-2px); }

        @media (max-width: 600px) { h1 { font-size: 1.5rem; } .details-card { padding: 20px; } }
    </style>
</head>
<body>

<div class="container">
    <div class="details-card">
        <span class="badge"><i class="fa-solid fa-layer-group"></i> <?php echo $category_name; ?></span>
        <h1><?php echo htmlspecialchars($post['name']); ?></h1>
        
        <div class="post-info">
            <span><i class="fa-solid fa-circle-user"></i> Posted by: <strong><?php echo htmlspecialchars($post['username']); ?></strong></span>
            <?php if(isset($post['created_at'])): ?>
                <span><i class="fa-solid fa-calendar-day"></i> <?php echo date('M d, Y', strtotime($post['created_at'])); ?></span>
            <?php endif; ?>
        </div>
        
        <?php if(!$is_market): ?>
            <div class="reward-box">
                <i class="fa-solid fa-mug-hot fa-2x"></i>
                <div>
                    <strong>Coffee Reward System ☕</strong>
                    <p style="font-size:12px;">মালিকানা প্রমাণের পর এক কাপ কফি ট্রিট দিয়ে আপনার কৃতজ্ঞতা প্রকাশ করুন।</p>
                </div>
            </div>
            <p style="margin-top:20px; color:#555; font-size: 14px;"><strong>Location:</strong> <?php echo htmlspecialchars($post['place']); ?></p>
        <?php else: ?>
            <p style="font-size: 1.2rem; color: #27ae60; font-weight: 600;">Price: ৳<?php echo $post['price']; ?></p>
            <p style="color:#666;">Available Quantity: <?php echo $post['qty']; ?></p>
        <?php endif; ?>
    </div>

    <div class="comment-section">
        <h3><i class="fa-solid fa-comments"></i> Discussions & Proofs</h3>
        
        <div id="comment-list">
            <?php
            $comments = mysqli_query($mysqli, "SELECT c.*, l.name FROM comments c JOIN login l ON c.user_id = l.id WHERE c.post_id = $post_id ORDER BY c.id ASC");
            if(mysqli_num_rows($comments) > 0):
                while($com = mysqli_fetch_assoc($comments)): ?>
                    <div class="comment-box">
                        <strong><i class="fa-solid fa-user-tag"></i> <?php echo htmlspecialchars($com['name']); ?>:</strong>
                        <p style="font-size:14px;"><?php echo htmlspecialchars($com['comment_text']); ?></p>
                    </div>
                <?php endwhile;
            else: ?>
                <p style="text-align:center; color:#999; padding:10px;">No messages yet. Start the conversation!</p>
            <?php endif; ?>
        </div>

        <form action="add_comment.php" method="POST" style="margin-top:20px;">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <textarea name="comment_text" rows="3" placeholder="মালিকানা প্রমাণের জন্য বিস্তারিত লিখুন..." required></textarea>
            <button type="submit" class="btn-post">Send Message</button>
        </form>
    </div>

    <p style="text-align:center; margin-top:30px;">
        <a href="index.php" style="text-decoration:none; color:#3498db; font-weight: 600;">
            <i class="fa-solid fa-arrow-left"></i> Back to Home
        </a>
    </p>
</div>

</body>
</html>