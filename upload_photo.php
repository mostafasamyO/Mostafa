<?php

session_start();
include ("Include/connection.php");
ini_set("display_errors", "off");
if (isset ($_SESSION['username'])) {
  $username = $_SESSION['username'];


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    global $image_name, $image_type, $image_temp, $image_size, $image_error, $errors;
    $image_name = $_FILES['image']['name'];
    $image_type = $_FILES['image']['type'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_error = $_FILES['image']['error'];

    $errors = array();

    if ($image_error == 4) {
      $errors[] = "<p id='error'>No File Uploaded</p>";
    } else {
      //check File Size 
      if ($image_size > 1000000) {

        $errors[] = "<p id='error'>Image Size Is Bigger</p>";

      }

      // Check Extension 
      $allowed_extensions = array('jpg', 'png', 'gif', 'jpeg');
      $image_extension = @strtolower(end(explode(".", $image_name)));

      if (!in_array($image_extension, $allowed_extensions)) {
        $errors[] = '<p id="error">File Extention Not Allowed</p>';
      }
    }

    if (empty ($errors)) {
      move_uploaded_file($image_temp, "C:\/xampp\htdocs\Mostafa\Images\\" . $image_name);
      $profile_query = $conn->prepare("UPDATE users SET profile_picture = '$image_name' WHERE username = '$username'");
      $profile_query->execute();
      header('Location: home.php');
      exit();
    } else {
      foreach ($errors as $error) {
        echo $error;
      }
    }
  }
} else {
  header("Location: index.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/main.css">
  <title>Upload</title>
</head>

<body>

</body>

</html>