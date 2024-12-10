<?php
//SIGNUP
require_once('auth.php');

$error='';
if(count($_POST)>0){
    $error = checkFields(1);

    $error = checkFields(1);
    //completness
    if(strlen($error)==0){
        require_once('db.php');

        $query=$db->prepare('INSERT INTO users(email,firstname,lastname,password) VALUES(?,?,?,?)');

        if(strlen($error)==0){
            $query->execute([$_POST['email'],$_POST['firstname'], $_POST['lastname'], password_hash($_POST['password'],PASSWORD_DEFAULT)]);
            header('location: sign-in.php');
            die();
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
        <h1>Sign Up</h1>
        <hr />
        <?php
        if(strlen($error)>0) echo $error;
        ?>
        <form method="POST">
            <label>FIRST NAME</label><br>
            <input class="border border-dark textBox" name='firstname' type="text" required/>
            <br><br>
            <label>LAST NAME</label><br>
            <input class="border border-dark textBox" name='lastname' type="text" required/>

            <br><br>
            <label>EMAIL</label><br>
            <input class="border border-dark textBox" name='email' type="email" required/>
            <br><br>
            <label>PASSWORD</label>
            <br>
            <input class="border border-dark textBox" name='password' type="password" required>
            <br><br>
            <label>CONFIRM PASSWORD</label>
            <br>
            <input class="border border-dark textBox" name='confirm_password' type="password" required>

            <br><br>
            <button class="btn button2 me-2" type="submit">SIGN UP</button>
        </form>
    </body>

