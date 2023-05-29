<?php

    include("../db/connection.php");

 $order_id = $_GET['order_id'];

 $sqls = "SELECT op.*,p.* 
 FROM ORDER_PRODUCT op 
 JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
 WHERE op.ORDER_ID = :order_id";
 $stids = oci_parse($connection, $sqls);
 oci_bind_by_name($stids, ":order_id", $order_id);
 oci_execute($stids);
 while ($row = oci_fetch_array($stids)) {
     $product_id = $row['PRODUCT_ID'];
     $qty = (int)$row['ORDER_QUANTITY'];
     $quantity = (int)$row['STOCK_NUMBER'];

     $updatesum = $quantity + $qty;
     echo $updatesum;

     $update = "UPDATE PRODUCT SET STOCK_NUMBER = :updatenum WHERE PRODUCT_ID = :product_id";
     $stidss = oci_parse($connection, $update);
     oci_bind_by_name($stidss, ":product_id", $product_id);
     oci_bind_by_name($stidss, ":updatenum", $updatesum);
     oci_execute($stidss);
 }


 $sql = "DELETE FROM ORDER_PRODUCT WHERE ORDER_ID = :order_id";
 $stid = oci_parse($connection, $sql);
 oci_bind_by_name($stid, ":order_id", $order_id);
 oci_execute($stid);

 $delete = "removed";
 $update = 'UPDATE ORDER_I SET ORDER_STATUS = :remove WHERE ORDER_ID = :order_id';
 $updatestmt = oci_parse($connection, $update);
 oci_bind_by_name($updatestmt, ":remove", $delete);
 oci_bind_by_name($updatestmt, ":order_id", $order_id);
 if (oci_execute($updatestmt)) {
     header("location:traderdashboard.php?cat=Orderlist&name=Orders");
 }
?>