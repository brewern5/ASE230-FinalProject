<?php
session_start();


function isLogged() {
    if(isset($_SESSION['email'])){
        return $_SESSION['email'];
    }
}

function checkFields($x) {
    $error='';
    
    //completeness
    if(!isset($_POST['email'][0])) $error=('You must enter your email');
    if(!isset($_POST['password'][0])) $error=('You must enter your password');
    

    //correctness
    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $error='You must enter a valid email';
    if(strlen($_POST['password'])<8 || strlen($_POST['password'])>16) $error='You must enter a password between 8 and 16 characters';

    //additional checks specifically for sign-up
    if($x == 1) {

        //completeness
        if(!isset($_POST['confirm_password'][0])) $error=('You must confirm your password');
        if(!isset($_POST['name'][0])) $error=('You must enter your name');

        //correctness
        if($_POST['password']!=$_POST['confirm_password']) $error='Your passwords do not match';

    }
   

    return $error;
}

function checkIfInDB($fileName, $email, $password=null) {
    $fp=fopen('users.csv.php', 'r');
    while(!feof($fp)){
        $line=fgets($fp);
        $line=explode(';',$line);
            //must trim the end because there is a newline character
        if(count($line)==2 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
            fclose($fp);
            if(!isset($password)) { return true; }
            return password_verify($password,trim($ine[1]));
        }
    }
    fclose($fp);
    return false;
}

function addUser() {
    
}