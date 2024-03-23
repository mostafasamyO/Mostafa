<?php

include("Include/connection.php");



if (isset($_POST["submit"])) {
  $username = strtolower($_POST["username"]); //htmlspcialchar() && mysqli_real_escape_string()
  $email = $_POST["email"];                   //htmlspcialchar() && mysqli_real_escape_string()
  $password = $_POST["password"];             //htmlspcialchar() && mysqli_real_escape_string()
  $md5_pass = md5($password);
  if (isset($_POST['birthday_day']) && isset($_POST['birthday_month']) && isset($_POST["birthday_year"])) {
    $birthday_day = (int) $_POST['birthday_day'];
    $birthday_month = (int) $_POST['birthday_month'];
    $birthday_year = (int) $_POST['birthday_year'];
    $birth = $birthday_day . "-" . $birthday_month . "-" . $birthday_year;
  }
  if (isset($_POST["gender"])) {
    $gender = $_POST["gender"];
    if (!in_array(["male", "female"], $gender)) {
      $gender_error = "<p id='error'>Please Enter A Vaild Gender!</p> <br>";
      $errors = 1;

    }
  }
  if (empty($username)) {
    $username_error = "<p id='error'>Please Enter Your Username</p><br>";
    $errors = 1;

  } elseif (strlen($username) < 6) {
    $username_error = "<p id='error'>Username Must Be More Than 6 Char</p><br>";
    $errors = 1;

  }
  if (empty($email)) {
    $email_error = "<p id='error'>Please Enter Your Email</p><br>";
    $errors = 1;

  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = "<p id='error'>Please Enter A Vaild Email</p><br>";
    $errors = 1;

  }
  if (empty($birth)) {
    $birth_error = "<p id='error'>Please Enter Your Birthday</p><br>";
    $errors = 1;
  }
  if (empty($password)) {
    $pass_error = "<p id='error'>Please Enter Your Password</p><br>";
    $errors = 1;

  } elseif (strlen($password) < 8) {
    $pass_error = "<p id='error'>Password Must Be More Than 8 Char </p><br>";
    $errors = 1;

  }
  if ($errors == 0) {
    $sql_query = "INSERT INTO users('id','username','email','password','md5_pass','gender','birthday') VALUES (NULL,'$username','$email','$password','$md5_pass','$gender','$birthday')";
    $conn->exec($sql_query);
    header("Location: index.php");
  } else {
    include("Register.php");
  }
}
?>
