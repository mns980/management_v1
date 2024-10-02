
<?php

 //Define constants for database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'management');

// Attempt to connect to MySQL database using mysqli
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection and handle errors securely
if (!$conn) {
    // Log error securely (avoid exposing sensitive information)
    error_log("Database connection failed: " . mysqli_connect_error());
    // Display generic error message to the user
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}

// Set character set to utf8mb4
if (!mysqli_set_charset($conn, "utf8mb4")) {
    error_log("Error setting charset: " . mysqli_error($conn));
    die("An error occurred. Please try again later.");
}

// Disable ONLY_FULL_GROUP_BY mode for better compatibility
mysqli_query($conn, "SET SESSION sql_mode = ''");

// Function to sanitize user inputs
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Success message (consider removing in production)
//echo "تم الاتصال مع قاعدة البيانات بنجاح .";

// Remember to close the connection when you're done
// mysqli_close($conn);

?>












<?php
/*
$server = "localhost";
$username = "root";
$password = "";
$database = "management";

$conn = mysqli_connect($server, $username, $password, $database);

// التحقق من حالة الاتصال مع قاعدة البيانات 
if($conn){
    echo "تم الاتصال مع قاعدة البيانات بنجاح .";
}else{
    
    echo "يوجد مشكلة في الاتصال مع قاعدة البيانات: " . mysqli_connect_error();
}
*/
?>
