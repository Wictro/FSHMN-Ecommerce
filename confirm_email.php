<?php
	if(isset($_GET['code'])){
		include 'includes/db_connect.php';
		$providedCode = $_GET['code'];

		$query = $conn->prepare("SELECT id FROM users WHERE confirmation_code = ?");
		$query->bind_param("s", $providedCode);
		$query->execute();
		$result = $query->get_result();

		if(mysqli_num_rows($result) == 1){
			$userId = $result->fetch_assoc()['id'];

			$query = $conn->prepare("UPDATE users SET confirmed = 1 WHERE id = ?");
			$query->bind_param("i", $userId);

			if($query->execute()){
				header("Location: login.php?confirm_success=true");
				die();
			}
		}
	}

	header("Location: login.php?confirm_success=false");
?>