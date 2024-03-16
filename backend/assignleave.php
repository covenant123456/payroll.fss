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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeName = $_POST['employee_name'];
    $leaveType = $_POST['leave_type'];
    $leaveDate = $_POST['leave_date'];
    $leaveDuration = $_POST['leave_duration'];
    $leaveReason = $_POST['leave_reason'];
    $employeeID = $_POST['employee_id'];
    // Validate input (you may add more validation as needed)

    // Insert leave request into the database
    $insertQuery = "INSERT INTO leaverequest (employee_id, employee_name,type, date, duration, reason) 
                    VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ssssss", $employeeID, $employeeName, $leaveType, $leaveDate, $leaveDuration, $leaveReason);

    if ($stmt->execute()) {
        echo "Leave request submitted successfully.";
    } else {
        echo "Error submitting leave request: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
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
  <div class="leave-status">
    <div class="overlap-group-wrapper">
      <div class="overlap-group">
        <?php include_once('header.php'); ?>
        <?php include_once('leftmenu.php'); ?>

        <div class="modal-2">
          <form action="" method="post">
            <div class="heading">Assign leave</div>
            <div class="form-list">
              <div class="input-label">
                <div class="container-2">
                  <div class="label-text">
                    <div class="label-4">Employee</div>
                  </div>
                </div>
                <div class="input-2"><input class="text-3" type="text" name="employee_name" placeholder="Employee Name"></div>
              </div>
              <div class="frame-2">
                <div class="input-label-2">
                  <div class="container-2">
                    <div class="label-text">
                      <div class="label-4">Leave Type</div>
                    </div>
                  </div>
                  <input type="text" name="leave_type" placeholder="Choose Leave Type" class="input-2">
                </div>
                <div class="input-label-2">
                  <div class="container-2">
                    <div class="label-text">
                      <div class="label-4">Resumption Date</div>
                    </div>
                  </div>
                  <input type="date" name="leave_date" class="input-1">
                </div>
              </div>
              <div class="frame-2">
                <div class="input-label-2">
                  <div class="container-2">
                    <div class="label-text">
                      <div class="label-4">Duration</div>
                    </div>
                  </div>
                  <input type="datetime" name="leave_duration" class="input-2" placeholder="Duration">
                </div>
              </div>
              <div class="frame-2">
                <div class="input-label-2">
                  <div class="container-2">
                    <div class="label-text">
                      <div class="label-4">Employee ID</div>
                    </div>
                  </div>
                  <input type="text" name="employee_id" class="input-2" placeholder="Employee ID">
                </div>
              </div>
              <div class="placeholder-wrapper">
                <input type="text" name="leave_reason" class="placeholder-3 input-2" placeholder="Reason">
              </div>
            </div>
            <div class="buttons-2">
              <button class="button" type="submit">Save</button>
              <button class="secondary-button"><input type="button" value="Cancel"></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="fontawesome/js/all.js"></script>
  <script src="js/script.js"></script>
</body>

</html>
