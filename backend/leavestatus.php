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
  $stmt = $conn->prepare("SELECT l.*, e.department FROM leaverequest l
                            INNER JOIN employee e ON l.employee_id = e.employee_id
                            WHERE e.name LIKE ?");
  $searchTerm = "%" . $searchTerm . "%";
  $stmt->bind_param("s", $searchTerm);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
} else {
  // Select all employees if there's no search
  $sql = "SELECT l.*, e.department FROM leaverequest l
            INNER JOIN employee e ON l.employee_id = e.employee_id";
  $result = $conn->query($sql);
}

// Handle accept or reject actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['accept_button']) || isset($_POST['reject_button']))) {
  $leaveRequestId = $_POST['leave_request_id'];
  $status = isset($_POST['accept_button']) ? 'Accepted' : 'Rejected';

  // Use prepared statement to update the database
  $updateStmt = $conn->prepare("UPDATE leaverequest SET approval_status = ? WHERE leave_id = ?");
  $updateStmt->bind_param("si", $status, $leaveRequestId);

  if ($updateStmt->execute()) {
    // Update successful
    echo "Leave request updated successfully.";
  } else {
    // Update failed
    echo "Error updating leave request: " . $conn->error;
  }

  $updateStmt->close();
}
// Handle search query
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  $searchTerm = $_POST['search'];

  // Use prepared statements to prevent SQL injection
  $stmt = $conn->prepare("SELECT l.*, e.department FROM leaverequest l
  INNER JOIN employee e ON l.employee_id = e.employee_id
  WHERE e.name LIKE ?");
  $searchTerm = "%" . $searchTerm . "%";
  $stmt->bind_param("s", $searchTerm);
  $stmt->execute();
  $result = $stmt->get_result();
  $stmt->close();
} else {
  // Select all employees if there's no search
  $sql = "SELECT l.*, e.department FROM leaverequest l
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
  <div class="leave-status">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php'); ?>
      <header class="header">
        <div class="div-2">
          <div class="name">Leave</div>
          <i class="fas fa-chevron-right"></i>
          <div class="name-2">Leave Status</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-3">Leave Status</div>
          </div>
          <div class="div-3">
            <a class="" href="assignleave.html">
              <i class="img fas fa-sign-out"></i> <a class="button-2" href="assignleave.php">Assign Leave</a>
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
                    <div class="pill-2">Department</div>
                  </div>
                </div>
                <div class="pill-frame-wrapper">
                  <div class="pill-frame">
                    <div class="pill-3">Work shift</div>
                  </div>
                </div>
                <div class="div-wrapper">
                  <div class="pill-frame">
                    <div class="pill-3">Leave duration</div>
                  </div>
                </div>
                <div class="pill-4">
                  <div class="pill-frame">
                    <div class="pill-3">Users</div>
                  </div>
                </div>
              </div>
            </div>

            <?php
            // Your existing code for database connection

            // Count the number of employees that applied for leave
            $countAppliedQuery = "SELECT COUNT(*) AS applied_count FROM leaverequest";
            $countAppliedResult = $conn->query($countAppliedQuery);
            $appliedCount = $countAppliedResult->fetch_assoc()['applied_count'];

            // Count the number of employees that have been approved for leave
            $countApprovedQuery = "SELECT COUNT(*) AS approved_count FROM leaverequest WHERE approval_status = 'Accepted'";
            $countApprovedResult = $conn->query($countApprovedQuery);
            $approvedCount = $countApprovedResult->fetch_assoc()['approved_count'];

            // Calculate the total number of days for the leave of the approved employees
            $totalDaysQuery = "SELECT SUM(duration) AS total_days FROM leaverequest WHERE approval_status = 'Accepted'";
            $totalDaysResult = $conn->query($totalDaysQuery);
            $totalDays = $totalDaysResult->fetch_assoc()['total_days'];

            // Display the counts
            echo '<div class="hour-info">';
            echo '<div class="div-4">';
            echo '<div class="text-wrapper-3">' . $appliedCount . '</div>';
            echo ' <div class="text-wrapper-4">.Leave employees.</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-4">';
            echo ' <div class="text-wrapper-3">' . $totalDays . '</div>';
            echo '<div class="text-wrapper-4">Totals leaves hour</div>';
            echo '</div>';
            echo '<div class="divider"></div>';
            echo '<div class="div-4">';
            echo '<div class="text-wrapper-3">' . $approvedCount . '</div>';
            echo '<div class="text-wrapper-4">On leave</div>';
            echo '</div>';
            echo '<div class="divider-2"></div>';
            echo ' </div>';

            ?>

            <div class="frame">
              <form class="input" method="post">
                <div class="text">
                  <i class="img fas fa-search"></i>
                  <input class="placeholder" type="text" name="search" placeholder="Enter Employee Name">
                  <input type="submit" value="Search">
                </div>
              </form>
            </div>
            <div class="table-pagination">
              <div class="table-sample">
                <div class="table-cell">
                  <div class="label">
                    <div class="label-2">
                      <div class="label-3">Employee Name</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Employee ID</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Date &amp; Time</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Department</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Type</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Duration (weeks)</div>
                    </div>
                  </div>
                  <div class="component">
                    <div class="label-2">
                      <div class="label-3">Status</div>
                    </div>
                  </div>
                </div>
                <div class="table-cell-2">
                  <?php
                  if (isset($result) && $result->num_rows > 0) {
                    // Display searched employee (if found)
                    while ($row = $result->fetch_assoc()) {
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="profile-2">';
                      echo '        <div class="text-wrapper-4">' . $row["name"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-5">' . $row["employee_id"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-7">' . $row["created_id"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-5">' . $row["department"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-5">' . $row["type"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-5">' . $row["duration"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                      echo '<div class="div-wrapper-2">';
                      echo '    <div class="label-2">';
                      echo '        <div class="text-wrapper-5">' . $row["approval_status"] . '</div>';
                      echo '    </div>';
                      echo '</div>';
                    }
                  }
                  ?>
                </div>

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