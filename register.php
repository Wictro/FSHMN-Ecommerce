<?php
session_start();

if(!is_null($_SESSION['user'])){
  header("Location: index.php");
  exit();
}

include 'includes/db_connect.php';
include 'includes/mail_config.php';

// check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // define variables and set to empty values
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $country = $_POST['country'];
    $zip_code = $_POST['zip_code'];

    $validData = 1;

    if($first_name == null || $first_name == ''){
      $first_nameErr = 'First name cannot be empty';
      $validData = 0;
    }
    if($last_name == null || $last_name == ''){
      $last_nameErr = 'Last name cannot be empty';
      $validData = 0;
    }
    if($city == null || $city == ''){
      $cityErr = 'City cannot be empty';
      $validData = 0;
    }
    if($address == null || $address == ''){
      $addressErr = 'Address cannot be empty';
      $validData = 0;
    }
    if($country == null || $country == ''){
      $countryErr = 'Country cannot be empty';
      $validData = 0;
    }
    if($zip_code == null || $zip_code == ''){
      $zipErr = 'Zip code cannot be empty';
      $validData = 0;
    }
    if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)){
      $emailErr = 'The email you provided is not a valid email';
      $validData = 0;
    }
    if(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)){
      $passwordErr = "The password should have at least one digit and be at least 8 characters long";
      $validData = 0;
    }

    $emailExistsQuery = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $emailExistsQuery->bind_param("s", $email);
    $emailExistsQuery->execute();
    $result = $emailExistsQuery->get_result();

    if(mysqli_num_rows($result) == 1){
      $emailErr = 'The email you provided is already registered';
      $validData = 0;
    }

    if($validData == 1){
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $length = 16;
      $confirmationCode = '';
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

      for ($i = 0; $i < $length; $i++) {
          $confirmationCode .= $characters[rand(0, strlen($characters) - 1)];
      }

      $query = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, city, address, country, zip_code, confirmation_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $query->bind_param("sssssssss", $first_name, $last_name, $email, $password, $city, $address, $country, $zip_code, $confirmationCode);

      if($query->execute()){
        $baseUrl = $_SERVER['SERVER_NAME'];
        $confirmationUrl = 'http://' . $baseUrl . '/ecommerce/' . 'confirm_email.php?code=' . $confirmationCode;

        $phpmailer->setFrom('noreply@randomincorporated.com', 'Random Incorporated');
        $phpmailer->addReplyTo('noreply@randomincorporated.com', 'Random Incorporated');
        $phpmailer->addAddress($email, $first_name . ' ' . $last_name);
        $phpmailer->Subject = 'Confirm your email';
        $phpmailer->isHTML(true);

        $emailBody = '<h3>Thank you for creating an account!</h3>';
        $emailBody .= '<p>Click <a href="' . $confirmationUrl . '">this</a> link to confirm your email.</p>';
        $emailBody .= "<p>Thank you for your business!<br><br>Random Incorporated<p>";
        $phpmailer->Body = $emailBody;

        if($phpmailer->send()){
          header("Location: login.php?confirm_info=true");
          die();
        } else{
           $err = "Something went wrong!";
        }
      }
      else{
        $err = "Something went wrong!";
      }
    }
}
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Register</title>
  </head>
  <body>
    <div class="login-form">
      <form method="post" action="register.php" autocomplete="off">
        <h1>Register</h1>
        <div class="content">
          <span class="error"><?php echo $err;?></span>
          <div class="input-field">
            <input type="text" name="first_name" placeholder="First Name:" value="<?php echo $first_name;?>" required>
            <span class="error"><?php echo $first_nameErr;?></span>
          </div>
          <div class="input-field">
            <input type="text" placeholder="Last Name" name="last_name" autocomplete="new-password" value="<?php echo $last_name;?>" required>
            <span class="error"><?php echo $last_nameErr;?></span>
          </div>
          <div class="input-field">
            <input type="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo $email;?>" required>
            <span class="error"><?php echo $emailErr;?></span>
          </div>
          <div class="input-field">
            <input type="password" name="password" placeholder="Password" autocomplete="off" required>
            <span class="error"><?php echo $passwordErr;?></span>
          </div>
          <div class="input-field">
            <input type="text" name="address" placeholder="Address" autocomplete="off" value="<?php echo $address;?>" required>
            <span class="error"><?php echo $addressErr;?></span>
          </div>
          <div class="input-field">
            <input type="text" name="city" placeholder="City" autocomplete="off" value="<?php echo $city;?>" required>
            <span class="error"><?php echo $cityErr;?></span>
          </div>
          <div class="input-field">
            <input type="text" name="country" placeholder="Country" autocomplete="off" value="<?php echo $country;?>" required>
            <span class="error"><?php echo $countryErr;?></span>
          </div>
          <div class="input-field">
            <input type="text" name="zip_code" placeholder="Zip Code" autocomplete="off" value="<?php echo $zip_code;?>" required>
            <span class="error"><?php echo $zipErr;?></span>
          </div>
        </div>
        <div class="action">
          <button><a href="login.php">Login</a></button>
          <button type="submit" name="submit">Register</button>
        </div>
      </form>
    </div>
    <?php include 'footer.php'?>
  </body>
</html>