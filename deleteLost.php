<?php 
session_start(); 

if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include("connection.php");

if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    
    // ডাটাবেস থেকে ডিলিট করা
    $result = mysqli_query($mysqli, "DELETE FROM lostfound WHERE id=$id");
}

// আপনার নতুন লজিক অনুযায়ী lost.php বা found.php তে রিডাইরেক্ট হওয়া ভালো
// আপাতত আপনার অরিজিনাল ফাইল অনুযায়ী রিডাইরেক্ট করা হলো
header("Location: index.php"); 
exit();
?>