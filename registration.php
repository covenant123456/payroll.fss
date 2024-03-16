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

// Default role for new users
$defaultRole = "admin";

// Check if the registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitizeInput($_POST["name"]);
    $pin = sanitizeInput($_POST["pin"]);
    $email = sanitizeInput($_POST["email"]);

    // Check if the email is already registered
    $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
    $emailResult = $conn->query($checkEmailQuery);

    if ($emailResult->num_rows > 0) {
        // Email already exists
        $error_message = "Email already registered. Please use a different email address.";
    } else {
        // Get the selected user role or use the default role
        $role = isset($_POST["role"]) ? sanitizeInput($_POST["role"]) : $defaultRole;

        // Insert new user into the database
        $insertQuery = "INSERT INTO user (admin_name, pin, email, userrole) VALUES ('$name', '$pin', '$email', '$role')";
        $insertResult = $conn->query($insertQuery);

        if ($insertResult === true) {
            $_SESSION["admin_name"] = $name;
            $_SESSION["role"] = $role;
            // Redirect to login page
            header("Location: login.php");
            exit();
        } else {
            // Error occurred during insertion
            $error_message = "Error registering user: " . $conn->error;
        }
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
                    <div class="heading">Admin Registration</div>
                    <div class="form-list">
                    <div class="input-label">
                            <div class="container-2">
                                <div class="label-text">
                                    <div class="label-4">Name</div>
                                </div>
                            </div>
                            <div class="input-2"><input class="text-3" placeholder="Name" type="name" name="name"></div>
                        </div>
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
                        <button class="button"><input type="submit" value="Register"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="fontawesome/js/all.js"></script>
    <script src="js/script.js"></script>
</body>

</html>