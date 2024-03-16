<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll";

// Initialize variables for employee data
$name = "";
$dateofbrith = "";
$phone = "";
$position = "";
$department = "";
$email = "";
$shift = "";
$employeestatus = "";
$employee_id = "";
$pin ="";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee data if editing
if(isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    // Prepare and execute query to fetch employee details
    $stmt = $conn->prepare("SELECT * FROM employee WHERE employee_id = ?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch employee details
        $row = $result->fetch_assoc();

        // Assign fetched values to variables
        $name = $row['name'];
        $dateofbrith = $row['dateofbrith'];
        $phone = $row['phone'];
        $position = $row['position'];
        $department = $row['department'];
        $email = $row['email'];
        $shift = $row['shift'];
        $employeestatus = $row['employeestatus'];
    } else {
        // No employee found with the provided ID
        echo "No employee found with the provided ID.";
    }

    $stmt->close();
}

// Handle form submission for both adding and editing employees
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data    
    $name = $_POST['name'];
    $dateofbrith = $_POST['dateofbrith'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $email = $_POST['email'];
    $shift = $_POST['shift'];
    $employeestatus = $_POST['employeestatus'];
    $pin = $_POST['pin'];
    if(isset($_POST['employee_id'])) {
        // Update existing employee record
        $employee_id = $_POST['employee_id'];
        $stmt = $conn->prepare("UPDATE employee SET name=?, dateofbrith=?, phone=?, position=?, department=?, email=?, shift=?, employeestatus=? WHERE employee_id=?");
        $stmt->bind_param("ssssssssi", $name, $dateofbrith, $phone, $position, $department, $email, $shift, $employeestatus, $employee_id);
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert new employee record
        $stmt = $conn->prepare("INSERT INTO employee (name, dateofbrith, phone, position, department, email, shift, employeestatus, pin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $name, $dateofbrith, $phone, $position, $department, $email, $shift, $employeestatus, $pin);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect to another page after submission
    header("Location: employees.php");
    exit();
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
  <div class="job-desk-employee">
    <div class="overlap-group-wrapper">
      <div class="overlap-group">
        <?php include_once('header.php'); ?>
        <?php include_once('leftmenu.php'); ?>

        <div class="modal-2">
          <div class="heading"><?php echo isset($_GET['employeeid']) ? 'Edit Employee' : 'Add Employee'; ?></div>
          <form class="form-list" method="post">
            <?php if(isset($_GET['employeeid'])): ?>
              <input type="hidden" name="employee_id" value="<?php echo $employee_id; ?>">
            <?php endif; ?>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Name</div>
                </div>
              </div>
              <input type="text" name="name" class="input-2" placeholder="Name" value="<?php echo $name; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Date of Birth</div>
                </div>
              </div>
              <input type="date" name="dateofbrith" class="" placeholder="Date of Birth" value="<?php echo $dateofbrith; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Phone Number</div>
                </div>
              </div>
              <input type="text" name="phone" class="input-2" placeholder="Phone Number" value="<?php echo $phone; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Position</div>
                </div>
              </div>
              <input type="text" name="position" class="input-2" placeholder="Position" value="<?php echo $position; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Department</div>
                </div>
              </div>
              <input type="text" name="department" class="input-2" placeholder="Department" value="<?php echo $department; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Email Address</div>
                </div>
              </div>
              <input type="email" name="email" class="input-2" placeholder="Email Address" value="<?php echo $email; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Employee Status</div>
                </div>
              </div>
              <input type="text" name="employeestatus" class="input-2" placeholder="Employee Status" value="<?php echo $employeestatus; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Shift</div>
                </div>
              </div>
              <input type="text" name="shift" class="input-2" placeholder="Shift" value="<?php echo $shift; ?>">
            </div>
            <div class="input-label">
              <div class="container-2">
                <div class="label-text">
                  <div class="label-3">Password</div>
                </div>
              </div>
              <input type="text" name="pin" class="input-2" placeholder="Password" value="<?php echo $pin; ?>">
            </div>
            <div class="buttons-2">
              <button type="submit" class="button">Save</button>
              <a href="employees.php" class="secondary-button">Cancel</a>
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
