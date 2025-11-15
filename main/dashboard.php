<?php
include 'db_connect.php'; // কানেকশন ও সেশন স্টার্ট

// ১. লগইন করা আছে কি না চেক করা
// আমি ধরে নিচ্ছি আপনি লগইনের সময় $_SESSION['user_id'] সেট করেছেন।
if (!isset($_SESSION['user_id'])) {
    // যদি লগইন করা না থাকে, login.php পেজে ফেরত পাঠান
    header("Location: login.php"); // আপনার লগইন পেজের নাম দিন
    exit();
}

// ২. সেশন থেকে ইউজার আইডি ও নাম নেওয়া
$user_id = $_SESSION['user_id'];
// ইউজারনেম ঐচ্ছিক, যদি সেশনে সেট করে থাকেন
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Student';

// ৩. এই ইউজারের ডেটা student_data টেবিলে আছে কি না চেক করা
$stmt = $conn->prepare("SELECT * FROM student_data WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$student_data = null;
if ($result->num_rows == 1) {
    // যদি ডেটা পাওয়া যায়
    $student_data = $result->fetch_assoc();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css"> <style> 
        body { font-family: "Inter", sans-serif; } 
    </style>
</head>
<body>
    <header>
        <div class="navbar sticky top-0 z-50 shadow-md bg-gradient-to-r from-white to-blue-100 px-10">
            <div class="navbar-start">
                <a class="btn btn-ghost text-xl font-bold text-blue-800">ABCD University</a>
            </div>
            <div class="navbar-end">
                <span class="font-medium mr-4">Welcome, <?php echo htmlspecialchars($user_name); ?></span>
                <a href="logout.php" class="btn btn-error text-white">Logout</a> 
            </div>
        </div>
    </header>

    <main class="flex justify-center p-6 md:p-10 bg-gray-50 min-h-screen">
        <div class="w-full max-w-4xl">
            
            <?php if ($student_data): ?>
                <H1 class="font-bold text-3xl text-center mb-8 text-gray-800">Your Student Profile</H1>
                <div class="card bg-base-100 shadow-xl border border-gray-200">
                    <div class="card-body p-6 md:p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Student Name</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['student_name']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Roll No.</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['roll_no']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Father's Name</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['father_name']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Mother's Name</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['mother_name']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Mobile No.</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['mobile_no']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Department</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['department']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Batch No.</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['batch_no']); ?></p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-sm font-medium text-gray-500">Section</span>
                                <p class="text-lg font-semibold text-gray-800"><?php echo htmlspecialchars($student_data['section']); ?></p>
                            </div>

                        </div>
                    </div>
                </div>

            <?php else: ?>
                <div class="text-center p-10 card bg-base-100 shadow-xl border border-gray-200">
                    <H1 class="font-bold text-3xl mb-4 text-gray-800">Welcome, <?php echo htmlspecialchars($user_name); ?>!</H1>
                    <p class="text-lg text-gray-600 mb-8">
                        You have not submitted your student details yet. <br>
                        Please complete your registration to view your profile.
                    </p>
                    <a href="registration_page.php" class="btn btn-primary btn-wide text-white text-lg transition-all duration-300 hover:scale-105">
                        Click Here to Register
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </main>
</body>
</html>