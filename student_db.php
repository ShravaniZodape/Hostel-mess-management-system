<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Table</title>
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

<div class="container">
    <div class="header">
        <h2>Student Table</h2>
        <form action="index.php" method="get">
            <button type="submit">Back to Home</button>
        </form>
    </div>

    <?php
    // Include your database connection file
    require_once "database.php";

    // Function to delete a student record
    function deleteStudent($conn, $student_id) {
        $sql = "DELETE FROM student WHERE student_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $student_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Perform SELECT query
    $sql = "SELECT * FROM student";
    $result = mysqli_query($conn, $sql);

    // Check if there are rows returned
    if (mysqli_num_rows($result) > 0) {
        // Start table markup
        echo "<table>";
        echo "<tr><th>student_id</th><th>student_name</th><th>phone_no</th><th>mess_card_no</th><th>course</th><th>department</th><th>year_of_study</th><th>hostel_room_no</th><th>Action</th></tr>";

        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["student_id"] . "</td><td>" . $row["student_name"] . "</td><td>" . $row["phone_no"] . "</td><td>" . $row["mess_card_no"] . "</td><td>" . $row["course"] . "</td><td>" . $row["department"] . "</td><td>" . $row["year_of_study"] . "</td><td>" . $row["hostel_room_no"] . "</td>";
            
            // Add delete button
            echo "<td><form method='post' action=''>
                  <input type='hidden' name='student_id' value='" . $row["student_id"] . "'>
                  <input type='submit' name='delete' value='Delete'>
                  </form></td>";

            echo "</tr>";
        }

        // End table markup
        echo "</table>";
    } else {
        echo "0 results";
    }

    // Check if delete button is clicked
    if (isset($_POST['delete'])) {
        // Get student ID from form submission
        $student_id = $_POST['student_id'];
        
        // Call delete function
        deleteStudent($conn, $student_id);

        // Refresh the page to reflect changes
        echo "<meta http-equiv='refresh' content='0'>";
    }

    // Close database connection
    mysqli_close($conn);
    ?>

</div>

</body>
</html>
