<?php
	include 'includes/authenticate_user.php';

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		include 'includes/db_connect.php';

		$productId = $_POST['productId'];
		$quantity = $_POST['quantity'];
		$userId = $user['id'];

		$deleteOldProductSql = $conn->prepare("DELETE FROM cart_products WHERE user_id = ? AND product_id = ?");
		$deleteOldProductSql->bind_param("ii", $userId, $productId);
		$deleteOldProductSql->execute();

		$addProductToCartSql = $conn->prepare("INSERT INTO cart_products (user_id, product_id, quantity) VALUES (?, ?, ?)");
		$addProductToCartSql->bind_param("iii", $userId, $productId, $quantity);
		$addProductToCartSql->execute();
	}
	
	header("Location: " . $_SERVER['HTTP_REFERER']);
?>