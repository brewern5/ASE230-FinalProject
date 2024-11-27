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
    echo $header;
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
    elseif(!isLogged()) {
        echo  
            '<div class="text-end">
                <a class="btn btn-info me-2" href="sign-in.php" role="button">Login</a>
                <a class="btn btn-warning" href="sign-up.php" role="button">Sign Up</a>
            </div>';
    }
    if(isLogged() && $entity) { 
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
    elseif(!isLogged()) {
        echo  
            '<div class="text-end">
                <a class="btn btn-info me-2" href="../sign-in.php" role="button">Login</a>
                <a class="btn btn-warning" href="../sign-up.php" role="button">Sign Up</a>
            </div>';
    }
    
}

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
function checkIfInDB($user, $email, $password=null) {   

    print_r($user);

    if(password_verify($password, $user[0]['password'])){
        return true;
    }
    return false;
        
    /*
    $fp=fopen('users.csv.php', 'r');
    while(!feof($fp)){
        $line=fgets($fp);
        $line=explode(';',$line);
            //must trim the end because there is a newline character
        if(count($line)==3 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
            fclose($fp);
            if(!isset($password)) { return true; }
            return password_verify($password,trim($line[1]));
        }
    }
    fclose($fp);
    return false;
    */
}

//displays most recent DB
function displayRecent($db){

    $query=$db->prepare('SELECT * FROM posts ORDER BY timestamp DESC LIMIT 10');
    $query->execute([]);
    $posts=$query->fetchAll();
    return $posts;

}

?>