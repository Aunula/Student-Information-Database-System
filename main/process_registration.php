<?php
// বাংলা ফন্টের জন্য এনকোডিং সেট করুন
header('Content-Type: text/html; charset=utf-8');

// ডাটাবেস সংযোগের তথ্য
$servername = "localhost";
$username = "root"; // XAMPP ডিফল্ট ইউজারনেম
$password = "";     // XAMPP ডিফল্ট পাসওয়ার্ড (সাধারণত খালি)
$dbname = "abcd_university"; // আপনার তৈরি করা ডাটাবেসের নাম

// ডাটাবেসে সংযোগ স্থাপন
$conn = new mysqli($servername, $username, $password, $dbname);

// সংযোগ পরীক্ষা
if ($conn->connect_error) {
    // সংযোগ ব্যর্থ হলে একটি ত্রুটি দেখান
    die("ডাটাবেসে সংযোগ ব্যর্থ: " . $conn->connect_error);
}

// চেক করুন ফর্মটি POST মেথড ব্যবহার করে সাবমিট করা হয়েছে কিনা
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ফর্ম ডেটা ভেরিয়েবলে সংরক্ষণ ও স্যানিটাইজ করা
    // এখানে আপনার HTML ফর্মের 'name' অ্যাট্রিবিউট অনুযায়ী ভেরিয়েবল নামগুলো ব্যবহার করা হয়েছে
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $mother_name = $conn->real_escape_string($_POST['mother_name']);
    $mobile_no = $conn->real_escape_string($_POST['mobile_no']);
    $dob = $conn->real_escape_string($_POST['dob']); // Date of Birth
    $department = $conn->real_escape_string($_POST['department']);
    $batch_no = $conn->real_escape_string($_POST['batch_no']);
    $section = $conn->real_escape_string($_POST['section']);
    $roll_no = $conn->real_escape_string($_POST['roll_no']);

    // ডেটা INSERT করার জন্য SQL কোয়েরি
    $sql = "INSERT INTO students (student_name, father_name, mother_name, mobile_no, dob, department, batch_no, section, roll_no)
            VALUES ('$student_name', '$father_name', '$mother_name', '$mobile_no', '$dob', '$department', '$batch_no', '$section', '$roll_no')";

    // কোয়েরি এক্সিকিউট করা এবং ফলাফল পরীক্ষা করা
    if ($conn->query($sql) === TRUE) {
        // সফল হলে, ব্যবহারকারীকে তার তথ্য দেখানোর পৃষ্ঠায় রিডাইরেক্ট করুন
        // GET প্যারামিটার ব্যবহার করে Roll No পাঠানো হচ্ছে যাতে পরবর্তী পেজটি সঠিক তথ্য লোড করতে পারে
        header("Location: registration_success.php?roll=" . urlencode($roll_no));
        exit();
    } else {
        // ইনসার্ট ব্যর্থ হলে
        echo "<h3>দুঃখিত! ডেটা সংরক্ষণে ত্রুটি হয়েছে: " . $sql . "<br>" . $conn->error . "</h3>";
    }

} else {
    // যদি কেউ সরাসরি এই পেজটি অ্যাক্সেস করে
    echo "<h3>এই পেজটি সরাসরি অ্যাক্সেস করা যাবে না। ফর্ম সাবমিট করুন।</h3>";
}

// ডাটাবেস সংযোগ বন্ধ করা
$conn->close();
?>