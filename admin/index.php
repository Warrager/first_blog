<?php
session_start();

$title = "Admin Main";
$css_file = "../CSS/admin.css";
include ("admin_header.php");
require_once('../db_settings.php');


$title = "";
$tags = "";
$post = "";

if ((array_key_exists('admin_user',$_SESSION)) && ($_SESSION['admin_user'] === "1771")){
    ?>
    <a href = "logout.php"> Logout </a>
    <h1> Admin Control Panel </h1>
    <ul>
        <li> <a href = "post.php"> Add Post </a> </li>
        <li> <a href = "post_list.php"> Edit / Delete Post </a> </li>
    </ul>
    <?php
}

else{
    echo <<< form
    <form action = "login.php" method = "post"> <br>
    <label for = "username"> Username </label> <br>
    <input type = "text" name = "username"> <br>
    <label for = "password"> Password </label> <br>
    <input type = "password" name = "password"> <br>
    <input type = "checkbox" id = "stay_logged_in" value = "1"> <label for = "stay_logged_in"> Stay Logged in </label> <br>
    <button type = "submit"> Submit </button>
    </form>
form;

}

include("admin_footer.php");
?>





