<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve ID and password from the form
    $id = $_POST["fname"];
    $userInputPassword = $_POST["lname"];

    // Escape any special characters in ID and password to prevent SQL injection or other security issues
    $escaped_id = escapeshellarg($id);
    $escaped_password = escapeshellarg($userInputPassword);

    // Database connection parameters
    $db_file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\TorWeb.accdb"; // Path to your Access database file

    try {
        // Construct the command to execute the Java program
        $command = "java example \"$db_file\" $escaped_id $escaped_password";

        $output = shell_exec($command);
        echo "<pre>$output</pre>";

    } catch (Exception $e) {
        // Error handling for database connection or query execution
        echo "<pre>Database error: " . $e->getMessage() . "</pre>";
    }
} else {
    // If form submission method is not POST
    echo "<pre>Form submission method is not POST.</pre>";
}
?>
