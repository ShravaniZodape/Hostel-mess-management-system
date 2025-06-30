<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student's Bills</title>
    <link rel="stylesheet" href="css/registration.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <div class="registration-container">
        <h2>Student's Bills Form</h2>

        <?php
        // Include the database connection file
        include_once "database.php";

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $student_id = $_POST['student-id'];
            $mess_card_no = $_POST['mess-card-no'];
            $total_charges = $_POST['total-charges'];
            $billing_date = $_POST['billing-date'];
            $meal_type = $_POST['meal-type'];
            $pending_dues = isset($_POST['pending-dues']) ? $_POST['pending-dues'] : '';

            // Prepare and execute SQL query to insert data into the bill table
            $sql = "INSERT INTO bill (student_id, mess_card_no, total_charges, billing_date, meal_type, pending_dues) 
                    VALUES ('$student_id', '$mess_card_no', '$total_charges', '$billing_date', '$meal_type', '$pending_dues')";

            if (mysqli_query($conn, $sql)) {
                // If insertion is successful, display success message
                echo "<div class='alert alert-success'>Bill submitted successfully.</div>";
                // Display the submitted data
                echo "<div id='pdf-content'>";
                echo "<h3>Submitted Data:</h3>";
                echo "<p><strong>Student ID:</strong> $student_id</p>";
                echo "<p><strong>Mess Card No.:</strong> $mess_card_no</p>";
                echo "<p><strong>Total Charges:</strong> $total_charges</p>";
                echo "<p><strong>Billing Date:</strong> $billing_date</p>";
                echo "<p><strong>Meal Type:</strong> $meal_type</p>";
                echo "<p><strong>Pending Dues:</strong> $pending_dues</p>";
                echo "</div>";
                
                // Button to trigger PDF download
                echo '<button onclick="downloadPDF()">Download PDF</button>';
            } else {
                // If insertion fails, display error message
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
            }
        } else {
            // Form is displayed only if not submitted
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="student-id">Student ID:</label>
                    <input type="text" id="student-id" name="student-id" required>
                </div>
                <div class="form-group">
                    <label for="mess-card-no">Mess Card No.:</label>
                    <input type="text" id="mess-card-no" name="mess-card-no" required>
                </div>
                <div class="form-group">
                    <label for="total-charges">Total Charges:</label>
                    <input type="text" id="total-charges" name="total-charges" required>
                </div>
                <div class="form-group">
                    <label for="billing-date">Billing Date:</label>
                    <input type="date" id="billing-date" name="billing-date" required>
                </div>
                <div class="form-group">
                    <label for="meal-type">Meal Type:</label>
                    <select id="meal-type" name="meal-type" required>
                        <option value="VEG">VEG</option>
                        <option value="NON-VEG_1">NON-VEG_1</option>
                        <option value="NON-VEG_2">NON-VEG_2</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pending-dues">Pending Dues:</label>
                    <input type="text" id="pending-dues" name="pending-dues">
                </div>
                <button type="submit" name="submit">Submit</button>
            </form>
            <?php
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </div>

    <script>
        // Function to download the content as PDF
        function downloadPDF() {
            const element = document.getElementById('pdf-content');
            const options = {
                margin:       1,
                filename:     'student_bill.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(options).save();
        }
    </script>
</body>
</html>
