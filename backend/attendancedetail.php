<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="globals.css">
  <link rel="stylesheet" href="css/styleguide.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
</head>
<body>
  <div class="attendance-details">
    <div class="overlap-group-wrapper">
      <div class="overlap-group">
        <?php include_once('header.php'); ?>
        <?php include_once('leftmenu.php'); ?>
        <header class="header">
          <!-- Your header content -->
        </header>
        <div class="content">
          <div class="container">
            <div class="attendance-info">
              <div class="title">
                <!-- Your title section -->
              </div>
              <div class="div-4">
                <div class="table-cell">
                  <div class="label">
                    <div class="label-2">
                      <div class="label-3">Profile</div>
                    </div>
                  </div>
                  <!-- Display months dynamically -->
                  <?php for ($i = 1; $i <= 12; $i++): ?>
                    <div class="component">
                      <div class="label-2">
                        <div class="label-3"><?php echo date("F", mktime(0, 0, 0, $i, 1)); ?></div>
                      </div>
                    </div>
                  <?php endfor; ?>
                </div>
                <?php
                // Database connection
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

                // Fetch attendance records for all employees
                $fetchQuery = "SELECT a.*, e.name FROM attendance a JOIN employee e ON a.employee_id = e.employee_id";
                $result = $conn->query($fetchQuery);

                if ($result === false) {
                  die("Error executing fetchQuery: " . $conn->error);
                }

                while ($row = $result->fetch_assoc()): ?>
                  <div class="table-cell-2">
                    <div class="profile-wrapper">
                      <div class="profile-2">
                        <div class="text-wrapper-3">
                          <?php echo isset($row['name']) ? $row['name'] : 'Undefined'; ?>
                        </div>
                      </div>
                    </div>
                    <!-- Display attendance hours for each month -->
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                      <div class="component-2">
                        <div class="label-2">
                          <div class="text-wrapper-4">
                            <?php
                            // Fetch attendance hours for this employee and month
                            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                            $attendanceHoursQuery = "SELECT SUM(total_hours) AS total_hours FROM attendance WHERE MONTH(date) = $month AND employee_id = " . $row['employee_id'];
                            $attendanceHoursResult = $conn->query($attendanceHoursQuery);
                            $attendanceHoursRow = $attendanceHoursResult->fetch_assoc();
                            echo isset($attendanceHoursRow['total_hours']) ? $attendanceHoursRow['total_hours'] : '0.00';
                            ?>
                          </div>
                        </div>
                      </div>
                    <?php endfor; ?>
                  </div>
                <?php endwhile; ?>

                <?php
                // Close your database connection
                $conn->close();
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
