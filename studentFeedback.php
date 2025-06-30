<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <link rel="stylesheet" href="css/registration.css"> 
</head>
<body>
    <div class="registration-container">
        <h2>Feedback Form</h2>

        <!-- Feedback Form -->
        <?php if (!isset($_POST['submit_feedback'])): ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" required>
                </div>
                <div class="form-group">
                    <label for="student_name">Student Name:</label>
                    <input type="text" id="student_name" name="student_name" required>
                </div>
                <div class="form-group">
                    <label for="feedback_text">Your Feedback:</label>
                    <textarea id="feedback_text" name="feedback_text" rows="4" cols="50" required></textarea>
                </div>

                <!-- New Feedback Options -->
                <div class="form-group">
                    <label for="food_quality">Food Quality:</label>
                    <select id="food_quality" name="food_quality" required>
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="poor">Poor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="hygiene">Hygiene:</label>
                    <select id="hygiene" name="hygiene" required>
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="poor">Poor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="staff_behavior">Staff Behavior:</label>
                    <select id="staff_behavior" name="staff_behavior" required>
                        <option value="excellent">Excellent</option>
                        <option value="good">Good</option>
                        <option value="average">Average</option>
                        <option value="poor">Poor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="improvements">Suggestions for Improvement:</label>
                    <textarea id="improvements" name="improvements" rows="4" cols="50"></textarea>
                </div>

                <button type="submit" name="submit_feedback">Submit Feedback</button>
            </form>
        <?php else: ?>
            <div class="alert alert-success">Feedback submitted successfully.</div>
        <?php endif; ?>
        
        <!-- Show Feedback Button -->
        <div class="buttons">
            <button onclick="showFeedback()">Show Feedback</button>
        </div>
    </div>

    <?php
    // Include the database connection file
    include_once "database.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_feedback'])) {
        // Retrieve form data
        $student_id = $_POST['student_id'];
        $student_name = $_POST['student_name'];
        $feedback_text = $_POST['feedback_text'];
        $food_quality = $_POST['food_quality'];
        $hygiene = $_POST['hygiene'];
        $staff_behavior = $_POST['staff_behavior'];
        $improvements = $_POST['improvements'];

        // Prepare and bind parameters for the SQL query to insert data into the feedback table
        $stmt = $conn->prepare("INSERT INTO student_feedback (student_id, student_name, feedback_text, food_quality, hygiene, staff_behavior, improvements) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $student_id, $student_name, $feedback_text, $food_quality, $hygiene, $staff_behavior, $improvements);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // If insertion is successful, display success message
            echo "<div class='alert alert-success'>Feedback submitted successfully.</div>";
        } else {
            // If insertion fails, display error message
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }

        // Close the prepared statement
        $stmt->close();
    }

    // Fetch and display feedback from the database
    $result = $conn->query("SELECT student_id, student_name, feedback_text, food_quality, hygiene, staff_behavior, improvements, timestamp 
                            FROM student_feedback ORDER BY timestamp DESC");

    if ($result->num_rows > 0) {
        echo "<div class='feedback-list' id='feedback-list' style='display: none;'>";
        echo "<h2>Feedback from Students:</h2>";
        echo "<table class='feedback-table'>";
        echo "<thead><tr><th>Student ID</th><th>Student Name</th><th>Feedback</th><th>Food Quality</th><th>Hygiene</th><th>Staff Behavior</th><th>Suggestions</th><th>Submitted On</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['feedback_text']) . "</td>";
            echo "<td>" . htmlspecialchars($row['food_quality']) . "</td>";
            echo "<td>" . htmlspecialchars($row['hygiene']) . "</td>";
            echo "<td>" . htmlspecialchars($row['staff_behavior']) . "</td>";
            echo "<td>" . htmlspecialchars($row['improvements']) . "</td>";
            echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='no-feedback'>No feedback available.</div>";
    }

    // Close the database connection
    $conn->close();
    ?>

    <script>
        // Function to show all feedback
        function showFeedback() {
            const feedbackList = document.getElementById('feedback-list');
            feedbackList.style.display = feedbackList.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
