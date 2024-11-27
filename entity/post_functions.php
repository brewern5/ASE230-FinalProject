<?php

function getPost($db, $post_id){
    $query=$db->prepare('SELECT * FROM posts WHERE post_id=?');
    $query->execute([$post_id]);
    $post = $query->fetchAll();

    return $post[0];
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
        $query  ->execute([$tag]);
        $query = $db->prepare('SELECT * FROM tags WHERE tag_title=?');
    } 
    $query->execute([$tag]);
    $tagID = $query->fetch();
    return $tagID['tag_ID'];
}

function displayPic($pic){
    $element;
    if($pic !== null) { 
        $element ='<img style="width:100%;height:100%;" src="'.$pic.'"class="rounded float-left" alt="...">';
    } else { 
        $element = '<img style="width:400px;height: 400px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22861%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20861%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_192771132f5%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A43pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_192771132f5%22%3E%3Crect%20width%3D%22861%22%20height%3D%22250%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22320.5124969482422%22%20y%3D%22144.2%22%3E861x250%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="rounded float-left" alt="Filler Image">';
    }
    return $element;
}

function displayTags($db, $post_id){
    $query=$db->prepare('SELECT * FROM post_tag WHERE post_id=?');
    $query->execute([$post_id]);
    $tagsID = $query->fetchAll();

    $tags='';
    
    foreach($tagsID as $tag){

        $query=$db->prepare('SELECT * FROM tags WHERE tag_id=?');
        $query->execute([$tag['tag_ID']]);
        $tagName = $query->fetch();
        $tags.= $tagName['tag_title'].' ';
    }
    return $tags;
}

function checkPostFields() {

    $error='';

    if(!isset($_POST['title'][0])) $error='You must put a title!';
    if(!isset($_POST['content'][0])) $error='You must write content!';
    if(!isset($_POST['tags'][0])) $error='You must have at least one tag!';

    return $error;

}

function checkTags($tags){

    print_r($tags);


    $tagError = '';
    $tag = substr($tags, 1);

    if(substr($tags, 0, 1) !== "#"){ return 'Tags must start with a "#"!'; }   

    //checks if there is a #, indicating there is another tag, if not it will go onto check the tag
    $pos = strpos($tags, '#', 1);

    if(($pos !== FALSE)) {
        $tag = substr($tags, 1, -($pos));
        $checkTag = substr($tags, $pos);
        $tagError = checkTags($checkTag);
        if(strlen($tagError)>0){ return $tagError; }
    }

    //checks the tag for any banned characters (anything non alphabetical)
    $goodTag = '#';
    for($i = 0; $i < strlen($tag); $i++){
        $tagChar = '';
        $tagChar = substr($tag, $i, 1);
        if(!ctype_alpha($tagChar)){
            break;
        }
        $goodTag .= substr($tagChar, 0);
    }
    return $tagError;
}
function postTags($tags){

    $tagArray = [];
    $result = postTagsHelper($tags).'#';    
    $onOff = true;

    while($onOff){
        $pos = strpos($result, '#', 1);
        $tag = substr($result, 0, $pos);

        array_push($tagArray, $tag);

        $result = substr($result, $pos);

        if(($pos === FALSE)) {
            $onOff = false;
        }
    }
    return $tagArray;
}
function postTagsHelper($tags){

    $result = '';

    $pos = strpos($tags, '#', 1);
    $tag = substr($tags, 1);

    if(($pos !== FALSE)) {
        $tag = substr($tags, 1, -($pos));
        $checkTag = substr($tags, $pos);
        $result = postTagsHelper($checkTag);
    }
    //checks the tag for any banned characters (anything non alphabetical)
    $goodTag = '#';
    for($i = 0; $i < strlen($tag); $i++){
        $tagChar = '';
        $tagChar = substr($tag, $i, 1);
        //  print_r(" ".$tagChar.' ');
        if(!ctype_alpha($tagChar)){
            break;
        }
        $goodTag .= substr($tagChar, 0);
    }
    
    return $goodTag .= $result;

}


?>