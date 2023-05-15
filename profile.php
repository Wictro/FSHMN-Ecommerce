<?php
  include 'includes/authenticate_user.php';
  include 'includes/db_connect.php';
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
    <title><?php echo $user['first_name']; ?></title>
    <style type="text/css">
    	main{
    		flex-grow: 1;
    		display: flex;
    		flex-direction: column;
    		align-items: center;
    		padding: 1em;
    	}
    </style>
	</head>
	<body>
				<?php 
			include 'header.php';
		?>
		<main>
			<?php 
				$profile_picture_url;

				if(is_null($user['profile_picture_url']))
					$profile_picture_url = 'assets/users/placeholder.png';
				else
					$profile_picture_url = 'assets/users/' . $user['profile_picture_url'];
			?>

			<div class="profile-picture-frame" style="background-image: url('<?php echo $profile_picture_url; ?>');">
				<form enctype="multipart/form-data" class="edit-profile-picture" method="post" action="profile_picture.php"><label for="profile-upload"><img src="assets/icons/edit.svg" width="20px" style="cursor: pointer; background: var(--delft-blue); padding: 2px;"></label><input id="profile-upload" style="display: none;" name="fileToUpload" type="file" multiple accept="image/*" onchange="this.form.submit()"></form>
			</div>

			<h1><?php echo $user['first_name'] . ' ' . $user['last_name'];?></h1>

			<form method="post" action="update_user.php" class="user-details-form">
				  <div class="input-field">
            <input type="text" name="address" placeholder="Address" autocomplete="nope" value="<?php echo $user['address'];?>" required>
          </div>
          <div class="input-field">
            <input type="text" name="city" placeholder="City" autocomplete="nope" value="<?php echo $user['city'];?>" required>
          </div>
          <div class="input-field">
            <input type="text" name="country" placeholder="Country" autocomplete="nope" value="<?php echo $user['country'];?>" required>
          </div>
          <div class="input-field">
            <input type="text" name="ZIP" placeholder="Zip Code" autocomplete="nope" value="<?php echo $user['zip_code'];?>" required>
          </div>
          <input type="submit" value="Save Address">
			</form>
		</main>
		<?php 
			include 'footer.php';
		?>
	</body>
</html>

<?php
  // close database connection
  $conn->close();
?>