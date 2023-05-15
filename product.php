<?php
  session_start();
  include 'includes/db_connect.php';

  $productId;

  if(isset($_GET['id'])){
    $productId = (int)$_GET['id'];
  }
  else{
    header('Location: index.php');
    die();
  }

  $productSql = "SELECT * FROM products WHERE id = $productId";
  $productResult = $conn->query($productSql);
  $product;

  if($productResult->num_rows > 0){
    $product = $productResult->fetch_assoc();
  }
  else{
    header('Location: index.php');
    die();
  }

  $productInCart = true;

  if($_SESSION['user']){
    $userId = $_SESSION['user']['id'];
    $productInCart = (int)($conn->query("SELECT COUNT(*) count FROM cart_products WHERE user_id = $userId AND product_id = " . $product['id'])->fetch_assoc()['count']) > 0;
  }
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title><?php echo $product['name']; ?></title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div class="product-container">
      <div class="product-image">
          <?php echo "<img width=\"350px\" src='assets/products/" . $product['image_url'] . "'>"; ?>
      </div>
      <div class="product-details">
        <?php
          echo "<h1>" . $product['name'] . "</h1>";
          echo "<p>" . $product['description'] . "</p>";
        ?>

        <div>
          <?php echo "<h2>" . $product['price'] . "$</h2>"; ?>

          <?php
            if(!$productInCart || !isset($_SESSION['user'])){
              echo '<form method="post" action="addtocart.php" style="bottom: 0;right: 1em;position: absolute;"><input type="hidden" name="productId" value="' . $product['id'] . '"><input type="hidden" name="quantity" value="1"><button class="add-to-cart-button" type="submit">Add to cart <img width="30px" src="assets/icons/add-to-cart.svg"></button></form>';
            }
            else{
              echo "~Already in cart~";
            }
          ?>
        </div>
      </div>
    </div>
    <?php include 'footer.php'; ?>
  </body>
</html>

<?php
  // close database connection
  $conn->close();
?>

