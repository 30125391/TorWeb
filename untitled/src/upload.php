<?php
// Function to read captions from file
function readCaptionsFromFile($file)
{
    $captions = [];
    $handle = fopen($file, "r");
    if ($handle) {
        // Read the file line by line
        while (($line = fgets($handle)) !== false) {
            // Add each line (caption) to the captions array
            $captions[] = trim($line); // Trim any leading or trailing whitespace
        }
        fclose($handle);
    } else {
        // Output an error message if fopen fails
        echo "Unable to open file: $file. Error: " . strerror(errno);
    }
    // Output the contents of the captions array for debugging
    var_dump($captions);
    return $captions;
}

// File paths
$target_dir = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\dumps\\";
$captions_file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\src\\captions.txt"; //the file path
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));

// Always read captions from file
$captions = readCaptionsFromFile($captions_file);


// Update captions array with user-input captions
$caption = $_POST['caption'];
if (!empty($caption)) {
    $captions = readCaptionsFromFile($captions_file);
    $captions[] = $caption;
    saveCaptionsToFile($captions, $captions_file);
} else {
    echo "Please provide a caption.";
}

// Get the list of files in the directory
$files = scandir($target_dir);

// Remove '.' and '..' from the list
$files = array_diff($files, array('.', '..'));

// Determine the next available number for the filename
$next_number = count($files) + 1;

// Define the target filename with the next available number
$target_file = $target_dir . $next_number;

// Check if file already exists, if so, increment the number
while (file_exists($target_file)) {
    $next_number++;
    $target_file = $target_dir . $next_number;
}

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";

// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Function to save captions to file
function saveCaptionsToFile($captions, $file)
{
    file_put_contents($file, implode("\n", $captions));
}
?>
