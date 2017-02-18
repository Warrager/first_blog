<?php
session_start();
date_default_timezone_set('Asia/Tokyo');

if ((array_key_exists('admin_user',$_SESSION)) && ($_SESSION['admin_user'] === "1771")){
    session_destroy();
    echo "You are now logged out.";
    header('Refresh: 1;url=index.php');
}
else{
    echo "Error, cannot log out someone who is not logged in.";
    header('Refresh: 1;url=index.php');
}


?>
