<?php

function checker($string, $not_empty = true, $type = "post"){
    $test_var = $_POST[$string];
    $test_var = trim($test_var);
    if ($type === "post"){
        if (isset($test_var)){
            return $not_empty ? (!empty($test_var) ? true : false) : true;
        } 
        else {
            return false;
        }
    }
}

function nth_pos($str, $substr, $n){
    $pos = 0;
    for ($x = 0; $x < $n; $x++){
        $pos = strpos($str, $substr, $pos+1);
        if (!$pos){
            return false;
        }
    }
    return $pos;
}

class PDO_object{
    function __construct($host = "localhost", $db = "blog", $user = "root", $pass = "", $charset = "utf8"){
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    function prepare($query){
        $order = $this->pdo->prepare($query);
        return $order;
    }

    function return_self(){
        return $this->pdo;
    }
    function simple_execute($query){

    }
}

class Post{
    function convert_to_html($contents){
        $newtext = preg_replace('/\n/', '</p><p>', $contents);
        $newtext = preg_replace ('/<p>\s*<\/p>/', '<br>', $newtext);
        $newtext = '<p>' . $newtext;
        return $newtext;
    }
    function convert_from_html($contents){
        $newtext = preg_replace('/<\/p>/', '', $contents);
        $newtext = preg_replace('/<p>/', '', $newtext);
        $breaks = array("<br />","<br>","<br/>");  
        $newtext = str_ireplace($breaks, "\r\n", $newtext);  
        return $newtext;
    }
    function new_post($title, $tags, $post){
        try {
            //Insert title and post message
            $pdo_object = new PDO_object();
            $query = "INSERT INTO `posts` (title, message)
            VALUES (:title, :post)";
            $order = $pdo_object->return_self()->prepare($query);
            $order->bindParam(':title', $title);
            $newtext = $this->convert_to_html($post);
            $newtext = $newtext . '</p>';
            $order->bindParam(':post', $newtext);
            $order->execute();

            //Insert tags if available
            $tags = preg_replace('/\s*,\s*/', ",", ltrim(rtrim($tags)));
            $tags = preg_replace('/\s{2,}/', ' ', $tags);
            if (preg_replace('/,/','',$tags) !== ""){
                $tags = explode(',', $tags);
                $tags = array_unique($tags);
                $post_id = $pdo_object->return_self()->lastInsertId();  
                $query = "INSERT INTO `tags` (post_id, tag)
                VALUES (:post_id, :tag)";
                foreach ($tags as $tag){
                    if (!$tag){
                        continue;
                    }
                    $order = $pdo_object->return_self()->prepare($query);
                    $order->bindParam(':post_id', $post_id);
                    $order->bindParam(':tag', $tag);
                    $order->execute();
                }
            }
            return true;
        }
        catch(PDOException $e){
            return false;
        }
    }

    function get_post($post_id){
        $pdo_object = new PDO_object();

        $this->post_id = $post_id;

        $query = "SELECT `title`, `message`, `post_date`, `post_id` FROM `posts` WHERE post_id = ? ";
        $order = $pdo_object->prepare($query);
        $order->execute(array($post_id));
        $info = $order->fetchAll(PDO::FETCH_ASSOC);

        $title = $info[0]['title'];
        $post = $info[0]['message'];

        $query = "SELECT `tag` FROM `tags` WHERE post_id = ?";
        $order = $pdo_object->prepare($query);
        $order->execute(array($post_id));
        $info = $order->fetchAll(PDO::FETCH_ASSOC);

        $tag_arr = array();
        for ($x = 0, $y = count($info); $x < $y; $x++){
            $tag_arr[] = $info[$x]['tag'];
        }

        $tags = implode(", ", $tag_arr);
        return array($title, $tags, $post);

    }

    function edit_post($post_id, $title, $tags, $post){

        $pdo_object = new PDO_object();

        $query = "UPDATE `posts` SET title = ?, message = ? WHERE post_id = ? ";
        $order = $pdo_object->prepare($query);
        $order->execute(array($title, $post, $post_id));

        $query = "DELETE FROM `tags` WHERE post_id = ? ";
        $order = $pdo_object->prepare($query);
        $order->execute(array($post_id));

        $tags = preg_replace('/\s*,\s*/', ",", ltrim(rtrim($tags)));
        $tags = preg_replace('/\s{2,}/', ' ', $tags);
        if (preg_replace('/,/','',$tags) !== ""){
            $tags = explode(',', $tags);
            $tags = array_unique($tags);
            $query = "INSERT INTO `tags` (post_id, tag)
            VALUES (:post_id, :tag)";
            foreach ($tags as $tag){
                if (!$tag){
                    continue;
                }
                $order = $pdo_object->return_self()->prepare($query);
                $order->bindParam(':post_id', $post_id);
                $order->bindParam(':tag', $tag);
                $order->execute();
            }
        }
    }

    function delete_post($post_id){
        $pdo_object = new PDO_object();

        $query = "DELETE FROM `tags` WHERE post_id = ?";
        $order = $pdo_object->prepare($query);
        $order->execute(array($post_id));

        $query = "DELETE FROM `posts` WHERE post_id = ?";
        $order = $pdo_object->prepare($query);
        $order->execute(array($post_id));

        
    }
}

//$pdo_object = new PDO_object();


//$query = "ALTER TABLE `posts` ADD COLUMN title VARCHAR (250) NOT NULL";
/*
$query = "CREATE TABLE `admin`
          username VARCHAR(30) NOT NULL,
          hash VARCHAR(255) NOT NULL";


/*
$username = "honda.r.kazuya@gmail.com";
$password = "Warrager1771";
$hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO `admin` (username, hash)
VALUES (:username, :hash)";
*/

//$order = $pdo_object->return_self()->prepare($query);
//$order->bindParam(":username", $username);
//$order->bindParam(":hash", $hash);
//$order->execute();
?>