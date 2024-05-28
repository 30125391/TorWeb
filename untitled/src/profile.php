<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $firstName = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastName = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $bio = isset($_POST['bio']) ? $_POST['bio'] : '';

    // Define variables
    $db_file = "C:/Users/30125391/OneDrive - NESCol/digital skills/untitled/TorWeb.accdb";
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

    // Check if user ID is not empty
    if (!empty($user_id)) {
        // Update user data in the database
        $java_path = "C:\\Apps\\lib\\*;C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\out\\production\\untitled";
        $java_file = "ProfileWriter";
        $command = "java -cp \"$java_path\" \"$java_file\" \"$db_file\" \"$user_id\" \"$dob\" \"$username\" \"$firstName\" \"$lastName\" \"$bio\"";
        $output = shell_exec($command);

        // Provide feedback to the user
        if ($output !== null) {
            echo "Profile updated successfully.";
        } else {
            echo "Failed to update profile. Please try again later.";
        }
    }
}

// Fetch user data from the database
// Initialize variables
$dob = '';
$username = '';
$firstName = '';
$lastName = '';
$bio = '';

// Define variables
$db_file = "C:/Users/30125391/OneDrive - NESCol/digital skills/untitled/TorWeb.accdb";
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Check if $user_id is not empty before executing the command
if (!empty($user_id)) {
    // Execute the Java program and capture the output
    $java_path = "C:\\Apps\\lib\\*;C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\out\\production\\untitled";
    $java_file = "ProfileDetails";
    $command = "java -cp \"$java_path\" \"$java_file\" \"$db_file\" \"$user_id\"";
    $output = shell_exec($command);

    // Parse Java output and extract user details
    if ($output !== null) {
        $lines = explode("\n", $output);
        $dob = isset($lines[2]) ? trim($lines[2]) : '';
        $username = isset($lines[3]) ? trim($lines[3]) : '';
        $firstName = isset($lines[4]) ? trim($lines[4]) : '';
        $lastName = isset($lines[5]) ? trim($lines[5]) : '';
        $bio = isset($lines[6]) ? trim($lines[6]) : '';
    }
}

// Array of acceptable file extensions
$acceptable_extensions = array("jpg", "jpeg", "png");

// Initialize profile_picture_path variable
$profile_picture_path = '';

// Loop through each acceptable extension to find the profile picture
foreach ($acceptable_extensions as $extension) {
    $profile_picture_path = "C:\\Users\\30125391\\OneDrive - NESCol\\digital skills\\untitled\\profilepics\\" . $user_id . "." . $extension;
    if (file_exists($profile_picture_path)) {
        // Profile picture found, break the loop
        break;
    }
}

// If profile picture path is still not found, set it to the placeholder
if (!isset($profile_picture_path) || !file_exists($profile_picture_path)) {
    $profile_picture_path = "PLACE HOLDER PFP.png"; // Placeholder image
}

// Get the base name of the profile picture file
$profile_picture_src = basename($profile_picture_path);
?>


<!DOCTYPE html>
<html>

<head>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="photos.html">Photos</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="aboutus.html">About Us</a></li>
        <li><a href="contactus.html">Contact Us</a></li>
    </ul>
    <link rel="stylesheet" href="CSS.css">
    <style>
        .dob-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-top: -100px;
        }

        .dob-container div:first-child {
            margin-right: 0px;
            margin-top: 107px;
        }

        label {
            margin-top: -45px;
        }

        input {
            margin-top: -45px;
            width: 200px;
            height: 35px;
        }

        .profile-img {
            bottom: 0;
            left: 0;
            width: 100%;
            margin-top: 15px;
            margin-left: -275px;
            text-align: center;
        }

        .form-group {
            margin-top: 100px;
            margin-right: 150px;
            position: fixed;
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
        }

        /* Added style for taller bio text box */
        #bio {
            height: 250px;
            /* Adjust the height as needed */
        }

        @media only screen and (max-width: 820px) {
            .form-group {

                margin-top: 500px;
                /* Adjust the top margin as needed */
            }

            #bio {
                width: 100%;
                margin-left: 0;
                margin-top: 5px;
                /* Adjust the top margin as needed */
            }
        }

        /* Added style to move the upload button up */
        #profile-picture {
            
            top: 60px; /* Adjust the top position as needed */
            left: 20px;
        }
    </style>
</head>

<body>
<h1>TorWeb</h1>
<hr>
<h2>Profile</h2>



<form action="" method="post" enctype="multipart/form-data">
    <div class="dob-container">

        <div>
            <p><b>DoB</b></p>
            <p><b>Username</b></p>
            <p><b>First Name</b></p>
            <p><b>Last Name</b></p>
            <p><b>User Id</b></p>
        </div>

        <input type="text" id="birthday" name="dob" placeholder="Date of Birth" value="<?php echo $dob; ?>">

        <input type="text" id="username" name="username" placeholder="Username" style="width: 197px; height: 35px; margin-top: 45px; margin-left: -205px" value="<?php echo $username; ?>">

        <input type="text" id="firstName" name="firstname" placeholder="First Name" style="width: 197px; height: 35px; margin-top: 130px; margin-left: -205px" value="<?php echo $firstName; ?>">

        <input type="text" id="lastname" name="lastname" placeholder="Last Name" style="width: 197px; height: 35px; margin-top: 216px; margin-left: -205px" value="<?php echo $lastName; ?>">

        <input type="text" id="ID" name="ID" placeholder="<?php echo $user_id; ?>" style="width: 197px; height: 35px; margin-top: 303px; margin-left: -205px" readonly>

        <div class="form-group">

            <label for="bio">Bio:</label>

            <textarea id="bio" name="bio" placeholder="<?php echo $bio; ?>" rows="10" cols="50" style="resize: none; margin-left: -20px; margin-bottom: 300px;"></textarea>
        </div>

        <input type="submit" value="Update Profile">

    </div>
    <style>
        @media only screen and (max-width: 820px) {
            .form-group {
                display: block;
                margin-top: 500px;
                /* Adjust the top margin as needed */
            }

            #bio {
                width: 100%;
                margin-left: 0;
                margin-top: 5px;
                /* Adjust the top margin as needed */
            }
        }
    </style>
</form>

<form action="Profile_Data.php" method="post" enctype="multipart/form-data">
    <div>
        <img src="profilepics/<?php echo basename($profile_picture_src); ?>" alt="Profile Picture" style="width: 150px; height: 150px; margin-left: 20px; margin-top: 20px;">
        <input type="file" id="profile-picture" name="profile-picture" style="margin-left: 10px; margin-bottom: 50px">
        <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
        <input type="submit" value="Upload Profile Picture">
    </div>
</form>

</body>
</html>
