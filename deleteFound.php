<?php 
session_start(); 

// ইউজার লগইন করা আছে কিনা চেক করা
if(!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

include("connection.php"); // ডাটাবেস কানেকশন

if(isset($_GET['id'])) {
    // URL থেকে আইডি নিয়ে সিকিউরিটি নিশ্চিত করা
    $id = mysqli_real_escape_string($mysqli, $_GET['id']);
    
    // ডাটাবেস থেকে ওই নির্দিষ্ট আইডি-র তথ্য ডিলিট করা
    $result = mysqli_query($mysqli, "DELETE FROM lostfound WHERE id=$id");
}

// ডিলিট সফল হওয়ার পর সরাসরি found.php পেজে ফেরত পাঠানো
header("Location: found.php"); 
exit();
?>