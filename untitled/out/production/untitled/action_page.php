<?php
session_start();
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Reset the user ID session variable
$_SESSION['user_id'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST["userInputID"];
    $password = $_POST["userInputPassword"];
    // Database connection parameters
    $db_file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\TorWeb.accdb";

    try {
        // Execute the Java program and capture the output
        $command = "java -cp \"C:\\Apps\\lib\\*;C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\out\\production\\untitled\" signUp \"$db_file\" \"$password\" \"$username\"";
        $output = shell_exec($command);

        // Extract the ID from the output
        if (preg_match('/ID: (\d+)/', $output, $matches)) {
            $user_id = $matches[1];

            // Store the generated ID in the session
            $_SESSION['user_id'] = $user_id;

            // Redirect to the profile page
            header("Location: ./profile.php");
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "<pre>Error: Unable to retrieve ID from Java output.</pre>";
        }

    } catch (Exception $e) {
        // Error handling for Java execution
        echo "<pre>Java execution error: " . $e->getMessage() . "</pre>";
    }

} else {
    // If form submission method is not POST
    echo "<pre>Form submission method is not POST.</pre>";
}
?>
