<?php
if(session_status() != PHP_SESSION_ACTIVE){
session_start();
}

if(!isset($_SESSION['user_levell'])){
    header('location: login.php');
    exit();
}

if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

try {

    require_once 'includeFiles/functions.php';
    require_once 'includeFiles/PDO_connect.php';
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

        <title>added</title>
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


            <div class="row mx-0">
                <div class="col-12 py-2 py-md-4">

                    <?php
                    if(!empty($errorString)){
                        echo '<p class="alert alert-danger text-center mx-auto">'.$errorString.' <br><a href="index.php?type='.$type.'&price='.$price.'" class="btn btn-outline-danger">Please try again</a></p>';
                    }else{

                    }

                    if (!is_numeric($_REQUEST['art_id'])){

                        $errors[] = 'Invalid request. <a class="alert-link" href="index.php">Please try again</a>';
                        echo '<div class="row mx-0"><div class="col-lg-6 col-xl-6">'.implode('<br>',$errors).'</div></div>';

                    }elseif(isset($_REQUEST['art_id']) && is_numeric($_REQUEST['art_id'])) {
                        $art_id = sanitizeString($_REQUEST['art_id']);
                        $updateCart = updateCart($art_id);
                        $selectDone = $updateCart[0];

                        if ($selectDone) {
                            echo '<div class="row mx-0"><div class="col-md-6 mx-auto"><p class="alert alert-info text-dark text-center mx-auto">'.addMessage().'</p></div></div>';
                        } else {
                            $selectMsg = $updateCart[1];
                            echo '<p class="alert alert-danger text-center mx-auto">' . $selectMsg . ' <br><a href="index.php" class="btn btn-outline-danger">Please try again</a></p>';
                        }
                    }

                    echo '<p class="text-center"><a href="index.php" class="btn btn-outline-primary">Continue Shopping</a> | <a href="checkout.php" class="btn btn-outline-success">Checkout</a></p>' ;
                    ?>
                </div>
            </div>
        </div>

        <footer class="p-1 p-lg-3">
            <?php include_once 'footer.php'?>
        </footer>

    </div>


    </body>
    </html>
    <?php
}
catch(Exception $e)
{
    print "The system is busy, please try later";
//    print $e->getMessage();
}
catch(Error $e)
{
    print "The system is busy, please come back later";
//    print $e->getMessage();
}



function addMessage()
{
    $cartSession = $_SESSION['cart'];
    if (count($cartSession) === 0) {
        return 'The cart is empty';
    } else {
        return "An item added to your <a href='cart.php' class='btn btn-outline-success'>cart</a>";

    }
}




function updateCart($art_idd){  // updates cart after each purchase (adding item to cart);
    $selectArt = selectArt($art_idd);
    $selectDone = $selectArt[0];

    if($selectDone){
        $itemDetailsArr =  $selectArt[1];

        if(isset($_SESSION['cart'][$art_idd])){
            $_SESSION['cart'][$art_idd]['quantity']++;
        }else{
            $_SESSION['cart'][$art_idd]['thumb'] = $itemDetailsArr[0];
            $_SESSION['cart'][$art_idd]['type'] = $itemDetailsArr[1];
            $_SESSION['cart'][$art_idd]['artist'] = $itemDetailsArr[2];
            $_SESSION['cart'][$art_idd]['price'] = (float) $itemDetailsArr[3];
            $_SESSION['cart'][$art_idd]['quantity'] = (int) 1;
            $_SESSION['cart'][$art_idd]['sumPriceItem'] = (float) ($_SESSION['cart'][$art_idd]['price'] * $_SESSION['cart'][$art_idd]['quantity']) ;


        }
        return array($selectDone, $_SESSION['cart'][$art_idd]);
    }else{
        $selectMsg = selectArt($art_idd)[1];
        return array($selectDone, $selectMsg);
    }


}



function selectArt($art_idd){
    global $dbcon;
    $query = "SELECT thumb, type, price, medium, artist, mini_descr  FROM art WHERE art_id=?";
    $stmt = $dbcon->prepare($query);
    $stmt->bindParam(1,$art_idd);
    $execute = $stmt->execute();
    if($execute){
        if($stmt->rowCount() === 1 ){

            $selectDone = true;
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $thumb = sanitizeString($row['thumb']);
            $type = sanitizeString($row['type']);
            $artist = sanitizeString($row['artist']);
            $price = sanitizeString($row['price']);

            $boughtItem = array($thumb, $type, $artist, $price);
            $stmt = null;
            $row = null;
            $dbcon = null;
            return array($selectDone, $boughtItem);
        }else{
            $selectDone = false;
            $selectMsg = 'There are no results for the chosen type and maximum price.';
        }
    }else{
        $selectDone = false;
        $selectMsg = 'Failure: '.$dbcon->error;

    }
    $dbcon = null;
    return array($selectDone, $selectMsg);
}
?>
