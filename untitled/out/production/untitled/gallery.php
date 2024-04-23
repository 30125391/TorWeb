<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery</title>
</head>
<body>
<h1>Image Gallery</h1>
<div class="gallery">
    <?php
    // Path to the directory containing images
    $imageDir = 'dumps/';

    // Get all files with .jpg extension in the directory
    $images = glob($imageDir . '*.jpg');

    // Loop through the images and display them
    foreach ($images as $image) {
        echo '<img src="' . $image . '" alt="Image" width="400">';
    }
    ?>
</div>
</body>
</html>
