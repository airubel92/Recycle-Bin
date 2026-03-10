<?php 
session_start(); 

// ইউজার লগইন করা আছে কিনা চেক করা
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

// URL থেকে আইডি নেওয়া এবং সিকিউরিটি চেক করা
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    
    // শুধুমাত্র নিজের প্রোডাক্ট ডিলিট করার পারমিশন (Security Update)
    $login_id = $_SESSION['id'];
    $result = mysqli_query($mysqli, "DELETE FROM products WHERE id=$id AND login_id=$login_id");
}

// ডিলিট শেষে মার্কেটপ্লেস পেজে ফেরত যাওয়া
header("Location: sale.php");
exit();
?>