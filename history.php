<?php
session_start();
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
  <div class="job-desk-history">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Job Desk</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">History</div>
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

          <div class="attendance-info">
            <div class="heading-wrapper">
              <div class="div-2">
                <div class="text-wrapper-14">History</div>
              </div>
            </div>
            <?php
        

            // Assuming you've established a database connection elsewhere
            // Replace "your_host", "your_username", "your_password", and "your_database" with your actual database credentials
            $mysqli = new mysqli("localhost", "root", "", "payroll");

            // Check connection
            if ($mysqli->connect_error) {
              die("Connection failed: " . $mysqli->connect_error);
            }

            // Retrieve employee ID from session
            if (isset($_SESSION['employee_id'])) {
              $employee_id = $_SESSION['employee_id'];

              // Prepare SQL statement
              $sql = "SELECT position, employeestatus, created_id FROM employee WHERE employee_id = ?";

              // Prepare statement
              if ($stmt = $mysqli->prepare($sql)) {

                // Bind parameters
                $stmt->bind_param("i", $employee_id);

                // Execute statement
                $stmt->execute();

                // Bind result variables
                $stmt->bind_result($position, $employeeStatus, $year);

                // Fetch values
                if ($stmt->fetch()) {
                  // Create a unique ID for the div
                  $id = "job_" . str_replace(' ', '_', strtolower($position));

                  // Output HTML with PHP variables embedded
                  echo '<div id="' . $id . '" class="job">';
                  echo '<div class="text-wrapper-15">' . $position . '</div>';
                  echo '<div class="container-5">';
                  echo '<div class="text-wrapper-16">' . $employeeStatus . '</div>';
                  echo '<div class="divider"></div>';
                  echo '<div class="text-wrapper-16">' . $year . '</div>';
                  echo '</div>';
                  echo '</div>';
                } else {
                  echo "No employee found with ID: " . $employee_id;
                }

                // Close statement
                $stmt->close();
              } else {
                echo "Error in SQL statement preparation: " . $mysqli->error;
              }
            } else {
              echo "Employee ID not set in session.";
            }

            // Close connection
            $mysqli->close();
            ?>



          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="fontawesome/js/all.js"></script>
</body>

</html>