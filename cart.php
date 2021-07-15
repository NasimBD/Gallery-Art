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

    if(isset($_POST['qty'])) {
        updateCart();
    }

    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="icon" href="images/dove3.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Bootstrap and jQuery CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>


        <!--  css-->
        <link rel="stylesheet" href="css/styles.css">

        <title>customcart added</title>
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
                <div class="col-sm-8 py-2 py-md-4">

                    <?php
                    if(!empty($errorString)){
                        echo '<p class="alert alert-danger text-center mx-auto">'.$errorString.' <br><a href="index.php?type='.$type.'&price='.$price.'" class="btn btn-outline-danger">Please try again</a></p>';
                    }else{

                    }

                        if(isset($_SESSION['cart'])){
                            echo showCart();
                        }else{
                            echo '<div class="row mx-0"><div class="col-md-6 mx-auto"><p class="alert alert-info text-dark text-center mx-auto">Your cart is empty.</p></div></div>';
                        }

                    echo '<p class="text-center my-1 my-sm-2"><a href="index.php" class="btn btn-outline-primary">Continue Shopping</a> |
<a href="checkout.php" class="btn btn-outline-success">Checkout</a></p>' ;
                    ?>
                </div>

            <div class="col-sm-4 py-2 py-md-4" id="cardTotals">
                <div class="card p-0">
                    <div class="card-header text-center font-weight-bold">
                        Your Cart
                    </div>
                    <div class="card-body">
                        <div class="row py-1 py-md-2">
                            <div class="col-lg-6 font-weight-bold text-center ">Total quantity</div>
                            <div class="col-lg-6 text-center"><?= totals()[0]; ?></div>
                        </div>

                        <div class="row py-1 py-md-2">
                            <div class="col-lg-6 font-weight-bold text-center">Total price</div>
                            <div class="col-lg-6 text-center">&pound;<?= totals()[1]; ?></div>
                        </div>
                    </div>
                </div>
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
    print $e->getMessage();
}
catch(Error $e)
{
    print "The system is busy, please come back later";
    print $e->getMessage();
}



function totals(){
    if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
        $totalQty = (int) 0;
        $totalPrice = (float) 0;
        foreach ($cart as $itemId => $itemDetails){
            $totalQty += $itemDetails['quantity'];
            $totalPrice += $itemDetails['sumPriceItem'];
        }

        $totals = array($totalQty, $totalPrice);
        return $totals;
    }
}



function showCart(){
    $cartSession = $_SESSION['cart'];
    if(count($cartSession) === 0){
        return '<p class="my-2 alert alert-info text-center">The cart is empty</p>';
    }else{

        $cartTable = '<form method="post" action="" id="updateCrdFrm"><table class="table table-responsive  text-light">
    <tr>
        <th class="text-center">Thumb</th>
        <th>Type</th>
        <th>Artist</th>
        <th>Quantity</th>
        <th>Item Total</th>

    </tr>';

        foreach ($cartSession as $itemId => $itemDetails){

            $cartTable .='<tr>
        <td class=" " ><a class="" href="process_found_pics.php?art_id='.$itemId.'"><img src="'.$itemDetails['thumb'].'" alt="Frame '.$itemId.'" class="thumbCard"></a></td>
        <td>'.$itemDetails['type'].'</td>
        <td>'.$itemDetails['artist'].'</td>
        <td ><input type="number" name="qty['.$itemId.']" class=" text-center m-0" size="2" min="0" value="'.$itemDetails['quantity'].'"></td>
        <td class="">&pound;'.$itemDetails['sumPriceItem'].'</td>
</tr>';
        }

        $cartTable .= '<tr class="text-center"><td colspan="5"><input type="submit" name="update" value="Update" class="btn btn-block btn-warning "></td></tr></table></form>';
        return $cartTable;
    }

}


function updateCart(){  // updates cart through the interactive card that has editable field for quantity;
        $quantitiesArr = sanitizeString($_POST['qty']);
        foreach ($quantitiesArr as $art_id => $quantity){
            $art_id = (int) $art_id;
            $quantity = (int) $quantity;
            if(isset($_SESSION['cart'][$art_id])){
                $price = (float) $_SESSION['cart'][$art_id]['price'];
                if($quantity > 0){
                    $_SESSION['cart'][$art_id]['quantity'] = (int) $quantity;
                    $_SESSION['cart'][$art_id]['sumPriceItem'] = $quantity * $price;
                }elseif($quantity === 0){
                    unset($_SESSION['cart'][$art_id]);
                }
            }
        }
}

?>
