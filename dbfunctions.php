<?php
require_once('db.php');

function getPostID($db, $title){
    $query=$db->prepare('SELECT post_ID FROM posts WHERE title=?');
    $query->execute([$title]);
    $post = $query->fetch();
    return $post['post_ID'];
}
function getUserByID($db, $user_id){

}

function getUserPosts($db){
    $query=$db->prepare('SELECT * FROM posts WHERE user_ID=?');
    $query->execute([getUserId($db)]);
    $posts=$query->fetchAll();
    return $posts;
}

function getUserID($db) {

    $query = $db->prepare('SELECT ID FROM users WHERE email=?');
    $query->execute([$_SESSION['email']]);
    $user = $query->fetch();
    return $user['ID'];
}

?>