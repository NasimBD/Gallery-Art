<?php
if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}

try {

    $_SESSION = array(); // Destroy the variables
    $params = session_get_cookie_params();
    // Destroy the cookie
    setcookie(session_name(), '', time()-42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    if (session_status() == PHP_SESSION_ACTIVE) {
        session_destroy(); } // Destroy the session itself



$logoutStatus = '<p class="alert alert-success text-center mx-auto">You logged out successfully.</p>';

?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="../images/dove3.png">
        <!-- Bootstrap and jQuery CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


        <!--  css-->
        <link rel="stylesheet" href="css/styles.css">
        <title>logout</title>
    </head>
    <body>

    <div class="wall container-fluid container-lg m-0 p-0 mx-lg-auto ">
        <header class="m-0">
            <?php include_once 'header.php';?>
            <?php
            if(isset($_SESSION['user_levell'])){
                require_once 'menu.php';
            }else{
                include_once 'menu_login.php';
            }
            ?>
        </header>

        <div class="content">
                    <div class="content row mt-2 mt-md-4">
                        <div class="col-12 col-md-6 mx-auto">
                            <?=$logoutStatus?>
                        </div>
                    </div>
        </div>

        <footer class="p-1 p-lg-3 position-fixed w-100 " style="bottom:0;">
            <?php include_once 'footer.php'?>
        </footer>
    </div>
    <?php
    }
    catch(Exception $e) // We finally handle any problems here
    {
        print "An Exception occurred. Message: " . $e->getMessage();
        print "The system is busy please try later";
    }
    catch(Error $e)
    {
        print "An Error occurred. Message: " . $e->getMessage();
        print "The system is busy please try later";
    }
    ?>

</div>
</body>
</html>
