<?php
    require_once('../auth.php');
    require_once('post_functions.php');

    function getDateStamp(){
        return date("Y:m:d");
    }
    function getTimeStamp(){
        return date("H:i:s");
    }

    //make it so this checks the user_id with the name in the DB
    function checkOwner($post_id, $x, $isPost=true){
        if($post_id==$_SESSION['id']){
            return 1;
        }
        else {
            return 0;
        }
    }

?>
