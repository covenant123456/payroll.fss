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
$sqlEmployee = "SELECT name, department, net_pay, shift, created_id, email, position, phone FROM employee";
$resultEmployee = $conn->query($sqlEmployee);

$conn->close();
?>
<div class="highlight">
    <div class="container">
        <?php
        if ($resultEmployee->num_rows > 0) {
            // Fetch data for the first employee
            $rowEmployee = $resultEmployee->fetch_assoc();
        ?>
            <div class="profile-2">
                <img class="photo" src="img/pro.jpg">
                <div class="div-3">
                    <div class="text-wrapper-6"><?php echo $rowEmployee['name'] ;?></div>
                    <div class="text-wrapper-7"><?php echo $rowEmployee['position'] ;?></div>
                </div>
            </div>
            <div class="desk-info">
                <div class="text-wrapper-8">Info</div>
                <div class="container-2">
                    <div class="div-4">
                        <div class="visual"><i class="img-2 fas fa-clipboard"></i></div>
                        <div class="div-3">
                            <div class="text-wrapper-9"><?php echo $rowEmployee['department'] ;?></div>
                            <div class="text-wrapper-7">Department</div>
                        </div>
                    </div>
                    <div class="div-4">
                        <div class="visual"><i class="img-2 fas fa-wallet"></i></div>
                        <div class="div-3">
                            <div class="text-wrapper-10">#<?php echo $rowEmployee['net_pay'] ;?></div>
                            <div class="text-wrapper-7">Sallary</div>
                        </div>
                    </div>
                    <div class="div-4">
                        <div class="visual"><i class="img-2 fas fa-image"></i></div>
                        <div class="div-3">
                            <div class="text-wrapper-9"><?php echo $rowEmployee['shift'] ;?></div>
                            <div class="text-wrapper-7">Work Shift</div>
                        </div>
                    </div>
                    <div class="div-4">
                        <div class="visual"><i class="img-2 fas fa-calendar"></i></div>
                        <div class="div-3">
                            <div class="text-wrapper-9"><?php echo $rowEmployee['created_id'] ;?></div>
                            <div class="text-wrapper-7">Joining date</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-5">
                <div class="text-wrapper-8">Contact</div>
                <div class="div-5">
                    <div class="div-6">
                        <i class="img-3 fas fa-envelope"></i>
                        <div class="text">
                            <div class="text-wrapper-11">Email</div>
                            <div class="text-wrapper-12"><?php echo $rowEmployee['email'] ;?></div>
                        </div>
                    </div>
                    <div class="div-6">
                        <i class="img-3 fas fa-mobile"></i>
                        <div class="text">
                            <div class="text-wrapper-11">Phone</div>
                            <div class="text-wrapper-12"><?php echo $rowEmployee['phone'] ;?></div>
                        </div>
                    </div>
                <?php
            } else {
                echo "0 employee results";
            }

                ?>
                </div>
            </div>
    </div>
</div>