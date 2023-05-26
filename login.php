<?php
session_start();

if(!is_null($_SESSION['user'])){
	header('Location: index.php');
	exit();
}

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
	include 'includes/db_connect.php';

	// Get the user's email and password from the form
	$email = $_POST['email'];
	$password = $_POST['password'];

	// Check if the email exists in the database
	$emailExistsQuery = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
	$emailExistsQuery->bind_param("s", $email);
	$emailExistsQuery->execute();
	$result = $emailExistsQuery->get_result();

	if (mysqli_num_rows($result) == 1) {
		$user = mysqli_fetch_assoc($result);
	    // Email exists, check password
	    if($user['confirmed'] == 0){
	    	$err = "You haven't confirmed your email yet!";
	    }
	    else{
		    if (password_verify($password, $user['password'])) {
		        $_SESSION['user'] = $user;
		        header("Location: index.php");
		        exit();
		    } else {
		        $err = "Authentication error";
		    }
	    }
	} else {
	    $err = "Authentication error";
	}
}
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Login</title>
	</head>
	<body>
		<div class="login-form">
		  <form method="post" action="login.php" autocomplete="off">
		    <h1>Login</h1>
		    <div class="content">
		      <div class="input-field">
		        <input type="email" name="email" placeholder="Email" autocomplete="off" value="<?php echo $email;?>" required>
		      </div>
		      <div class="input-field">
		        <input type="password" placeholder="Password" name="password" autocomplete="new-password" required>
		      </div>
		      <span class="error"><?php echo $err;?></span>
		    </div>
		    <div class="action">
		      <button><a href="register.php">Register</a></button>
		      <button type="submit" name="submit">Sign in</button>
		    </div>
		  </form>
		</div>

		<?php 
			if(isset($_GET['confirm_info'])){
				echo '<script>setTimeout(() => window.alert("Go to your email to confirm your account"), 500);</script>';
			}
			else if(isset($_GET['confirm_success'])){
				if($_GET['confirm_success'] == 'true'){
					echo '<script>setTimeout(() => window.alert("Your email was confirmed successfully!"), 500);</script>';
				}
				else{
					echo '<script>setTimeout(() => window.alert("There was an error confirming your email"), 500);</script>';
				}
			}
		?>
		<?php include 'footer.php'?>
	</body>
</html>

<?php
  // close database connection
  $conn->close();
?>