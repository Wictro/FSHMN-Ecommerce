<?php
	include 'includes/authenticate_user.php';

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		include 'includes/db_connect.php';

		$productId = $_POST['productId'];
		$userId = $user['id'];

		$deleteOldProductSql = $conn->prepare("DELETE FROM cart_products WHERE user_id = ? AND product_id = ?");
		$deleteOldProductSql->bind_param("ii", $userId, $productId);
		$deleteOldProductSql->execute();
	}
	
	header("Location: " . $_SERVER['HTTP_REFERER']);
?>