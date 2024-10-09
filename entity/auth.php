
<?php
    require_once('../auth.php');

    function getDateStamp(){
        return date("Y:m:d");
    }
    function getTimeStamp(){
        return date("H:i:s");
    }

    function checkPostFields() {

        $error=' ';

        if(!isset($_POST['title'][0])) $error='You must put a title!';
        if(!isset($_POST['content'][0])) $error='You must write content!';
        if(!isset($_POST['tags'][0])) $error='You must have at least one tag!';

        return $error;

    }

?>
