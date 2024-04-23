<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve ID and password from the form
    $id = $_POST["userInputID"];
    $userInputPassword = $_POST["userInputPassword"];
    // Database connection parameters
    $db_file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\TorWeb.accdb";

    try {
        // Execute the Java program and capture the output
        $command = "java -cp \"C:\\Apps\\Lib\\*;C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\out\\production\\untitled\" signUp \"$db_file\" \"$id\" \"$userInputPassword\"";
        $output = shell_exec($command);
        // Print the output
        echo "<pre>$output</pre>";

    } catch (Exception $e) {
        // Error handling for Java execution
        echo "<pre>Java execution error: " . $e->getMessage() . "</pre>";
    }

} else {
    // If form submission method is not POST
    echo "<pre>Form submission method is not POST.</pre>";
}
?>