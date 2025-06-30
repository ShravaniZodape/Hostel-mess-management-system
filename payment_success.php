<?php
// Include the database connection file
include_once "database.php";

// Check the response from the payment gateway (example for Razorpay)
if (isset($_GET['payment_id']) && isset($_GET['order_id'])) {
    // Get the payment ID and order ID from the query parameters
    $payment_id = $_GET['payment_id'];
    $order_id = $_GET['order_id'];

    // Example: Fetch the payment status from Razorpay API or handle your payment gateway's confirmation here
    $payment_status = "paid"; // This should be confirmed via API request to the payment gateway

    // Update the payment status in the database
    $sql = "UPDATE student_payments SET payment_status = '$payment_status' WHERE order_id = '$order_id'";

    if (mysqli_query($conn, $sql)) {
        // Successful payment update
        echo "<p>Payment successful. You will be redirected to the homepage.</p>";
        header("Refresh: 3; url=index.php"); // Redirect to index.php after 3 seconds
    } else {
        // Error in updating payment status
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
