<?php

// Include the allowance and deduction calculator file
require_once('calculation.php');

// Check if the employee ID is stored in the session
if (!isset($_SESSION['employee_id'])) {
    // Redirect to login page if the employee is not logged in
    header("Location: login.php");
    exit();
}

// Retrieve the employee ID from the session
$employee_id = $_SESSION['employee_id'];

// Initialize variables for allowance name and amount
$name = "";
$amount = "";

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee salary from the employee table
$sql_salary = "SELECT salary FROM employee WHERE employee_id = $employee_id";
$result_salary = $conn->query($sql_salary);
if ($result_salary->num_rows > 0) {
    $row_salary = $result_salary->fetch_assoc();
    $salary = $row_salary["salary"];
} else {
    echo "No salary found for the employee.";
}

// Fetch all allowance percentages from the payable table
$sql_deduction = "SELECT type, amount FROM deductible";
$result_deduction = $conn->query($sql_deduction);

// Check if there are deductions to calculate
if ($result_deduction->num_rows > 0) {
    // Loop through each deduction
    while ($row = $result_deduction->fetch_assoc()) {
        // Retrieve the deduction type and percentage
        $deduction_type = $row['type'];
        $deduction_percentage = $row['amount'];

        // Check if the deduction already exists for the employee
        $sql_check = "SELECT * FROM deduction WHERE employee_id = $employee_id AND type = '$deduction_type'";
        $result_check = $conn->query($sql_check);

        // If deduction doesn't exist, calculate and insert it
        if ($result_check->num_rows == 0) {
            // Calculate the amount for the current deduction based on the percentage and employee salary
            $calculated_amount = $salary * ($deduction_percentage / 100);

            // Insert the calculated deduction into the deductions table
            $sql_insert_deduction = "INSERT INTO deduction (employee_id, type, amount) VALUES ($employee_id, '$deduction_type', $calculated_amount)";
            if ($conn->query($sql_insert_deduction) === TRUE) {
                echo "Deduction inserted successfully for type: $deduction_type<br>";
            } else {
                echo "Error inserting deduction: " . $conn->error . "<br>";
            }
        }
    }

    // Reset the internal pointer of the result set to the beginning
    $result_deduction->data_seek(0);
} else {
    echo "No deductions found.";
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="globals.css">
    <link rel="stylesheet" href="css/styleguide.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<body>
    <div class="job-desk-allowance">
        <div class="div">
            <?php include('header.php'); ?>
            <?php include('leftmenu.php'); ?>
            <header class="header">
                <div class="div-2">
                    <div class="text-wrapper-3">Job Desk</div>
                    <i class="fas fa-chevron-right"></i>
                    <div class="text-wrapper-4">Allowance</div>
                </div>
                <div class="title">
                    <div class="div-2">
                        <div class="text-wrapper-5">Job Desk</div>
                    </div>
                </div>
            </header>
            <?php include('details.php'); ?>
            <div class="content">
                <div class="container-3">
                    <?php include('tabline.php'); ?>
                    <div class="paid-info">
                        <div class="container-5">
                            <?php
                            if ($result_deduction->num_rows > 0) {
                                // Loop through each deduction
                                while ($row_deduction = $result_deduction->fetch_assoc()) {
                                    // Retrieve the deduction details
                                    $deduction_name = $row_deduction["type"];
                                    $deduction_percentage = $row_deduction["amount"];
                                    $amount = ($salary * $deduction_percentage) / 100;
                                    // Display the details of each deduction
                                    echo '<div class="div-7">';
                                    echo '<div class="text-wrapper-14">' . $deduction_name . '</div>';
                                    echo '<div class="information">';
                                    echo '<div class="text-wrapper-15"></div>';
                                    echo '<div class="text-wrapper-7"></div>';
                                    echo '</div>';
                                    echo '<div class="information">';
                                    echo '<div class="text-wrapper-16">' . $deduction_percentage . '%</div>';
                                    echo '<div class="text-wrapper-7">Allowance</div>';
                                    echo '</div>';
                                    echo '<div class="information">';
                                    echo '<div class="text-wrapper-16">#' . number_format($amount, 2) . '</div>';
                                    echo '<div class="text-wrapper-7">Earned</div>';
                                    echo '</div>';
                                    echo '<div class="information">';
                                    echo '<div class="text-wrapper-16"></div>'; // Assuming no amount taken initially
                                    echo '<div class="text-wrapper-7"></div>';
                                    echo '</div>';
                                    echo '<div class="information">';
                                    echo '<div class="text-wrapper-16"></div>'; // Assuming no availability initially
                                    echo '<div class="text-wrapper-7"></div>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo "No allowances found.";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="fontawesome/js/all.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
