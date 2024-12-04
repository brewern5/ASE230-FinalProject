<?php
require_once('db.php');

function getPostID($db, $title){
    $query=$db->prepare('SELECT post_ID FROM posts WHERE title=?');
    $query->execute([$title]);
    $post = $query->fetch();
    return $post['post_ID'];
}

function getUserID($db, $post_ID){
    $query=$db->prepare('SELECT user_ID FROM posts WHERE post_ID=?');
    $query->execute([$post_ID]);
    $user_ID = $query->fetch();
    $query=$db->prepare('SELECT firstname FROM users WHERE user_ID=?');
    $query->execute([$user_ID['user_ID']]);
    $username = $query->fetch();
    
    return $username['firstname'];
}

function getUserPosts($db){
    $query=$db->prepare('SELECT * FROM posts WHERE user_ID=?');
    $query->execute([$_SESSION['id']]);
    $posts=$query->fetchAll();
    return $posts;
}

function getPost($db, $post_id){
    $query=$db->prepare('SELECT * FROM posts WHERE post_id=?');
    $query->execute([$post_id]);
    $post = $query->fetchAll();

    return $post[0];
}

function getTagsByPostID($db, $post_id){
    $tagName = [];
    $query=$db->prepare('SELECT tag_ID FROM post_tag WHERE post_ID=?');
    $query->execute([$post_id]);
    $tag_id=$query->fetchAll();


    foreach($tag_id as $tag){
        $query=$db->prepare('SELECT tag_title FROM tags WHERE tag_ID=?');
        $query->execute([$tag['tag_ID']]);
        $tagName[] = $query->fetchColumn();
    }
    return $tagName;
}
/*
 *  Will check if a tag is already in the data base and return the tag_ID, 
 *  if there is no tag in the DB then a new one will be made with a new id.
*/
function checkTagDB($db, $tag) {

    $query = $db->prepare('SELECT * FROM tags WHERE tag_title=?');
    $query->execute([$tag]);
    if(count($query->fetchAll()) < 1){
        $query = $db->prepare('INSERT INTO tags(tag_title) VALUES(?)');
        $query->execute([$tag]);
        $query = $db->prepare('SELECT * FROM tags WHERE tag_title=?');
    } 
    $query->execute([$tag]);
    $tagID = $query->fetch();
    return $tagID['tag_ID'];
}

function checkPostLikeStatus($db, $post_ID){
    if(strlen(isLogged())>0){
        $query=$db->prepare('SELECT * FROM post_likes WHERE post_ID=? AND user_ID=?');
        $query->execute([$post_ID, $_SESSION['id']]);

        $liked = $query->fetch();
        if($liked == null){
            return false;
        }
        return true;
    }
    return false;
}
function likePost($db, $post_ID, $likes){
    $query=$db->prepare('UPDATE posts set likes=? WHERE post_ID=?');
    $query->execute([$likes+1, $post_ID]);

    $query=$db->prepare('INSERT INTO post_likes(post_ID, user_ID) VALUES(?, ?)');
    $query->execute([$post_ID, $_SESSION['id']]);
}
function dislikePost($db, $post_ID, $likes){
    $query=$db->prepare('UPDATE posts set likes=? WHERE post_ID=?');
    $query->execute([$likes-1, $post_ID]);

    $query=$db->prepare('DELETE FROM post_likes WHERE post_ID=? AND user_ID=?');
    $query->execute([$post_ID, $_SESSION['id']]);
}

function checkCommentLikeStatus($db, $comment_ID){
    if(strlen(isLogged())>0){
        $query=$db->prepare('SELECT * FROM comment_likes WHERE comment_ID=? AND user_ID=?');
        $query->execute([$comment_ID, $_SESSION['id']]);

        $liked = $query->fetch();
        if($liked == null){
            return false;
        }
        return true;
    }
    return false;
}
function likeComment($db, $comment_ID, $likes){
    $query=$db->prepare('UPDATE comments SET likes=? WHERE comment_ID=?');
    $query->execute([$likes+1, $comment_ID]);

    $query=$db->prepare('INSERT INTO comment_likes(comment_ID, user_ID) VALUES(?, ?)');
    $query->execute([$comment_ID, $_SESSION['id']]);
}
function dislikeComment($db, $comment_ID, $likes){
    $query=$db->prepare('UPDATE comments SET likes=? WHERE comment_ID=?');
    $query->execute([$likes-1]);

    $query=$db->prepare('DELETE * FROM comment_likes WHERE comment_ID=? AND user_ID=?');
    $query->execute([$comment_ID, $_SESSION['id']]);
}

function createComment($db, $post_ID, $comment){
    $query=$db->prepare('INSERT INTO comments(post_ID, user_ID, content) VALUES(?, ?, ?)');
    $query->execute([$post_ID, $_SESSION['id'], $comment]);


}

?>