<?php

//this page will post the top "review" for each genre that anyone can view

require_once('../auth.php');

//opens json to print post info
$contents=file_get_contents("posts.json");
$blogdata=json_decode($contents,true);


function displayElement($element,$x) {
   

    echo    '<div class="container">
            <div class="row">
                <div class="col-10">
                    <h1><a href="detail.php?x='.$x.'" class="text-decoration-none">'.$element["title"].'</a></h1>
                </div>
                <div class="col-1">
                    <a class="btn button1 me-2" href="edit.php?x='.$x.'" role="button">Edit</a>
                </div>
                <div class="col-1">
                    <a class="btn button2" href="delete.php?x='.$x.'" role="button">Delete</a>
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
       
        <header class="tab">

            <!-- will display user's name if they are logged in -->
            <?php echo displayHeader(); ?>

            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                        <li><a href="../index.php?x=new" class="nav px-2">Home</a></li>
                        <li><a href="index.php?x=new" class="nav px-2">Posts</a></li>
                        <?php if(isset($_SESSION['email'])) echo
                        '<li><a href="myPosts.php?x=ne" class="currentloc nav px-2">My Posts</a></li>
                        <li><a href="create.php" class="nav px-2">Create New Post</a></li>' ?>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="textBox form-control" placeholder="Search..." aria-label="Search">
                    </form>

                    <?php if(isset($_SESSION['email'])) { ?>
                        
                    <!--This shows profile information is the user is in a session-->
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" style="">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href=" sign-out.php">Sign out</a></li>
                        </ul>
                    </div>
                        
                    <!--This shows sign in and sign up buttons if the user is not in a session-->
                    <?php } else { ?>
                        
                    <div class="text-end">
                        <a class="btn button1 me-2" href="sign-in.php" role="button">Login</a>
                        <a class="btn button2" href="sign-up.php" role="button">Sign Up</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </header>

        <?php if(isLogged()) { ?>

        <div class="top mx-5">
            <a class="btn button1 m-2" href="create.php" role="button">create new post</a>
        </div>

        <div class="bottom mx-5 text-center">

            <!--prints most recent for the specific user-->
            <?php 
                for($x=count($blogdata)-1;$x>=0;$x--) {
                    if($blogdata[$x]['author']==$_SESSION['name']) {
                        displayElement($blogdata[$x],$x); 
                    }
                }
            ?>
        </div>

        <?php } else { ?>

            <div class="border border-top-0 rounded-bottom bg-dark mx-5 jumbotron text-center text-white">
                <h1 class="pt-2">You are not signed in</h1>
                <hr />
                <a class="btn btn-info me-2 mb-2" href="../sign-in.php" role="button">Login</a>
                <a class="btn btn-warning mb-2" href="../sign-up.php" role="button">Sign Up</a>
            </div>

        <?php } ?>


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



