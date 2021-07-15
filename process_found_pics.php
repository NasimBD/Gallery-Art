<?php
if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}

if(!isset($_SESSION['user_levell'])){
  header('location: login.php');
  exit();
}

try {

require_once 'includeFiles/functions.php';
require_once 'includeFiles/PDO_connect.php';


if(isset($_REQUEST['art_id']) && is_numeric($_REQUEST['art_id'])){
    $art_id = sanitizeString($_REQUEST['art_id']);
}elseif(isset($_POST['submit'])){
    $type = sanitizeString($_POST['type']);
    if(empty($type)){
        $errors = 'The type is empty or invalid';
    }

    $price = sanitizeString($_POST['price']);
    if(empty($price)){
        $errors = 'The maximum price is empty or invalid';
    }
}else{
    header('location: index.php');
    exit();
}


    if(!empty($errors)){
        $errorString = implode('<br>', $errors);
    }else{
        if(isset($art_id)){
            $query = "SELECT art_id, thumb, type, price, medium, artist, mini_descr  FROM art WHERE art_id=?";
            $stmt = $dbcon->prepare($query);
            $stmt->bindParam(1,$art_id);
        }else{
            $query = "SELECT art_id, thumb, type, price, medium, artist, mini_descr  FROM art WHERE type=? AND (price < ?) AND (price > (? - 100)) ORDER BY art_id ASC";
            $stmt = $dbcon->prepare($query);
            $stmt->bindParam(1,$type);
            $stmt->bindParam(2, $price);
            $stmt->bindParam(3, $price);
        }


        $execute = $stmt->execute();
        if($execute){
            if($stmt->rowCount() > 0 ){
                $selectDone = true;
                $table = '<table class="table table-responsive table-striped text-light ">
    <tr>
        <th class="text-center">Thumb</th>
        <th>Type</th>
        <th>Medium</th>
        <th>Artist</th>
        <th>Details</th>
        <th>Price</th>
    </tr>';
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $thumb = sanitizeString($row['thumb']);
                    $type = sanitizeString($row['type']);
                    $medium = sanitizeString($row['medium']);
                    $artist = sanitizeString($row['artist']);
                    $details = sanitizeString($row['mini_descr']);
                    $price = sanitizeString($row['price']);
                    $art_id = sanitizeString($row['art_id']);


                    $table .='<tr>
        <td class=" " ><img src="'.$thumb.'" alt="Frame '.$art_id.'" class="thumb" ></td>
        <td>'.$type.'</td>
        <td>'.$medium.'</td>
        <td>'.$artist.'</td>
        <td>'.$details.'</td>
        <td class="">&pound;'.$price.'<a class="btn btn-sm btn-warning m-1" href="added.php?art_id='.$art_id.'">Add to Cart</a></td>

    </tr>';
                }
                $table .= '</table>';
                $stmt = null;
                $row = null;
            }else{
                $selectDone = false;
                $selectMsg = 'There are no results for the chosen type and maximum price.';
            }
        }else{
            $selectDone = false;
            $selectMsg = 'Failure: '.$dbcon->error;
        }
        $dbcon = null;
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
    <!-- Bootstrap and jQuery CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!--  css-->
    <link rel="stylesheet" href="css/styles.css">

    <title>customcart found_pics</title>
    <?php require_once 'includeFiles/functions.php'?>
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
            <div class="col-lg-6 col-xl-6">
                <?php
                if(!empty($errorString)){
                    echo '<p class="alert alert-danger text-center mx-auto">'.$errorString.' <br><a href="index.php?type='.$type.'&price='.$price.'" class="btn btn-outline-danger">Please try again</a></p>';
                }
                ?>
            </div>
        </div>

        <div class="row mx-0">
            <div class="col-12 py-2 py-md-4">
                <?php
                if($selectDone){
                    echo  $table;
                }else{
                    echo '<p class="alert alert-danger text-center">'.$selectMsg.'</p>';
                }
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
catch (Exception $e) // We finally handle any problems here
{
    print "An Exception occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
} catch (Error $e) {
    print "An Error occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
}
?>
