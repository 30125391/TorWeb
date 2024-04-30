<?php
$target_dir = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\dumps\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Update captions array with user-input captions
$captions = readCaptionsFromFile();
$caption = $_POST['caption'];
$captions[] = $caption;
saveCaptionsToFile($captions);



function readCaptionsFromFile()
{
    $file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\captions.txt\\";
    $captions = [];

    if (file_exists($file)) {
        $lines = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            $captions[] = $line;
        }
    }

    return $captions;
}

// Display images from the "dumps" folder with captions
for ($i = 1; $i <= count($captions); $i++) {
    $image_path = "dumps/" . $i;
    $caption = $captions[$i - 1];
    echo "<figure>";
    echo "<img src='$image_path' alt='Image $i'>";
    echo "<figcaption>$caption</figcaption>";
    echo "</figure>";
}



// Function to save captions to file
function saveCaptionsToFile($captions)
{
    $file = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\captions.txt";
    file_put_contents($file, implode("\n", $captions));
}

var_dump($_FILES);


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
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
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
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
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
?>