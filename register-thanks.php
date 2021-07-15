<!DOCTYPE html>
<html lang="en">
<head>
    <title>Template for an interactive web page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap and jQuery CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!--    Google recaptcha-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!--  css-->
    <link rel="stylesheet" href="css/styles.css">


    <?php
        require_once 'includeFiles/mysqli_connect.php';
        require_once 'includeFiles/functions.php';

    ?>
</head>
<body>
<div class="wall container-fluid container-lg m-0 p-0 mx-lg-auto ">
    <header class="m-0" >
        <?php include_once 'header.php';
        if(isset($_SESSION['user_levell'])){
            require_once 'menu.php';
        }else{
            include_once 'menu_login.php';
        }
        ?>
    </header>

    <!-- Body Section #2-->
        <div class="mt-5">
            <h2 class="h2 py-3 mb-4 text-center ornament">Thank you for registering <i class=" fas fa-heart "></i></h2>
            <h6 class="h6 text-center">
                To confirm your registration please pay the membership fee.</h6>
            <h6 class="h6 text-center">You can use PayPal or a credit/debit card.</h6>
        </div>
    <!-- Footer Content Section #4-->
    <footer class="position-fixed w-100" style="bottom: 0;">
        <?php include('footer.php'); ?>
    </footer>
</div>
</body>
</html>