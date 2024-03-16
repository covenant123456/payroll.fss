<?php
// Start session
session_start();

// Check if employee ID is set in the session
if (!isset($_SESSION['employee_id'])) {
    // Redirect to login page if employee ID is not set
    header("Location: login.php");
    exit();
}

$employee_id = $_SESSION['employee_id']; // Retrieve employee ID from session

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
    <div class="dashboard">
        <div class="div">
            <?php include_once('header.php'); ?>
            <?php include_once('leftmenu.php'); ?>

            <div class="content">
                <header class="header">
                    <div class="text-wrapper">Dashboard</div>

                </header>
                <div class="container">
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

                    // SQL query to fetch employee data
                    $sqlEmployee = "SELECT employee_id, name FROM employee";
                    $resultEmployee = $conn->query($sqlEmployee);

                    if ($resultEmployee->num_rows > 0) {
                        // Fetch data for the first employee
                        $rowEmployee = $resultEmployee->fetch_assoc();
                        $employeeId = $rowEmployee['employee_id'];

                        // SQL query to fetch the latest attendance record for the first employee
                        $sqlAttendance = "SELECT punch_in, punch_out, total_hours, minutes_late, minutes_early 
                          FROM attendance 
                          WHERE employee_id = $employeeId
                          ORDER BY date DESC
                          LIMIT 1";
                        $resultAttendance = $conn->query($sqlAttendance);

                        // Display greeting only once
                        echo '<div class="greeting">';
                        echo '<div class="title-2">';
                        echo '<div class="heading">';
                        echo "<p class='text-wrapper-3'>Good to see you, " . $rowEmployee['name'] . " 👋</p>";
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        // Display attendance information
                        echo '<div class="greeting">';
                        echo '<div class="title-2">';
                        echo '<div class="heading">';

                        if ($rowAttendance = $resultAttendance->fetch_assoc()) {
                            echo "<p class='p'>You came " . ($rowAttendance['minutes_early'] !== '' ? abs($rowAttendance['minutes_early']) . " minutes early" : "on time or early") . " today.</p>";

                            if ($rowAttendance['minutes_late'] > 0) {
                                echo "<p class='p'>You are " . $rowAttendance['minutes_late'] . " minutes late today.</p>";
                            } else {
                                //echo "<p class='p'>You are on time or early today.</p>";
                            }

                            // Display punch time
                            echo '</div>';
                            echo '<div class="punch-time">';
                            echo '<div class="div-2">';
                            echo '<div class="addons">';
                            echo "<i class='fas fa-sign-in-alt horizontal-align'></i>";
                            echo '</div>';
                            echo '<div class="date">';
                            echo "<div class='text-wrapper-4'>" . $rowAttendance["punch_in"] . "</div>";
                            echo "<div class='text-wrapper-5'>Punch in</div>";
                            echo '</div>';
                            echo '</div>';

                            echo '<div class="div-2">';
                            echo '<div class="overlap-group-wrapper">';
                            echo '<div class="overlap-group">';
                            echo "<div class='rectangle'></div>";
                            echo "<i class='fas fa-sign-out-alt horizontal-align'></i>";
                            echo '</div>';
                            echo '</div>';
                            echo '<div class="date">';
                            echo "<div class='text-wrapper-4'>" . $rowAttendance["punch_out"] . "</div>";
                            echo "<div class='text-wrapper-5'>Punch Out</div>";
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '</div>';
                        echo '</div>';
                        echo '</div>';

                        // Fetch data for the remaining employees

                    } else {
                        echo "0 employee results";
                    }

                    // Close the database connection

                    ?>
                </div>
                <div class="tracking">
                    <div class="container-2">

                        <div class="divider"></div>
                        <?php

                        // Query to fetch leave information for the employee from the database
                        $sql = "SELECT approval_status FROM leaverequest WHERE employee_id = $employee_id";
                        $result = $conn->query($sql);

                        // Initialize counters
                        $totalLeaveCount = 0;
                        $approvedLeaveCount = 0;

                        // Check if any rows are fetched
                        if ($result->num_rows > 0) {
                            // Fetch and display leave information for each row
                            while ($row = $result->fetch_assoc()) {
                                // Increment total leave count for each row
                                $totalLeaveCount++;

                                // Check if the approval status is 'Accepted'
                                if ($row["approval_status"] == 'Accepted') {
                                    $approvedLeaveCount++;
                                }
                            }

                            // Output total leave taken
                            echo '<div class="div-3">';
                            echo '<div class="text-wrapper-6">Total leave taken</div>';
                            echo '<div class="text-wrapper-7">' . $totalLeaveCount . '</div>';

                            // Output number of leave requests accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Leave Requests Accepted</div>';
                            echo '<div class="text-wrapper-9">' . $approvedLeaveCount . '</div>';
                            echo '</div>';

                            // Output number of leave requests not accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Leave Requests Not Accepted</div>';
                            echo '<div class="text-wrapper-10">' . ($totalLeaveCount - $approvedLeaveCount) . '</div>';
                            echo '</div>';

                            echo '</div>';
                        } else {
                            // No rows found in the database
                            echo "No results found";
                        }

                        ?>

                        <div class="divider"></div>

                        <?php

                        // Query to fetch leave information for the employee from the database
                        $sql = "SELECT approval_status FROM leaverequest WHERE employee_id = $employee_id";
                        $result = $conn->query($sql);

                        // Initialize counters
                        $totalLeaveCount = 0;
                        $approvedLeaveCount = 0;
                        $rejectedLeaveCount = 0;

                        // Check if any rows are fetched
                        if ($result->num_rows > 0) {
                            // Fetch and display leave information for each row
                            while ($row = $result->fetch_assoc()) {
                                // Increment total leave count for each row
                                $totalLeaveCount++;

                                // Check if the approval status is 'Accepted'
                                if ($row["approval_status"] == 'Accepted') {
                                    $approvedLeaveCount++;
                                }

                                // Check if the approval status is 'Rejected'
                                if ($row["approval_status"] == 'Rejected') {
                                    $rejectedLeaveCount++;
                                }
                            }

                            // Output total leave available
                            echo '<div class="div-3">';
                            echo '<div class="text-wrapper-6">Total leave available</div>';
                            echo '<div class="text-wrapper-7">' . $totalLeaveCount . '</div>';

                            // Output number of leave requests accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Leave Requests Accepted</div>';
                            echo '<div class="text-wrapper-9">' . $approvedLeaveCount . '</div>';
                            echo '</div>';

                            // Output number of leave requests rejected
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Leave Requests Rejected</div>';
                            echo '<div class="text-wrapper-10">' . $rejectedLeaveCount . '</div>';
                            echo '</div>';

                            // Output number of leave requests not accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Leave Requests Not Accepted</div>';
                            echo '<div class="text-wrapper-11">' . ($totalLeaveCount - $approvedLeaveCount - $rejectedLeaveCount) . '</div>';
                            echo '</div>';

                            echo '</div>';
                        } else {
                            // No rows found in the database
                            echo "No results found";
                        }

                        ?>

                        <div class="divider"></div>
                        <?php



                        // Query to fetch leave information from the database
                        // Query to fetch leave information for the employee from the database
                        $sql = "SELECT approval_status FROM attendance WHERE employee_id = $employee_id";
                        $result = $conn->query($sql);

                        // Initialize counters
                        $totalAttendanceCount = 0;
                        $approvedAttendanceCount = 0;
                        $rejectedAttendanceCount = 0;
                        $pendingAttendanceCount = 0;
                        // Check if any rows are fetched


                        // Check if any rows are fetched
                        if ($result->num_rows > 0) {
                            // Fetch and display leave information for each row
                            while ($row = $result->fetch_assoc()) {
                                // Increment total leave count for each row
                                $totalAttendanceCount++;
                                // Check if the approval status is 'Accepted'
                                if ($row["approval_status"] == '') {
                                    $pendingAttendanceCount++;
                                }
                                // Check if the approval status is 'Accepted'
                                if ($row["approval_status"] == 'Accepted') {
                                    $approvedAttendanceCount++;
                                }

                                // Check if the approval status is 'Rejected'
                                if ($row["approval_status"] == 'reject') {
                                    $rejectedAttendanceCount++;
                                }
                            }




                            // Output total leave taken
                            echo '<div class="div-3">';
                            echo '<div class="text-wrapper-6">Total attendance</div>';
                            echo '<div class="text-wrapper-7">' . $totalAttendanceCount . '</div>';
                            // Output number of leave requests accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Attendance Accepted</div>';
                            echo '<div class="text-wrapper-9">' .  $pendingAttendanceCount . '</div>';
                            echo '</div>';
                            // Output number of leave requests accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Attendance Accepted</div>';
                            echo '<div class="text-wrapper-9">' .  $approvedAttendanceCount . '</div>';
                            echo '</div>';

                            // Output number of leave requests not accepted
                            echo '<div class="info">';
                            echo '<div class="text-wrapper-8">Attendance Not Accepted</div>';
                            echo '<div class="text-wrapper-10">' . $rejectedAttendanceCount . '</div>';
                            echo '</div>';

                            echo '</div>';
                        } else {
                            // No rows found in the database
                            echo "No results found";
                        }


                        ?>
                    </div>

                </div>
                <div class="container-wrapper">
                    <div class="container-3">
                        <div class="text-wrapper-3">Time Log</div>
                        <div class="long-container">
                            <div class="today-s-log-time">
                                <div class="text-wrapper-11">Today</div>
                                <div class="container-4">
                                    <div class="div-5">
                                        <div class="text-wrapper-12">09:00</div>
                                        <div class="text-wrapper-13">Scheduled</div>
                                    </div>
                                    <div class="div-5">
                                        <div class="text-wrapper-12">12:00</div>
                                        <div class="text-wrapper-13">Balance</div>
                                    </div>
                                    <div class="div-5">
                                        <div class="text-wrapper-12">05:00</div>
                                        <div class="text-wrapper-13">Worked</div>
                                    </div>
                                </div>
                            </div>
                            <div class="primary-wrapper"></div>
                            <div class="div-6">
                                <div class="text-wrapper-6">This month</div>
                                <?php


                                // Query to fetch total worked hours from the attendance table
                                $sql = "SELECT SUM(TIMESTAMPDIFF(SECOND, punch_in, punch_out)) AS total_hours FROM attendance WHERE employee_id = $employee_id";
                                $result = $conn->query($sql);

                                // Initialize total worked hours
                                $totalHours = 0;

                                // Check if any rows are fetched
                                if ($result->num_rows > 0) {
                                    // Fetch and store total worked hours
                                    $row = $result->fetch_assoc();
                                    $totalHours = $row["total_hours"];
                                }

                                // Convert total hours to hours format
                                $totalHours = $totalHours / 3600;

                                // Calculate the total hours from 9 am to 5 pm (in seconds)
                                $startTime = strtotime('9:00');
                                $endTime = strtotime('17:00');
                                $totalHoursFrom9to5 = ($endTime - $startTime) * 7; // Assuming 7 working days in a week

                                // Calculate shortage time
                                $shortageTime = max(0, $totalHoursFrom9to5 - $totalHours);

                                // Simulated data for worked hours (in seconds)
                                $workedHours = $totalHours * 3600; // Convert hours to seconds

                                // Simulated data for overtime hours (in seconds)
                                $overtimeHours = max(0, $totalHours - 8) * 3600; // Assuming 8 hours of work per day

                                // Output the results in the provided HTML format
                                echo '<div class="container-5">';
                                echo '<div class="div-6">';
                                echo '<div class="div-7">';
                                echo '<div class="title-3">';
                                echo '<div class="text-wrapper-14">Total</div>';
                                echo '<div class="text-wrapper-4">' . $totalHoursFrom9to5 / 3600 . ' hour</div>'; // Convert seconds to hours
                                echo '</div>';
                                echo '<div class="progress-bar">';
                                echo '<div class="progress">';
                                echo '<div class="bar">';
                                echo '<div class="piece"></div>';
                                echo '<div class="piece"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="div-7">';
                                echo '<div class="title-3">';
                                echo '<div class="text-wrapper-14">Shortage time</div>';
                                echo '<div class="text-wrapper-4">' . $shortageTime / 3600 . ' hour</div>'; // Convert seconds to hours
                                echo '</div>';
                                echo '<div class="progress-bar">';
                                echo '<div class="progress">';
                                echo '<div class="bar-2">';
                                echo '<div class="piece"></div>';
                                echo '<div class="piece"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="child-frame">';
                                echo '<div class="div-8">';
                                echo '<div class="title-4">';
                                echo '<div class="text-wrapper-14">Worked time</div>';
                                echo '<div class="text-wrapper-4">' . $workedHours / 3600 . ' hour</div>'; // Convert seconds to hours
                                echo '</div>';
                                echo '<div class="progress-wrapper">';
                                echo '<div class="progress">';
                                echo '<div class="bar-3">';
                                echo '<div class="piece"></div>';
                                echo '<div class="piece"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="div-8">';
                                echo '<div class="title-4">';
                                echo '<div class="text-wrapper-14">Over time</div>';
                                echo '<div class="text-wrapper-4">' . $overtimeHours / 3600 . ' hour</div>'; // Convert seconds to hours
                                echo '</div>';
                                echo '<div class="progress-wrapper">';
                                echo '<div class="progress">';
                                echo '<div class="bar-4">';
                                echo '<div class="piece"></div>';
                                echo '<div class="piece"></div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';

                                // Close database connection
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
</body>

</html>