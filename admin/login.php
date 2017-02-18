<?php
session_start();

require_once ('../db_settings.php');

if ((array_key_exists('admin_user',$_SESSION)) && ($_SESSION['admin_user'] === "1771")){
    echo "You are already logged in.";
    header('Refresh: 2;url=index.php');
}

else {
    if (checker('username') && checker('password')){

        $db = new PDO_object();
        //$query = "INSERT INTO users (`username`, `first_name`, `last_name`, `email`, `hash`, `reg_date`) 
        //VALUES ('$username', '$first_name', '$last_name', '$email', '$hash', NOW())";
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$salt = "Jynx7177Jun0fe-z";
        $query = "SELECT `hash`,`username` FROM `admin` WHERE username = ?";
        $order = $db->return_self()->prepare($query);
        $order->execute(array($username));
        //$data = $order->fetchAll(PDO::FETCH_ASSOC);
        $data = $order->fetch();
        $hash = $data['hash'];
        if (password_verify($password, $hash)){

            //setcookie("admin_hash","1771", time() + 86400);
            $_SESSION['admin_user'] = "1771";
            header('Refresh: 1;url=index.php');
        }
        else {
            header('Refresh: 1;url=index.php');
        }
    }
}

?>