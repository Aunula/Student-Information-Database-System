<?php
// Set encoding for proper display
header('Content-Type: text/html; charset=utf-8');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "abcd_university";

// Roll No taken from GET parameter
$submitted_roll = isset($_GET['roll']) ? $_GET['roll'] : '';

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_data = null;

// Load data using Roll No if available
if (!empty($submitted_roll)) {
    $safe_roll = $conn->real_escape_string($submitted_roll);
    // Fetch the latest entry using the roll number
    $sql = "SELECT * FROM students WHERE roll_no = '$safe_roll' ORDER BY id DESC LIMIT 1"; 
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
    }
}

// Close database connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>✅ Registration Successful!</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Custom CSS for Animations */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-in {
            animation: slideInUp 0.8s ease-out forwards;
        }
        
        /* Removed staggered animation for cleaner look and smoother flow */
        .detail-row {
            opacity: 0; /* Initially hidden */
            animation: slideInUp 0.8s ease-out forwards; /* Apply base animation without delay */
        }
        /* Adjusted the gap between elements */
    </style>
</head>
<body class="bg-gray-50">

    <header>
        <div class="navbar sticky top-0 z-50 shadow-md bg-gradient-to-r from-white to-blue-100 px-10">

            <div class="navbar-start">
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h8m-8 6h16" />
                        </svg>
                    </div>
                    <ul tabindex="-1"
                        class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                        <li><a>Home</a></li>
                        <li>
                            <a>Info</a>
                            <ul class="p-2">
                                <li><a>Information</a></li>
                                <li><a>Facilities</a></li>
                            </ul>
                        </li>
                        <li><a>Contact</a></li>
                    </ul>
                </div>
                <a class="btn btn-ghost text-xl font-bold text-blue-800">ABCD University</a>
            </div>

            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal space-x-15 font-medium text-gray-800">
                    <li><a href="Information/faculty.html">Faculty</a></li>
                    <li><a href="Information/classroutine.html">Class Routine</a></li>
                    <li><a href="Information/Notice.html">Notice</a></li>
                    <li><a href="Information/Rating.html">Rating</a></li>
                </ul>
            </div>

            <div class="navbar-end">
                <a href="../login/login.html" class="btn btn-primary text-white">Logout</a>
            </div>
        </div>
    </header>

    <main class="flex justify-center p-4 sm:p-6 md:p-10 min-h-screen bg-gradient-to-br from-green-50 to-blue-100">
        <div class="w-full max-w-3xl">
            
            <?php if ($student_data): ?>
                
                <h1 class="font-extrabold text-5xl text-center mb-4 text-green-700 tracking-wider animate-slide-in">
                    <span class="text-green-500">🎉</span> Registration Successful!
                </h1>
                <p class="text-center text-gray-600 mb-10 font-medium animate-slide-in" style="animation-delay: 0.2s;">
                    Your information has been successfully saved. Below is the summary of your submission.
                </p>

                <div class="card bg-white shadow-2xl border border-green-300/50 rounded-xl overflow-hidden animate-slide-in" style="animation-delay: 0.4s;">
                    <div class="card-body p-6 sm:p-8 md:p-12">
                        
                        <div class="text-center mb-8 p-4 bg-blue-50 border-4 border-blue-500 rounded-lg shadow-inner detail-row mt-0" style="animation-delay: 0.4s;">
                            <p class="text-sm font-semibold text-blue-600 uppercase">Your University Roll Number</p>
                            <span class="text-3xl sm:text-4xl font-extrabold text-blue-800 tracking-widest block mt-1">
                                <?php echo htmlspecialchars($student_data['roll_no']); ?>
                            </span>
                        </div>
                        
                        <div class="space-y-4">
                            
                            <h2 class="text-2xl font-bold text-gray-700 border-b pb-2 mb-3 pt-0">Personal Details</h2>

                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>Student Name:</span>
                                <span class="text-gray-900 font-medium"><?php echo htmlspecialchars($student_data['student_name']); ?></span>
                            </div>

                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" /></svg>Date of Birth:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars(date('d F, Y', strtotime($student_data['dob']))); ?></span>
                            </div>

                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>Mobile Number:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($student_data['mobile_no']); ?></span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-700 border-b pb-2 mb-3 pt-4">Academic Details</h2>

                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.207 5 7.5 5A3.5 3.5 0 007 10.5v1a3.5 3.5 0 003.5 3.5h.5c.95 0 1.902-.32 2.76-1M12 6.253C13.168 5.477 14.793 5 16.5 5A3.5 3.5 0 0117 10.5v1a3.5 3.5 0 01-3.5 3.5h-.5c-.95 0-1.902-.32-2.76-1" /></svg>Department:</span>
                                <span class="text-lg font-bold text-blue-800"><?php echo htmlspecialchars($student_data['department']); ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v2a2 2 0 01-2 2h-5m-5 0H5a2 2 0 01-2-2v-2a2 2 0 012-2h5m5 0a2 2 0 012-2V7a2 2 0 00-2-2h-2.5A2.5 2.5 0 0012 5.5v2.5m-1 10h2m-6 0h.01M16 17h.01" /></svg>Batch & Section:</span>
                                <span class="text-gray-900"><?php echo "Batch " . htmlspecialchars($student_data['batch_no']) . " | Section " . htmlspecialchars($student_data['section']); ?></span>
                            </div>

                            <h2 class="text-2xl font-bold text-gray-700 border-b pb-2 mb-3 pt-4">Parent/Guardian Details</h2>

                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>Father's Name:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($student_data['father_name']); ?></span>
                            </div>
                            <div class="flex justify-between items-center detail-row">
                                <span class="font-semibold text-gray-600 flex items-center"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>Mother's Name:</span>
                                <span class="text-gray-900"><?php echo htmlspecialchars($student_data['mother_name']); ?></span>
                            </div>
                            
                            <div class="mt-10 text-center detail-row">
                                <a href="../index.html" class="btn btn-lg btn-success text-white font-bold transition-all duration-300 transform hover:scale-[1.03] shadow-lg hover:shadow-green-500/50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                                    Go Back to Home Page
                                </a>
                            </div>

                        </div>

                    <?php else: ?>
                        <div class="card bg-white shadow-2xl border border-red-300/50 rounded-xl p-12 text-center animate-slide-in">
                            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-16 w-16 mx-auto text-red-500 mb-4" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            <h2 class="text-2xl font-bold text-red-600 mb-2">Error! Data Not Found.</h2>
                            <p class="text-gray-600 mb-6">We couldn't retrieve the details for the submitted Roll Number. Please check your submission or try again.</p>
                            
                            <a href="student_registration.html" class="btn btn-error text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                                Re-submit Registration
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
    </main>
</body>
</html>