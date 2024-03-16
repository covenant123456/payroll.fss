<?php
session_start(); // Start or resume the session

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

// Function to retrieve basic salary based on level and step
function getBasicSalary($level, $step, $conn) {
    // Prepare and execute query to fetch basic salary from grade table
    $stmt = $conn->prepare("SELECT salary FROM grade WHERE level = ? AND step = ?");
    $stmt->bind_param("ii", $level, $step);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch basic salary
        $row = $result->fetch_assoc();
        return $row['salary'];
    } else {
        // No matching record found
        return null;
    }
}

// Check if employee ID is set in the session
if (isset($_SESSION['employee_id'])) {
    $employee_id = $_SESSION['employee_id'];

    // Retrieve level and step from employee table
    $stmt_emp = $conn->prepare("SELECT level, step FROM employee WHERE employee_id = ?");
    $stmt_emp->bind_param("i", $employee_id);
    $stmt_emp->execute();
    $result_emp = $stmt_emp->get_result();

    if ($result_emp->num_rows > 0) {
        // Fetch level and step
        $row_emp = $result_emp->fetch_assoc();
        $level = $row_emp['level'];
        $step = $row_emp['step'];

        // Get basic salary from grade table
        $basic_salary = getBasicSalary($level, $step, $conn);

        if ($basic_salary !== null) {
            // Update basic salary in employee table
            $stmt_update = $conn->prepare("UPDATE employee SET salary = ? WHERE employee_id = ?");
            $stmt_update->bind_param("di", $basic_salary, $employee_id);
            $stmt_update->execute();
            $stmt_update->close();

       //     echo "Basic salary updated successfully!";
        } else {
             header("Location: login.php");
            exit();

        }
    } else {
      //  echo "No employee found with the provided ID.";
    }

    $stmt_emp->close();
} else {
    echo "Employee ID not found in session.";
}

// Close database connection
$conn->close();
?>
