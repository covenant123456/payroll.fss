<?php
// Start session
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
      <?php include('header.php'); ?>
      <?php include('leftmenu.php'); ?>

      <header class="header">
        <div class="div-2">
          <div class="text-wrapper-3">Job Desk</div>
          <i class="fas fa-chevron-right"></i>
          <div class="text-wrapper-4">Salary</div>
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
                <div class="text-wrapper-14">Salary</div>
              </div>
            </div>
            <?php
            $name = "";
            $net_pay = "";

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

              // Check if payment code is already set in session
              if (!isset($_SESSION['payment_code'])) {
                // Generate payment code if not already generated and store it in session
                $_SESSION['payment_code'] = generatePaymentCode();
              }

              // Retrieve payment code from session
              $payment_code = $_SESSION['payment_code'];

              // Prepare SQL statement to fetch net pay from employee table
              $sql = "SELECT name, net_pay FROM employee WHERE employee_id = ?";
              // Prepare statement
              if ($stmt = $mysqli->prepare($sql)) {

                // Bind parameters
                $stmt->bind_param("i", $employee_id);

                // Execute statement
                $stmt->execute();

                // Bind result variables
                $stmt->bind_result($name, $net_pay);

                // Fetch values
                if ($stmt->fetch()) {
                  // Close previous statement
                  $stmt->close();

                  // Prepare SQL statement to insert payment information into the database
                  $sql_insert = "INSERT INTO payment_history (employee_id, net_pay, payment_code, payment_date) VALUES (?, ?, ?, NOW())";

                  // Prepare statement
                  if ($stmt_insert = $mysqli->prepare($sql_insert)) {

                    // Bind parameters
                    $stmt_insert->bind_param("ids", $employee_id, $net_pay, $payment_code);

                    // Execute statement
                    if ($stmt_insert->execute()) {
                      echo "Payment information stored successfully.";
                    } else {
                      echo "Error: " . $mysqli->error;
                    }

                    // Close statement
                    $stmt_insert->close();
                  } else {
                    echo "Error in SQL statement preparation: " . $mysqli->error;
                  }

                  // Output HTML with PHP variables embedded
                  echo '<div class="payment-history">';
                  echo '<div class="amount">';
                  echo '<div class="text-wrapper-15">Amount</div>';
                  echo '<div class="text-wrapper-16">$' . number_format($net_pay, 2) . '</div>'; // Format net pay as currency
                  echo '</div>';
                  echo '<div class="container-5">';
                  echo '<div class="div-7">';
                  echo '<div class="text-wrapper-15">To</div>';
                  echo '<div class="text-wrapper-17">' . $name . '</div>';
                  echo '</div>';
                  echo '<div class="div-7">';
                  // Assuming you want to display the current date
                  echo '<div class="text-wrapper-15">Date</div>';
                  echo '<div class="text-wrapper-17">' . date("m/d/Y") . '</div>'; // Format current date as "MM/DD/YYYY"
                  echo '</div>';
                  // You may replace "Payment code" with an appropriate label
                  echo '<div class="div-7">';
                  echo '<div class="text-wrapper-15">Payment code</div>';
                  // Assuming you generate a payment code dynamically or fetch it from the database
                  echo '<div class="text-wrapper-17">' . $payment_code . '</div>'; // Placeholder payment code
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
                } else {
                  echo "No employee found with ID: " . $employee_id;
                }
              } else {
                echo "Error in SQL statement preparation: " . $mysqli->error;
              }
            } else {
              echo "Employee ID not set in session.";
            }

            // Close connection
            $mysqli->close();

            // Function to generate a unique payment code
            function generatePaymentCode()
            {
              // You can generate a payment code based on your requirements
              // Here's an example of generating a random alphanumeric code
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $payment_code = '';
              $length = 6; // Change the length of the payment code as needed
              for ($i = 0; $i < $length; $i++) {
                $payment_code .= $characters[rand(0, strlen($characters) - 1)];
              }
              return $payment_code;
            }
            ?>


          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="fontawesome/js/all.js"></script>
</body>

</html>
