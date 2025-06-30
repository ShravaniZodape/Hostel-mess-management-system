<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mess Staff Table</title>
    <style>
        /* General Body Styling */
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

<div class="container">
    <div class="header">
        <h2>Mess Staff Table</h2>
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
        $employee_id = $_POST['employee_id'];
        $delete_sql = "DELETE FROM mess_staff WHERE employee_id = ?";
        if ($stmt = mysqli_prepare($conn, $delete_sql)) {
            mysqli_stmt_bind_param($stmt, "i", $employee_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }

    // Perform SELECT query
    $sql = "SELECT * FROM mess_staff";
    $result = mysqli_query($conn, $sql);

    // Check if there are rows returned
    if (mysqli_num_rows($result) > 0) {
        // Start table markup
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr><th>Employee ID</th><th>Employee Name</th><th>Phone No</th><th>Address</th><th>Salary</th><th>Service</th><th>Action</th></tr>";

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["employee_id"] . "</td>";
            echo "<td>" . $row["employee_name"] . "</td>";
            echo "<td>" . $row["phone_no"] . "</td>";
            echo "<td>" . $row["address"] . "</td>";
            echo "<td>" . $row["salary"] . "</td>";
            echo "<td>" . $row["service"] . "</td>";
            echo "<td>
                    <form method='POST' action=''>
                        <input type='hidden' name='employee_id' value='" . $row["employee_id"] . "'>
                        <input type='submit' name='delete' value='Delete'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        // End table markup
        echo "</table>";
        echo "</div>";  // Close table container
    } else {
        echo "<p>No results found.</p>";
    }

    // Close database connection
    mysqli_close($conn);
    ?>

</div>

</body>
</html>
