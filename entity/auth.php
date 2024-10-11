<?php
    require_once('../auth.php');

    function getDateStamp(){
        return date("Y:m:d");
    }
    function getTimeStamp(){
        return date("H:i:s");
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

    function checkOwner($blogdata, $x){
        if($blogdata==$_SESSION['name']){
            echo'   <div class="container">
                        <div class="row">
                            <div class="col-sm-2">
                                <a class="btn btn-info me-2" href="edit.php?x='.$x.'" role="button">Edit</a>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-danger" href="delete.php?x='.$x.'" role="button">Delete</a>
                            </div>
                        </div>
                    </div>';
        }
    }
?>
