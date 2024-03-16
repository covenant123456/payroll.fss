<?php
// Check if the user is an admin (you should implement a secure way to check user roles)
session_start();


// Assuming you have a database connection already established
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "payroll";
$conn = new mysqli($servername, $username, $password, $dbname);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through submitted data and update roles
    foreach ($_POST["roles"] as $employeeId => $newRole) {
        // Validate and sanitize data as needed
        $employeeId = intval($employeeId);
        $newRole = mysqli_real_escape_string($conn, $newRole);

        // Update the database with new role
        $updateQuery = "UPDATE employee SET role = '$newRole' WHERE employee_id = $employeeId";
        $updateResult = $conn->query($updateQuery);

        // Handle errors if needed
        if ($updateResult === false) {
            echo "Error updating roles: " . $conn->error;
            exit();
        }
    }

    echo "Roles updated successfully.";
}

// Fetch employee data for display
$sqlEmployee = "SELECT employee_id, name, role FROM employee";
$resultEmployee = $conn->query($sqlEmployee);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="globals.css">
    <link rel="stylesheet" href="css/styleguide.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
</head>

<body>
    <div class="job-desk-employee">
        <div class="div">
            <?php include_once('header.php'); ?>
            <?php include_once('leftmenu.php'); ?>
            <header class="header">
                <div class="div-2">
                    <div class="text-wrapper-3">Employee</div>
                    <i class="fas fa-chevron-right"></i>
                    <div class="text-wrapper-4">All Employee</div>
                </div>
                <div class="title">
                    <div class="div-2">
                        <div class="text-wrapper-5">All Employee</div>
                    </div>
                    <div class="div-3">
                        <a class="button" href="addemployee.php">
                            <i class="img fas fa-plus"></i> <a class="button-4">Add Employee</a>
                        </a>
                    </div>
                </div>
            </header>
            <div class="announcements">
                <div class="container">
                    <div class="frame">
                        <form class="input" method="post">
                            <div class="text">
                                <i class="img fas fa-search"></i>
                                <input class="placeholder" type="text" name="search" placeholder="Enter Employee Name">
                                <input type="submit" value="Search">
                            </div>
                        </form>
                    </div>
                    <form method="post">
                        <div class="div-4">
                            <div class="div-4">
                                <div class="table-cell">
                                    <div class="label">
                                        <div class="div-wrapper">
                                            <div class="label-2">Name</div>
                                        </div>
                                    </div>
                                    <div class="component">
                                        <div class="div-wrapper">
                                            <div class="label-2">Current Role</div>
                                        </div>
                                    </div>
                                    <div class="component">
                                        <div class="div-wrapper">
                                            <div class="label-2">New Role</div>
                                        </div>
                                    </div>
                                    <div class="component">
                                        <div class="div-wrapper">
                                            <div class="label-2">Action</div>
                                        </div>
                                    </div>
                                </div>
                                <?php while ($row = $resultEmployee->fetch_assoc()) : ?>
                                    <div class="table-cell-2">
                                        <div class="div-wrapper-2">
                                            <div class="profile-2">
                                                <div class="text-wrapper-4"><?= $row["name"] ?></div>
                                            </div>
                                        </div>
                                        <div class="div-wrapper-2">
                                            <div class="profile-2">
                                                <div class="text-wrapper-4"><?= $row["role"] ?></div>
                                            </div>
                                        </div>
                                        <div class="div-wrapper-2">
                                            <div class="profile-2">
                                                <div class="text-wrapper-4">
                                                    <select name="roles[<?= $row["employee_id"] ?>]">
                                                        <option value="admin">Admin</option>
                                                        <option value="employee">Employee</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="div-wrapper-2">
                                            <div class="profile-2">
                                                <input type="submit" name="update_roles[<?= $row["employee_id"] ?>]" value="Update Role">
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>



<script src="fontawesome/js/all.js"></script>
<script src="js/script.js"></script>

</html>

<?php
// Close the database connection
$conn->close();
?>