<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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



// Fetch attendance records for admin approval
$fetchQuery = "SELECT * FROM attendance";
$result = $conn->query($fetchQuery);

if ($result === false) {
  die("Error executing fetchQuery: " . $conn->error);
}




// Calculate counts for each category
$cameOnTime = 0;
$cameBeforeTime = 0;
$cameLate = 0;
$daysOnLeave = 0;
// Fetch leave records for the employee
$employee_id = 1; // Example employee ID, replace with the actual employee ID
$leaveQuery = "SELECT * FROM leaverequest WHERE employee_id = $employee_id";
$leaveResult = $conn->query($leaveQuery);

if ($leaveResult === false) {
  die("Error executing leaveQuery: " . $conn->error);
}

// Calculate number of days on leave
$daysOnLeave = $leaveResult->num_rows;

?>
<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="css/styleguide.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<style>

</style>

<body>
  <div class="job-desk-attendance">
    <div class="div">
      <?php include('header.php'); ?>
      <?php include('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Job Desk</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">Attendance</div>
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
                <div class="text-wrapper-14">Attendance</div>
              </div>
              <div class="">

                <div class="text-wrapper-8">
                  <input type="date" id="custom-date">
                </div>

              </div>
            </div>
            <div class="graph">
              <div class="">
                <div class="">
                  <div class="shadow"></div>
                  <div class="title-wrapper">
                    <div class="title-2">
                      <div class="text-wrapper-15"><?php echo $cameOnTime; ?> Days</div>
                      <div class="text-wrapper-13">Regular</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="overlap-wrapper">
                <div class="overlap">
                  <div class="shadow-2"></div>
                  <div class="div-wrapper">
                    <div class="title-2">
                      <div class="text-wrapper-15"><?php echo $cameBeforeTime; ?> Days</div>
                      <div class="text-wrapper-13">Early</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="overlap-group-wrapper">
                <div class="overlap-2">
                  <div class="shadow-3"></div>
                  <div class="container-5">
                    <div class="title-2">
                      <div class="text-wrapper-15"><?php echo $cameLate; ?> Days</div>
                      <div class="text-wrapper-13">Late</div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="chart-2">
                <div class="overlap-3">
                  <div class="shadow-4"></div>
                  <div class="container-6">
                    <div class="title-3">
                      <div class="text-wrapper-15"><?php echo $daysOnLeave; ?> Days</div>
                      <div class="text-wrapper-13">Leave</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php
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

            // Assuming $employee_id is the employee ID for whom you want to calculate the hours
            $employee_id = $_SESSION['employee_id']; // Example employee ID, replace with the actual employee ID

            // Fetch attendance records for the employee
            $attendanceQuery = "SELECT * FROM attendance WHERE employee_id = $employee_id";
            $attendanceResult = $conn->query($attendanceQuery);

            // Calculate total active hours
            $total_active_hours = 0;
            if ($attendanceResult->num_rows > 0) {
              while ($row = $attendanceResult->fetch_assoc()) {
                // Calculate active hours from punch in and punch out time (Assuming time format HH:MM:SS)
                $punch_in = strtotime($row['punch_in']);
                $punch_out = strtotime($row['punch_out']);
                $active_hours = ($punch_out - $punch_in) / 3600; // Convert seconds to hours
                $total_active_hours += $active_hours;
              }
            }

            // Fetch leave records for the employee
            $leaveQuery = "SELECT * FROM leaverequest WHERE employee_id = $employee_id";
            $leaveResult = $conn->query($leaveQuery);

            // Calculate total leave hours
            $total_leave_hours = 0;
            if ($leaveResult->num_rows > 0) {
              while ($row = $leaveResult->fetch_assoc()) {
                // Calculate leave hours from start_date and end_date (Assuming time format YYYY-MM-DD)
                $start_date = strtotime($row['date_approved']);
                $end_date = strtotime($row['date']);
                $leave_days = ceil(($end_date - $start_date) / (3600)); // Convert seconds to days
                $total_leave_hours += $leave_days * 8; // Assuming 8 hours per day
              }
            }

            // Calculate total scheduled hours (Assuming 8 hours per day)
            $total_working_days = 20; // Total working days in a month
            $total_scheduled_hours = $total_working_days * 8;

            // Total work hours available (considering leave hours and scheduled hours)
            $total_work_hours_available = $total_scheduled_hours - $total_leave_hours;

            // Total work availability percentage
            $total_work_availability_percentage = ($total_scheduled_hours / $total_work_hours_available) * 100;

            // Balance hours (difference between total active hours and total work hours available)
            $balance_hours = $total_active_hours - $total_work_hours_available;

            // Determine average behavior based on total work availability percentage
            if ($total_work_availability_percentage < 50) {
              $average_behavior = "Poor";
            } elseif ($total_work_availability_percentage < 70) {
              $average_behavior = "Average";
            } else {
              $average_behavior = "Early";
            }

            // Display the calculated values
            echo '<div class="hour-info">';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-9">' . $total_scheduled_hours . '</div>';
            echo '<div class="text-wrapper-7">Total schedule hour</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-9">' . $total_leave_hours . '</div>';
            echo '<div class="text-wrapper-7">Leave hour</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-16">' . number_format($total_work_availability_percentage, 2) . '%</div>';
            echo '<div class="text-wrapper-7">Total work availability</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-10">' . $total_active_hours . ' hour</div>';
            echo '<div class="text-wrapper-7">Total active hour</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-17">' . $balance_hours . ' hour</div>';
            echo '<div class="text-wrapper-7">Balance</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-7">';
            echo '<div class="text-wrapper-9">' . $average_behavior . '</div>';
            echo '<div class="text-wrapper-7">Average Behaviour</div>';
            echo '</div>';
            echo '</div>';


            ?>

            <div class="table-pagination">
              <div class="table-sample">
                <div class="table-cell">
                  <div class="label">
                    <div class="label-wrapper">
                      <div class="label-2">Date</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-3">
                      <div class="label-2">Punched In</div>
                    </div>
                  </div>

                  <div class="component">
                    <div class="label-wrapper">
                      <div class="label-2">Punched Out</div>
                    </div>
                  </div>


                  <div class="component">
                    <div class="label-wrapper">
                      <div class="label-2">Status</div>
                    </div>
                  </div>
                </div>

                <?php
                while ($row = $result->fetch_assoc()) {
                  echo ' <div class="table-cell-2">';
                  echo ' <div class="label-wrapper-2">';
                  echo '<div class="label-wrapper">';
                  echo '      <div class="text-wrapper-5">' . $row['date'] . '</div>';
                  echo '  </div>';
                  echo ' </div>';
                  echo ' <div class="label-wrapper-2">';
                  echo ' <div class="label-wrapper">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['punch_in']) ? $row['punch_in'] : '') . '</div></div>';
                  echo '</div>';
                  echo ' </div>';
                  echo ' <div class="label-wrapper-2">';
                  echo '<div class="label-wrapper">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['punch_out']) ? $row['punch_out'] : '') . '</div></div>';
                  echo '</div>';
                  echo '</div>';
                  echo ' <div class="label-wrapper-2">';
                  echo '<div class="label-wrapper">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['approval_status']) ? $row['approval_status'] : '') . '</div></div>';
                  echo '   </div>';
                  echo '</div>';
                  echo '</div>';
                }
                ?>

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