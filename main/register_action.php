<?php
include 'db_connect.php'; // কানেকশন ও সেশন স্টার্ট

// লগইন করা আছে কি না চেক করা
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // আপনার লগইন পেজের নাম
    exit();
}

// চেক করা হচ্ছে যে ফর্মটি POST মেথডে সাবমিট হয়েছে কি না
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // সেশন থেকে ইউজার আইডি নেওয়া
    $user_id = $_SESSION['user_id'];

    // ফর্মের ডেটাগুলো ভেরিয়েবলে সেভ করা
    $student_name = $_POST['student_name'];
    $father_name  = $_POST['father_name'];
    $mother_name  = $_POST['mother_name'];
    $mobile_no    = $_POST['mobile_no'];
    $department   = $_POST['department'];
    $batch_no     = $_POST['batch_no'];
    $section      = $_POST['section'];
    $roll_no      = $_POST['roll_no'];

    // (জাভাস্ক্রিপ্টে ভ্যালিডেশন করা হলেও, সার্ভারেও ভ্যালিডেশন করা ভালো)
    // (আপাতত আমরা JS ভ্যালিডেশনের উপর নির্ভর করছি)

    // Prepared Statement দিয়ে ডেটা ইনসার্ট করা (SQL Injection প্রতিরোধ)
    $stmt = $conn->prepare("INSERT INTO student_data 
        (user_id, student_name, father_name, mother_name, mobile_no, department, batch_no, section, roll_no) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // "isssssiss" হলো ডেটা টাইপ: i = integer, s = string
    $stmt->bind_param("isssssiss", 
        $user_id, 
        $student_name, 
        $father_name, 
        $mother_name, 
        $mobile_no, 
        $department, 
        $batch_no, 
        $section, 
        $roll_no
    );

    // স্টেটমেন্ট এক্সিকিউট করা
    if ($stmt->execute()) {
        // সফলভাবে ইনসার্ট হলে, ড্যাশবোর্ডে ফেরত যান
        header("Location: dashboard.php"); // সফলভাবে সেভ হয়েছে, তাই ড্যাশবোর্ডে ডেটা দেখাবে
        exit();
    } else {
        // কোনো এরর হলে (যেমন, যদি ইউজার ডুপ্লিকেট সাবমিট করার চেষ্টা করে)
        echo "Error: " . $stmt->error;
        // আপনি চাইলে একটি এরর পেজেও পাঠাতে পারেন
    }

    $stmt->close();
    $conn->close();

} else {
    // যদি কেউ সরাসরি register_action.php পেজে আসার চেষ্টা করে
    echo "Invalid request method.";
    header("Location: dashboard.php");
    exit();
}
?>