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

    if(isset($_POST['submit'])){
        $email = sanitizeString($_POST['email']);
        if(empty($email) || strlen($email) > 60 || !filter_var(FILTER_VALIDATE_EMAIL)){
            $errors[] = '- You forgot to enter your email or the e-mail format is incorrect.';
        }

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
                    print_r($user);
                    $stmt->close();
                    $result->close();
                    if ($user_level == 0) {
                        $_SESSION['user_levell'] = (int)0;
                        header('location: iindex.php');
                    } elseif ($user_level == 1) {
                        $_SESSION['user_levell'] = (int)1;
                        header('location: advert.php');
                    }

                } else {
                    echo 'duplicate';
                }
            } else {
                echo 'error' . $dbcon->error;
            }
            $dbcon->close();
        }
    }

    if (!empty($errors)) {
        $errorString = implode('<br>', $errors);
    }

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
    <title>Forgot password</title>
</head>
<body>

<div class="wall container-fluid container-lg m-0 p-0 mx-lg-auto ">
    <header class="m-0">
        <?php include_once 'header.php';?>
        <?php include_once 'menu_login.php'; ?>
    </header>

    <div class="content">
        <div class="row mx-0">

            <div class="col-sm-4 col-lg-3">

            </div>


            <div class="col-sm-6 col-lg-7 py-2 py-md-4">
                <div class="row mx-0 mb-sm-2">
                <div class="offset-lg-4 col-lg-8">
                    <h4 class="h4 text-center">Forgot Your Password?</h4>
                    <p class="text-center">When you apply, you will receive your new password in an email. Read that email as soon as possible. Don't delay! For maximum security, immediately login with your new password. Then change the password as quickly as possible.</p>
                </div>
                </div>

                <form action="process_forgot.php" id="loginFrm" method="post">
                    <div class="form-group row mx-0">
                        <label for="email" class="col-form-label col-sm-4">Email</label>
                        <input type="email" name="email" id="email" class="form-control col-sm-8" maxlength="60" value="<?php if(isset($email)) echo $email ?>" placeholder="Email" required>
                    </div>


                    <div class="form-group row mx-0" >
                        <label  for="secret" class="col-sm-4 col-form-label">Secret Answer</label>
                        <input type="text" name="secret" id="secret"  class="form-control col-sm-8"  placeholder="Secret Question's Answer" required>
                    </div>


                    <div class="form-group row mx-0">
                        <input type="submit" name="submit"  class="offset-md-4 col-md-8 btn btn-warning btn-block" value="Submit">
                    </div>
                </form>
            </div>


            <div class="col-sm-2 py-2 py-md-4">

            </div>

        </div>
    </div>

    <footer class="p-1 p-lg-3">
        <?php include_once 'footer.php'?>
    </footer>

</div>


</body>
</html>
