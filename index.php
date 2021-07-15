<?php
if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}

require_once 'includeFiles/functions.php';

$type = (isset($_GET['type'])) ? sanitizeString($_GET['type']) : '';
$price = (isset($_GET['price'])) ? sanitizeString($_GET['price']) : '';

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

    <title>index</title>
</head>
<body>

<div class="wall container-fluid container-lg m-0 p-0 mx-lg-auto ">
    <header class="m-0">
        <?php include_once 'header.php';

        if(isset($_SESSION['user_levell'])){
            require_once 'menu.php';
        }else{
            include_once 'menu_login.php';
        }
        ?>
    </header>

    <div class="content">

        <div class="row mx-0">
            <div class="col-sm-4 col-lg-3 py-2 py-md-4">
                <h5 class="h5 text-center font-weight-bold py-1 ">Search for a painting</h5>
                <h6 class="text-center">All prices include frames, sales tax, delivery and insurance</h6>
                <div class="formCard card border-0 px-0">
                    <div class="card-body px-0 mx-0">
                        <form action="process_found_pics.php" method="post"  class="">

                            <div class="form-group row mx-0">
                                <label for="type" class="col-form-label col-4 col-sm-12 col-xl-5 ">Type:</label>
                                <select name="type" id="type" class="custom-select col-8 col-sm-12 col-xl-7" required>
                                    <option selected value="">- Select -</option>
                                    <option value="still-life" <?= stickySelect('type', 'still-life')?>>Still Life</option>
                                    <option value="nature" <?= stickySelect('type', 'nature')?>>Nature</option>
                                    <option value="abstract" <?= stickySelect('type', 'abstract')?>>Abstract</option>
                                </select>
                            </div>

                            <div class="form-group row mx-0 px-0">
                                <label for="price" class="col-form-label col-4 col-sm-12 col-xl-5 ">Maximum Price:</label>
                                <select name="price" id="price" class="custom-select col-8 col-sm-12  col-xl-7" required>
                                    <option selected value="">- Select -</option>
                                    <option value="40" <?= stickySelect('price', '40')?>>&pound;40</option>
                                    <option value="80" <?= stickySelect('price', '80')?>>&pound;80</option>
                                    <option value="800" <?= stickySelect('price', '800')?>>&pound;800</option>
                                </select>
                            </div>

                            <div class="form-group mx-0 ">
                                <div class="offset-4 col-8 col-sm-12 offset-xl-5  col-xl-7 px-0">
                                    <input type="submit" name="submit"  class="btn btn-secondary " value="Search">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-sm-6 col-lg-7  py-2 py-md-4 text-center">
                <h5 id="welcome" class="h5 px-3 py-1 text-left mb-1 mb-md-2">Welcome to the Dove Gallery</h5>

                <div class="row mx-0">
                    <div class="col-4 col-md-6 col-lg-3 ">
                        <img src="../images/frame10.jpg" alt="Frame 10" id="img10indx" class="img-fluid">
                    </div>
                    <div class="col-8 col-md-6 col-lg-9">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ducimus eum, expedita obcaecati qui repudiandae vitae. A aspernatur, aut cum expedita libero magnam, nam nihil quam quisquam quo rerum ut velit!
                        </p>
                    </div>
                </div>
            </div>



            <div class="col-sm-2 col-lg-2 p-0 py-2 py-sm-5 order-first order-sm-0 ">

            </div>

        </div>
    </div>

    <footer class="p-1 p-lg-3">
        <?php include_once 'footer.php'?>
    </footer>

</div>


</body>
</html>
