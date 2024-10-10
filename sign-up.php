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

    $error = checkFields(1);
    //completnes

    if(strlen($error)==0){
        $fp=fopen('users.csv.php', 'r');

        if(str_contains($_POST['name'], ';')) {
            $error='Do not add a ; to your name';
        }
        while(!feof($fp) && strlen($error)==0){
            $line=fgets($fp);
            $line=explode(';',$line);
            
            if(count($line)==3 && $_POST['email']==$line[0]){
                $error='The email is already registered';
                break;
            }
            if(count($line)==3 && $_POST['name']==$line[1]){
                $error='The name is already in use';
                break;
            }
        }
        fclose($fp);
        if(strlen($error)==0){
            //open csv file in append mode
            $fp=fopen('users.csv.php', 'a+');
            fputs($fp,$_POST['email'].';'.$_POST['name'].';'.password_hash($_POST['password'],PASSWORD_DEFAULT).PHP_EOL);
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
        <a href="index.php" class="text-decoration-none fs-1 text-info">
            <p class="text-start">Home</p>
        </a>
        <h1>Sign Up</h1>
        <hr />
        <?php
        if(strlen($error)>0) echo '<h4 class="text-warning">'.$error.'</h4>';
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
            <button class="btn btn-info text-dark" type="submit">SIGN UP</button>
        </form>
    </body>

