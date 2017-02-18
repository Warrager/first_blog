


<?php

require_once('../db_settings.php');
if ($_POST['ajax']){
    $post_id = $_POST['post_id'];
    $delete_page = new Post();
    $delete_page->delete_post($post_id);
    echo "Successfully deleted.";
}


    

?>