<?php

    require_once("auth.php");
    require_once("../db.php");
    require_once("post_functions.php");

    function likePost($db, $post_ID, $user_ID, $likes){

        $query=$db->prepare('UPDATE posts set likes=? WHERE post_ID=?');
        $query->execute([$likes+1, $post_ID]);
        
        $query=$db->prepare('INSERT INTO post_likes(post_ID, user_ID) VALUES(?, ?)');
        $query->execute([$post_ID, $user_ID]);
    }
    function dislikePost($db, $post_ID, $user_ID, $likes){
        $query=$db->prepare('UPDATE posts set likes=? WHERE post_ID=?');
        $query->execute([$likes-1, $post_ID]);

        $query=$db->prepare('DELETE FROM post_likes WHERE post_ID=? AND user_ID=?');
        $query->execute([$post_ID, $user_ID]);
    }

    function likeComment($db, $post_ID, $comment_ID, $user_ID, $likes){
        $query=$db->prepare('UPDATE comments set likes=? WHERE comment_ID=? AND post_ID=?');
        $query->execute([$likes+1, $comment_ID, $post_ID]);

        $query=$db->prepare('INSERT INTO comment_likes(comment_ID, user_ID) VALUES(?, ?)');
        $query->execute([$comment_ID, $user_ID]);
    }
    function dislikeComment($db, $post_ID, $comment_ID, $user_ID, $likes){
        $query=$db->prepare('UPDATE comments set likes=? WHERE comment_ID=? AND post_ID=?');
        $query->execute([$likes-1, $comment_ID, $post_ID]);

        $query=$db->prepare('DELETE FROM comment_likes WHERE comment_ID=? AND user_ID=?');
        $query->execute([$comment_ID, $user_ID]);
    }

    //all the variables sent to this script from the AJAX object in the 'entity/detail.php' js script
    $likeStatus = filter_var($_POST['like'], FILTER_VALIDATE_BOOLEAN);
    $post_ID = $_POST['post_ID'];
    $comment_ID = $_POST['comment_ID'];
    $user_ID = $_POST['user_ID'];

    $likes;

    $likeButtonHTML;

    if($comment_ID == null){

        $query=$db->prepare('SELECT likes FROM posts WHERE post_ID=?');
        $query->execute([$post_ID]);
        $likes=$query->fetch();

        if($likeStatus){
            likePost($db, $post_ID, $user_ID, $likes['likes']);
            $likes = $likes['likes']+1;
        }
        elseif(!$likeStatus){
            dislikePost($db, $post_ID, $user_ID, $likes['likes']);
            $likes = $likes['likes']-1;
        }
        $likeButtonHTML = displayPostLikeButton($db, $post_ID, $likes);
        unset($_POST);
        unset($likes);
        echo $likeButtonHTML;

    }
    elseif($comment_ID != null){

        $query=$db->prepare('SELECT likes FROM comments WHERE comment_ID=? AND post_ID=?');
        $query->execute([$comment_ID, $post_ID]);
        $likes=$query->fetch();

        if($likeStatus){
            likeComment($db, $post_ID, $comment_ID, $user_ID, $likes['likes']);
            $likes = $likes['likes']+1;
        }
        elseif(!$likeStatus){
            dislikeComment($db, $post_ID, $comment_ID, $user_ID, $likes['likes']);
            $likes = $likes['likes']-1;
        }
        $likeButtonHTML = displayCommentLikeButton($db, $comment_ID, $post_ID, $likes);
        unset($_POST);
        unset($likes);
        echo $likeButtonHTML;
    }

?>