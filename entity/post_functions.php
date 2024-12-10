<?php

function displayPic($pic){
    $element;
    if($pic != '') { 
        $element ='<img style="width:100%;height:100%;" src="'.$pic.'"class="rounded float-left" alt="...">';
    } else { 
        $element = '<img style="width:400px;height: 400px;" src="https://placehold.jp/400x400.png" class="rounded float-left" alt="Filler Image">';
    }
    return $element;
}

function displayTags($db, $post_id){
    $query=$db->prepare('SELECT tag_ID FROM post_tag WHERE post_id=?');
    $query->execute([$post_id]);
    $tagsID = $query->fetchAll();

    $tags='';
    
    foreach($tagsID as $tag){

        $query=$db->prepare('SELECT tag_title FROM tags WHERE tag_id=?');
        $query->execute([$tag['tag_ID']]);
        $tagName = $query->fetch();
        $tags .= $tagName['tag_title'].' ';
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