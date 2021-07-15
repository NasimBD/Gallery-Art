<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap and jQuery CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!--  css-->
    <link rel="stylesheet" href="css/styles.css">
    <title>Register</title>
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

    <!-- Validate Input -->
    <?php require_once 'process-register-page.php';

    if(isset($errorString)){
        echo "<div class='text-danger text-center mx-auto'><span class='border border-danger font-weight-bold '>ERROR!</span><br>$errorString</div>";
    }

    ?>



    <div class="row mx-0">

        <div class="col-md-8">
            <div class="card border-0 bg-transparent">

                <div class="card-header">
                    <h3 class="h3 text-center">Register</h3>
                    <h5 class="h6 text-center">Items marked with an asterisk * are required</h5>
                </div>


                <div class="card-body">
                    <form id="registerFrm" action="register-page.php" method="post">

                        <div class="form-group row mx-0">
                            <label for="title" class="col-md-4 col-form-label">Title:</label>
                            <input type="text" class="form-control col-md-8" id="title" name="title" value="<?= $title?>"  maxlength="12" pattern='[a-zA-Z][a-zA-Z\s\.]*' title="Alphabetic, period and space max 12 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="first_name" class="col-md-4 col-form-label">&ast;First Name:</label>
                            <input type="text" class="form-control col-md-8" id="first_name" name="first_name" value="<?= $first_name?>" required maxlength="30" pattern="[a-zA-Z][a-zA-Z\s]*" title="Alphabetic and space only max of 30 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="last_name" class="col-md-4 col-form-label">&ast;Last Name:</label>
                            <input type="text" class="form-control col-md-8" id="last_name" name="last_name" value="<?= $last_name?>" required maxlength="40" pattern="[a-zA-Z][a-zA-Z\s\-\']*" title="Alphabetic and space only max of 40 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="email" class="col-md-4 col-form-label">&ast;Email:</label>
                            <input type="email" class="form-control col-md-8" id="email" name="email" value="<?= $email?>" required maxlength="50">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="password1" class="col-md-4 col-form-label ">&ast;Password:</label>
                            <div class="col-md-8 px-0 d-flex flex-column justify-content-center ">
                                <input type="password" class="form-control " minlength="8" maxlength="12" id="password1" name="password1" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}"  title="One number, one upper, one lower, one special, with 8 to 12
characters">
                                <p class="text-muted form-text small">Between 8 and 12 characters.</p>
                            </div>
                        </div>


                        <div class="form-group row mx-0">
                            <label for="password2" class="col-md-4 col-form-label">&ast;Confirm Password:</label>
                            <input type="password" class="form-control col-md-8" minlength="8" maxlength="12" id="password2" name="password2" required  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,12}"  title="One number, one upper, one lower, one special, with 8 to 12
characters">
                        </div>
                        <p id="message" class="form-text small"></p>


                        <div class="form-group row mx-0">
                            <label for="level" class="col-md-4 col-form-label">&ast;Membership Class</label>
                            <select name="level" id="level" class="custom-select col-md-8" required>
                                <option value="">select</option>
                                <option value="a">A</option>
                                <option value="b">B</option>
                                <option value="c">C</option>
                            </select>
                        </div>


                        <div class="form-group row mx-0">
                            <label for="address1" class="col-md-4 col-form-label">&ast;Address:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="address1" name="address1" value="<?= $address1?>" required pattern="[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*"
                                   title="Alphabetic, numbers, period, comma, dash and space only max of 30
characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="address2" class="col-md-4 col-form-label">Address:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="address2" name="address2" value="<?= $address2?>" pattern="[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*"
                                   title="Alphabetic, numbers, period, comma, dash and space only max of 30
characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="city" class="col-md-4 col-form-label">&ast;City:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="city" name="city" value="<?= $city?>" required pattern="[a-zA-Z][a-zA-Z\s\.]*" title="Alphabetic, period and space only max of 30 characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="state_country:" class="col-md-4 col-form-label">&ast;State/Country:</label>
                            <input type="text" class="form-control col-md-8" maxlength="25" id="state_country" name="state_country" value="<?= $state_country?>" required pattern="[a-zA-Z][a-zA-Z\s\.]*"
                                   title="Alphabetic, period and space only max of 30 characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="zcode_pcode" class="col-md-4 col-form-label">&ast;Zip Code/Post Code:</label>
                            <input type="text" class="form-control col-md-8" maxlength="10" id="zcode_pcode" name="zcode_pcode" value="<?= $zcode_pcode?>" required pattern="[a-zA-Z0-9][a-zA-Z0-9\s]*"
                                   title="Alphabetic, period and space only max of 30 characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="phone" class="col-md-4 col-form-label">Phone Number:</label>
                            <input type="tel" class="form-control col-md-8" maxlength="15" id="phone" name="phone" value="<?= $phone?>">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="question" class="col-md-4 col-form-label">&ast;Secret Question:</label>
                            <select name="question" id="question" class="custom-select col-md-8" required>
                                <option selected value="">- Select -</option>
                                <option value="Maiden">Mother's Maiden Name</option>
                                <option value="Pet">Pet's Name</option>
                                <option value="School">High School</option>
                                <option value="Vacation">Favorite Vacation Spot</option>
                            </select>
                        </div>
                        <div class="form-group row mx-0">
                            <label for="secret" class="col-md-4 col-form-label">&ast;Answer:</label>
                            <input type="tel" class="form-control col-md-8" maxlength="30" id="secret" name="secret" value="<?= $secret?>" placeholder="Secret Answer" pattern="[a-zA-Z][a-zA-Z\s\.\,\-]*" title="Alphabetic, period, comma, dash and space only max of 30
characters">
                        </div>


                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input id="submit" class="btn btn-warning btn-block" type="submit" name="submit" value="Register">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        include_once 'footer.php' ?>
        ?>
</div>
</body>
</html>