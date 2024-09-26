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
    <body>
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
            <button type="submit">SIGN IN</button>
        </form>
    </body>
</html>