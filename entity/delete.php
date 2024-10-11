<?php
    require_once('auth.php');

    echo '1';
      
    if(strlen(isLogged())>0){

        //opening json
        $contents=file_get_contents("posts.json");
        $blogdata=json_decode($contents,true);

        echo '3';

        $post_id=$_GET['x'];

        $tempArray = [];
            for($i=0;$i<count($blogdata);$i++) {
                echo '4';
                if($i != $post_id)
                    array_push($tempArray, $blogdata[$i]);
            }


            $jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

            file_put_contents('posts.json', $jsonData);
            header('location: myPosts.php?x=new');
            die();
    }

?>