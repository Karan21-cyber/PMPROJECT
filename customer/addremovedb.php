<?php
session_start();
include("../db/connection.php");

if (!empty($_SESSION['cart']) || !empty($_SESSION['wishlist'])) {
    if ($_SESSION['userID']) {
        $sqlquery = "SELECT CART.CART_ID, WISHLIST.WISHLIST_ID 
        FROM CART 
        JOIN WISHLIST ON CART.USER_ID = WISHLIST.USER_ID 
        WHERE CART.USER_ID = :user_id";

        $stmt = oci_parse($connection, $sqlquery);

        oci_bind_by_name($stmt, ':user_id', $_SESSION['userID']);

        oci_execute($stmt);

        while ($row = oci_fetch_assoc($stmt)) {
            $cart_id = $row['CART_ID'];
            $wishlist_id = $row['WISHLIST_ID'];
        }
        foreach ($_SESSION['cart'] as $key => $value) {
            $product_id = $value('product_id');
            $quantity = $value['product_quantity'];

            $sql = "INSERT INTO CART_PRODUCT(CART_ID,PRODUCT_ID,QUANTITY) VALUES (:cart_id,:pid,:qty)";
            $stid = oci_parse($connection, $sql);
            oci_bind_by_name($stid, ":cart_id", $cart_id);
            oci_bind_by_name($stid, ":pid", $product_id);
            oci_bind_by_name($stid, ":qty", $quantity);
            oci_execute($stid);
        }

        foreach ($_SESSION['wishlist'] as $key => $value) {
            $product_id = $value('product_id');

            $sql = "INSERT INTO WISHLIST_PRODUCT(WISHLIST_ID,PRODUCT_ID) VALUES (:cart_id,:pid)";
            $stid = oci_parse($connection, $sql);
            oci_bind_by_name($stid, ":cart_id", $wishlist_id);
            oci_bind_by_name($stid, ":pid", $product_id);
            oci_execute($stid);
        }

        unset($_SESSION['cart']);
        unset($_SESSION['wishlist']);
    }
}

if (isset($_SESSION['userID'])) {
    $product_id = $_GET['id'];
    if (!empty($_GET['quantity'])) {
        $quantity = $_GET['quantity'];
    }

    $sql = "SELECT CART.CART_ID, WISHLIST.WISHLIST_ID 
    FROM CART 
    JOIN WISHLIST ON CART.USER_ID = WISHLIST.USER_ID 
    WHERE CART.USER_ID = :user_id";

    $stmt = oci_parse($connection, $sql);

    oci_bind_by_name($stmt, ':user_id', $_SESSION['userID']);

    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
        $cart_id = $row['CART_ID'];
        $wishlist_id = $row['WISHLIST_ID'];
    }

    //  add to cart
    if ($_GET['action'] == 'addcart') {
        $sql = "INSERT INTO CART_PRODUCT(CART_ID,PRODUCT_ID,QUANTITY) VALUES (:cart_id,:pid,:qty)";
        $stid = oci_parse($connection, $sql);
        oci_bind_by_name($stid, ":cart_id", $cart_id);
        oci_bind_by_name($stid, ":pid", $product_id);
        oci_bind_by_name($stid, ":qty", $quantity);
        oci_execute($stid);
    }

    // remove from cart
    else if ($_GET['action'] == 'removecart') {
        $sql = "DELETE FROM CART_PRODUCT WHERE PRODUCT_ID = :pid";
        $stid = oci_parse($connection, $sql);
        oci_bind_by_name($stid, ":pid", $product_id);
        oci_execute($stid);
    }
    // update cart
    if ($_GET['action'] == 'updatecart') {
        $sql = "UPDATE CART_PRODUCT SET QUANTITY = :qty  WHERE PRODUCT_ID = :pid";
        $stid = oci_parse($connection, $sql);
        oci_bind_by_name($stid, ":qty", $quantity);
        oci_bind_by_name($stid, ":pid", $product_id);
        oci_execute($stid);
    }
    // add to wishlist

    if ($_GET['action'] == 'addwishlist') {
        $sql = "INSERT INTO WISHLIST_PRODUCT(WISHLIST_ID,PRODUCT_ID) VALUES (:cart_id,:pid)";
        $stid = oci_parse($connection, $sql);
        oci_bind_by_name($stid, ":cart_id", $wishlist_id);
        oci_bind_by_name($stid, ":pid", $product_id);
        oci_execute($stid);
    }
    // remove from wishlist
    if ($_GET['action'] == 'removewishlist') {
        $sql = "DELETE FROM WISHLIST_PRODUCT WHERE PRODUCT_ID = :pid";
        $stid = oci_parse($connection, $sql);
        oci_bind_by_name($stid, ":pid", $product_id);
        oci_execute($stid);
    }
}
?>