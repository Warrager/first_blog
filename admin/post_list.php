<?php
session_start();

$title = "Admin Main";
$css_file = "../CSS/admin.css";
include ("admin_header.php");
require_once('../db_settings.php');

if ((array_key_exists('admin_user',$_SESSION)) && ($_SESSION['admin_user'] === "1771")){
    $pdo_object = new PDO_object();
    $query = "SELECT COUNT(*) AS `total_posts` FROM `posts`";
    $order = $pdo_object->prepare($query);
    $order->execute();
    $total_posts = $order->fetchAll();
    $total_posts = $total_posts[0]['total_posts'];

    $posts_per_page = 10;
    $last_page = ceil($total_posts / $posts_per_page);

    $current_page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;

    $start = $posts_per_page * ($current_page - 1);

    if ($current_page < 1 || $current_page > $last_page){
        $current_page = 1;
    }

    echo "<a href = 'index.php'> <button> Back </button> </a>";

    echo "<div id = 'previous_next'>";
    if ($current_page > 1){
        $previous_page = $current_page - 1;
        echo "<a href = '?page=$previous_page'><button id = 'previous'> < Previous Page   </button></a>";
    }
    if ($current_page < $last_page){
        $next_page = $current_page + 1;
        echo "<a href = '?page=$next_page'> <button id = 'next'> Next Page > </button> </a> ";
    }
    echo "</div>";

    echo <<< start
    <div id = 'post_list'>
    <div id = "titles">
        <div class = "row">
            <h4 class = "col-xs-1"> Post Id </h4>
            <h4 class = "col-xs-2"> Title </h4>
            <h4 class = "col-xs-2"> Tags </h4>
            <h4 class = "col-xs-2"> Date </h4>
            <h4 class = "col-xs-3"> Contents </h4>
            <h4 class = "col-xs-1"> Edit </h4>
            <h4 class = "col-xs-1"> Delete </h4>
        </div>
start;

    $query = "SELECT `title`, `message`, `post_date`, `post_id` FROM `posts` ORDER BY post_date DESC LIMIT $start, $posts_per_page ";
    $order = $pdo_object->prepare($query);
    $order->execute();
    $posts = $order->fetchAll(PDO::FETCH_ASSOC);

    for ($x = 0, $y = count($posts); $x < $y; $x++){
        $date = strtotime($posts[$x]['post_date']);
        $date = date('F j, Y - g:i a', $date);
        $message = $posts[$x]['message'];
        $post_id = $posts[$x]['post_id'];
        $title = $posts[$x]['title'];

        $pos = nth_pos($message, '</p>', 2);
        $preview = $pos ? substr($message, 0, $pos) : $message;
        $post = $pos ? substr($message, $pos) : "";

        echo <<< row
        <div class = "row">
            <h5 class = "col-xs-1"> {$post_id} </h5>
            <h5 class = "col-xs-2"> {$title} </h5>
            <h5 class = "col-xs-2"> Tags </h5>
            <h5 class = "col-xs-2"> {$date} </h5>
            <h5 class = "col-xs-3"> {$message} </h5>
            <h5 class = "col-xs-1"> <a href = 'post.php?edit={$post_id}'> Edit </a> </h5>
            <button class = "delete col-xs-1" id = "post_{$post_id}"> <p> Delete </p> </button>
        </div>
row;
    }

    echo "</div>";
 
}

else{
    echo "Permission denied. Please log in";
    header('Refresh: 3;url=index.php');
}
?>

<script>
/*
$('.delete').click(function(){
    var post = $(this).attr('id').replace(/post_/, '');
    $.ajax({
        type: "POST",
        url: "delete_post.php",
        data:{
            'post_id' : post
            'ajax' : true;
        }
    });
});
*/
$('.delete').click(function(){
    var post = $(this).attr('id').replace(/post_/, '');
    $.ajax({
        url: 'delete_post.php',
        type:"post",
        data:{post_id : post,
            ajax : true
        },
        complete: function (response) {
            location.reload();
        }
    });
});


</script>

<?php
include('../footer.php');
?>