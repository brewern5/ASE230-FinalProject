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

?>