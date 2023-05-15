<?php
  include 'includes/authenticate_user.php';
  include 'includes/db_connect.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "assets/users/";

    $length = 10;
	$randomFileName = '';
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

	for ($i = 0; $i < $length; $i++) {
	    $randomFileName .= $characters[rand(0, strlen($characters) - 1)];
	}


    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
    $randomFileName = $randomFileName . '.' . $imageFileType;
    $target_file = $target_dir . $randomFileName;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $uploadOk = 0;
    }

    //Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

        $prepared = $conn->prepare("UPDATE users SET profile_picture_url = ? WHERE id = ?");
        $userId = $user['id'];
        $prepared->bind_param("si", $randomFileName, $userId);
        $prepared->execute();

        if (file_exists($target_dir . $user['profile_picture_url'])) {
		  unlink($target_dir . $user['profile_picture_url']);
		}

		$_SESSION['user']['profile_picture_url'] = $randomFileName;
    }
  }

  header('Location: profile.php');
  die();

?>