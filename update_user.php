<?php
	include 'includes/authenticate_user.php';
	include 'includes/db_connect.php';
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$address = $_POST['address'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$ZIP = $_POST['ZIP'];
		$userId = $user['id'];

		$stmt = $conn->prepare("UPDATE users SET address = ?, city = ?, country = ?, zip_code = ? WHERE id = ?");
		$stmt->bind_param("ssssi", $address, $city, $country, $ZIP, $userId);
		$stmt->execute();

		$_SESSION['user']['address'] = $address;
		$_SESSION['user']['city'] = $city;
		$_SESSION['user']['country'] = $country;
		$_SESSION['user']['zip_code'] = $ZIP;
	}

	header("Location: profile.php");
?>