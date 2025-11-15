<?php
// ডেটাবেস কনফিগারেশন
$servername = "localhost";
$username = "root"; // XAMPP-এর ডিফল্ট ইউজারনেম
$password = "";     // XAMPP-এর ডিফল্ট পাসওয়ার্ড (খালি)
$dbname = "user_db";  // আপনার ডেটাবেসের নাম

// কানেকশন তৈরি করুন
$conn = new mysqli($servername, $username, $password, $dbname);

// কানেকশন চেক করুন
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// বাংলা অক্ষরের জন্য UTF-8 সেট করা (যদি লাগে)
$conn->set_charset("utf8");

// PHP সেশন শুরু করা (সবচেয়ে গুরুত্বপূর্ণ)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>