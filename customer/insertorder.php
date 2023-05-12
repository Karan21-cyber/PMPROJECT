<?php
session_start();
include("../db/connection.php");
echo $_SESSION['cart_id'] . "  ";
echo $_SESSION['collectionslot_id']. " ";


$sqls = "SELECT * FROM ORDER_I WHERE CART_ID = :cart_id AND COLLECTION_SLOT_ID = :slot_id";
$stmt = oci_parse($connection, $sqls);
oci_bind_by_name($stmt , ":cart_id" , $_SESSION['cart_id']);
oci_bind_by_name($stmt, ":slot_id" ,$_SESSION['collectionslot_id']);
oci_execute($stmt);
$data = oci_fetch_array($stmt);
$order_id = $data['ORDER_ID'];
echo $order_id;

$sqlt = "SELECT * FROM CART_PRODUCT WHERE CART_ID = :cart_id";
$stms = oci_parse($connection,$sqlt);
oci_bind_by_name($stms , ":cart_id" , $_SESSION['cart_id']);
oci_execute($stms);
while($data = oci_fetch_array($stms, OCI_ASSOC)){
    $product_id = $data['PRODUCT_ID'];
    echo "PRODUCT_ID". $product_id ."  \n";
    echo "ORDER _ID ".$order_id . "\n";
    $sql = "INSERT INTO ORDER_PRODUCT(ORDER_ID,PRODUCT_ID) VALUES (:order_id,:pid)";
    $stid = oci_parse($connection, $sql);
    oci_bind_by_name($stid, ":order_id", $order_id);
    oci_bind_by_name($stid, ":pid", $product_id);
    oci_execute($stid);
}

$delsql = "DELETE FROM CART_PRODUCT WHERE CART_ID = :cart_id";
$delstmt = oci_parse($connection, $delsql);
oci_bind_by_name($delstmt , ":cart_id" , $_SESSION['cart_id']);
oci_execute($delstmt);

// update collection slot
    $sqls = "SELECT * FROM COLLECTION_SLOT WHERE COLLECTION_SLOT_ID = :slot_id";
    $stid = oci_parse($connection, $sqls);
    oci_bind_by_name($stid, ":slot_id" ,$_SESSION['collectionslot_id']);
    oci_execute($stid);
    $data = oci_fetch_array($stid);
    $orderscount = $data['NUMBER_OF_ORDER'];
    if($orderscount == 0){ 
        // update the number of order in collectionslot 
        $status = 'deactive';
        $stql = "UPDATE COLLECTION_SLOT SET COLLECTION_STATUS= :ustatus WHERE COLLECTION_SLOT_ID = :slot_id";
        $stmt = oci_parse($connection,$stql);
        oci_bind_by_name($stmt , ":slot_id", $_SESSION['collectionslot_id']);
        oci_bind_by_name($stmt , ":ustatus", $status);
        oci_execute($stmt);
       }

    echo "success";
    
?>
