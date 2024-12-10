<?php
    require_once('auth.php');
    require_once('../db.php');
      
    if(strlen(isLogged())>0){

        $post_id=$_GET['x'];
        print_r($post_id);

        $query=$db->prepare('DELETE FROM posts WHERE post_ID=?');
        $query->execute([$post_id]);

        header('location: myPosts.php?x=new');
        die();
    }

?>