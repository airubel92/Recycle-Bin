<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); }
include_once("connection.php");

if(isset($_POST['update'])) {	
    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);	
    
    if(empty($name)) {
        $error = "Item name cannot be empty!";
    } else {	
        // ডাটাবেস আপডেট করা হচ্ছে
        mysqli_query($mysqli, "UPDATE lostfound SET name='$name' WHERE id=$id");
        
        // আপডেট শেষে found.php পেজে ফিরে যাবে
        header("Location: found.php");
    }
}

// URL থেকে আইডি নেওয়া হচ্ছে
$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM lostfound WHERE id=$id");
while($res = mysqli_fetch_array($result)) { 
    $name = $res['name']; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Found Item | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; padding:20px; }
        
        .edit-card { 
            background:#fff; 
            padding:35px; 
            border-radius:12px; 
            box-shadow:0 10px 25px rgba(0,0,0,0.1); 
            width:100%; 
            max-width:400px; 
            border-top: 5px solid #27ae60; /* Found আইটেমের জন্য সবুজ বর্ডার */
        }
        
        .edit-card h2 { text-align:center; color:#27ae60; margin-bottom:25px; font-size:22px; }
        
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; margin-bottom:8px; font-weight:500; color:#555; }
        .form-group input { 
            width:100%; 
            padding:12px; 
            border:1px solid #ddd; 
            border-radius:8px; 
            font-size:14px;
        }
        
        .btn-update { 
            width:100%; 
            padding:12px; 
            background:#27ae60; 
            color:white; 
            border:none; 
            border-radius:8px; 
            font-weight:600; 
            cursor:pointer; 
            transition:0.3s;
            font-size:16px;
        }
        
        .btn-update:hover { background:#219150; transform: translateY(-2px); }
        
        .msg-error { background:#ffebee; color:#c62828; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center; font-size:14px; }
        
        .back-link { display:block; text-align:center; margin-top:20px; text-decoration:none; color:#7f8c8d; font-size:14px; }
        .back-link:hover { color: #27ae60; }
    </style>
</head>
<body>

<div class="edit-card">
    <h2><i class="fa-solid fa-magnifying-glass"></i> Edit Found Item</h2>
    
    <?php if(isset($error)) echo "<div class='msg-error'>$error</div>"; ?>
    
    <form name="form1" method="post" action="editFound.php">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="name" value="<?php echo $name;?>" required placeholder="e.g. Found Black Keys">
        </div>
        
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        
        <button type="submit" name="update" class="btn-update">Update Information</button>
    </form>
    
    <a href="found.php" class="back-link">← Cancel and Back to List</a>
</div>

</body>
</html>