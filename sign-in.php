<?php
require_once('auth.php');

$error='';

if(count($_POST)>0){

    //completness
    $error = checkFields();

    if(strlen($error)==0){
        checkIfInDB('users.csv.php',$_POST['email'],$_POST['password']);
        $fp=fopen('users.csv.php', 'r');
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';',$line);
                //must trim the end because there is a newline character
            if(count($line)==2 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
                fclose($fp);
                $_SESSION['email'] = $line[0];
                header('location: index.php');
                die();
            }
        }
        fclose($fp);
        echo 'Your credentials are wrong';
    }
}

?>
<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    </head>
    <body class="bg-secondary mt-5 text-white text-center">
        <h1>Sign In</h1>
        <?php if(strlen($error)>0) echo $error; ?>
        <form method="POST">
            <label>EMAIL</label><br>
            <input name='email' type="email" required/>
            <br><br>
            <label>PASSWORD</label>
            <br>
            <input id='password' name='password' type="password" required>
            <br><br>
            <button class="btn btn-info me-2 text-white" type="submit">SIGN IN</button>
        </form>
    </body>
</html>