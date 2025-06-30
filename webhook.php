<?php
// Include the database connection file
include_once "database.php";

// Include Razorpay's PHP SDK (you need to install it using Composer or download it from Razorpay's GitHub repo)
require('razorpay-php/Razorpay.php');

// Set up Razorpay API credentials (replace with your actual credentials)
$keyId = 'your_key_id';
$keySecret = 'your_key_secret';

// Initialize Razorpay client
$razorpay = new Razorpay\Api\Api($keyId, $keySecret);

// Read the raw POST data from Razorpay
$input = @file_get_contents("php://input");

// Log incoming webhook request (for debugging purposes)
file_put_contents('razorpay_webhook.log', $input, FILE_APPEND);

// Decode the JSON payload
$data = json_decode($input, true);

// Check if the payment is successful
if ($data['event'] == 'payment.captured') {
    // Extract the payment ID and order ID from the payload
    $paymentId = $data['payload']['payment']['entity']['id'];
    $orderId = $data['payload']['payment']['entity']['order_id'];
    
    // Verify the payment using Razorpay's API
    try {
        $payment = $razorpay->payment->fetch($paymentId);

        if ($payment->status == 'captured') {
            // Payment was successful, update the payment status in the database
            $sql = "UPDATE student_payments SET payment_status = 'paid' WHERE order_id = '$orderId'";

            if (mysqli_query($conn, $sql)) {
                // Payment status updated successfully
                file_put_contents('razorpay_webhook.log', "Payment status updated for order: $orderId\n", FILE_APPEND);
                
                // Redirect user to index.php with a success message
                header("Location: index.php?status=success");
                exit();
            } else {
                // Error in updating payment status
                file_put_contents('razorpay_webhook.log', "Error updating payment status: " . mysqli_error($conn) . "\n", FILE_APPEND);
            }
        }
    } catch (Exception $e) {
        file_put_contents('razorpay_webhook.log', "Error verifying payment: " . $e->getMessage() . "\n", FILE_APPEND);
    }
} else {
    // Handle other events if necessary
    file_put_contents('razorpay_webhook.log', "Received event: " . $data['event'] . "\n", FILE_APPEND);
}

// Close the database connection
mysqli_close($conn);
?>
