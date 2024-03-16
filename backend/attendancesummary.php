<?php
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

// Initialize variables
$searchResults = array();
$totalWorkHours = 0;
$totalLeaveHours = 0;
$totalWorkDays = 0;
$totalActiveDays = 0;

// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $searchTerm = $_POST['search'];

  // Use prepared statements to prevent SQL injection
  $searchStmt = $conn->prepare("SELECT a.*, e.name FROM attendance a INNER JOIN employee e ON a.employee_id = e.employee_id WHERE e.name LIKE ? OR e.employee_id = ?");
  $searchTerm = "%" . $searchTerm . "%";
  $searchStmt->bind_param("ss", $searchTerm, $searchTerm);
  $searchStmt->execute();
  $searchResults = $searchStmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $searchStmt->close();
}

// Fetch all attendance records
$fetchQuery = "SELECT * FROM attendance";
$fetchStmt = $conn->prepare($fetchQuery);
$fetchStmt->execute();
$result = $fetchStmt->get_result();
$fetchStmt->close();

if ($result === false) {
  die("Error executing fetchQuery: " . $conn->error);
}

// Calculate total work hours, total leave hours, total work days, and total active days
while ($row = $result->fetch_assoc()) {
  $resumptionTimestamp = strtotime($row['date']);
  $createdTimestamp = strtotime($row['created_id']);

  if ($resumptionTimestamp !== false && $createdTimestamp !== false && $resumptionTimestamp < $createdTimestamp) {
    // Calculate total work hours
    $totalWorkHours += ($createdTimestamp - $resumptionTimestamp) / 3600; // Convert seconds to hours

    // Calculate total work days
    $totalWorkDays++;
  }

  // Fetch leave request data and calculate total leave hours
  $leaveQuery = "SELECT * FROM leaverequest WHERE employee_id = ?";
  $leaveStmt = $conn->prepare($leaveQuery);
  $leaveStmt->bind_param("i", $row['employee_id']);
  $leaveStmt->execute();
  $leaveResult = $leaveStmt->get_result();

  if ($leaveResult) {
    while ($leaveRow = $leaveResult->fetch_assoc()) {
      $leaveStartDate = strtotime($leaveRow['created_id']);
      $leaveEndDate = strtotime($leaveRow['date']);

      if ($leaveStartDate !== false && $leaveEndDate !== false && $leaveStartDate < $leaveEndDate) {
        // Calculate total leave hours (if applicable)
        $totalLeaveHours += ($leaveEndDate - $leaveStartDate) / 3600; // Convert seconds to hours

        // Calculate total active days (if applicable)
        $totalActiveDays++;
      }
    }
  }

  $leaveStmt->close();
}
// Fetch attendance records for admin approval
$fetchQuery = "SELECT * FROM attendance";
$result = $conn->query($fetchQuery);

if ($result === false) {
  die("Error executing fetchQuery: " . $conn->error);
}

// Handle individual record approval or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_approval'])) {
  // Check if approval_status is an array, if not convert it to an array
  $approvalStatuses = is_array($_POST['approval_status']) ? $_POST['approval_status'] : array($_POST['approval_status']);

  foreach ($approvalStatuses as $attendanceId => $status) {
    $updateQuery = "UPDATE attendance SET approval_status = '$status' WHERE attendance_id = $attendanceId";
    $updateResult = $conn->query($updateQuery);

    if ($updateResult === false) {
      die("Error executing updateQuery: " . $conn->error);
    }
  }

  echo "Approval status updated successfully.";
}

// Handle bulk approval or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['approve_all']) || isset($_POST['reject_all']))) {
  $action = isset($_POST['approve_all']) ? 'approve' : 'reject';

  $updateQuery = "UPDATE attendance SET approval_status = '$action'";
  $updateResult = $conn->query($updateQuery);

  if ($updateResult === false) {
    die("Error executing updateQuery: " . $conn->error);
  }

  echo "All records have been $action ed.";
}


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
  <div class="attendance-summary">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="name">Attendance</div>
          <i class="img fas fa-chevron-right"></i>
          <div class="name-2">Summary</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-3">Summary</div>
          </div>
          <div class="frame">
            <div class="div-3">
              <a class="button" href="addattendancesummary.html">
                <i class="img fas fa-plus"></i> <a class="button-2" href="addattendancesummary.html">Req Attendance</a>
              </a>
            </div>
            <a class="button-3">
              <i class="img fas fa-upload"></i><a class="button-4">Export</a>
            </a>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="attendance-info">
            <div class="title">
              <div class="pills">
                <div class="pill">
                  <div class="pill-frame">
                    <div class="pill-2">Apply between</div>
                  </div>
                </div>
                <div class="pill-frame-wrapper">
                  <div class="pill-frame">
                    <div class="pill-3">Department</div>
                  </div>
                </div>
                <div class="div-wrapper">
                  <div class="pill-frame">
                    <div class="pill-3">Work shift</div>
                  </div>
                </div>
                <div class="pill-frame-wrapper">
                  <div class="pill-frame">
                    <div class="pill-3">Rejected</div>
                  </div>
                </div>
                <div class="pill-4">
                  <div class="pill-frame">
                    <div class="pill-3">Duration</div>
                  </div>
                </div>
              </div>
              <div class="input-wrapper">
                <div class="input">
                  <div class="text">
                    <form method="post" action="">
                      <i class="img fas fa-search"></i>
                      <input class="placeholder" placeholder="Search" type="text" name="search">
                      <button type="submit">Search</button>
                    </form>
                  </div>
                </div>
              </div>

            </div>
            <div class="frame-2">
              <div class="doughnut-chart">
                <?php
                if (isset($_POST['search'])) {
                  $search = $_POST['search'];
                  echo '<img class="doughnut-chart" src="img/pie-chart-14.png">';

                  // Assuming you have a database connection established

                  // Check if the search query parameter is set


                  // Query to retrieve attendance data based on employee name or ID
                  // Join the attendance table with the employees table on employee_id
                  // Modify this query according to your database schema
                  $query = "SELECT a.*, e.name FROM attendance a 
              INNER JOIN employee e ON a.employee_id = e.employee_id
              WHERE e.name LIKE '%$search%' OR a.employee_id = '$search'";
                  $result = mysqli_query($conn, $query);

                  // Check if query was successful
                  if ($result) {
                    // Start building HTML for the attendance summary
                    echo '<div class="frame-2">';
                    echo '<div class="doughnut-chart">';
                    echo '<div class="frame-3">';

                    // Initialize variables to store attendance counts
                    $normalDays = 0;
                    $earlyDays = 0;
                    $lateDays = 0;

                    // Iterate over each row in the result set
                    while ($row = mysqli_fetch_assoc($result)) {
                      // Calculate the punch out time
                      $punchOutTime = strtotime($row['punch_out']);

                      // Calculate the closing time (5:00 PM)
                      $closingTime = strtotime('5:00 PM');

                      // Compare punch out time with closing time
                      if ($punchOutTime >= $closingTime) {
                        $normalDays++;
                      } elseif ($punchOutTime > strtotime('5:00 PM')) {
                        $lateDays++;
                      } else {
                        $earlyDays++;
                      }
                    }

                    // Output the attendance counts
                    echo '<div class="div-4">';
                    echo '<div class="color-indicator"></div>';
                    echo '<div class="description">';
                    echo '<div class="text-wrapper-4">' . $normalDays . '</div>';
                    echo '<div class="text-wrapper-5">Regular Days</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="div-4">';
                    echo '<div class="color-indicator-2"></div>';
                    echo '<div class="description">';
                    echo '<div class="text-wrapper-6">' . $earlyDays . '</div>';
                    echo '<div class="text-wrapper-5">Early Days</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '<div class="div-4">';
                    echo '<div class="color-indicator-3"></div>';
                    echo '<div class="description">';
                    echo '<div class="text-wrapper-7">' . $lateDays . '</div>';
                    echo '<div class="text-wrapper-5">Late Days</div>';
                    echo '</div>';
                    echo '</div>';

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                  } else {
                    // Handle database query error
                    echo "Error: " . mysqli_error($conn);
                  }
                }

                // Close database connection
                mysqli_close($conn);
                ?>

              </div>
              <div class="frame-4">
                <div class="hour-info">
                  <div class="div-5">
                    <div class="text-wrapper-8"><?php echo $totalWorkHours; ?> hrs</div>
                    <div class="text-wrapper-9">Total schedule hour</div>
                  </div>
                  <div class="divider"></div>
                  <div class="div-5">
                    <div class="text-wrapper-8"><?php echo $totalLeaveHours; ?> hr</div>
                    <div class="text-wrapper-9">Leave hour</div>
                  </div>
                  <div class="divider-2"></div>
                  <div class="divider-3"></div>
                </div>
                <div class="hour-info">
                  <div class="div-5">
                    <div class="text-wrapper-8"><?php echo $totalWorkDays; ?> days</div>
                    <div class="text-wrapper-9">Total work</div>
                  </div>
                  <div class="divider"></div>
                  <div class="div-5">
                    <div class="text-wrapper-8"><?php echo $totalActiveDays; ?> days</div>
                    <div class="text-wrapper-9">Total active</div>
                  </div>
                  <div class="divider-2"></div>
                  <div class="divider-3"></div>
                </div>
              </div>
            </div>
            <div class="table-pagination">
              <div class="table-sample">
                <div class="table-cell">
                  <div class="label">
                    <div class="label-2">
                      <div class="label-3">Profile</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Punch In</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Punched Out</div>
                    </div>
                  </div>
                  
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Total hours</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Status</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Action</div>
                    </div>
                  </div>
                </div>
                <?php
                   while ($row = $result->fetch_assoc())  {
                  echo '<div class="table-cell-2">';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="profile-2">';
                  echo '      <div class="text-wrapper-5">' . $row['employee_id'] . '</div>';
                  echo '    </div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['punch_in']) ? $row['punch_in'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['punch_out']) ? $row['punch_out'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['attendance_type']) ? $row['attendance_type'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['total_hours']) ? $row['total_hours'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['approval_status']) ? $row['approval_status'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="more-vertical-wrapper">';
                  echo '      <form method="post" action="">';
                  echo '        <input type="hidden" name="attendance_id" value="' . $row['attendance_id'] . '">';
                  echo '        <input type="hidden" name="approval_status" value="approve">';
                  echo '        <button type="submit" name="submit_approval" onclick="return confirm(\'Are you sure you want to approve?\')">Approve</button>';
                  echo '      </form>';
                  echo '      <form method="post" action="">';
                  echo '        <input type="hidden" name="attendance_id" value="' . $row['attendance_id'] . '">';
                  echo '        <input type="hidden" name="approval_status" value="reject">';
                  echo '        <button type="submit" name="submit_approval" onclick="return confirm(\'Are you sure you want to reject?\')">Reject</button>';
                  echo '      </form>';
                  echo '    </div>';
                  echo '  </div>';
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
  <script src="js/script.js"></script>
</body>

</html>