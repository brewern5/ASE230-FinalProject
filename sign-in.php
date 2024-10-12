<?php
require_once('auth.php');

$error='';

if(count($_POST)>0){

    //completness
    $error = checkFields(0);
    $isEmail = false;

    if(strlen($error)==0){
        checkIfInDB('users.csv.php',$_POST['email'],$_POST['password']);
        $fp=fopen('users.csv.php', 'r');
        while(!feof($fp)){
            $line=fgets($fp);
            $line=explode(';',$line);
            //checks if you have a registered email
            if(count($line)==3 && $_POST['email']==$line[0])
                $isEmail = true;
        
            //must trim the end because there is a newline character
            if(count($line)==3 && $_POST['email']==$line[0] && password_verify($_POST['password'],trim($line[1]))){
                fclose($fp);
                $_SESSION['email'] = $line[0];
                $_SESSION['name'] = $line[2];
                header('location: index.php?x=new');
                die();
            }
        }
        fclose($fp);
        if($isEmail) {
            $error='Your password is wrong';
        }
        else {
            $error='This email is not in our system';
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
        <a href="index.php" class="text-decoration-none text-info fs-1">
            <p class="text-start">Home</p>
        </a>

        <h1>Sign In</h1>
        <?php
            if(strlen($error)>0) echo '<h4 class="text-warning">'.$error.'</h4>';
        ?>
        <hr />
        <form method="POST">
            <label>EMAIL</label><br>
            <input class="border border-dark" name='email' type="email" required/>
            <br><br>
            <label>PASSWORD</label>
            <br>
            <input class="border border-dark" id='password' name='password' type="password" required>
            <br><br>
            <button class="btn btn-info me-2 text-white" type="submit">SIGN IN</button>
        </form>
    </body>
</html>
