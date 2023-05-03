<?php
    session_start();
    include('connection.php');

    $status = 'off';    
    $sql = "UPDATE USER_I SET STATUS = :active WHERE USER_ID= :id";
    $stid = oci_parse($connection,$sql);
    oci_bind_by_name($stid,':active' ,$status);

    if($_SESSION['profile'] == 'customer'){
        oci_bind_by_name($stid, ':id' , $_SESSION['userID'] );
      }
    if($_SESSION['profile'] == 'trader'){
        oci_bind_by_name($stid, ':id' , $_SESSION['traderID'] );
      }
    if($_SESSION['profile'] == 'admin'){
        oci_bind_by_name($stid, ':id' , $_SESSION['adminID'] );
      }
      
    oci_execute($stid);

    if($_SESSION['profile'] == 'customer'){
        unset($_SESSION['userID']);
    }
    if($_SESSION['profile'] == 'trader'){
        unset($_SESSION['traderID']);
      }
    if($_SESSION['profile'] == 'admin'){
        unset($_SESSION['adminID']);

      }
    header('location:../login.php');

?>