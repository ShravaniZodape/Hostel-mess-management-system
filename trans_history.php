<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" href="css/registration.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <div class="registration-container">
        <h2>Transaction History Form</h2>

        <?php
        // Include the database connection file
        include_once "database.php";

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $mess_card_no = $_POST['mess-card-no'];
            $amount = $_POST['amount'];
            $bill_month = $_POST['bill-month'];
            $payment_date = $_POST['payment-date'];
            $leave_days = $_POST['leave-days'];

            // Prepare and execute SQL query to insert data into the transaction_history table
            $sql = "INSERT INTO transaction_history (mess_card_no, amount, bill_month, payment_date, leave_days) 
                    VALUES ('$mess_card_no', '$amount', '$bill_month', '$payment_date', '$leave_days')";

            if (mysqli_query($conn, $sql)) {
                // If insertion is successful, display success message
                echo "<div class='alert alert-success'>Transaction recorded successfully.</div>";
                
                // Display the submitted data for PDF generation
                echo "<div id='pdf-content'>";
                echo "<h3>Transaction Details:</h3>";
                echo "<p><strong>Mess Card No.:</strong> $mess_card_no</p>";
                echo "<p><strong>Amount:</strong> $amount</p>";
                echo "<p><strong>Bill Month:</strong> $bill_month</p>";
                echo "<p><strong>Payment Date:</strong> $payment_date</p>";
                echo "<p><strong>Leave Days:</strong> $leave_days</p>";
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
                    <label for="transaction-id">Transaction ID:</label>
                    <input type="text" id="transaction-id" name="transaction-id" readonly>
                </div>
                <div class="form-group">
                    <label for="mess-card-no">Mess Card No.:</label>
                    <input type="text" id="mess-card-no" name="mess-card-no" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="text" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="bill-month">Bill Month:</label>
                    <input type="text" id="bill-month" name="bill-month" required>
                </div>
                <div class="form-group">
                    <label for="payment-date">Payment Date:</label>
                    <input type="date" id="payment-date" name="payment-date" required>
                </div>
                <div class="form-group">
                    <label for="leave-days">Leave Days:</label>
                    <input type="text" id="leave-days" name="leave-days" required>
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
                filename:     'transaction_history.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(options).save();
        }
    </script>
</body>
</html>
