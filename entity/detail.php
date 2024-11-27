<?php
require_once('auth.php');
require_once('../db.php');
require_once('post_functions.php');

$post_id=$_GET['x'];

function displayElement($db, $post_id) {
     
    $post = getPost($db, $post_id);

    $pic = displayPic($post['picture']);

    $tags = displayTags($db, $post_id);
    
    checkOwner($post['user_ID'], $post_id);
   
    echo '
        <div class="border rounded bg-dark mx-5 p-2 jumbotron text-white">
            <div class="row">
                <div class="col-5">
                    '.displayPic($pic).'
                </div>
                
                <div class="col-7 text-center">
                    <h1 class="">'.$post['title'].'</h1>
                    <h3 class="">Band:'.$post['band'].' || Album: '.$post['album'].'</h3>
                    <p>Song: '.$post['song'].'</p>
                    <p>Tag(s): '.$tags.' <p>
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="row">
                    <h3 class="text-center">
                        '.$post['content'].'
                    </h3>
                </div>
            </div>
        </div>';
}
?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


    </head>
    <body class="bg-secondary">        
        <header class="p-3 mb-3 border-bottom bg-dark text-white rounded-bottom">

            <!-- will display user's name if they are logged in -->
            <?php $header = displayHeader(); ?>
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                        <li><a href="../index.php?x=new" class="nav-link px-2">Home</a></li>
                        <li><a href="index.php?x=new" class="nav-link px-2">Posts</a></li>
                        
                        <?php displayLoggedPost(true); ?>

                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
                    </form>

                    <?php displayNav(true)?>
                </div>
            </div>
        </header>

        <?php displayElement($db, $post_id) ?>

        <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0 text-body-secondary">© 2024 Nate Brewer & Danny Poff</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" src="/images/twitter.svg/"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
            </ul>
        </footer>
    </div>
</html>