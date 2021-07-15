<?php
if(session_status() != PHP_SESSION_ACTIVE){
    session_start();
}


try {
    require_once 'includeFiles/functions.php';
    $log = (isset($_SESSION['user_levell'])) ? 'Logout' : 'Login';

    if (!isset($_POST['submit'])) {
        $email = '';
        $password = '';
    }
    $siteKey = 'Put Your siteKey for recaptcha';  //NOTE: Put Your siteKey for recaptcha

    if(isset($_POST['submit'])){
        $email = sanitizeString($_POST['email']);
        if(empty($email) || strlen($email) > 60 || !filter_var(FILTER_VALIDATE_EMAIL)){
            $errors[] = '- You forgot to enter your email or the e-mail format is incorrect.';
        }

                if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

            $secret = 'Put Your secret code for recaptcha';  //NOTE: Put Your secret code for recaptcha
            $fileName = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response'];
            $verifyResponse = file_get_contents($fileName);
            $responseData = json_decode($verifyResponse);

            if ($responseData->success) {

        $password = sanitizeString($_POST['password']);
        if(empty($password) || (strlen($password) < 8) || (strlen($password)) > 12){
            $errors[] = '- Password missing or not valid. Max 60.';
        }

                if (empty($errors)) {
                    require_once 'includeFiles/mysqli_connect.php';
                    $query = "SELECT title, first_name, last_name, user_level FROM users WHERE email=?";
                    $stmt = $dbcon->prepare($query);
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result) {
                        if ($result->num_rows === 1) {
                            $user = $result->fetch_array(MYSQLI_ASSOC);
                            $title = htmlentities($user['title']);
                            $first_name = htmlentities($user['first_name']);
                            $last_name = htmlentities($user['last_name']);
                            $user_level = htmlentities($user['user_level']);
                            $stmt->close();
                            $result->close();
                            if ($user_level == 0) {
                                $_SESSION['user_levell'] = (int)0;
                                header('location: index.php');
                            } elseif ($user_level == 1) {
                                $_SESSION['user_levell'] = (int)1;
                                header('location: index.php');
                            }

                        } else {
                            echo '<p class="alert alert-danger text-center">Wrong Information</p>';
                        }
                    } else {
                        echo 'error' . $dbcon->error;
                    }
                    $dbcon->close();
                }
                    } else {
                $errors[] = 'Robot verification failed, please try again.';
            }
        } else {
            $reCapMsgErr = 'Please check the "I\'m not a robot" box below.';
        }
    }

    if (!empty($errors)) {
        $errorString = implode('<br>', $errors);
    }

}
catch (Exception $e)
{
    print "An Exception occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
} catch (Error $e) {
    print "An Error occurred. Message: " . $e->getMessage();
    print "The system is busy please try later";
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="../images/dove3.png">
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
    <title>login</title>
</head>
<body>

<div class="wall container-fluid container-lg m-0 p-0 mx-lg-auto ">
    <header class="m-0">
        <?php include_once 'header.php';?>
        <?php include_once 'menu_login.php'; ?>
    </header>

    <div class="content">
        <div class="row mx-0">

            <div class="col-sm-7 col-lg-6 p-2 px-3 p-md-4">
                <form action="" id="loginFrm" method="post">
                    <div class="form-group row mx-0">
                        <label for="email" class="col-form-label col-md-4">Email</label>
                        <input type="email" name="email" id="email" class="form-control col-md-8" maxlength="60" value="<?php if(isset($email)) echo $email ?>" placeholder="Email" required>
                    </div>


                    <div class="form-group row mx-0" >
                        <label  for="maxPrice" class="col-md-4 col-form-label">Password</label>
                        <input type="password" name="password" id="password"  class="form-control col-md-8" minlength="8" maxlength="12"  value="<?php if(isset($password)) echo $password ?>" placeholder="Password" required>
                    </div>


                    <div class="form-group row mx-0">
                        <?php if(isset($reCapMsgErr)) {
                            echo '<p class="offset-md-4 col-md-8 alert alert-danger">'.$reCapMsgErr.'</p>';
                        }
                        ?>
                        <div class="g-recaptcha offset-md-4 col-md-8 px-0" data-sitekey="<?=$siteKey?>"></div>
                    </div>


                    <div class="form-group row mx-0">
                        <input type="submit" name="submit"  class="offset-md-4 col-md-8 btn btn-warning btn-block" value="Login">
                    </div>


                    <div class="form-group row mx-0">
                        <a href="forgot.php" class="offset-md-4 col-md-8 text-center text-light">Forgot Password?</a>
                    </div>
                </form>
            </div>

            <div class="col-sm-5 col-lg-4 py-2 py-md-3">
                <p class="alert alert-info text-center mx-auto my-3">
                    <strong>Admin:</strong>
                    Mike Rosoft, <br>
                    email: miker@myisp.com <br>
                    password: W111g@t3s <br>


                    <br>
                    <strong>sample user:</strong>
                    Mrs. Rose Bush, <br>
                    email: rbush@myisp.co.uk <br>
                    password: R@db100ms
                </p>
                <h6 id="memberTitle" class="text-light text-center mt-4 pb-1 border-bottom border-secondary">
                    <strong>Become a member and support our cause</strong>
                </h6>
                <p class="text-light text-center">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam, dolorem error optio pariatur quidem quis quo voluptate!
                </p>
            </div>

        </div>
    </div>

    <footer class="p-1 p-lg-3">
        <?php include_once 'footer.php'?>
    </footer>

</div>
</body>
</html>
