<?php
  include 'includes/authenticate_user.php';
  include 'includes/db_connect.php';
  include 'includes/mail_config.php';
  
  $cartProductsSql = "SELECT p.*, quantity FROM cart_products cp JOIN products p ON cp.product_id = p.id WHERE user_id = " . $user['id'];
  $cartProductsResult = $conn->query($cartProductsSql);

  if($_SERVER['REQUEST_METHOD'] === "POST"){
    $userId = $user['id'];
    $orderStatus = 'PAID';

    $createOrder = $conn->prepare("INSERT INTO orders (user_id, status) VALUES (?, ?)");
    $createOrder->bind_param("is", $userId, $orderStatus); $createOrder->execute();

    $order_id = $conn->insert_id;

    $productId; $productQuantity; $subTotal;

    $addProductToOrder = $conn->prepare("INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $addProductToOrder->bind_param("iiii", $order_id, $productId, $productQuantity, $subTotal);

    $cartProductsResult->data_seek(0);
    $total = 0;
    while($product = $cartProductsResult->fetch_assoc()){
      $productId = (int)$product['id'];
      $productQuantity = (int)$product['quantity'];
      $subTotal = (int)$product['price'] * $productQuantity;
      $total += $subTotal;
      $addProductToOrder->execute();
    }

    $conn->query("DELETE FROM cart_products WHERE user_id = " . $user['id']);

    $createPayment = $conn->prepare("INSERT INTO payments (order_id, amount, payment_method) VALUES (?, ?, ?)");
    $paymentMethod = 'CARD';
    $createPayment->bind_param("sis", $order_id, $total, $paymentMethod); $createPayment->execute();

    $phpmailer->setFrom('noreply@randomincorporated.com', 'Random Incorporated');
    $phpmailer->addReplyTo('noreply@randomincorporated.com', 'Random Incorporated');
    $phpmailer->addAddress($user['email'], $user['first_name'] . ' ' . $user['last_name']);
    $phpmailer->Subject = 'Your ecommerce purchase';
    $phpmailer->isHTML(true);

    $emailBody = "<p>Hello <strong>" . $user['first_name'] . "</strong>,<p>";
    $emailBody .= "<p>Here are the products you ordered:<p>";
    $emailBody .= "<ul>";
    $cartProductsResult->data_seek(0);
    while ($product = mysqli_fetch_assoc($cartProductsResult)) {
        $emailBody .= "<li>" . $product['name'] . " - $" . $product['price'] . " x " . $product['quantity'] . "</li>";
    }
    $emailBody .= "</ul>";
    $emailBody .= "<h3>Total: " . $total . "$<h3>";
    $emailBody .= "<p>Thank you for your business!<br><br>Random Incorporated<p>";
    $phpmailer->Body = $emailBody;

    if($phpmailer->send()){
      header("Location: index.php?order_success=true");
      die();
    }else{
      header("Location: index.php?order_success=false");
      die();
    }
  }
?>

<?php
  if($cartProductsResult->num_rows == 0){
    header("Location: index.php");
    die();
  }
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Checkout</title>
    <style type="text/css">
      main{
        flex-grow: 1;
        display: flex;
        align-items: center;
        justify-content: center;
      }
    </style>
  </head>
  <body>
    <?php 
      include 'header.php';
    ?>
    <main>
      <form method="post" action="checkout.php" class="checkout-form">
        <div>
          <label for="creditNumber">Credit Card Number</label>
          <input type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx" id="creditNumber" name="creditNumber" required>
        </div>
        <div>
          <label for="creditExpiry">Expiry Date</label>
          <input type="month" id="creditExpiry" name="creditExpiry" required>
        </div>
        <div>
          <label for="ccv">CCV</label>
          <input type="number" id="ccv" name="ccv" placeholder="123" required>
        </div>
        <input type="submit" value="Finalize Order">
        <span>5354 1234 5678 9101</span>
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