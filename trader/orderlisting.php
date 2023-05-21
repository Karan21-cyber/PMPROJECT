<?php
include("../db/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="css/orderslis.css">
    <style>
        .success {
            color: green;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="order">
        <div class="order_header">
            <h3>Orders Listing Lists</h3>
            <div class="search-box">
                <div class="search">
                    <input type="text" placeholder="Search...">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                </div>

                <select name="" id="">
                    <option value="">All</option>
                    <option value="">Asce</option>
                    <option value="">Desc</option>
                </select>
            </div>
        </div>
        <div class="line"></div>
    </div>
    <div class="user-container">

        <table>
            <!-- table heading -->

            <tr>
                <th>ORDER ID</th>
                <th>CUSTOMER</th>
                <th>PRODUCT</th>
                <th>QTY</th>
                <th>PRICE(&#163;)</th>
                <th>DATE</th>
                <th>STATUS</th>
                <th>ACTION</th>
            </tr>

            <?php

            $sql = "SELECT o.*,op.*,p.*
                FROM ORDER_I o
                JOIN ORDER_PRODUCT op ON o.ORDER_ID = op.ORDER_ID
                JOIN PRODUCT p ON op.PRODUCT_ID = p.PRODUCT_ID
                JOIN SHOP s ON p.SHOP_ID = s.SHOP_ID
                JOIN USER_I u ON s.USER_ID = u.USER_ID
                WHERE u.USER_ID = :user_id";

            $stid = oci_parse($connection, $sql);
            oci_bind_by_name($stid, ":user_id", $_SESSION['traderID']);
            oci_execute($stid);

            while ($row = oci_fetch_array($stid)) {
                $product_image = $row['PRODUCT_IMAGE'];
                $order_id = $row['ORDER_ID'];
                $order_date = $row['ORDER_DATE'];
                $order_price = $row['TOTAL_PRICE'];
                $order_status = $row['STATUS'];
                $order_item = $row['NO_OF_ITEM'];

                echo "
                <tr>
                    <td>" . $order_id . "</td>
                    <td>kARAN CHADUAHRY</td>
                    <td><img id='image' src='../db/uploads/products/$product_image' alt='' /></td>
                    <td>" . $order_item . "</td>
                    <td><b> &pound; " . $order_price . "</b></td>
                    <td>" . $order_date . "</td>";

                if ($order_status == 'pending') {
                    echo "<td id='status'>" . $order_status . "</td>";
                } else {
                    echo "<td class='success'>" . $order_status . "</td>";
                }

                if ($order_status == 'pending') {
                    echo "<td>
                        <div class='action'>
                            <a id='decline' href='deletetrader.php?id=$order_id&action=decline'>Remove</a>
                        </div>
                        </td>";
                }

                echo "</tr>";
            }

            ?>



        </table>
    </div>

</body>

</html>