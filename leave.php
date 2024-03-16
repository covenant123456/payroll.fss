<?php
// Start session
session_start();

// Check if employee ID is set in the session
if (!isset($_SESSION['employee_id'])) {
  // Redirect or handle the case where employee ID is not set
  // For example:
  header("Location: login.php");
  exit();
}

// Retrieve employee ID from the session
$employee_id = $_SESSION['employee_id'];

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

// SQL query to fetch leave based on employee ID
$sqlLeave = "SELECT * FROM leaverequest WHERE employee_id = $employee_id";
$resultLeave = $conn->query($sqlLeave);

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
  <div class="job-desk-leave">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Job Desk</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">Leave</div>
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
            <div class="title">
              <div class="div-2">
                <div class="text-wrapper-14">Leave</div>
              </div>
              <div class="">

                <div class="text-wrapper-8">
                  <input type="date" id="custom-date">
                </div>
              </div>
            </div>

            <div class="hour-info">
              <?php
              // Initialize counters and variables
              $totalLeaveTaken = 0;
              $upcomingLeaveCount = 0;
              $pendingRequestCount = 0;
              $leaveRecords = []; // Array to store leave records

              // Check if any rows are fetched
              if ($resultLeave->num_rows > 0) {
                // Fetch and calculate leave information for each row
                while ($rowLeave = $resultLeave->fetch_assoc()) {
                  // Increment total leave taken count
                  if ($rowLeave["approval_status"] == 'Accepted') {
                    $totalLeaveTaken += $rowLeave["duration"];
                  } elseif ($rowLeave["approval_status"] == '') {
                    // Increment pending request count
                    $pendingRequestCount++;
                  }
                  // Store leave record in array
                  $leaveRecords[] = $rowLeave;
                }

                // Output total leave taken
                echo '<div class="div-7">';
                echo '<div class="text-wrapper-15">' . $totalLeaveTaken . ' Days</div>';
                echo '<div class="text-wrapper-7">Leave taken</div>';
                echo '</div>';
                echo '<div class="divider"></div>';

                // Output upcoming leave count (assuming there is a process to determine upcoming leave)
                // You may need to modify this part based on your application logic
                echo '<div class="div-7">';
                echo '<div class="text-wrapper-15">' . $upcomingLeaveCount . ' days</div>';
                echo '<div class="text-wrapper-7">Upcoming leave</div>';
                echo '</div>';
                echo '<div class="divider"></div>';

                // Output pending request count
                echo '<div class="div-7">';
                echo '<div class="text-wrapper-15">' . $pendingRequestCount . '</div>';
                echo '<div class="text-wrapper-7">Pending request</div>';
                echo '</div>';
                echo '<div class="divider-2"></div>';

                // Output leave records from array

              ?>
            </div>

            <div class="div-8">
                <div class="div-8">
                  <div class="table-cell">
                    <div class="label">
                      <div class="label-wrapper"><div class="label-2">Date &amp; time</div></div>
                    </div>
                    <div class="component">
                      <div class="label-wrapper"><div class="label-2">Leave duration</div></div>
                    </div>
                    <div class="div-wrapper">
                      <div class="label-wrapper"><div class="label-2">Leave Type</div></div>
                    </div>
                   
                    <div class="component">
                      <div class="label-wrapper"><div class="label-2">Status</div></div>
                    </div>
                  </div>
                  <?php
                        // Output leave records from array
                        foreach ($leaveRecords as $rowLeave) {
                          echo '<div class="table-cell-2">';
                          echo '<div class="label-3">';
                          echo '<div class="label-wrapper"><p class="label-2">' . $rowLeave['date'] . '</p></div>';
                          echo '</div>';
                          echo '<div class="component-3">';
                          echo '<div class="label-wrapper"><div class="label-2">' . $rowLeave['duration'] . '</div></div>';
                          echo '</div>';
                          echo '<div class="component-4">';
                          echo '<div class="label-wrapper"><div class="label-2">' . $rowLeave['reason'] . '</div></div>';
                          echo '</div>';

                          echo '<div class="component-3">';
                          echo '<div class="label-wrapper"><div class="label-2">' . $rowLeave['approval_status'] . '</div></div>';
                          echo '</div>';
                          echo '</div>';
                        }
                      } else {
                        // No leave records found for the employee
                        echo "No leave records found";
                      } ?>
                 
                </div>
               
              </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="fontawesome/js/all.js"></script>
</body>

</html>