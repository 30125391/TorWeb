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

    // Database file path relative to the script
    $db_file = __DIR__ . "/src/TorWeb.accdb";

    // Define the Java class path relative to the script
    $lib_path = __DIR__ . "/lib/*";
    $class_path = __DIR__ . "/out/production/untitled";

    // Escape arguments to prevent shell injection
    $db_file_escaped = escapeshellarg($db_file);
    $username_escaped = escapeshellarg($username);
    $password_escaped = escapeshellarg($password);

    try {
        // Execute the Java program and capture the output
        $command = "java -cp \"$lib_path;$class_path\" signUp $db_file_escaped $password_escaped $username_escaped";
        $output = shell_exec($command);

        // Debugging: print the command and output
        echo "<pre>Command: $command</pre>";
        echo "<pre>Output: $output</pre>";

        // Extract the ID from the output
        if ($output && preg_match('/ID: (\d+)/', $output, $matches)) {
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

