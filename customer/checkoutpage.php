<?php
  // session_start();
  include('../db/connection.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="css/checkouts.css" />
  </head>
  <body>
  <div class='nav-bar'>
    <?php
    require('navbar.php');
    ?>
  </div>
    <div class="checkout-container">
      <div class="checkout-part1">
        <h3>Collection Slot</h3>
        <form>
          <div class="collection-slot">
            <label>Time : </label>
            <select name="time" id="selectbox">
              <option value="#">Select Time</option>
              <option value="">10am to 1pm</option>
              <option value="">1pm to 4pm</option>
              <option value="">4pm to 7pm</option>
            </select>
          </div>

          <div class="collection-slot">
            <label>Day : </label>
            <select name="day" id="selectbox">
              <option value="#">Select Time</option>
              <option value="">Wednesday</option>
              <option value="">Thusday</option>
              <option value="">Friday</option>
            </select>
          </div>

          <div class="order-container">
            <table>
              <!-- table heading -->
              
                <tr>
                  <th>Product Image</th>
                  <th>Product Name</th>
                  <th>Quantity</th>
                  <th>&#163; Price</th>
                </tr>
              

              <?php
              $productprice = 0;
              $totalprice = 0;
               $sql = "SELECT * FROM CART_PRODUCT WHERE CART_ID = :cart_id";
               $stmts = oci_parse($connection,$sql);
               oci_bind_by_name($stmts, ":cart_id" , $_SESSION['cart_id']);
               oci_execute($stmts);
               while($row = oci_fetch_array($stmts,OCI_ASSOC)){
                 $pid = $row['PRODUCT_ID'];
                 $quantity = $row['QUANTITY'];
                 // query for product table 
                 $sqlpr = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :pid";
                 $stmt = oci_parse($connection,$sqlpr);
                 oci_bind_by_name($stmt, ":pid" , $pid);
                 oci_execute($stmt);
                 while($data = oci_fetch_array($stmt,OCI_ASSOC)){
                   $productprice =  $quantity * $data['PRODUCT_PRICE'];
                   $totalprice += $quantity * $data['PRODUCT_PRICE'];
                   $productname = $data['PRODUCT_NAME'];

                   echo "
                   <tr>
                   <td class='img'>";
                   echo "<img src=\"../db/uploads/products/" . $data['PRODUCT_IMAGE'] . "\" alt='$productname' /> ";
                   echo "</td>
                   <td>".$data['PRODUCT_NAME']."</td>
                   <td>". $quantity."</td>
                   <td>&#163; ". $productprice."</td>
                 </tr>
                   ";
                 }
               }
              ?>
             
            </table>
          </div>
            <div class="order-summary">
              <h3>Order Summary</h3>
              <div class="total-items">
                <h6>Total Items</h6>
                <h6><b><?php echo $_SESSION['cart_num']; ?> </b>(Items)</h6>
              </div>
              <div class="total-items">
                <h6>Total Payment</h6>
                <h6><b>&#163; <?php echo $totalprice; ?></b> </h6>
              </div>
            </div>
            <div class="place-btn">
              <input type="submit" name="order" value="Place Order" />
            </div>
         
        </form>
      </div>
    </div>

    <?php
  require('footer.php');
  ?>

  </body>
</html>
