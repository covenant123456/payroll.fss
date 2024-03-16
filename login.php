<?php
// Start session
session_start();

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

// Function to sanitize input data
function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitizeInput($_POST["email"]);
    $pin = sanitizeInput($_POST["pin"]);

    // Query to fetch user from the database
    $sql = "SELECT u.user_id, u.email, e.employee_id, e.name, e.role 
            FROM user u 
            JOIN employee e ON u.user_id = e.employee_id
            WHERE u.email = '$email' AND u.pin = '$pin'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Store user ID and other relevant data in the session
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["employee_id"] = $row["employee_id"]; // Storing employee ID in session
        $_SESSION["name"] = $row["name"];
        $_SESSION["role"] = $row["role"];

        // Redirect based on user role
        if ($row["role"] == "admin") {
            // Redirect to the index page of the admin
            header("Location: backend/index.php");
            exit();
        } else {
            // Redirect to the index page of the employee or other appropriate page
            header("Location: ./index.php");
            exit();
        }
    } else {
        // Set error message if login credentials are incorrect
        $error_message = "Invalid username or password";
    }
}

// Close the database connection
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
                <form class="modal-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="heading">Log in</div>
                    <div class="form-list">
                        <div class="input-label">
                            <div class="container-2">
                                <div class="label-text">
                                    <div class="label-4">Email Address</div>
                                </div>
                            </div>
                            <div class="input-2"><input class="text-3" placeholder="Email" type="email" name="email"></div>
                        </div>
                        <div class="input-label">
                            <div class="container-2">
                                <div class="label-text">
                                    <div class="label-4">Password</div>
                                </div>
                            </div>
                            <div class="input-2"><input class="text-3" placeholder="Paassword" type="password" name="pin"></div>
                        </div>

                    </div>

                    <div class="buttons-2">
                        <button class="button" type="submit">Login</button>
                    </div>
                </form>
                <?php
                if (isset($error_message)) {
                    echo "<p style='color:red;'>$error_message</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <script src="fontawesome/js/all.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
