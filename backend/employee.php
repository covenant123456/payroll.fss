<?php
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


// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $searchTerm = $_POST['search'];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT * FROM employee WHERE name LIKE ?");
  $searchTerm = "%" . $searchTerm . "%";
  $stmt->bind_param("s", $searchTerm);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
} else {
  // Select all employees if there's no search
  $sql = "SELECT * FROM employee";
  $result = $conn->query($sql);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_employee'])) {
        $employee_id = $_POST['employee_id'];

        // Prepare and execute the delete query
        $delete_stmt = $conn->prepare("DELETE FROM employee WHERE employee_id = ?");
        $delete_stmt->bind_param("i", $employee_id);

        if ($delete_stmt->execute()) {
            // Employee deleted successfully
            echo "<script>alert('Employee deleted successfully');</script>";
            // Refresh the page or redirect to update the displayed data
             header("Location: employee.php"); // Uncomment this line to redirect to a specific page after deletion
        } else {
            // Error occurred while deleting employee
            echo "<script>alert('Error deleting employee');</script>";
        }

        $delete_stmt->close();
    }
}

// Your existing code for displaying employees goes here

// Handle edit employee request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_employee'])) {
  $employeeIdToEdit = $_POST['employee_id'];
  // Redirect to the edit employee page with the employee ID
  header("Location: addemployee.php?id=$employeeIdToEdit");
}
// Close connection
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
  <div class="job-desk-employee">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Employee</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">All Employee</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-5">All Employee</div>
          </div>
          <div class="div-3">
            <a class="button" href="addemployee.php">
              <i class="img fas fa-plus"></i> <a class="button-4">Add Employee</a>
            </a>

          </div>

        </div>
      </header>
      <div class="announcements">
        <div class="container">
          <div class="frame">
            <form class="input" method="post">
              <div class="text">
                <i class="img fas fa-search"></i>
                <input class="placeholder" type="text" name="search" placeholder="Enter Employee Name">
                <input type="submit" value="Search">
              </div>
            </form>
          </div>
          <div class="text-wrapper-4">Announcements</div>
          <div class="div-4">
            <div class="div-4">
              <div class="table-cell">
                <div class="label">
                  <div class="div-wrapper">
                    <div class="label-2">Profile</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">ID</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Status</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Department</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Shift</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Joining date</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Role</div>
                  </div>
                </div>
                <div class="component">
                  <div class="div-wrapper">
                    <div class="label-2">Action</div>
                  </div>
                </div>
              </div>
              <?php

              if (isset($result) && $result->num_rows > 0) {
                // Display searched employee (if found)
                while ($row = $result->fetch_assoc()) {

                  echo ' <div class="table-cell-2">';
                  echo ' <div class="div-wrapper-2">';
                  echo '  <div class="profile-2">';

                  echo '<div class="text-wrapper-4">' . $row["name"] . '</div>';
                  echo ' </div>';
                  echo ' </div>';
                  echo ' <div class="div-wrapper-2">';
                  echo ' <div class="div-wrapper">';
                  echo ' <div class="text-wrapper-5">' . $row["employee_id"] . '</div>';
                  echo ' </div>';
                  echo '</div>';
                  echo ' <div class="div-wrapper-2">';
                  echo '<div class="tag">';
                  echo ' <div class="tag-name-wrapper">';
                  echo '<div class="tag-name">' . $row["employeestatus"] . '</div>';
                  echo '  </div>';
                  echo ' </div>';
                  echo '  </div>';
                  echo ' <div class="div-wrapper-2">';
                  echo ' <div class="div-wrapper">';
                  echo ' <div class="text-wrapper-5">' . $row["department"] . '</div>';
                  echo '</div>';
                  echo ' </div>';
                  echo ' <div class="div-wrapper-2">';
                  echo ' <div class="div-wrapper">';
                  echo '<div class="text-wrapper-5">' . $row["shift"] . '</div>';
                  echo '</div>';
                  echo ' </div>';
                  echo '<div class="div-wrapper-2">';
                  echo '<div class="div-wrapper">';
                  echo ' <div class="text-wrapper-5">' . $row["created_id"] . '</div>';
                  echo '</div>';
                  echo '</div>';
                  echo '<div class="div-wrapper-2">';
                  echo '<div class="div-wrapper">';
                  echo '<div class="text-wrapper-5">' . $row["role"] . '</div>';
                  echo '</div>';
                  echo '</div>';
                   // Add buttons for editing and deleting employees
                   echo '<div class="div-wrapper-2">';
                   echo '<form method="post">';
                   echo '<input type="hidden" name="employee_id" value="' . $row["employee_id"] . '">'; // Hidden field to store employee ID
                   echo '<button type="submit" name="edit_employee">Edit</button>';
                   echo '<button type="submit" name="delete_employee">Delete</button>';
                   echo '</form>';
                   echo '</div>';
                  echo ' </div>';
                }
              }
              ?>


              
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="fontawesome/js/all.js"></script>
    <script src="js/script.js"></script>
</body>

</html>