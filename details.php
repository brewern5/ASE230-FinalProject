<?php
require_once('auth.php');

//opening json to print page
$contents=file_get_contents("posts.json");
$blogdata=json_decode($contents,true);

//getting id of page
$post_id=$_GET['x'];

//------counting views of this page-----//
//reading elements
$fp=fopen('visitors.csv','r');
$i=0;
$tempR = [];
while(! feof($fp)) {
  $temp = fgets($fp);
  if(explode(';',$temp)[0] == $post_id){
    $tempR[$i]=$post_id.';'.(explode(';',$temp)[1]+1).PHP_EOL;
  }
  else {
    $tempR[$i]=$temp;
  }
  $i++;
}
fclose($fp);

//writing elements
$fp=fopen('visitors.csv','w');
  for($i=0;$i<count($tempR);$i++) {
    fputs($fp,$tempR[$i]);
  }
fclose($fp);

?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


    </head>
    <body>

        <header>    <!-- will display user's name if they are logged in -->
            <?php if(isset($_SESSION['email'])) echo '<h1> Welcome '.$_SESSION['email'].' to **Insert Site Name Here** </h1>';
                  else echo '<h1> Welcome to **Insert Site Name Here** </h1>'; ?>
        </header>
        
        <header class="p-3 mb-3 border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                        <li><a href="index.php" class="nav-link px-2">Home</a></li>
                        <li><a href="detail.php" class="nav-link px-2">Posts</a></li>
                        <li><a href="post.php" class="nav-link px-2">My Posts</a></li>
                    </ul>

                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
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
                            <li><a class="dropdown-item" href="sign-out.php">Sign out</a></li>
                        </ul>
                    </div>
                        
                    <!--This shows sign in and sign up buttons if the user is not in a session-->
                    <?php } else { ?>
                       
                    <div class="text-end">
                        <a class="btn btn-outline-dark me-2" href="sign-in.php" role="button">Login</a>
                        <a class="btn btn-warning" href="sign-up.php" role="button">Sign Up</a>
                    </div>
                        
                        
                        
                    <?php } ?>
                </div>
            </div>
        </header>


        <div class="jumbotron text-center">
            <h1><?php echo $blogdata[$post_id]['title'] ?></h1>
            <hr>
            <h3>
                <?php echo $blogdata[$post_id]['content'] ?>
            </h3>
            <h5>
                <?php //prints visitor count
                    $fp=fopen('visitors.csv','r');
                    while(! feof($fp)) {
                        $temp = fgets($fp);
                        if(explode(';',$temp)[0] == $post_id){
                            echo 'Views: '.(explode(';',$temp)[1]).'<br />';
                        }
                    }
                    fclose($fp);
                ?>
                <?php echo $blogdata[0]['author'].' - '.$blogdata[0]['date'] ?>
            </h5>
        </div>



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