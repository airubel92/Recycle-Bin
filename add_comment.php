<?php
session_start();
include_once("connection.php");

// ইউজার লগইন করা আছে কিনা চেক করা
if (!isset($_SESSION['valid'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['comment_text'])) {
    // সিকিউরিটির জন্য ডেটা ফিল্টার করা
    $post_id = mysqli_real_escape_string($mysqli, $_POST['post_id']);
    $user_id = $_SESSION['id'];
    $comment_text = mysqli_real_escape_string($mysqli, $_POST['comment_text']);

    // কমেন্ট বক্স খালি থাকলে ফেরত পাঠানো
    if (empty(trim($comment_text))) {
        header("Location: post_details.php?id=$post_id");
        exit();
    }

    // ডাটাবেসে কমেন্ট ইনসার্ট করা
    $query = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
    
    if (mysqli_query($mysqli, $query)) {
        // সফলভাবে সেভ হলে পুনরায় আগের পেজে রিডাইরেক্ট করা
        header("Location: post_details.php?id=$post_id");
        exit();
    } else {
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    // সরাসরি এক্সেস করলে হোমপেজে পাঠানো
    header('Location: index.php');
    exit();
}
?>