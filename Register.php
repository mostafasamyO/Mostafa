<?php

include("Include/connection.php");

ini_set("display_errors", "off");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $username = strtolower($_POST["username"]); //htmlspcialchar() && mysqli_real_escape_string()
  $email = $_POST["email"];                   //htmlspcialchar() && mysqli_real_escape_string()
  $password = $_POST["password"];             //htmlspcialchar() && mysqli_real_escape_string()
  $md5_pass = md5($password);
  $birthday_day = (int) $_POST['birthday_day'];
  $birthday_month = (int) $_POST['birthday_month'];
  $birthday_year = (int) $_POST['birthday_year'];
  $birth = $birthday_day . "-" . $birthday_month . "-" . $birthday_year;
  $gender = $_POST['gender'];
  $gender == 'Male' ? $img = 'no_profile_picture_male.png' : $img = "no_profile_picture_female.png";
  // print_r($_POST);

  global $errors;


  $Check_query = "SELECT username FROM `users` WHERE username = '$username'";
  $result = $conn->prepare($Check_query);
  $result->execute();
  $num_rows = $result->rowCount();
  // echo $num_rows;
  if ($num_rows != 0) {
    $username_error = "<p id='error'>This Username Is already Exist</p>";
    $errors = 1;
  }
  if (empty($username)) {
    $username_error = "<p id='error'>Please Enter Your Username</p>";
    $errors = 1;

  } elseif (strlen($username) < 6) {
    $username_error = "<p id='error'>Username Must Be More Than 6 Char</p>";
    $errors = 1;

  } elseif (filter_var($username, FILTER_VALIDATE_INT)) {
    $username_error = "<p id='error'>Username Must Begin With Char</p>";
    $errors = 1;
  }
  $Check_query_email = "SELECT email FROM `users` WHERE email = '$email'";
  $result_email = $conn->prepare($Check_query_email);
  $result_email->execute();
  $num_rows_email = $result_email->rowCount();
  if ($num_rows_email != 0) {
    $email_error = "<p id='error'>This Email Is Already Registered</p>";
    $errors = 1;
  }
  if (empty($email)) {
    $email_error = "<p id='error'>Please Enter Your Email</p>";
    $errors = 1;

  } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
    $email_error = "<p id='error'>Please Enter A Vaild Email</p>";
    $errors = 1;

  }
  if (empty($birth)) {
    $birth_error = "<p id='error'>Please Enter Your Birthday</p>";
    $errors = 1;
  }
  if (empty($password)) {
    $pass_error = "<p id='error'>Please Enter Your Password</p>";
    $errors = 1;

  } elseif (strlen($password) < 8) {
    $pass_error = "<p id='error'>Password Must Be More Than 8 Char </p>";
    $errors = 1;
  }

  if (empty($gender)) {
    $gender_error = "<p id='error'>Please Enter Your Gender!</p>";
    $errors = 1;
  } elseif (in_array($gender, ['Male', 'Female']) == false) {
    $gender_error = "<p id='error'>Please Enter A Vaild Gender!</p>";
    $errors = 1;

  }


  if ($errors == 0) {

    $sql_query = "INSERT INTO users(id,username,email,password,md5_pass,gender,birthday,profile_picture) VALUES (NULL,'$username','$email','$password','$md5_pass','$gender','$birth','$img')";
    $conn->exec($sql_query);
    header("Location: index.php");
  }
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style/main.css">
  <title>Register</title>
</head>

<body>
  <div class="main">
    <h1>Register</h1>
    <br>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <?php if (isset($username_error)) {
        echo $username_error;
      } ?>
      <input type="text" placeholder="Username" name="username"><br>
      <?php if (isset($email_error)) {
        echo $email_error;
      } ?>
      <input type="email" placeholder="Email" name="email"><br>
      <?php if (isset($pass_error)) {
        echo $pass_error;
      } ?>
      <input type="password" placeholder="Password" name="password"><br>
      <?php if (isset($gender_error)) {
        echo $gender_error;
      } ?>
      <label for="gender">Gender</label>
      <select name="gender" id="gender">
        <option value="Choose" selected disabled>Choose</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>

      </select><br>
      <?php if (isset($birth_error)) {
        echo $birth_error;
      } ?>
      <label for="birthday_day">Date of birth</label>
      <span><select aria-label="Day" name="birthday_day" id="day" title="Day" class="_9407 _5dba _9hk6 _8esg">
          <option value="chosse" selected disabled>Choose</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>
          <option value="13">13</option>
          <option value="14">14</option>
          <option value="15">15</option>
          <option value="16">16</option>
          <option value="17">17</option>
          <option value="18">18</option>
          <option value="19">19</option>
          <option value="20">20</option>
          <option value="21">21</option>
          <option value="22">22</option>
          <option value="23">23</option>
          <option value="24">24</option>
          <option value="25">25</option>
          <option value="26">26</option>
          <option value="27">27</option>
          <option value="28">28</option>
          <option value="29">29</option>
          <option value="30">30</option>
          <option value="31">31</option>
        </select><select aria-label="Month" name="birthday_month" id="month" title="Month"
          class="_9407 _5dba _9hk6 _8esg">
          <option value="chosse" selected disabled>Choose</option>
          <option value="1">Jan</option>
          <option value="2">Feb</option>
          <option value="3">Mar</option>
          <option value="4">Apr</option>
          <option value="5">May</option>
          <option value="6">Jun</option>
          <option value="7">Jul</option>
          <option value="8">Aug</option>
          <option value="9">Sep</option>
          <option value="10">Oct</option>
          <option value="11">Nov</option>
          <option value="12">Dec</option>
        </select><select aria-label="Year" name="birthday_year" id="year" title="Year" class="_9407 _5dba _9hk6 _8esg">
          <option value="chosse" selected disabled>Choose</option>
          <option value="2024">2024</option>
          <option value="2023">2023</option>
          <option value="2022">2022</option>
          <option value="2021">2021</option>
          <option value="2020">2020</option>
          <option value="2019">2019</option>
          <option value="2018">2018</option>
          <option value="2017">2017</option>
          <option value="2016">2016</option>
          <option value="2015">2015</option>
          <option value="2014">2014</option>
          <option value="2013">2013</option>
          <option value="2012">2012</option>
          <option value="2011">2011</option>
          <option value="2010">2010</option>
          <option value="2009">2009</option>
          <option value="2008">2008</option>
          <option value="2007">2007</option>
          <option value="2006">2006</option>
          <option value="2005">2005</option>
          <option value="2004">2004</option>
          <option value="2003">2003</option>
          <option value="2002">2002</option>
          <option value="2001">2001</option>
          <option value="2000">2000</option>
          <option value="1999">1999</option>
          <option value="1998">1998</option>
          <option value="1997">1997</option>
          <option value="1996">1996</option>
          <option value="1995">1995</option>
          <option value="1994">1994</option>
          <option value="1993">1993</option>
          <option value="1992">1992</option>
          <option value="1991">1991</option>
          <option value="1990">1990</option>
          <option value="1989">1989</option>
          <option value="1988">1988</option>
          <option value="1987">1987</option>
          <option value="1986">1986</option>
          <option value="1985">1985</option>
          <option value="1984">1984</option>
          <option value="1983">1983</option>
          <option value="1982">1982</option>
          <option value="1981">1981</option>
          <option value="1980">1980</option>
          <option value="1979">1979</option>
          <option value="1978">1978</option>
          <option value="1977">1977</option>
          <option value="1976">1976</option>
          <option value="1975">1975</option>
          <option value="1974">1974</option>
          <option value="1973">1973</option>
          <option value="1972">1972</option>
          <option value="1971">1971</option>
          <option value="1970">1970</option>
          <option value="1969">1969</option>
          <option value="1968">1968</option>
          <option value="1967">1967</option>
          <option value="1966">1966</option>
          <option value="1965">1965</option>
          <option value="1964">1964</option>
          <option value="1963">1963</option>
          <option value="1962">1962</option>
          <option value="1961">1961</option>
          <option value="1960">1960</option>
          <option value="1959">1959</option>
          <option value="1958">1958</option>
          <option value="1957">1957</option>
          <option value="1956">1956</option>
          <option value="1955">1955</option>
          <option value="1954">1954</option>
          <option value="1953">1953</option>
          <option value="1952">1952</option>
          <option value="1951">1951</option>
          <option value="1950">1950</option>
          <option value="1949">1949</option>
          <option value="1948">1948</option>
          <option value="1947">1947</option>
          <option value="1946">1946</option>
          <option value="1945">1945</option>
          <option value="1944">1944</option>
          <option value="1943">1943</option>
          <option value="1942">1942</option>
          <option value="1941">1941</option>
          <option value="1940">1940</option>
          <option value="1939">1939</option>
          <option value="1938">1938</option>
          <option value="1937">1937</option>
          <option value="1936">1936</option>
          <option value="1935">1935</option>
          <option value="1934">1934</option>
          <option value="1933">1933</option>
          <option value="1932">1932</option>
          <option value="1931">1931</option>
          <option value="1930">1930</option>
          <option value="1929">1929</option>
          <option value="1928">1928</option>
          <option value="1927">1927</option>
          <option value="1926">1926</option>
          <option value="1925">1925</option>
          <option value="1924">1924</option>
          <option value="1923">1923</option>
          <option value="1922">1922</option>
          <option value="1921">1921</option>
          <option value="1920">1920</option>
          <option value="1919">1919</option>
          <option value="1918">1918</option>
          <option value="1917">1917</option>
          <option value="1916">1916</option>
          <option value="1915">1915</option>
          <option value="1914">1914</option>
          <option value="1913">1913</option>
          <option value="1912">1912</option>
          <option value="1911">1911</option>
          <option value="1910">1910</option>
          <option value="1909">1909</option>
          <option value="1908">1908</option>
          <option value="1907">1907</option>
          <option value="1906">1906</option>
          <option value="1905">1905</option>
        </select></span><br>

      <input type="submit" value="Register" required><br>

    </form>
    <h3>OR</h3>
    <br>
    <a id="login" href="index.php">Log in</a>
  </div>
</body>

</html>