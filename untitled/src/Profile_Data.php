<?php
session_start();
$user_id = $_SESSION['user_id'];
// Check if a profile picture is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile-picture"])) {
    // Array of acceptable file extensions
    $acceptable_extensions = array("jpg", "jpeg", "png");

    // Get the file extension of the uploaded file
    $file_extension = strtolower(pathinfo($_FILES["profile-picture"]["name"], PATHINFO_EXTENSION));

    // Check if the uploaded file has an acceptable extension
    if (in_array($file_extension, $acceptable_extensions)) {
        // Construct the file path for the new profile picture
        $target_dir = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\profilepics\\";
        $target_file = $target_dir . $user_id . "." . $file_extension;

        // Delete the old profile picture if it exists
        if (file_exists($target_file)) {
            unlink($target_file);
        }

        // Upload the new profile picture
        if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["profile-picture"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Invalid file format. Please upload a JPG, JPEG, or PNG file.";
    }
}
?>
