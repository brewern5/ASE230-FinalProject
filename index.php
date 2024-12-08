<?php

//this page will post the top "review" for each genre that anyone can view
require_once('auth.php');

//variable that keeps track of the sort order: newest, popular, and maybe their reverse. filter will filter by genre.
$sortOrder='newest';
$filter='none';

function displayElement($db, $posts) {

    foreach($posts as $post){

        $tags = getTagsByPostID($db, $post['post_ID']);
        $user_id = getUserID($db, $post['post_ID']);

        echo 
        '
        <hr>
        <div class="cotainer">
            <div class="row">
                <h1 class="col-sm-5 width-20%">
                        <a href="entity/detail.php?x='.$post['post_ID'].'" class="text-decoration-none">'.$post["title"].'</a>
                </h1>
                <p class = col-sm-2>'; foreach($tags as $tag) {echo $tag." ";} echo '</p>
                <h5 class="col-sm-4 width-20%">
                    <a href="" class="text-decoration-none">By: '.$user_id.'</a>
                </h5>
            </div>
        </div>
        <hr>
        ';  
    }
}
?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel = "stylesheet" href="format.css">
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </head>
    <body>

        <!--Displays the nav bar, function is in auth-->
        <?php echo displayNav(); ?>

        <div class="tab">
            <ul class="nav py-3">
                <li class="tab px-3">Sort:</li>

                <!---makes it so the currentloc changes when the user changes page--->
                <?php if(empty($_GET) || $_GET['x'] == "new" ) { ?>
                    <li><a class="tab currentloc nav px-2" href="index.php?x=new">New</a></li>
                    <li><a class="tab nav px-2" href="index.php?x=popular">Popular</a></li>
                <?php } else {?>
                    <li><a class="tab nav px-2" href="index.php?x=new">New</a></li>
                    <li><a class="tab currentloc nav px-2" href="index.php?x=popular">Popular</a></li>
                <?php } ?>

            </ul>
        </div>

        <br>

        <div class="tab text-center">

            <?php 
            require_once('db.php');
            displayElement($db, displayRecent($db));
            ?>
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

