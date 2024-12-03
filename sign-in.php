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
        <link rel = "stylesheet" href="format.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

        
    </head>

    <header class="tab">

        <!-- will display user's name if they are logged in -->
        <?php echo displayHeader(); ?>

        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
                </a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                        
                    <li><a href="index.php?x=new" class="currentloc nav px-2">Home</a></li>
                    <li><a href="entity/index.php?x=new" class="nav px-2">Posts</a></li>
                    <?php if(isset($_SESSION['email'])) echo
                        '<li><a href="entity/myPosts.php?x=ne" class="nav px-2">My Posts</a></li>
                        <li><a href="entity/create.php" class="nav px-2">Create New Post</a></li>' ?>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                    <input type="search" class="textBox form-control" placeholder="Search..." aria-label="Search">
                </form>

                <?php if(isset($_SESSION['email'])) { ?>
                        
                <!--This shows profile information is the user is in a session-->
                <div class="dropdown text-end">
                    <a href="#" class="d-block link-body-emphasis text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                    </a>
                    <ul class="dropdown-menu text-small" style="">
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href=" sign-out.php">Sign out</a></li>
                    </ul>
                </div>
                        
                <!--This shows sign in and sign up buttons if the user is not in a session-->
                <?php } else { ?>
                   
                <div class="text-end">
                    <a class="btn button1 me-2" href="sign-in.php" role="button">Login</a>
                    <a class="btn button2" href="sign-up.php" role="button">Sign Up</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </header>

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
