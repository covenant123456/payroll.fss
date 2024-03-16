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

    // Assuming you have fetched net pay from somewhere
    $net_pay = 8865.00; // Example value, replace with actual net pay

    // Generate payment code if not already generated
    $payment_code = isset($_SESSION['payment_code']) ? $_SESSION['payment_code'] : generatePaymentCode();

    // Store payment code in session
    $_SESSION['payment_code'] = $payment_code;

    // Prepare SQL statement to insert payment information into the database
    $sql = "INSERT INTO payment_history (employee_id, net_pay, payment_code, payment_date) VALUES (?, ?, ?, NOW())";

    // Prepare statement
    if ($stmt = $mysqli->prepare($sql)) {

        // Bind parameters
        $stmt->bind_param("ids", $employee_id, $net_pay, $payment_code);

        // Execute statement
        if ($stmt->execute()) {
            echo "Payment information stored successfully.";
        } else {
            echo "Error: " . $mysqli->error;
        }

        // Close statement
        $stmt->close();
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
