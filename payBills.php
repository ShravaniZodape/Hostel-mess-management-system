<?php
// Include the database connection file
include_once "database.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $student_id = $_POST['student_id'];
    $mess_card_no = $_POST['mess_card_no'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email_id'];
    $month = $_POST['month'];
    $pending_bills = $_POST['pending_bills'];
    $total_amount = $_POST['total_amount'];

    // Insert student data into the student_payments table (initial insertion)
    $sql = "INSERT INTO student_payments (student_id, mess_card_no, phone_number, email, month, pending_bills, total_amount, payment_status)
            VALUES ('$student_id', '$mess_card_no', '$phone_number', '$email', '$month', '$pending_bills', '$total_amount', 'pending')";

    if (mysqli_query($conn, $sql)) {
        // Now update payment status to 'done' after successful insertion
        $update_sql = "UPDATE student_payments 
                       SET payment_status = 'done' 
                       WHERE student_id = '$student_id' AND mess_card_no = '$mess_card_no'";

        if (mysqli_query($conn, $update_sql)) {
            // Payment status successfully updated to 'done'
            echo "<p>Payment status updated to 'done'. You are being redirected to the payment page.</p>";
            // Redirect to the payment gateway (Razorpay in this case)
            header("Location: https://rzp.io/rzp/S6p5H4Xv");
            exit(); // Ensure the script stops after the redirection
        } else {
            // If updating the payment status fails
            echo "Error updating payment status: " . mysqli_error($conn);
        }
    } else {
        // If insertion fails
        echo "Error: " . mysqli_error($conn);
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
    <title>Student Payment Form</title>
    <link rel="stylesheet" href="css/registration.css">
</head>
<body>
    <div class="registration-container">
        <h2>Student Payment Form</h2>

        <form id="payment-form" method="POST" action="">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="mess_card_no">Mess Card No.:</label>
                <input type="text" id="mess_card_no" name="mess_card_no" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="email_id">Email: </label>
                <input type="email" id="email_id" name="email_id" required>
            </div>
            <div class="form-group">
                <label for="month">Month:</label>
                <input type="text" id="month" name="month" required>
            </div>
            <div class="form-group">
                <label for="pending_bills">Pending Bills:</label>
                <input type="number" id="pending_bills" name="pending_bills" required oninput="calculateTotal()">
            </div>
            <div class="form-group">
                <label for="total_amount">Total Amount:</label>
                <input type="number" id="total_amount" name="total_amount" value="3038" readonly>
            </div>
            <button type="submit">Proceed to Pay</button>
        </form>
    </div>

    <script>
        // Base amount that’s always included in total
        const baseAmount = 3038;

        function calculateTotal() {
            // Get the pending bills amount entered by the user
            const pendingBills = parseFloat(document.getElementById('pending_bills').value) || 0;

            // Calculate total by adding base amount to pending bills
            const total = baseAmount + pendingBills;

            // Update the total amount field
            document.getElementById('total_amount').value = total;
        }
    </script>
</body>
</html>
