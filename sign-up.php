<?php
//SIGNUP
require_once('auth.php');
/*
if(islogged()){
    header('location: index.php');
    die();
} */

$error='';
if(count($_POST)>0){

    $error = checkFields();
    //completnes

    if(strlen($error)==0){
        $fp=fopen('users.csv.php', 'r');
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';',$line);
            
            if(count($line)==3 && $_POST['email']==$line[0]){
                $error='The email is already registered';
                break;
            }
            if(count($line)==3 && $_POST['name']==$line[2]){
                $error='This name is already in use';
                break;
            }
        }
        fclose($fp);
        if(strlen($error)==0){
            //open csv file in append mode
            $fp=fopen('users.csv.php', 'a+');
            fputs($fp,$_POST['email'].';'.password_hash($_POST['password'],PASSWORD_DEFAULT).PHP_EOL);
            fclose($fp);
            header('location: sign-in.php');
            die();
        }
    }
}
?>

<html>
    <head>
    </head>
    <body>
        <h1>Sign Up</h1>
        <?php
        if(strlen($error)>0) echo $error;
        ?>
        <form method="POST">
            <label>EMAIL</label><br>
            <input name='email' type="email" required/>
            <br><br>
            <label>PASSWORD</label>
            <br>
            <input name='password' type="password" required>
            <br><br>
            <label>CONFIRM PASSWORD</label>
            <br>
            <input name='confirmPassword' type="password" required>
            <br><br>
            <button type="submit">SIGN UP</button>
        </form>
    </body>

