<header>
	<a href="index.php"><img class="header-logo" width="60px" src="assets/icons/logo.svg"></a>
	<nav>
		<?php 
			session_start();
			if(is_null($_SESSION['user'])){
				echo "<a href='login.php' style='padding: 0.5em; border: 1px solid var(--coral);'>Log in</a>";
			}
			else{
				echo '<a href="cart.php" style="position: relative;">';
				if(isset($conn)){
					$userId = $_SESSION['user']['id'];
					$cartNumberOfItemsQuery = "SELECT COUNT(*) count FROM cart_products WHERE user_id = $userId";
					$cartNumberOfItems = $conn->query($cartNumberOfItemsQuery)->fetch_assoc()['count'];
					if($cartNumberOfItems > 0)
						echo '<span class="cart-notification">' .  $cartNumberOfItems .  '</span>';
				}
				echo '<img src="assets/icons/cart-white.svg" width="30px"></a>';
				echo '<a href="profile.php"><img src="assets/icons/account-white.svg" width="30px"></a>';
				echo '<a href="logout.php"> <img src="assets/icons/sign-out-white.svg" width="30px"> </a>';
			}
		?>
	</nav>
</header>