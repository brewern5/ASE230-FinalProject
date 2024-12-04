<?php
require_once('auth.php');

$error='';

if(count($_POST)>0){

    //completness
    $error = checkFields(0);

    if(strlen($error)==0){

        require_once('db.php');
        $query=$db->prepare('SELECT * FROM users WHERE email=?');

        $query->execute([$_POST['email']]);
        $user = $query->fetch();

        if (checkIfInDB($user, $_POST['email'],$_POST['password'])){
            $_SESSION['id'] = $user['user_ID'];
            $_SESSION['name'] = $user['firstname'];
            header('location: index.php?x=new');
            die();
        }
        else{
            $error = 'Your Email or Password is wrong!';
        }
    }
}

?>
<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel = "stylesheet" href="format.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        
    </head>

   <!--Displays the nav bar, function is in auth-->
   <?php echo displayNav(); ?>

    <body>
        <div class="tab text-center">
            <h1>Sign In</h1>
            <?php
                if(strlen($error)>0) echo '<h4 class="text-warning">'.$error.'</h4>';
            ?>
            <hr />
            <form method="POST">
                <label>EMAIL</label><br>
                <input class="border border-dark textBox" name='email' type="email" required/>
                <br><br>
                <label>PASSWORD</label>
                <br>
                <input class="border border-dark textBox" id='password' name='password' type="password" required>
                <br><br>
                <button class="btn button1 me-2" type="submit">SIGN IN</button>
            </form>
        </div>
    </body>
</html>
