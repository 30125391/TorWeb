<?php
session_start();

// Reset the user ID session variable
$_SESSION['user_id'] = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve ID and password from the form
    $id = $_POST["fname"];
    $userInputPassword = $_POST["lname"];

    // Escape any special characters in ID and password to prevent issues
    $escaped_id = escapeshellarg($id);
    $escaped_password = escapeshellarg($userInputPassword);

    // Database connection parameters
    $db_file = "C:/Users/30125391/OneDrive - NESCol/digital skills/untitled/TorWeb.accdb";

    //$_SESSION['ID'] = $_POST["fname"];
    $_SESSION['user_id'] = $id;


    try {
        // Execute the Java program and capture the output
        $command = "java -cp \"C:\\APPS\\lib\\*;C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\out\\production\\untitled\" signIn \"$db_file\" $escaped_id $escaped_password";
        $output = shell_exec($command);

        // Check if authentication was successful
        if ($output !== null && strpos($output, "authenticated") !== false) {
            // Store the ID in a session variable
            $_SESSION['user_id'] = $id;


            // Redirect to profile page
            header("Location: ./profile.php");
            exit(); // Stop script execution after redirection
        } else {
            // Redirect the user to signIn.html if authentication failed
            header("Location: ./signIn.html");
            exit(); // Stop script execution after redirection
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
