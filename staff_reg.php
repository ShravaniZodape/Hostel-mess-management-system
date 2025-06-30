<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Staff Registration</title>
    <link rel="stylesheet" href="css/registration.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    
    <div class="registration-container">
        <h2>Mess Staff Registration Form</h2>

        <?php
        // Include the database connection file
        include_once "database.php";

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $employee_id = $_POST['employee-id'];
            $employee_name = $_POST['employee-name'];
            $phone_number = $_POST['phone-number'];
            $address = $_POST['address'];
            $salary = $_POST['salary'];
            $service = $_POST['service'];

            // Prepare and execute SQL query to insert data into the mess_staff table
            $sql = "INSERT INTO mess_staff (employee_id, employee_name, phone_no, address, salary, service) 
                    VALUES ('$employee_id', '$employee_name', '$phone_number', '$address', '$salary', '$service')";

            if (mysqli_query($conn, $sql)) {
                // If insertion is successful, display success message
                echo "<div class='alert alert-success'>Mess Staff registered successfully.</div>";
                
                // Display the submitted data
                echo "<div id='pdf-content'>";
                echo "<h3>Submitted Data:</h3>";
                echo "<p><strong>Employee ID:</strong> $employee_id</p>";
                echo "<p><strong>Employee Name:</strong> $employee_name</p>";
                echo "<p><strong>Phone Number:</strong> $phone_number</p>";
                echo "<p><strong>Address:</strong> $address</p>";
                echo "<p><strong>Salary:</strong> $salary</p>";
                echo "<p><strong>Service:</strong> $service</p>";
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
                    <label for="employee-id">Employee ID:</label>
                    <input type="text" id="employee-id" name="employee-id" required>
                </div>
                <div class="form-group">
                    <label for="employee-name">Employee Name:</label>
                    <input type="text" id="employee-name" name="employee-name" required>
                </div>
                <div class="form-group">
                    <label for="phone-number">Phone Number:</label>
                    <input type="tel" id="phone-number" name="phone-number" required>
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="salary">Salary:</label>
                    <input type="text" id="salary" name="salary" required>
                </div>
                <div class="form-group">
                    <label for="service">Service:</label>
                    <input type="text" id="service" name="service" required>
                </div>
                <button type="submit" name="register">Register</button>
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
                filename:     'mess_staff_registration.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(options).save();
        }
    </script>
</body>
</html>
