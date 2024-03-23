<?php
session_start();
include("Include/connection.php");
ini_set("display_errors", "off");

if (isset($_SESSION['username'])) {
  header("Location: home.php");
  exit();
} else {


  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = strtolower($_POST['username']); //htmlspcialchar() , metaquaote()
    $password = $_POST['pass'];
    $md5_pass = md5($_POST['pass']);

    if (empty($username)) {
      $username_error = "<p id='error'>Enter Your Username Please</p>";
    }

    if (empty($password)) {
      $pass_error = "<p id='error'>Enter Your Password Please</p>";

    }
    if (empty($username) == false && empty($password) == false) {
      $login_query = $conn->prepare("SELECT id,username FROM users WHERE username = ? AND md5_pass = ?");
      $login_query->execute(array($username, $md5_pass));
      $login_result = $login_query->fetch();
      // echo "<pre>";
      // print_r($login_result);
      // echo "</pre>";
      if (@$login_result['username'] == $username) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = @$login_result['id'];
        header("Location: home.php");
        exit();
      } else {
        $login_error = "<p id='error'>Wrong Username Or Password</p>";
      }
    }

  }
}




?>


<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link rel="stylesheet" href="style/main.css">
</head>

<body>
  <div class="main">
    <h1>Login</h1>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <?php if (isset($login_error)) {
        echo $login_error;
      } ?>
      <?php if (isset($username_error)) {
        echo $username_error;
      }
      ; ?>
      <input type="text" name="username" placeholder="Username">
      <br>
      <?php if (isset($pass_error)) {
        echo $pass_error;
      } ?>
      <input type="password" name="pass" id="" placeholder="Password">
      <br>
      <label><input type="checkbox" name="kepp" id="">Keep Me Signed In</label><br>
      <input type="submit" value="Log in">
      <br>
      <a href="forget_password.php">Forget Password ?</a>
    </form>
    <h3>OR</h3>
    <br>
    <a id="register" href="Register.php">Register</a>
  </div>
</body>

</html>