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
  <div class="attendance-request">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="name">Attendance</div>
          <i class="img fas fa-chevron-right"></i>
          <div class="name-2">Request</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-3">Request</div>
          </div>
          <div class="frame">
            <div class="div-3">
              <a class="button" href="attendance.php">
                <i class="img fas fa-plus"></i> <a class="button-2" href="addattendancerequest.html">Add Attendance</a>
              </a>
            </div>

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
                    <div class="text-wrapper-4">Department</div>
                  </div>
                </div>
                <div class="div-wrapper">
                  <div class="pill-frame">
                    <div class="text-wrapper-4">Work shift</div>
                  </div>
                </div>
                <div class="pill-frame-wrapper">
                  <div class="pill-frame">
                    <div class="text-wrapper-4">Rejected</div>
                  </div>
                </div>
                <div class="pill-3">
                  <div class="pill-frame">
                    <div class="text-wrapper-4">Duration</div>
                  </div>
                </div>
              </div>
              <div class="input-wrapper">
                <form method="post">
                  <input type="submit" name="approve_all" value="Approve All" onclick="return confirm('Are you sure you want to approve all?')">
                  <input type="submit" name="reject_all" value="Reject All" onclick="return confirm('Are you sure you want to reject all?')">
                </form>
              </div>
            </div>
            <div class="div-4">
              <div class="div-4">
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
                while ($row = $result->fetch_assoc()) {
                  echo '<div class="table-cell-2">';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="profile-2">';
                  echo '      <div class="text-wrapper-5">' . $row['attendance_id'] . '</div>';
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
