<?php
session_start();

require_once('dbfunctions.php');
require_once('db.php');

function isLogged() {
    if(isset($_SESSION['id'])){
        return $_SESSION['id'];
    }
}

//if the user is logged it will display a welcome to the user
function displayHeader(){
    $header='';
    if(isLogged()){
        $header = '<h1> Welcome '.$_SESSION['name'].' to The Metal Detector </h1>';
    }  
    else {
        $header = '<h1> Welcome to The Metal Detector </h1>';
    }
    return $header;
}

function ifPage($pageName, $level) {
    $address=explode('/',$_SERVER['SCRIPT_NAME']);
    if($level == "1" && $pageName == $address['3']) {
        echo "currentloc";
    }
    else if($level == "2" && $pageName == $address['4']) {
        echo "currentloc";
    }
}

//helps the navbar send user to the correct place based on where they currently are
function ifEntity($level) {
    if(str_contains($_SERVER['SCRIPT_NAME'], "/entity") && $level == "1") {
        echo "../";
    }
    else if(!str_contains($_SERVER['SCRIPT_NAME'], "/entity") && $level == "2") {
        echo "entity/";
    }
}

function displayNav(){ ?>
        <header class="tab">

            <!-- will display user\'s name if they are logged in -->
            <?php echo displayHeader(); ?> 

            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                    </a>

                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                        <!--Nav bar buttons-->
                        <li><a href="<?php ifEntity("1"); ?>index.php?x=new" class="<?php ifPage("index.php", "1") ?> nav px-2">Home</a></li>
                        <li><a href="<?php ifEntity("2"); ?>index.php?x=new" class="<?php ifPage("index.php", "2") ?> nav px-2">Posts</a></li>
                        <?php if(isLogged()) { ?>
                            <li><a href="<?php ifEntity("2"); ?>myPosts.php?x=new" class="<?php ifPage("myPosts.php", "2") ?> nav px-2">My Posts</a></li>
                            <li><a href="<?php ifEntity("2"); ?>create.php" class="<?php ifPage("create.php", "2") ?> nav px-2">Create New Post</a></li>
                        <?php }?>
                    </ul>

                    <!--Search Bar-->
                    <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                        <input type="search" class="textBox form-control" placeholder="Search..." aria-label="Search">
                    </form>

                    <?php if(isLogged()) { ?>
                        
                    <!--This shows profile information is the user is in a session-->
                    <div class="dropdown text-end">
                        <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small" style="">
                           <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php ifEntity("1"); ?>sign-out.php">Sign out</a></li>
                        </ul>
                    </div>
                        
                    <!--This shows sign in and sign up buttons if the user is not in a session-->
                    <?php } else { ?>
                       
                    <div class="text-end">
                        <a class="btn button1 me-2" href="<?php ifEntity("1"); ?>sign-in.php" role="button">Login</a>
                        <a class="btn button2" href="<?php ifEntity("1"); ?>sign-up.php" role="button">Sign Up</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </header>
        <?php 
}

//if the user is logged tbe create post and myposts pages will be able to be navigated to
function displayLoggedPost($entity=false){
    if(isLogged() && !$entity){ 
        echo
            '<li><a href="entity/myPosts.php?x=ne" class="nav-link px-2">My Posts</a></li>
            <li><a href="entity/create.php" class="nav-link px-2">Create New Post</a></li>';
    }
    elseif(isLogged() && $entity){
        echo
            '<li><a href="myPosts.php?x=ne" class="nav-link px-2">My Posts</a></li>
            <li><a href="create.php" class="nav-link px-2">Create New Post</a></li>';
    }
}
//if user is not logged in - some options will not display
/*
function displayNav($entity=false){
    if(isLogged() && !$entity) { 
        echo
        '<div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" style="">
               <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href=" sign-out.php">Sign out</a></li>
            </ul>
        </div>';
        } 
    elseif(!isLogged() && !$entity) {
        echo  
            '<div class="text-end">
                <a class="btn btn-info me-2" href="sign-in.php" role="button">Login</a>
                <a class="btn btn-warning" href="sign-up.php" role="button">Sign Up</a>
            </div>';
    }
    elseif(isLogged() && $entity) { 
        echo
        '<div class="dropdown text-end">
            <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
            </a>
            <ul class="dropdown-menu text-small" style="">
               <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href=" ../sign-out.php">Sign out</a></li>
            </ul>
        </div>';
        } 
    elseif(!isLogged() && $entity) {
        echo  
            '<div class="text-end">
                <a class="btn btn-info me-2" href="../sign-in.php" role="button">Login</a>
                <a class="btn btn-warning" href="../sign-up.php" role="button">Sign Up</a>
            </div>';
    }
    
}
*/
//will check login fields and authenticate user
function checkFields($x) {
    $error='';
    
    //completeness
    if(!isset($_POST['email'][0])) $error=('You must enter your email');
    if(!isset($_POST['password'][0])) $error=('You must enter your password');
    //if(!isset($_POST['confirm_password'][0])) $error=('You must confirm your password');


    //correctness
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $error='You must enter a valid email';
    if(strlen($_POST['password'])<8 || strlen($_POST['password'])>16) $error='You must enter a password between 8 and 16 characters';

    //additional checks specifically for sign-up
    if($x == 1) {

        //completeness
        if(!isset($_POST['confirm_password'][0])) $error=('You must confirm your password');
        if(!isset($_POST['firstname'][0])) $error=('You must enter your first name');
        if(!isset($_POST['lastname'][0])) $error=('You must enter your last name');

        //correctness
        if($_POST['password']!=$_POST['confirm_password']) $error='Your passwords do not match';

    }
    return $error;
}

//assisting logging in user
function checkIfInDB($user, $email, $password) {   

    print_r($user);

    if($user == null){
        return false;
    }
    else{
        return password_verify($password, $user['password']);
    }
    return false;
        
}

//displays most recent DB
function displayRecent($db){

    $query=$db->prepare('SELECT * FROM posts ORDER BY timestamp DESC LIMIT 10');
    $query->execute([]);
    $posts=$query->fetchAll();
    return $posts;

}

?>