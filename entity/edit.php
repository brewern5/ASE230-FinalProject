<?php

    require_once('auth.php');

    if(strlen(isLogged())>0){
        $error='';

        require_once('../db.php');
        require_once('post_functions.php');
        require_once('../dbfunctions.php');

        $post_id=$_GET['x'];

        //displays current post info
        $query=$db->prepare('SELECT * from posts WHERE post_ID=?');
        $query->execute([$post_id]);
        $post=$query->fetch();

        //displays tags already associated with the post
        $tags=getTagsByPostID($db, $post_id);

        if(count($_POST)>0){
            $error = checkPostFields();

            //will check the new tags if they are able to be added
            $error = checkTags($_POST['tags']);
            if(strlen($error) == 0){
                
                $query=$db->prepare(
                    'UPDATE posts set 
                    title=?,
                    content=?,
                    picture=?,
                    band=?,
                    album=?,
                    song=?
                    WHERE post_ID=?'
                );
                $query->execute(
                    [
                        $_POST['title'],
                        $_POST['content'],
                        $_POST['picture'],
                        $_POST['band'],
                        $_POST['album'],
                        $_POST['song'],
                        $post_id
                    ]
                );

                $post_id = getPostID($db, $_POST['title']); 

                $tagArray = postTags($_POST['tags']);

                foreach($tagArray as $tag){
                    $var = checkPostTags($db, $tag, $post_id);
                    
                    if(checkPostTags($db, $tag, $post_id) != 1){
                        $newTagID = createNewTag($db, $tag);
                        $query = $db->prepare('INSERT INTO post_tag(post_ID, tag_ID) VALUES(?, ?)');
                        $query->execute([$post_id, $newTagID]);
                    }
                }

                header('location: detail.php?x='.$_GET['x']);
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
            <h1 class="pt-2">Edit Post</h1>
            <div class="error"> 
                <?php
                    if(strlen($error) > 0) {echo $error;}
                ?>
            </div>
            <form method="POST">
                <div class="container">
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col">
                            <label>Title</label><br>
                            <input value="<?php echo $post['title']; ?>"class="border border-dark" name='title' type="text" required/>
                            <br><br>
                            <label>Band Name</label><br>
                            <input value="<?php echo $post['band']; ?>"class="border border-dark" name='band' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col">
                            <label>Album Name</label><br>
                            <input value="<?php echo $post['album']; ?>" class="border border-dark" name='album' type="text" required/>
                            <br><br>
                            <label>Song Name</label><br>
                            <input value="<?php echo $post['song']; ?>" class="border border-dark" name='song' type="text" required/>
                            <br><br>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
                <label>Picture address(optional)</label><br>
                <input value="<?php echo $post['picture']; ?>" Style="width:407px;" class="border border-dark" name='picture' type="text" />
                <br><br>
                <label>Write your post</label><br>
                <textarea style="width:800px;height:200px" class="border border-dark" name='content' type="text" required>
                    <?php echo $post['content']; ?>
                </textarea>
                <br><br>
                <label>Add tag(s) - Need to Start With a '#'</label><br>
                <input value="<?php foreach ($tags as $tag){echo $tag;} ?>" class="border border-dark" name='tags' type="text" required/>
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
        header("location: index.php");
        die();
    }  
?>