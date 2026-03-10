<?php 
session_start(); 
if(!isset($_SESSION['valid'])) { header('Location: login.php'); }
include_once("connection.php");

if(isset($_POST['update'])) {	
    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
    $name = mysqli_real_escape_string($mysqli, $_POST['name']);	
    
    if(empty($name)) {
        $error = "Name cannot be empty!";
    } else {	
        mysqli_query($mysqli, "UPDATE lostfound SET name='$name' WHERE id=$id");
        header("Location: lost.php"); // Updated to match your separate logic
    }
}

$id = $_GET['id'];
$result = mysqli_query($mysqli, "SELECT * FROM lostfound WHERE id=$id");
while($res = mysqli_fetch_array($result)) { $name = $res['name']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lost Item | UIU RecycleBin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
        body { background:#f4f7f6; display:flex; justify-content:center; align-items:center; min-height:100vh; }
        .edit-card { background:#fff; padding:35px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.1); width:100%; max-width:400px; }
        .edit-card h2 { text-align:center; color:#e67e22; margin-bottom:20px; }
        .form-group { margin-bottom:15px; }
        .form-group label { display:block; margin-bottom:5px; font-weight:500; }
        .form-group input { width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; }
        .btn-update { width:100%; padding:12px; background:#e67e22; color:white; border:none; border-radius:6px; font-weight:600; cursor:pointer; }
        .back-link { display:block; text-align:center; margin-top:15px; text-decoration:none; color:#7f8c8d; font-size:14px; }
    </style>
</head>
<body>
<div class="edit-card">
    <h2>Edit Item Info</h2>
    <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
    <form name="form1" method="post" action="editLost.php">
        <div class="form-group">
            <label>Item Name</label>
            <input type="text" name="name" value="<?php echo $name;?>" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
        <button type="submit" name="update" class="btn-update">Save Changes</button>
    </form>
    <a href="index.php" class="back-link">Back to Home</a>
</div>
</body>
</html>