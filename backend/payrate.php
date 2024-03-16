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

// Check if form data is submitted for Deductible
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['deductible'])) {
    // Prepare insert statement for Deductible table
    $stmt = $conn->prepare("INSERT INTO deductible (month, type, amount) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sss", $payrun_period, $type, $amount);

    // Set parameters
    $payrun_period = $_POST['payrun_period'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];

    // Execute statement
    if ($stmt->execute()) {
      echo "New record inserted into Deductible table successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
  }
}

// Check if form data is submitted for Payable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['payable'])) {
    // Prepare insert statement for Payable table
    $stmt = $conn->prepare("INSERT INTO payable (month, type, amount) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sss", $payrun_period, $type, $amount);

    // Set parameters
    $payrun_period = $_POST['payrun_period'];
    $type = $_POST['type'];
    $amount = $_POST['amount'];

    // Execute statement
    if ($stmt->execute()) {
      echo "New record inserted into Payable table successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
  }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST['grade'])) {
    // Prepare insert statement for Payable table
    $stmt = $conn->prepare("INSERT INTO grade (level, step, amount) VALUES (?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("sss", $level, $step, $amount);

    // Set parameters
    $level = $_POST['level'];
    $step = $_POST['step'];
    $amount = $_POST['amount'];

    // Execute statement
    if ($stmt->execute()) {
      echo "New record inserted into Grade table successfully";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
  }
}
// Close database connection
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
  <div class="job-desk-pay-run">
    <div class="div">
      <?php include_once('header.php'); ?>
      <?php include_once('leftmenu.php') ?>
      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Job Desk</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">Pay run</div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-5">Job Desk</div>
          </div>

        </div>
      </header>

      <div class="content">
        <div class="container-3">

          <div class="attendance-info">
            <div class="title">
              <div class="div-2">
                <div class="text-wrapper-14">Pay run</div>
              </div>
            </div>
           
            <form method="post" action="">
              <div class="input-container">
                <div class="input-label">
                  <div class="div-5">
                    <div class="label-text">
                      <div class="label-2">Payrun period</div>
                    </div>
                  </div>
                  <input type="text" class="input" name="payrun_period" placeholder="Monthly">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Type</div>
                    </div>
                    <div class="text-wrapper-3">(Deduction)</div>
                  </div>
                  <input type="text" class="input" name="type" placeholder="Name">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Amount</div>
                    </div>
                    <div class="text-wrapper-3">(Percentage)</div>
                  </div>
                  <input type="text" class="input" name="amount" placeholder="15%">
                </div>
                <button type="submit" name="deductible">Submit</button>
              </div>
            </form>
            <form method="post" action="">
              <div class="input-container">
                <div class="input-label">
                  <div class="div-5">
                    <div class="label-text">
                      <div class="label-2">Payrun period</div>
                    </div>
                  </div>
                  <input type="text" class="input" name="payrun_period" placeholder="Monthly">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Type</div>
                    </div>
                    <div class="text-wrapper-3">(Payable)</div>
                  </div>
                  <input type="text" class="input" name="type" placeholder="Name">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Amount</div>
                    </div>
                    <div class="text-wrapper-3">(Percentage)</div>
                  </div>
                  <input type="text" class="input" name="amount" placeholder="15%">
                </div>
                <button type="submit" name="payable">Submit</button>
              </div>
            </form>
            <form method="post" action="">
              <div class="input-container">
                <div class="input-label">
                  <div class="div-5">
                    <div class="label-text">
                      <div class="label-2">Grade</div>
                    </div>
                  </div>
                  <input type="text" class="input" name="level" placeholder="Level">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Step</div>
                    </div>
                    <div class="text-wrapper-3">(Step)</div>
                  </div>
                  <input type="text" class="input" name="step" placeholder="Step">
                </div>
                <div class="input-label">
                  <div class="div-3">
                    <div class="label-text">
                      <div class="label-2">Basic Salary</div>
                    </div>
                    <div class="text-wrapper-3"></div>
                  </div>
                  <input type="text" class="input" name="amount" placeholder="40000">
                </div>
                <button type="submit" name="grade">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="fontawesome/js/all.js"></script>
  <script src="js/script.js"></script>
</body>

</html>