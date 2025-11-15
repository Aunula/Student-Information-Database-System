<?php
include 'db_connect.php'; // কানেকশন ও সেশন স্টার্ট

// লগইন করা আছে কি না চেক করা
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // আপনার লগইন পেজের নাম
    exit();
}

// ইউজার অলরেডি রেজিস্টার করেছে কি না চেক করা (ডাবল চেক)
$stmt_check = $conn->prepare("SELECT id FROM student_data WHERE user_id = ?");
$stmt_check->bind_param("i", $_SESSION['user_id']);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // যদি ডেটা আগে থেকেই থাকে, ড্যাশবোর্ডে ফেরত পাঠান
    header("Location: dashboard.php");
    exit();
}
$stmt_check->close();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: "Inter", sans-serif; }
        /* JS ভ্যালিডেশনের জন্য এরর মেসেজ স্টাইল */
        .error-message { 
            color: #D90429; /* লাল রঙ */
            font-size: 0.875rem; /* 14px */
            margin-top: 0.25rem; 
            display: none; /* ডিফল্টভাবে লুকানো */
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar sticky top-0 z-50 shadow-md bg-gradient-to-r from-white to-blue-100 px-10">
            <div class="navbar-start"><a class="btn btn-ghost text-xl font-bold text-blue-800">ABCD University</a></div>
            <div class="navbar-end"><a href="logout.php" class="btn btn-error text-white">Logout</a></div>
        </div>
    </header>

    <main class="flex justify-center p-6 md:p-10 bg-gray-50 min-h-screen">
        <div class="w-full max-w-4xl">
            <H1 class="font-bold text-3xl text-center mb-2 text-gray-800">Student Registration Form</H1>
            <p class="text-center text-gray-600 mb-8">Please fill out the form below accurately.</p>

            <div class="card bg-base-100 shadow-xl border border-gray-200">
                <div class="card-body p-6 md:p-10">
                    
                    <form id="registrationForm" action="register_action.php" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Student Name</span></label>
                            <input type="text" id="student_name" name="student_name" placeholder="Enter full name" class="input input-bordered w-full" />
                            <span id="name_error" class="error-message">Name is required.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Father's Name</span></label>
                            <input type="text" id="father_name" name="father_name" placeholder="Enter father's full name" class="input input-bordered w-full" />
                            <span id="father_name_error" class="error-message">Father's name is required.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Mother's Name</span></label>
                            <input type="text" id="mother_name" name="mother_name" placeholder="Enter mother's full name" class="input input-bordered w-full" />
                            <span id="mother_name_error" class="error-message">Mother's name is required.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Mobile No.</span></label>
                            <input type="tel" id="mobile_no" name="mobile_no" placeholder="e.g., 01700000000" class="input input-bordered w-full" />
                            <span id="mobile_error" class="error-message">Must be 11 digits (e.g., 017...).</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Department Name</span></label>
                            <select id="department" name="department" class="select select-bordered w-full">
                                <option disabled selected value="">Select Department</option>
                                <option value="CSE">Computer Science and Engineering (CSE)</option>
                                <option value="EEE">Electrical and Electronic Engineering (EEE)</option>
                                <option value="BBA">Bachelor of Business Administration (BBA)</option>
                                <option value="ENG">English</option>
                                <option value="LAW">Law</option>
                            </select>
                            <span id="dept_error" class="error-message">Please select a department.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Batch No.</span></label>
                            <input type="text" id="batch_no" name="batch_no" placeholder="e.g., 29" class="input input-bordered w-full" />
                            <span id="batch_error" class="error-message">Batch is required.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Section</span></label>
                            <input type="text" id="section" name="section" placeholder="e.g., A" class="input input-bordered w-full" />
                            <span id="section_error" class="error-message">Section is required.</span>
                        </div>

                        <div class="form-control">
                            <label class="label"><span class="label-text font-medium">Roll No.</span></label>
                            <input type="text" id="roll_no" name="roll_no" placeholder="e.g., CSE 0290761" class="input input-bordered w-full" />
                            <label class="label"><span class="label-text-alt">Include department prefix (e.g., CSE 0290761)</span></label>
                            <span id="roll_error" class="error-message">Format must be: DEPT 1234567</span>
                        </div>

                        <div class="form-control mt-6 md:col-span-2 text-center">
                            <button type="submit" class="btn btn-primary btn-wide text-white text-lg transition-all duration-300 hover:scale-105">
                                Submit Registration
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("registrationForm");
            
            form.addEventListener("submit", (event) => {
                // ভ্যালিডেশন ফাংশন কল করা
                if (!validateForm()) {
                    event.preventDefault(); // যদি ভ্যালিড না হয়, ফর্ম সাবমিট বন্ধ করুন
                    console.log("Form validation failed.");
                } else {
                    console.log("Form validation passed. Submitting...");
                }
            });

            function validateForm() {
                let valid = true; // ধরি ফর্মটি ভ্যালিড
                hideAllErrors();

                // সব ইনপুট ও এরর ফিল্ড সিলেক্ট করুন
                const inputs = {
                    student_name: document.getElementById("student_name"),
                    father_name: document.getElementById("father_name"),
                    mother_name: document.getElementById("mother_name"),
                    mobile_no: document.getElementById("mobile_no"),
                    department: document.getElementById("department"),
                    batch_no: document.getElementById("batch_no"),
                    section: document.getElementById("section"),
                    roll_no: document.getElementById("roll_no")
                };

                const errors = {
                    student_name: document.getElementById("name_error"),
                    father_name: document.getElementById("father_name_error"),
                    mother_name: document.getElementById("mother_name_error"),
                    mobile_no: document.getElementById("mobile_error"),
                    department: document.getElementById("dept_error"),
                    batch_no: document.getElementById("batch_error"),
                    section: document.getElementById("section_error"),
                    roll_no: document.getElementById("roll_error")
                };

                // Helper Functions
                const showError = (field, message) => {
                    errors[field].textContent = message;
                    errors[field].style.display = "block";
                    valid = false;
                };

                const hideAllErrors = () => {
                    for (let key in errors) {
                        errors[key].style.display = "none";
                    }
                };

                // --- ভ্যালিডেশন রুলস ---
                if (inputs.student_name.value.trim() === "") showError("student_name", "Name is required.");
                if (inputs.father_name.value.trim() === "") showError("father_name", "Father's name is required.");
                if (inputs.mother_name.value.trim() === "") showError("mother_name", "Mother's name is required.");
                if (inputs.department.value === "") showError("department", "Please select a department.");
                if (inputs.batch_no.value.trim() === "") showError("batch_no", "Batch is required.");
                if (inputs.section.value.trim() === "") showError("section", "Section is required.");

                // Mobile Regex (বাংলাদেশী নম্বর)
                const mobileRegex = /^01[3-9]\d{8}$/;
                if (inputs.mobile_no.value.trim() === "") {
                    showError("mobile_no", "Mobile number is required.");
                } else if (!mobileRegex.test(inputs.mobile_no.value.trim())) {
                    showError("mobile_no", "Must be a valid 11-digit Bangladeshi number (e.g., 017...).");
                }

                // Roll Regex (e.g., CSE 0290761)
                const rollRegex = /^[A-Z]{3,4}\s\d{7}$/; 
                if (inputs.roll_no.value.trim() === "") {
                    showError("roll_no", "Roll number is required.");
                } else if (!rollRegex.test(inputs.roll_no.value.trim().toUpperCase())) { // .toUpperCase() যোগ করা ভালো
                    showError("roll_no", "Format must be: DEPT 1234567 (e.g., CSE 0290761)");
                }

                return valid; // ভ্যালিড হলে true, না হলে false রিটার্ন করবে
            }
        });
    </script>
</body>
</html>