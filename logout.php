<?php
session_start(); // সেশন শুরু করা যাতে এটি মুছে ফেলা যায়

// ১. সমস্ত সেশন ভেরিয়েবল খালি করা
$_SESSION = array();

// ২. সেশনটি পুরোপুরি ধ্বংস করা
session_destroy();

// ৩. সেশন কুকি মুছে ফেলা (নিরাপত্তার জন্য)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// ৪. ইউজারকে হোম পেজে পাঠিয়ে দেওয়া
header("Location: index.php");
exit();
?>