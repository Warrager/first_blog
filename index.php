<?php

require_once('db_settings.php');

$css_file = "CSS/index_css.css";
$title = "Slice of Programming";
include("header.php");

$pdo_object = new PDO_object();

if (isset($_GET['post'])){

    $post_id = (INT)$_GET['post'];

    $query = "SELECT MAX(post_id) FROM `posts`";
    $order = $pdo_object->prepare($query);
    $order->execute();
    $post = $order->fetch(PDO::FETCH_ASSOC);
    $last_post = $post['MAX(post_id)'];


    echo "<div id = 'previous_next'>";
    if ($post_id > 1){
        $previous_post = $post_id - 1;
        echo "<a href = '?post=$previous_post'><button id = 'previous'> < Previous Post   </button></a>";
    }
    if ($post_id < $last_post){
        $next_post = $post_id + 1;
        echo "<a href = '?post=$next_post'> <button id = 'next'> Next Post > </button> </a> ";
    }

    echo "</div>";


    $query = "SELECT `title`, `message`, `post_date` FROM `posts` WHERE post_id = ? ";
    $order = $pdo_object->prepare($query);
    $order->execute(array($post_id));
    $post = $order->fetchAll(PDO::FETCH_ASSOC);
    $date =strtotime($post[0]['post_date']);
    $date = date('F j, Y - g:i a', $date);
    echo <<< post
        <div class = "post_div">
        <h3 class = "title"> {$post[0]['title']} </h4>
        <h5 class = "post_date"> {$date} </h5>
        <br>
        <div class = "preview"> {$post[0]['message']} </div>
        <br>
        </div>
post;
}

else {
    $query = "SELECT COUNT(*) AS `total_posts` FROM `posts`";
    $order = $pdo_object->prepare($query);
    $order->execute();
    $total_posts = $order->fetchAll();
    $total_posts = $total_posts[0]['total_posts'];

    $posts_per_page = 10;
    $last_page = ceil($total_posts / $posts_per_page);

    $current_page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
    if ($current_page < 1 || $current_page > $last_page){
        $current_page = 1;
    }

    $start = $posts_per_page * ($current_page - 1);

    $query = "SELECT `title`, `message`, `post_date`, `post_id` FROM `posts` ORDER BY post_date DESC LIMIT $start, $posts_per_page ";
    $order = $pdo_object->prepare($query);
    $order->execute();
    $posts = $order->fetchAll(PDO::FETCH_ASSOC);

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

    for ($x = 0, $y = count($posts); $x < $y; $x++){
        $date = strtotime($posts[$x]['post_date']);
        $date = date('F j, Y - g:i a', $date);
        $message = $posts[$x]['message'];
        $post_id = $posts[$x]['post_id'];

        $pos = nth_pos($message, '</p>', 2);
        $preview = $pos ? substr($message, 0, $pos) : $message;
        $post = $pos ? substr($message, $pos) : "";

        echo <<< preview
        <div class = "post_div post_{$post_id}">
        <h3 class = "title"> <a href = "?post={$post_id}"> {$posts[$x]['title']} </a></h3>
        <h5 class = "post_date"> {$date} </h5>
        <br>
        <div class = "message"> 
            <div class = "preview"> {$preview} </div>
            <div class = "post hidden"> {$post} </div>
        </div>
preview;
        if ($post){
            echo <<< buttons
            <div class = "center_button">
            <button class = "continue_reading {$post_id}"> <i class="fa fa-angle-double-down fa-2x" aria-hidden="true"> </i> </button>
            <button class = "shrink_post {$post_id} hidden"> <i class="fa fa-angle-double-up fa-2x" aria-hidden="true"> </i> </button>
        </div>
buttons;
        }
        else{
            echo "<br><br>";

        }
        echo "</div>";
        
    }
    ?>
    <div id = "pagination">
    <ul>
        <li><a href ="?page=1"><< &nbsp; </li>
        <li><a href ="?page=<?php echo $current_page - 1 > 0 ? $current_page - 1 : 1; ?>"> < &nbsp; </li>

        <?php echo "<li><a href ='?page=$current_page'> $current_page </li>"; ?>

        <li><a href ="?page=<?php echo $current_page + 1 <= $last_page ? $current_page + 1 : $last_page; ?>">&nbsp; > </li>
        <li><a href = "?page=<?php echo $last_page; ?>">&nbsp; >> </li>
    </ul>
    </div>
    <script>
    $('.continue_reading ').click(function(){
        var post_id = '.post_' + $(this)[0].classList[1] + " ";
        $(post_id + '.post').removeClass('hidden').css('display', 'none').slideDown(1000);
        $(post_id + '.continue_reading').slideUp(500, function(){
            $(post_id + '.continue_reading').addClass('hidden');
            $(post_id + '.shrink_post').removeClass('hidden').css('display', 'none').slideDown(500);
        });
    });
    $('.shrink_post').click(function(){
        var post_id = '.post_' + $(this)[0].classList[1] + " ";
        $(post_id + '.post').slideUp(1000, function(){
            $(post_id + '.post').addClass('hidden');
        });
        $(post_id + '.shrink_post').slideUp(500, function(){
            $(post_id + '.shrink_post').addClass('hidden');
            $(post_id + '.continue_reading').removeClass('hidden').css('display', 'none').slideDown(500);
        });
    })
    </script>
    <?php
}

include("footer.php");
?>