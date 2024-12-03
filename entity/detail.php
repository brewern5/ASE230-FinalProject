<?php
require_once('auth.php');


//opening json to print page
$contents=file_get_contents("posts.json");
$blogdata=json_decode($contents,true);

$post_id=$_GET['x'];

function displayElement($element,$x) { ?>
   
    <h1><a href="detail.php?x=<?php echo $x;?>"><?php echo $element['title']; ?></a></h1>
    <hr>

<?php 
}
?>

<html>
    <head>
        <link rel = "stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel = "stylesheet" href="../format.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>


    </head>
    <body>        
       
        <!--Displays the nav bar, function is in auth-->
        <?php echo displayNav(); ?>

        <div class="tab mx-5 p-2">
            <div class="row">
                <div class="col-5">
                    <?php if(strlen($blogdata[$post_id]['picture'])>0) { ?>
                        <img style="width:100%;height: 100%;" src="<?php echo $blogdata[$post_id]['picture']; ?>" class="pic float-left m-2" alt="...">
                    <?php } else { ?>
                        <img style="width:400px;height: 400px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22861%22%20height%3D%22250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20861%20250%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_192771132f5%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A43pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_192771132f5%22%3E%3Crect%20width%3D%22861%22%20height%3D%22250%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22320.5124969482422%22%20y%3D%22144.2%22%3E861x250%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" class="pic float-left m-2" alt="...">
                    <?php }?>
                </div>
                <div class="col-7 text-center">
                    <h1 class=""><?php echo $blogdata[$post_id]['title'] ?></h1>
                    <h3 class="">Band: <?php echo $blogdata[$post_id]['band'] ?> || Album: <?php echo $blogdata[$post_id]['album'] ?></h3>
                    <p>Song: <?php echo $blogdata[$post_id]['song'] ?></p>
                    <p>Tag(s): <?php foreach ($blogdata[$post_id]['tags'] as $tag){ echo $tag.' '; }?></p>
                </div>
            </div>
            <div class="container">
                <?php if(isLogged()>0) checkOwner($blogdata[$post_id]['author'], $post_id); ?>
                <hr>

                <div class="row">
                    <h3 class="text-center">
                        <?php echo $blogdata[$post_id]['content'] ?>
                    </h3>
                </div>
                <div class="row">
                    <h5>
                        <?php //prints visitor count
                            $fp=fopen('../visitors.csv','r');
                            while(! feof($fp)) {
                                $temp = fgets($fp);
                                if(explode(';',$temp)[0] == $post_id){
                                    echo 'Views: '.(explode(';',$temp)[1]).'<br />';
                                }
                            }
                            fclose($fp);
                            echo '<h6 class="fw-light text-center">'.$blogdata[$post_id]['author'].' | '.$blogdata[0]['time']['date'].'</h6>';
                        ?>
                    </h5>
                </div>
            </div>
        </div>

        <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                </a>
                <span class="mb-3 mb-md-0">© 2024 Nate Brewer & Danny Poff</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-body-secondary" src="/images/twitter.svg/"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
            </ul>
        </footer>
    </div>
    </body>
</html>