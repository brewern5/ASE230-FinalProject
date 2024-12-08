<?php

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

    $tagError = '';
    $tag = substr($tags, 1);

    //checks if the first entered tag has a #
    if(substr($tags, 0, 1) !== "#"){ return 'Tags must start with a "#"!'; }   

    //checks if there is another #, indicating there is another tag.
    $pos = strpos($tags, '#', 1);

    //If there is another tag, it will cut the string to the found # and then recursivly send the remaining tags to get checked
    if(($pos !== FALSE)) {
        $tag = substr($tags, 1, -($pos));
        $checkTag = substr($tags, $pos);
        $tagError = checkTags($checkTag);
        if(strlen($tagError)>0){ return $tagError; }
    }

    //checks the individual tag for any banned characters (anything non alphabetical)
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
    $result = postTagsHelper($tags);  

    $onOff = true;
    $lastTag = false;

    while($onOff){ 
        $pos = strpos($result, '#', 1);
        //if this is a boolean then that means it is on the last tag
        if($pos == null){
            $tag = substr($result, 0);
        }
        else{
            $tag = substr($result, 0, $pos);
        }
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
        $tag = substr($tags, 1, -($pos - 1));
        $checkTag = substr($tags, $pos);
        $result = postTagsHelper($checkTag);
    }

    return "#" . $tag . $result;

}

function displayComments($db, $post_ID, $viewAll=false){

    $query=$db->prepare('SELECT * FROM comments WHERE post_ID=?');
    $query->execute([$post_ID]);

    $comments = $query->fetchAll();

    if($comments != null){

        $displayAmount = 5;
        if(count($comments)< $displayAmount){
            $displayAmount=count($comments);
        }
        else if($viewAll){
            $displayAmount = count($comments);
        }

        for($i = 0; $displayAmount > $i; $i++){
            
            echo'
            <div class="tab mx-5 p-2">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <img src="https://placehold.co/40x40">
                        </div>
                        <div class="col-2"> 
                            <p>'.$comments[$i]['username'].'<p>
                        </div>
                        <div class="col-8">
                            <p>'.$comments[$i]['content'].'</p>
                        </div>
                        <div id="commentLikeDiv_Comment'.$comments[$i]['comment_ID'].'" class="col-1">
                            '.displayCommentLikeButton($db, $comments[$i]['comment_ID'], $post_ID, $comments[$i]['likes']).'
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
    else{
        echo'
        <div class="border rounded bg-dark mx-5 p-2 jumbotron text-white">
            <div class="container">
                <div class="row">
                    <h3 class="text-center">There is no comments on this post</h3>
                </div>
            </div>
        </div>';   
    }

}

function displayPostLikeButton($db, $post_ID, $likes){

    $liked = checkPostLikeStatus($db, $post_ID);

    if(!$liked){
        $like = '
        <form method="POST">
            <button type="button" class="btn notLike" id="postLike" name="postLike" onclick="changeLikeStatusPost(true);">Like</button>
        </form>';
    }
    else if($liked){
        $like = '
        <form method="POST">
            <button type="button" class="btn button1" id="postDislike" name="postDislike" onclick="changeLikeStatusPost(false);">Unlike</button>
        </form>';
    }
    return '
        <div class="col-4 text-left">
             <p> Likes : '.$likes.' </p>
        </div>'
        .$like;
}
function displayCommentLikebutton($db, $comment_ID, $post_ID, $likes){
    $liked = checkCommentLikeStatus($db, $comment_ID);
    if(!$liked){
        $like = '
        <form method="POST">
            <button type="button" class="btn notLike" id="commentLike" name="commentLike" onclick="changeLikeStatusComment(true, '.$comment_ID.')">Like</button>
        </form>';
    }
    else if($liked){
        $like = '
        <form method="POST">
            <button type="button" class="btn button1" id="commentDislike" name="commentDislike" onclick="changeLikeStatusComment(false, '.$comment_ID.')">Unlike</button>
        </form>';
    }
    return 
        $like.' 
        <p>'.$likes.'</p>';
}