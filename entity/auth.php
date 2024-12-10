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
            return'   <div class="container">
                        <div class="row">
                            <div class="col-sm-7">
                                <a class="btn button1 me-2" href="edit.php?x='.$x.'" role="button">Edit</a>
                            </div>
                            <div class="col-sm-4">
                                <a class="btn button2" href="delete.php?x='.$x.'" role="button">Delete</a>
                            </div>
                        </div>
                    </div>';
        }
    }

?>
