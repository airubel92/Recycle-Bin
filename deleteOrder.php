<?php 
session_start(); 

if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    $login_id = $_SESSION['id'];

    // শুধুমাত্র নিজের অর্ডার ডিলিট করার সুরক্ষা নিশ্চিত করা
    $result = mysqli_query($mysqli, "DELETE FROM orders WHERE id=$id AND login_id=$login_id");
}

// অর্ডার পেজে ফেরত যাওয়া
header("Location: order.php");
exit();
?>