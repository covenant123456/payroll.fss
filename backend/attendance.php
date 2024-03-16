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


$today = date("Y-m-d");

if (isset($_POST['punch_in'])) {
    // Record punch in
    $insertQuery = "INSERT INTO punch_in (employee_id, date, punch_in) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("is", $employeeId, $today);

    if ($stmt->execute()) {
        echo "Punch in recorded successfully.";
    } else {
        echo "Error recording punch in: " . $stmt->error;
    }

    // If Punch Out button is not clicked, set punch_out time to NULL
    if (!isset($_POST['punch_out'])) {
        $insertNullQuery = "INSERT INTO punch_in (employee_id, date, punch_out) VALUES (?, ?, NULL)";
        $stmt_null = $conn->prepare($insertNullQuery);
        $stmt_null->bind_param("is", $employeeId, $today);

        if ($stmt_null->execute()) {
            echo "Punch out time set to NULL.";
        } else {
            echo "Error setting punch out time to NULL: " . $stmt_null->error;
        }
    }
} elseif (isset($_POST['punch_out'])) {
    // Record punch out
    $insertQuery = "INSERT INTO punch_out (employee_id, date, punch_out) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("is", $employeeId, $today);

    if ($stmt->execute()) {
        echo "Punch out recorded successfully.";
    } else {
        echo "Error recording punch out: " . $stmt->error;
    }
} else {
    //echo "Invalid action.";
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
    <div class="attendance-details">
        <div class="overlap-group-wrapper">
            <div class="overlap-group">
                <?php include_once('header.php'); ?>

                <?php include_once('leftmenu.php'); ?>
                <div class="modal">
                    <div class="text-wrapper-8">Add Attendance</div>
                    <form class="form-list" method="post" action="">
                        <div class="input-label">
                            <div class="container-2">
                                <div class="label-text">
                                    <div class="label-4">Employee</div>
                                </div>
                            </div>
                            <div class="input-2"><input class="text-2" placeholder="Employee ID" type="text" name="employee_id" required></div>
                        </div>
                        <div class="frame-2">
                            <div class="input-label-2">
                                <div class="container-2">
                                    <div class="label-text">
                                        <div class="label-4">Punch in</div>
                                    </div>
                                </div>
                                <div class="button-2">
                                    <input type="submit" name="punch_in" value="Punch In">
                                </div>

                            </div>
                            <div class="input-label-2">
                                <div class="container-2">
                                    <div class="label-text">
                                        <div class="label-4">Punch out</div>
                                    </div>
                                </div>
                                <div class="button-2">
                                    <input type="submit" name="punch_out" value="Punch Out">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="attendance_type" value="<?php echo isset($_POST['punch_in']) ? 'punch_in' : 'punch_out'; ?>">
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="fontawesome/js/all.js"></script>
    <script src="js/script.js"></script>

</body>

</html>
