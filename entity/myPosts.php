<?php

//this page will post the top "review" for each genre that anyone can view

require_once('../auth.php');
require_once('auth.php');

 function displayElement($element, $post_id) {
          echo    '<div class="container">
                    <div class="row">
                        <div class="col-10">
                            <h1><a href="detail.php?x='.$element[$post_id]['post_ID'].'" class="text-decoration-none">'.$element[$post_id]['title'].'</a></h1>
                        </div>
                        <div class="col-1">
                            <a class="btn btn-info me-2" href="edit.php?x='.$element[$post_id]['post_ID'].'" role="button">Edit</a>
                        </div>
                        <div class="col-1">
                            <a class="btn btn-danger" href="delete.php?x='.$element[$post_id]['post_ID'].'" role="button">Delete</a>
                        </div>
                    </div>
                </div>';

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

            <!-- will display user's name if they are logged in -->
            <?php echo displayNav(); ?>

<!---if(isLogged()){ } --->

        <?php if(isLogged()) { ?>

        <div class="top mx-5">
            <a class="btn button1 m-2" href="create.php" role="button">create new post</a>
        </div>

        <div class="bottom mx-5 text-center">

                <!--prints most recent for the specific user-->
                <?php 
                    require_once('../db.php');
                    $posts = getUserPosts($db);
                    if(!empty($posts)) {
                        for($x=count($posts)-1;$x>=0;$x--) {
                            if($posts[$x]['user_ID'] == $_SESSION['id']) {
                                displayElement($posts,$x); 
                            }
                        }
                    }
                    else {
                        echo "<br><h1>You have no posts.</h1><br>";
                    }
                ?>
            </div>
        </body>

        <div class="container">
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
}else{
    header('location: ../index.php');
    die();
}


