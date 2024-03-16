<?php
// Start the session
session_start();

// Check if the employee ID is stored in the session
if (!isset($_SESSION['employee_id'])) {
  // Redirect to login page or perform other actions if the employee is not logged in
  header("Location: login.php");
  exit();
}

// Retrieve the employee ID from the session
$employee_id = $_SESSION['employee_id'];

// Initialize variables for net pay, total deduction, and total allowance
$net_pay = 0;
$total_deduction = 0;
$total_allowance = 0;
$basic_salary = 0;

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

// Check if net pay already exists for the employee
$sql_check_net_pay = "SELECT net_pay FROM employee WHERE employee_id = $employee_id";
$result_check_net_pay = $conn->query($sql_check_net_pay);

if ($result_check_net_pay->num_rows > 0) {
  // Net pay already exists for the employee, update it
  $row_net_pay = $result_check_net_pay->fetch_assoc();
  $net_pay = $row_net_pay['net_pay'];

  // Fetch employee salary from the employee table
  $sql_salary = "SELECT salary FROM employee WHERE employee_id = $employee_id";
  $result_salary = $conn->query($sql_salary);
  if ($result_salary->num_rows > 0) {
    $row_salary = $result_salary->fetch_assoc();
    $basic_salary = $row_salary["salary"];
  } else {
    echo "No salary found for the employee.";
    exit;
  }

  // Fetch all deductions for the employee from the deduction table
  $sql_deductions = "SELECT SUM(amount) AS total_deduction FROM deduction WHERE employee_id = $employee_id";
  $result_deductions = $conn->query($sql_deductions);
  if ($result_deductions === false) {
    echo "Error fetching deductions: " . $conn->error;
    exit;
  }
  $row_deductions = $result_deductions->fetch_assoc();
  $total_deduction = $row_deductions["total_deduction"];

  // Fetch all allowances for the employee from the allowance table
  $sql_allowances = "SELECT SUM(amount) AS total_allowance FROM allowance WHERE employee_id = $employee_id";
  $result_allowances = $conn->query($sql_allowances);
  if ($result_allowances === false) {
    echo "Error fetching allowances: " . $conn->error;
    exit;
  }
  $row_allowances = $result_allowances->fetch_assoc();
  $total_allowance = $row_allowances["total_allowance"];

  // Update net pay in the employee table
  $sql_update_net_pay = "UPDATE employee SET net_pay = $net_pay WHERE employee_id = $employee_id";
  if ($conn->query($sql_update_net_pay) === TRUE) {
    //  echo "Net pay updated successfully.";
  } else {
    echo "Error updating net pay: " . $conn->error;
    exit;
  }
} else {
  // Net pay does not exist, calculate it and insert it

  // Fetch employee salary from the employee table
  $sql_salary = "SELECT salary FROM employee WHERE employee_id = $employee_id";
  $result_salary = $conn->query($sql_salary);
  if ($result_salary->num_rows > 0) {
    $row_salary = $result_salary->fetch_assoc();
    $basic_salary = $row_salary["salary"];
  } else {
    echo "No salary found for the employee.";
    exit;
  }

  // Fetch all deductions for the employee from the deduction table
  $sql_deductions = "SELECT SUM(amount) AS total_deduction FROM deduction WHERE employee_id = $employee_id";
  $result_deductions = $conn->query($sql_deductions);
  if ($result_deductions === false) {
    echo "Error fetching deductions: " . $conn->error;
    exit;
  }
  $row_deductions = $result_deductions->fetch_assoc();
  $total_deduction = $row_deductions["total_deduction"];

  // Fetch all allowances for the employee from the allowance table
  $sql_allowances = "SELECT SUM(amount) AS total_allowance FROM allowance WHERE employee_id = $employee_id";
  $result_allowances = $conn->query($sql_allowances);
  if ($result_allowances === false) {
    echo "Error fetching allowances: " . $conn->error;
    exit;
  }
  $row_allowances = $result_allowances->fetch_assoc();
  $total_allowance = $row_allowances["total_allowance"];

  // Calculate net pay
  $net_pay = $basic_salary + $total_allowance - $total_deduction;

  // Insert net pay into the employee table
  $sql_insert_net_pay = "INSERT INTO employee (employee_id, net_pay) VALUES ($employee_id, $net_pay)";
  if ($conn->query($sql_insert_net_pay) === TRUE) {
    //   echo "Net pay inserted successfully.";
  } else {
    echo "Error inserting net pay: " . $conn->error;
    exit;
  }
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
          <div class="name">Ferdral School of Surveying Oyo</div>
          <div class="name-2"></div>
        </div>
        <div class="div-2">
          <div class="name">PMB 1024, Oyo State</div>
          <div class="name-2"></div>
        </div>
        <div class="title">
          <div class="div-2">
            <div class="text-wrapper-3">www.fss-oyo.edu.ng</div>

          </div>

          <div class="div-3">
            <a class="" href="">
              <a class="button-2" href="">PAYSLIP</a>
            </a>
          </div>
        </div>
      </header>
      <div class="content">
        <div class="container">
          <div class="attendance-info">

            <div class="hour-info">
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

              // Query to fetch employee information
              $sql_employee_info = "SELECT name, email, position, department, created_id FROM employee WHERE employee_id = $employee_id";
              $result_employee_info = $conn->query($sql_employee_info);

              // Check if there is a result
              if ($result_employee_info->num_rows > 0) {
                // Fetch the row containing employee information
                $row_employee_info = $result_employee_info->fetch_assoc();

                // Display employee information
                echo '<div class="div-4">';
                echo '<div class="text-wrapper-3">EMPLOYEE INFORMATION</div>';
                echo '<div class="text-wrapper-4">' . $row_employee_info["name"] . '</div>';
                //  echo '<div class="text-wrapper-4">' . $row_employee_info[""] . '</div>';
                echo '<div class="text-wrapper-4">' . $row_employee_info["email"] . '</div>';
                echo '<div class="text-wrapper-4">' . $row_employee_info["position"] . '</div>';
                echo '<div class="text-wrapper-4">' . $row_employee_info["department"] . '</div>';
                echo '<div class="text-wrapper-4">' . $row_employee_info["created_id"] . '</div>';
                echo '</div>';
              } else {
                echo "No employee information found.";
              }


              ?>

              <div class="divider"></div>
              <div class="div-4">
                <div class="text-wrapper-3"></div>
                <div class="text-wrapper-4"></div>
              </div>
              <div class="divider"></div>
              <?php
                // Assuming you have already established a connection to your database
                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }


                // Fetch allowances data
                $allowance_query = "SELECT * FROM allowance WHERE employee_id = $employee_id";
                $allowance_result = $conn->query($allowance_query);

                // Fetch deductions data
                $deduction_query = "SELECT * FROM deduction WHERE employee_id = $employee_id";
                $deduction_result = $conn->query($deduction_query);

                ?>

              <div class="divider-2"></div>
            </div>
            <div class="hour-info">
              <div class="div-4">
                <div class="text-wrapper">
                <?php

                echo "<h2>Deductions</h2>";
                
                if ($deduction_result->num_rows > 0) {
                  while ($row = $deduction_result->fetch_assoc()) {
                    // Display deduction data
                    echo " " . $row["type"] . " - : " . $row["amount"] . "<br>";
                  }
                } else {
                  echo "No deductions found for employee ID: $employee_id";
                }


                ?><br>
                <div class="text-wrapper"> Total Deduction :<?php echo $total_deduction ?></div>
                
               </div>
                <br><br><hr>
                <div class="text-wrapper">Net Pay:<?php echo $net_pay ?></div>
              </div>
              <div class="divider"></div>

              <div class="divider"></div>
              <div class="div-4">
                
                <?php
                echo "<h2>Allowances</h2>";
               echo' Basic Salary :' . $basic_salary.'' ;
               echo'<br>';
                if ($allowance_result->num_rows > 0) {
                  while ($row = $allowance_result->fetch_assoc()) {
                    // Display allowance data
                    echo "" . $row["type"] . " - Amount: " . $row["amount"] . "<br>";
                  }
                } else {
                  echo "No allowances found for employee ID: $employee_id";
                }
                ?><br>
                <div class="text-wrapper">Total Allowance :<?php echo $total_allowance + $basic_salary  ?></div><br>
               
                </div>
              <div class="divider-2"></div>
            
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