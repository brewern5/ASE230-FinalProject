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

    //$error = checkFields();
    //completness
    $error='';

    if(strlen($error)==0){
        $fp=fopen('users.csv.php', 'r');
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';',$line);
            
            if(count($line)==2 && $_POST['email']==$line[0]){
                $error='The email is already registered';
                break;
            }
        }
        fclose($fp);
        if(strlen($error)==0){
            //open csv file in append mode
            $fp=fopen('users.csv.php', 'a+');
            fputs($fp,$_POST['email'].';'.password_hash($_POST['password'],PASSWORD_DEFAULT).';'.$_POST['name'].PHP_EOL);
            fclose($fp);
            header('location: sign-in.php');
            die();
        }
    }
}
?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </head>
    <body class="bg-secondary mt-5 text-dark text-center">
        <h1>Sign Up</h1>
        <hr />
        <?php
        if(strlen($error)>0) echo $error;
        ?>
        <form method="POST">
            <label>NAME</label><br>
            <input class="border border-dark" name='name' type="text" required/>
            <br><br>
            <label>EMAIL</label><br>
            <input class="border border-dark" name='email' type="email" required/>
            <br><br>
            <label>PASSWORD</label>
            <br>
            <input class="border border-dark" name='password' type="password" required>
            <br><br>
            <label>CONFIRM PASSWORD</label>
            <br>
            <input class="border border-dark" name='confirmPassword' type="password" required>
            <br><br>
            <button class="btn btn-warning text-dark" type="submit">SIGN UP</button>
        </form>
    </body>

