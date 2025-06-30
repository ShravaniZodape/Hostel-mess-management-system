<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Table</title>
    <style>
        body {
            padding: 50px;
            font-family: Arial, sans-serif;
            background: url('../images/login_bg.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        .container {
            max-width: auto;
            margin: 0 auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background for the content */
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border-radius: 8px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header h2 {
            font-size: 24px;
            color: #333;
        }

        .header button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .header button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        td input[type="submit"]:hover {
            background-color: #c0392b;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3); /* Semi-transparent overlay */
            z-index: -1; /* Ensures the overlay is behind other content */
        }
    </style>
</head>
<body>

<div class="header">
    <h2>Bill Table</h2>
    <!-- Navigation Button to go back to index.php -->
    <form action="index.php" method="get">
        <button type="submit">Back to Home</button>
    </form>
</div>

<?php
// Include your database connection file
require_once "database.php";

// Check if a delete request has been made
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $mess_card_no = $_POST['mess_card_no'];
    $delete_sql = "DELETE FROM bill WHERE mess_card_no = ?";
    if ($stmt = mysqli_prepare($conn, $delete_sql)) {
        mysqli_stmt_bind_param($stmt, "i", $mess_card_no);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Perform SELECT query
$sql = "SELECT * FROM bill";
$result = mysqli_query($conn, $sql);

// Check if there are rows returned
if (mysqli_num_rows($result) > 0) {
    // Start table markup
    echo "<table border='1'>";
    echo "<tr><th>student_id</th><th>mess_card_no</th><th>total_charges</th><th>billing_date</th><th>meal_type</th><th>pending_dues</th><th>Action</th></tr>";

    // Output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . $row["mess_card_no"] . "</td>";
        echo "<td>" . $row["total_charges"] . "</td>";
        echo "<td>" . $row["billing_date"] . "</td>";
        echo "<td>" . $row["meal_type"] . "</td>";
        echo "<td>" . $row["pending_dues"] . "</td>";
        echo "<td>
                <form method='POST' action=''>
                    <input type='hidden' name='mess_card_no' value='" . $row["mess_card_no"] . "'>
                    <input type='submit' name='delete' value='Delete'>
                </form>
              </td>";
        echo "</tr>";
    }

    // End table markup
    echo "</table>";
} else {
    echo "0 results";
}

// Close database connection
mysqli_close($conn);
?>

</body>
</html>
