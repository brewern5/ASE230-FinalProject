<?php
    require_once('auth.php');
    //this will be where the post is created
    //the name/user, date, time, will automatically be collected through the session
    //the user will have fourth input fields, three of which are required. These three being:
    // 'Title', 'content', and at least one tag.
    //the third field will be an optional single image upload(for now).

    //will need to create a new field in posts.json.php with all the include attributes
      
    if(strlen(isLogged())>0){
        $error='';

        if(count($_POST)>0){

            $error = checkPostFields();

            $json = file_get_contents('posts.json');
            $tempArray = json_decode($json, true);

            $jsonArray = 
            [
                'title' => '',
                'content' => '',
                "picture" => '',
                "band" => '',
                "album" => '',
                "song" => '',
                'author' => '',
                'time' => [
                    'date' => '',
                    'timeStamp' => ''
                ],
                'tags'=> [
                    0 => ''
                ],
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

            $error = checkTags($_POST['tags']);
            if(strlen($error) == 0){

                $jsonArray['title'] = $_POST['title'];
                $jsonArray['content'] = $_POST['content'];
                $jsonArray['picture'] = $_POST['picture'];    
                $jsonArray['band'] = $_POST['band'];                
                $jsonArray['album'] = $_POST['album'];
                $jsonArray['song'] = $_POST['song'];
                $jsonArray['author'] = $_SESSION['name'];
                $jsonArray['tags'] = postTags($_POST['tags']);
                    

                $jsonArray['time']['date'] = date("Y:m:d");
                $jsonArray['time']['timeStamp'] = date("H:i:s");

                array_push($tempArray, $jsonArray);

                $jsonData = json_encode($tempArray, JSON_PRETTY_PRINT);

                file_put_contents('posts.json', $jsonData);
            header("location: myPosts.php?x=new");
            die();
            }
        }
        
?>

<html>
    <head>
        <link rel= "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel = "stylesheet" href="../format.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </head>

    <body>        

        <!--Displays the nav bar, function is in auth-->
        <?php echo displayNav(); ?>
        
        <div class="tab mx-5 text-center">
            <h1 class="pt-2">Create Post</h1>
            <?php
                if(strlen($error) > 0) {echo '<h4 class="text-warning">'.$error.'</h4><br>';}
            ?>
            <form method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col">
                            <label>Title</label><br>
                            <input class="textBox border border-dark" name='title' type="text" required/>
                            <br><br>
                            <label>Band Name</label><br>
                            <input class="textBox border border-dark" name='band' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col">
                            <label>Album Name</label><br>
                            <input class="textBox border border-dark" name='album' type="text" required/>
                            <br><br>
                            <label>Song Name</label><br>
                            <input class="textBox border border-dark" name='song' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
                <label>Picture address(optional)</label><br>
                <input Style="width:407px;" class="textBox border border-dark" name='picture' type="text" />
                <br><br>
                <label>Write your post</label><br>
                <textarea style="width:800px;height:200px" class="textBox border border-dark" name='content' type="text" required></textarea>
                <br><br>
                <label>Add tag(s)</label><br>
                <input class="textBox border border-dark" name='tags' type="text" required/>
                <br><br>
                <button class="btn button2" type="submit">Post</button>
            </form>
        </div>
    </body>

    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0">© 2024 Nate Brewer & Danny Poff</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" src="/images/twitter.svg/"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
            </ul>
        </footer>
    </div>
</html>
<?php
    }
    else{
        location("header: index.php");
    }