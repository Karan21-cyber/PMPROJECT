<?php
session_start();
// unset($_SESSION['token']);
    echo "ID :". $_SESSION['ID'];
    echo "user ID :" . $_SESSION['userID'];
    echo"otp :". $_SESSION['otp'];
    echo "\nemail :".$_SESSION['email'];
    echo "\ntrader id :" .$_SESSION['traderID'];
    echo "\nadmin id :".$_SESSION['adminID'];
    echo "\nPname :".$_SESSION['pname'];
    echo "\ncatefory :" .$_SESSION['category'];
    echo "\ntoken :".$_SESSION['token'];
    echo "\ncategory: ".$_SESSION['type'];
    echo "\nusername :".$_SESSION['username'];
    echo "\n shop id: ". $_SESSION['shop_id'];

    unset($_SESSION['wishlist']);
    unset($_SESSION['cart']);
    echo empty($_SESSION['cart']) ? "cart is Empty" : "cart is not empty";
    echo empty($_SESSION['wishlist']) ? "wishlist is empty" : "wishlist is not empty";
?>