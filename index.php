<?php
require_once('auth.php');



if(isset($_SESSION['email'])) {}
    
?>

<html>
    <head>
    </head>
        <body>
            <header>    <!-- will display user's name if they are logged in -->
                <h1> Welcome to **Insert Site Name Here** </h1>
            </header>
            <nav>  <!-- if user is not logged on then will display sign-up/sign-in -->
                <h3><a href="sign-in.php">Sign in</a><h3>
                <h3><a href="sign-up.php">Sign Up</a><h3>
            </nav>
            <main>  <!-- will take users to posts -->
                <h2><a href="entity/index.php">Posts</a></h2>
            </main>
        </body>
    </html>
<?php/* }

else { echo 'Go away poo head. if you know your credentials <a href="sign_in.php">Click Here</a>'; }
?>
*/
?>