<?php
  include 'includes/authenticate_user.php';
  include 'includes/db_connect.php';

  $cartProductsSql = "SELECT p.*, quantity FROM cart_products cp JOIN products p ON cp.product_id = p.id WHERE user_id = " . $user['id'];
  $cartProducts = $conn->query($cartProductsSql);
?>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Cart</title>
    <style type="text/css">
      main{
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1em;
        gap: 2em;
        flex-direction: column;
        flex-grow: 1;
      }
    </style>
  </head>
  <body>
    <?php
    include 'header.php';
      if($cartProducts->num_rows == 0){
        echo "<main><h1 style='text-align: center;'>Cart is empty!<br><a href='index.php'>Back to products</a></h1></main>";
        include 'footer.php';
        exit();
      }
    ?>
    <main>
      <table width="500px" class="cart-table">
      <thead>
        <th>NO.</th>
        <th>PRODUCT</th>
        <th>QUANTITY</th>
        <th>PRICE</th>
        <th></th>
      </thead>
      <tbody>
        <?php
          $counter = 1;
          $total = 0;
          while($row = $cartProducts->fetch_assoc()){
            $subtotal = (int)$row['quantity'] * (int)$row['price'];
            $total += $subtotal;
            echo "<tr>";
            echo "<td>" . $counter . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo '<td><form method="post" action="addtocart.php" style="margin: 0;"><input type="number" name="quantity" value="' . $row['quantity'] . '" min="0" onchange="this.form.submit()"><input type="hidden" name="productId" value="' . $row['id'] . '""></form>';
            echo "<td>" . $subtotal . "$</td>";
            echo '<td><form method="post" action="removefromcart.php" style="margin: 0;"><input type="hidden" name="productId" value="' . $row['id'] . '"><button class="remove-from-cart-button" type="submit"><img src="assets/icons/remove-from-cart.svg" width="25px"></button></form></td>';
            echo '</tr>';

            $counter++;
          }
        ?>
      </tbody>
    </table>

    <div class="cart-total">
      <h1>Total: <?php echo $total . "$";?></h1> 
      <a href="checkout.php">Checkout</a>
    </div>
    </main>

    <?php include 'footer.php'; ?>
  </body>
</html>

<?php
  // close database connection
  $conn->close();
?>