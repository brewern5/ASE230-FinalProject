<?php
session_start();

function isLogged() {
    //checks if user is logged.
    return isset($_POST['email']);
}

function checkFields() {
    //returns true or false

    $error='';

    //completeness
    if(!isset($_POST['email'][0])) $error=('You must enter your email');
    if(!isset($_POST['password'][0])) $error=('You must enter your password');
    if(!isset($_POST['confirm_password'][0])) $error=('You must confirm your password');

    //correctness
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $error='You must enter a valid email';
    if(strlen($_POST['password'])<8 || strlen($_POST['password'])>16) $error='You must enter a password between 8 and 16 characters';
    if($_POST['password']!=$_POST['confirm_password']) $error='Your passwords do not match';

    return $error;
}


//sign up and sign out
function checkIfInDb($file,$email,$password=null) {
    $fp=fopen('data.csv.php','r');
        while(!feof($fp)) {
            $line=fgets($fp);
            $line=explode(';',$line);
            if(count($line)==2 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))) {
                $_SESSION['email']=$line[0];
                header('location: index.php');
                die();
            }
        }
        fclose($fp);
        $error='Your credentials are wrong';

}

function addUser($email,$password) {
    //saves user into data base
}



?>