<?php
// Start or resume the session
session_start();

$db_name = "C:/Users/30125391/OneDrive - NESCol/digital skills/untitled/TorWeb.accdb";

// Get user ID from session
$user_id = $_SESSION[ID];

// Create connection to the database
$conn = new mysqli($db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare a statement
$sql = "SELECT * FROM userDetails WHERE ID = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error in preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("s", $user_id);

// Execute statement
$stmt->execute();

// Get result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch data
    $row = $result->fetch_assoc();

    // Set retrieved values to session
    $_SESSION['username'] = $row['Alias'];
    $_SESSION['firstname'] = $row['FirstName'];
    $_SESSION['lastname'] = $row['LastName'];
    $_SESSION['dob'] = $row['DOB'];
} else {
    echo "User not found";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
