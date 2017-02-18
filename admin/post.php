<?php
session_start();

$title = "Admin Main";
$css_file = "../CSS/admin.css";
include ("admin_header.php");
require_once ('../db_settings.php');

echo " <a href = 'index.php'><button> Back </button> </a> ";

if ((array_key_exists('admin_user',$_SESSION)) && ($_SESSION['admin_user'] === "1771")){

    $title = "";
    $tags = "";
    $post = "";

    if (isset($_GET['edit'])){
        $post_id = (int)$_GET['edit'];
        $edit_post = new Post();
        $array = $edit_post->get_post($post_id);
        $title = $array[0];
        $tags = $array[1];
        $post = $edit_post->convert_from_html($array[2]);
    }
    if (isset($_POST['posted'])){

        $title = $_POST['title'];
        $tags = $_POST['tags'];
        $post = $_POST['post'];

        if (isset($_GET['edit'])){
            $valid = true;
            $error_array = [];
            
            if (!checker('title') || !checker('post')){
                $error_array[] = "Both the Title and Post fields must be filled.";
                $valid = false;
            }

            for ($x = 0, $y = count($error_array); $x < $y; $x++){
                echo "<p> $error_array[$x] </p>";
            }

            if ($valid){
                $edit_post->edit_post($post_id, $title, $tags, $edit_post->convert_to_html($post));
                echo "Edit complete";
                header('Refresh: 2;url=index.php');
            }
        }
        else{
            
            $valid = true;
            $error_array = [];
            
            if (!checker('title') || !checker('post')){
                $error_array[] = "Both the Title and Post fields must be filled.";
                $valid = false;
            }

            for ($x = 0, $y = count($error_array); $x < $y; $x++){
                echo "<p> $error_array[$x] </p>";
            }

            if ($valid){
                try{
                    $new_post = new Post();
                    $new_post->new_post($title, $tags, $post);
                    echo "complete";
                    header('Refresh: 1;url=index.php');

                }
                catch(PDOException $e){
                    
                }
            }
        }
    }

    ?>

    <form action = "" method = "POST">
    <h4> New Post </h4>
    <label for = "title"> Title </label><br>
    <input type = "text" name = "title" value = "<?php echo $title ?>"> <br>

    <label for = "tags"> Tags </label><br>
    <input type = "text" name = "tags" value = "<?php echo $tags ?>"> <br>

    <div class = "row">
        <div class = "col-xs-12">
    <label for = "post"> Post </label><br>
    <textarea name = "post"><?php echo $post ?></textarea> <br>
    <input type = "hidden" name = "posted"> 
    <button type = "submit"> Submit Post </button>
        </div>
    </div>
    </form>

    <script>
    </script>

    <?php
    
}

else{
    echo "Permission denied. Please log in";
    header('Refresh: 3;url=index.php');
}

include('../footer.php');
?>
