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

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </head>
    <body class="bg-secondary">

        <header class="p-3 mb-3 border-bottom bg-dark text-white rounded-bottom">

            <!-- will display user's name if they are logged in -->
            <?php echo '<h1> Welcome '.$_SESSION['name'].' to **Insert Site Name Here** </h1>' ?>

            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                        <li><a href="../index.php?x=new" class="nav-link px-2">Home</a></li>
                        <li><a href="index.php?x=new" class="nav-link px-2">Posts</a></li>
                        <li><a href="myPosts.php?x=new" class="nav-link px-2">My Posts</a></li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>
                        
                    <!--This shows profile information is the user is in a session-->
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" style="">
                           <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../sign-out.php">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        
        <div class="border rounded bg-dark mx-5 jumbotron text-center text-white">
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
                            <input class="border border-dark" name='title' type="text" required/>
                            <br><br>
                            <label>Band Name</label><br>
                            <input class="border border-dark" name='band' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col">
                            <label>Album Name</label><br>
                            <input class="border border-dark" name='album' type="text" required/>
                            <br><br>
                            <label>Song Name</label><br>
                            <input class="border border-dark" name='song' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
                <label>Picture address(optional)</label><br>
                <input Style="width:407px;" class="border border-dark" name='picture' type="text" />
                <br><br>
                <label>Write your post</label><br>
                <textarea style="width:800px;height:200px" class="border border-dark" name='content' type="text" required></textarea>
                <br><br>
                <label>Add tag(s)</label><br>
                <input class="border border-dark" name='tags' type="text" required/>
                <br><br>
                <button class="btn btn-warning text-dark" type="submit">Post</button>
            </form>
        </div>
    </body>

    <div class="container bg-secondary">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0 text-white">© 2024 Nate Brewer & Danny Poff</span>
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