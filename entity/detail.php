<?php
require_once('auth.php');
require_once('../db.php');
require_once('post_functions.php');

$post_id=$_GET['x'];

function displayElement($db, $post_id) {
     
    $post = getPost($db, $post_id);

    $pic = displayPic($post['picture']);

    $tags = displayTags($db, $post_id);

    echo '
        <div class="tab mx-5 p-2">
            <div class="row">
                <div class="col-5">
                    '.$pic.'
                </div>
                
                <div class="col-7 text-center">
                    <h1 class="">'.$post['title'].'</h1>
                    <h3 class="">Band: '.$post['band'].' || Album: '.$post['album'].'</h3>
                    <p>Song: '.$post['song'].'</p>
                    <p>Tag(s): '.$tags.' <p>
                    '.(strlen(isLogged()) > 0 ? checkOwner($post['user_ID'], $post_id) : null).'
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <h4 class="text-center">
                        '.$post['content'].'
                    </h4>
                </div>
                <hr>
                <div>
                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                                <p> Comments : 2 </p>
                            </div>
                            <div class="col-2 text-left">
                                <p> Likes : '.$post['likes'].' </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-10">
                        <form method="POST">
                            <div class="row">
                                <div class="col-3">
                                    <label>Comment on this post:</label><br>
                                </div>
                                <div class="col-7">
                                    <textarea style="width:500px;height:55px" class="border border-dark" name="comment" type="text" required/></textarea>
                                </div>
                                <div class="col-1">
                                    <button class="btn button2 text-dark" type="submit">Post</button>
                                </div>
                            </div>
                        </form>  
                    </div>
                    <div class="col-2">
                        '.displayPostLikebutton($db, $post_id, $post['likes']).'
                    </div>
                </div>
            </div>
            <hr>
        </div>';
        displayComments($db, $post_id);
}

if(count($_POST)>0){

    require_once('../dbfunctions.php');

    createComment($db, $post_id, $_POST['comment']);

    header('location: detail.php?x='.$post_id);

}

?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel = "stylesheet" href="../format.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


    </head>
    <body>        
       
        <!--Displays the nav bar, function is in auth-->
        <?php echo displayNav(); ?>

        <?php displayElement($db, $post_id) ?>

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
    </body>
</html>