<?php

//cookies 
//setcookie('firstname','Danny');
//setcookie('lastname','Poff');
//setcookie('age','20');
//
//echo '<pre>';
//print_r($_COOKIE);
//
//echo '<h1>'.$_COOKIE['firstname'].'<h1>';

//sessions
session_start();

if(isset($_SESSION['email'])) echo 'Welcome '.$_SESSION['email'].'. <a href="signout.php">Click here to sign out</a>';
else echo 'GO AWAY. If you know your credentials <a href="auth.php">Click here</a>';

//session_destroy();

?>