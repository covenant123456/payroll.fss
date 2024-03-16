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
  foreach ($_POST['approval_status'] as $attendanceId => $status) {
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
// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $searchTerm = $_POST['search'];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT l.*, e.department FROM attendance l
  INNER JOIN employee e ON l.employee_id = e.employee_id
  WHERE e.employee_id LIKE ?");
  $searchTerm = "%" . $searchTerm . "%";
  $stmt->bind_param("s", $searchTerm);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
} else {
  // Select all employees if there's no search
  $sql = "SELECT l.*, e.department FROM attendance l
            INNER JOIN employee e ON l.employee_id = e.employee_id";
  $result = $conn->query($sql);
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
  <div class="attendance-daily-log">
    <div class="div">

      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="name">Attendance</div>
          <i class="img fas fa-chevron-right"></i>
          <div class="name-2">Daily Log</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-3">Daily Log</div>
          </div>
          <div class="frame">
            <div class="div-3">
              <a class="" href="detailattendance.html">
                <i class="img fas fa-sign-out"></i> <a class="button-2" href="attendance.php">Add Attendance</a>
              </a>
            </div>
            <a class="" href="">
              <i class="img fas fa-image"></i> <a class="button-3" href="">Import</a>
            </a>
            <a class="" href="">
              <i class="img fas fa-upload"></i> <a class="button-3" href="">Export</a>
            </a>
            <a class="" href="settings.html">
              <i class="img fas fa-cogs"></i> <a class="button-5" href="">Setting</a>
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
              <div class="frame">
                <form class="input" method="post">
                  <div class="text">
                    <i class="img fas fa-search"></i>
                    <input class="placeholder" type="text" name="search" placeholder="Enter Employee Name">
                    <input type="submit" value="Search">
                  </div>
                </form>
              </div>
              </div>
            </div>
            <div class="div-4">
              <div class="div-4">
                <div class="table-cell">
                  <div class="label">
                    <div class="label-2">
                      <div class="label-3">Employee ID</div>
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
                      <div class="label-3">Behavior</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Total hours</div>
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
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['total_hours']) ? $row['total_hours'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="label-2"><div class="text-wrapper-6">' . (isset($row['approval_status']) ? $row['approval_status'] : '') . '</div></div>';
                  echo '  </div>';
                  echo '  <div class="div-wrapper-2">';
                  echo '    <div class="more-vertical-wrapper">';
                  echo '      <form method="post" action="">';
                  echo '        <input type="hidden" name="attendance_id" value="' . $row['attendance_id'] . '">';
                  echo '        <button type="submit" name="approve" onclick="return confirm(\'Are you sure you want to approve?\')">Approve</button>';
                  echo '        <button type="submit" name="reject" onclick="return confirm(\'Are you sure you want to reject?\')">Reject</button>';
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
  <script src="fontawesome/js/all.js"></script>
  <script src="js/script.js"></script>
</body>

</html>