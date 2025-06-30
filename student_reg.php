<?php
// Include the database connection file
include_once "database.php";

// Initialize variables for success or error message
$success_message = '';
$error_message = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $phone_number = $_POST['phone_number'];
    $mess_card_no = $_POST['mess_card_no'];
    $course = $_POST['course'];
    $department = $_POST['department'];
    $year_of_study = $_POST['year_of_study'];
    $hostel_room_number = $_POST['hostel_room_number'];

    // Prepare and execute SQL query to insert data into the student table
    $sql = "INSERT INTO student (student_id, student_name, phone_no, mess_card_no, course, department, year_of_study, hostel_room_no) 
            VALUES ('$student_id', '$student_name', '$phone_number', '$mess_card_no', '$course', '$department', '$year_of_study', '$hostel_room_number')";

    if (mysqli_query($conn, $sql)) {
        // If insertion is successful, display success message
        $success_message = "Student registered successfully.";
    } else {
        // If insertion fails, display error message
        $error_message = "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="css/registration.css">
    <!-- Include html2pdf library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <div class="registration-container">
        <h2>Student Registration Form</h2>

        <?php
        // If registration was successful, show the student details and download button
        if ($success_message) {
            echo "<div class='alert alert-success'>$success_message</div>";
            ?>
            <div id="pdf-content">
            <h2 style="text-align: center; color: #000000; text-transform: uppercase;">Student Registration Details</h2>
            <div style="padding: 20px; border: 1px solid #ddd; border-radius: 10px; background-color: #f9f9f9; max-width: 600px; margin: 0 auto;">
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Student ID:</strong> <?php echo $student_id; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Student Name:</strong> <?php echo $student_name; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Mess Card No.:</strong> <?php echo $mess_card_no; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Course:</strong> <?php echo $course; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Department:</strong> <?php echo $department; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Year of Study:</strong> <?php echo $year_of_study; ?></p>
            <p style="font-size: 16px; margin-bottom: 10px;"><strong>Hostel Room No.:</strong> <?php echo $hostel_room_number; ?></p>
        </div>
    </div>

            <button class="pdf-download-btn" onclick="downloadPDF()">Download PDF</button>
            <button class="pdf-download-btn" onclick="window.location.href='dashboard.php'">Back to Dashboard</button> <!-- New Button -->

            <div id="pdf-content" style="padding: 20px;">

            <script>
                // Function to download the PDF using html2pdf
                function downloadPDF() {
                    var element = document.getElementById('pdf-content');
                    var opt = {
                        margin:       1,
                        filename:     'student_registration_<?php echo $student_id; ?>.pdf',
                        image:        { type: 'jpeg', quality: 0.98 },
                        html2canvas:  { scale: 4 },
                        jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                    };
                    html2pdf(element, opt);
                }
            </script>
            <?php
        } else {
            // If registration failed, show the error message
            if ($error_message) {
                echo "<div class='alert alert-danger'>$error_message</div>";
            }
            ?>

            <!-- Registration Form -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
                <div class="form-group">
                    <label for="student_name">Student Name:</label>
                    <input type="text" id="student_name" name="student_name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="tel" id="phone_number" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="mess_card_no">Mess Card No.:</label>
                    <input type="text" id="mess_card_no" name="mess_card_no" required>
                </div>
                <div class="form-group">
                    <label for="course">Course:</label>
                    <input type="text" id="course" name="course" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" id="department" name="department" required>
                </div>
                <div class="form-group">
                    <label for="year_of_study">Year of Study:</label>
                    <input type="text" id="year_of_study" name="year_of_study" required>
                </div>
                <div class="form-group">
                    <label for="hostel_room_number">Hostel Room Number:</label>
                    <input type="text" id="hostel_room_number" name="hostel_room_number" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>

        <?php } ?>
    </div>
</body>
</html>


