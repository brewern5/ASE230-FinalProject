<?php
    require_once('auth.php');
    //this will be where the post is created
    //the name/user, date, time, will automatically be collected through the session
    //the user will have fourth input fields, three of which are required. These three being:
    // 'Title', 'content', and at least one tag.
    //the third field will be an optional single image upload(for now).

    //will need to create a new field in posts.json.php with all the include attributes
    /*
    "title":"", 
    "content":"", 
    "author":"", 
    "time":[
        {
            "date":"",
            "time":""
        }
    ],
    "tags":[ "", "" ],
    "likes":int,
    "comments":[
        {
            "user":"",
            "date":"",
            "commentContent":"",
            "likes":
        }
    ]     
    */

    //date("Y-m-d")

    //date("H:i:s")

    $error = checkPostFields();

    if(count($_POST)>0){

        $json = file_get_contents('posts.json');
        $tempArray = json_decode($json, true);

        $jsonArray = 
        [
            'title' => '',
            'content' => '',
            'author' => '',
            'time' => [
                'date' => getDateStamp(),
                'timeStamp' => getTimeStamp()
            ],
            'tags'=> [],
            'likes' => 0,
            'comments'=> [
                'numOfComments' => 0,
                'comment' => [
                    'user'=> '',
                    'date' => '',
                    'commentContent' => '',
                    'likes' => 0
                ]
            ]
        ];

        if(strlen($error) == 0){
            $jsonArray['title'] = $_POST['title'];
            $jsonArray['content'] = $_POST['content'];
            $jsonArray['tags'] = $_POST['tags'];

            $jsonArray['time']['date'] = date("Y:m:d");
            $jsonArray['time']['timeStamp'] = date("H:i:s");

            array_push($tempArray, $jsonArray);

            $jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

            file_put_contents('posts.json', $jsonData);
        }
    }
?>

<html>
    <head>
        <link rel= "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </head>
    <body>
        <h1>Create Post</h1>
        <?php
        if(strlen($error) > 0) echo $error;
        ?>
        <form method="POST">
            <label>Title</label><br>
            <input class="border border-dark" name='title' type="text" required/>
            <br><br>
            <label>Write your post</label><br>
            <input class="border border-dark" name='content' type="text" required/>
            <br><br>
            <label>Add tag(s)</label><br>
            <input class="border border-dark" name='tags' type="text" required/>
            <br><br>
            <button class="btn btn-warning text-dark" type="submit">Post</button>
        </form>
    </body>
</html>
