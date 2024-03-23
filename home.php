<?php
session_start();
include ("Include/connection.php");
ini_set("display_errors", "off");


if (isset ($_SESSION['username'])) {

  $GLOBALS['username'] = $_SESSION['username'];
  $GLOBALS['id'] = $_SESSION['id'];
  echo "<h1> Welcome Back " . ucfirst($GLOBALS['username']) . "</h1>";
  echo '<a id="logout" href="logout.php">Log out</a>';
} else {
  echo "<strong> You Are Not Authorized To Be Here Bro!</strong>";
  header("Location: index.php");
  exit();
}
$img_query = $conn->prepare("SELECT profile_picture FROM users WHERE username = ?");
$img_query->execute(array($GLOBALS['username']));
$img = $img_query->fetchColumn();

if (isset ($_GET['search'])) {
  global $searchval;
  $searchval = htmlspecialchars($_GET['search']);
  $search_query = "SELECT * FROM users WHERE username = '$searchval'";
  $search_qresult = $conn->prepare($search_query);
  $query = $search_qresult->execute();
  $final_result = $search_qresult->fetch(PDO::FETCH_ASSOC);


  $searchname = $final_result['username'];
  $searchmail = $final_result['email'];
  $searchgender = $final_result['gender'];
  echo "<div id='result'> You Searched For User $searchval  
    Name: $searchname 
    Email: $searchmail 
    Gender: $searchgender <div>";


}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/main.css">
  <title>Home</title>
</head>

<body>
  <div class="profile-picture">
    <?php echo '<img src="Images/' . $img . '" alt="Invaild Img Dude !" class="profile-picture">' ?>
  </div>
  <form action="upload_photo.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" id="file" accept="image/*">
    <input type="submit" value="Change Profile Picture">

  </form>
  <form action="" method="get">
    <input type="search" name="search" id="">
    <input type="submit" value="Search">

  </form>
</body>

</html>