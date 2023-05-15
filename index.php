<?php
  session_start();
?>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Ecommerce</title>
  </head>
  <body>
    <?php
      include 'includes/db_connect.php';
      include 'header.php';

      $query;
      $search;
      $category;
      $sql;
      $query;
      $result = null;

      if((isset($_GET['category']) && $_GET['category'] != '')){
        $category = $_GET['category'];

        if(isset($_GET['search']) && $_GET['search'] != ''){
          $search = $_GET['search'];
          $sql = "SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE (c.id = ? OR c.parent_id = ?) AND (p.name LIKE CONCAT('%', ?, '%') OR p.description LIKE CONCAT('%', ?, '%') OR c.name LIKE CONCAT('%', ?, '%'))";
          $query = $conn->prepare($sql);
          $query->bind_param("sssss", $category, $category, $search, $search, $search);
          $query->execute();
          $result = $query->get_result();
        }
        else{
          $sql = "SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE c.id = ? OR c.parent_id = ?";
          $query = $conn->prepare($sql);
          $query->bind_param("ss", $category, $category);
          $query->execute();
          $result = $query->get_result();
        }
      }
      else if(isset($_GET['search']) && $_GET['search'] != ''){
        $search = $_GET['search'];
        $sql = "SELECT p.* FROM products p JOIN categories c ON p.category_id = c.id WHERE p.name LIKE CONCAT('%', ?, '%') OR p.description LIKE CONCAT('%', ?, '%') OR c.name LIKE CONCAT('%', ?, '%')";
        $query = $conn->prepare($sql);
        $query->bind_param("sss", $search, $search, $search);
        $query->execute();
        $result = $query->get_result();
      }

      if($result == null)
        $result = $conn->query("SELECT * FROM products");

      // get categories for dropdown menu
      $sql = "SELECT * FROM categories WHERE parent_id IS NULL";
      $category_result = $conn->query($sql);
      // display category dropdown menu
      echo "<form method='get' class='filters-container'>";
      echo '<input id="searchbox" name="search" placeholder=\'Search Products\' value="' . $_GET['search'] . '">';
      echo "<select id='category' name='category'>";
      echo "<option value=''>All categories</option>";
      while ($category_row = $category_result->fetch_assoc()) {
        $selected = $category_row['id'] == $_GET['category'];
        echo "<option value='" . $category_row['id'] . "'" . ($selected? ' selected' : '') . ">" . $category_row['name'] . "</option>";
        // get subcategories for submenu
        $sub_sql = "SELECT * FROM categories WHERE parent_id = " . $category_row['id'];
        $sub_result = $conn->query($sub_sql);
        if ($sub_result->num_rows > 0) {
          echo "<optgroup label='" . $category_row['name'] . "'>";
          while ($sub_row = $sub_result->fetch_assoc()) {
            $selected = $sub_row['id'] == $_GET['category'];
            echo "<option value='" . $sub_row['id'] . "'" . ($selected? ' selected' : '') . ">" . $sub_row['name'] . "</option>";
          }
          echo "</optgroup>";
        }
      }
      echo "</select>";
      echo "<button class='search-button' type='submit'><img src='assets/icons/search.svg' width='20px'></button>";
      echo "</form>";

      // display products in a grid
      echo "<div class='product-grid'>";
      while ($row = $result->fetch_assoc()) {
        echo "<a class='product-grid-item' href='product.php?id=" . $row['id'] . "'>";
        echo "<div class='product-image-container'>";
        echo "<img src='assets/products/" . $row['image_url'] . "' load='lazy'>";
        echo "</div>";
        echo "<div>";
        echo "<h3>" . $row['name'] . "</h3>";
        echo "<p>" . $row['price'] . "</p>";
        echo "</div>";
        echo "</a>";
      }
      echo "</div>";

      if($_GET['order_success']){
        $order_success = $_GET['order_success'];

        if($order_success == 'true'){
          echo '<script>setTimeout(() => window.alert("Order placed succesfully! Check your email for details."), 500)</script>';
        }
        else{
          echo '<script>setTimeout(() => window.alert("There was an error processing your payment!"), 500)</script>';
        }
      }

      include 'footer.php';

      // close database connection
      $conn->close();
    ?>
  </body>
</html>
