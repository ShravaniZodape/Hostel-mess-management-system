<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="css/registration.css"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js"></script>
</head>
<body>
    <div class="registration-container">
        <h2>Inventory Form</h2>

        <?php
        // Include the database connection file
        include_once "database.php";

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $item_id = $_POST['item-id'];
            $item_name = $_POST['item-name'];
            $quantity_in_hand = $_POST['quantity-in-hand'];
            $last_restocked_date = $_POST['last-restocked-date'];

            // Prepare and execute SQL query to insert data into the inventory table
            $sql = "INSERT INTO inventory (item_id, item_name, quantity_in_hand, last_restocked_date) 
                    VALUES ('$item_id', '$item_name', '$quantity_in_hand', '$last_restocked_date')";

            if (mysqli_query($conn, $sql)) {
                // If insertion is successful, display success message
                echo "<div class='alert alert-success'>Inventory data submitted successfully.</div>";
                
                // Display the submitted data for PDF generation
                echo "<div id='pdf-content'>";
                echo "<h3>Inventory Details:</h3>";
                echo "<p><strong>Item ID:</strong> $item_id</p>";
                echo "<p><strong>Item Name:</strong> $item_name</p>";
                echo "<p><strong>Quantity in Hand:</strong> $quantity_in_hand</p>";
                echo "<p><strong>Last Restocked Date:</strong> $last_restocked_date</p>";
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
                    <label for="item-id">Item ID:</label>
                    <input type="text" id="item-id" name="item-id" required>
                </div>
                <div class="form-group">
                    <label for="item-name">Item Name:</label>
                    <input type="text" id="item-name" name="item-name" required>
                </div>
                <div class="form-group">
                    <label for="quantity-in-hand">Quantity in Hand:</label>
                    <input type="text" id="quantity-in-hand" name="quantity-in-hand" required>
                </div>
                <div class="form-group">
                    <label for="last-restocked-date">Last Restocked Date:</label>
                    <input type="date" id="last-restocked-date" name="last-restocked-date" required>
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
                filename:     'inventory_details.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(element).set(options).save();
        }
    </script>
</body>
</html>
