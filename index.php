<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://use.fontawesome.com/0c7a3095b5.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>User Dashboard</title>
</head>
<body>
<div class="header">
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
    <div class="bannerWrapper">
        <div class="banner">
            <div class="bannerOverlay"></div>
            <div class="homepageContainer">
                <div class="bannerHeader">
                    <h1>Hostel Mess</h1>
                    <h3>VJTI Hostel Mess</h3>
                </div>
                <p class="bannerTagline">
                    Welcome to our hostel mess management system. 
                    Manage your meals easily with us!
                </p>
            </div>
        </div>
    </div>
    
    <div class="dashboard">
        <button class="dashboardBtn"><a href="dashboard.php">Go to dashboard </a></button>
        <button class="dashboardBtn"><a href="payBills.php">Pay Monthly bill </a></button>
    </div>
    <div class="bannerIcons">
        <div class="icon">
            <a href="student_db.php"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
            <p>Student Registration</p>
        </div>
        <div class="icon">
            <a href="staff_db.php"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
            <p>Mess Staff Registration</p>
        </div>
        <div class="icon">
            <a href="bill_db.php"><i class="fa fa-inr" aria-hidden="true"></i></a>
            <p>Student's Bills</p>
        </div>
        <div class="icon">
            <a href="trans_history_db.php"><i class="fa fa-history" aria-hidden="true"></i></a>
            <p>Transaction History</p>
        </div>
        <div class="icon">
            <a href="inventory_db.php"><i class="fa fa-clipboard" aria-hidden="true"></i></a>
            <p>Inventory</p>
        </div>
        <div class="icon">
            <a href="meal_pricing_db.php"><i class="fa fa-cutlery" aria-hidden="true"></i></a>
            <p>Meal Pricing</p>
        </div>
        <script>
            // Add event listener to the dashboard button
            document.getElementById('dashboardBtn').addEventListener('click', function() {
                // Navigate to the dashboard page
                window.location.href = 'dashboard.php';
            });
        </script>
    <!-- <div>
    <a href="logout.php" class="btn btn-warning">Logout</a>
    </div> -->
</body>
</html>


