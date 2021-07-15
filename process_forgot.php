<!-- Please read about using PHPMailer at  https://github.com/PHPMailer/PHPMailer
 If you're not using Composer, you can download PHPMailer as a zip file
  -->

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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

<?php
try {
    require ('includeFiles/PDO_connect.php');
// Assign the value FALSE to the variable $byId
    $byId = FALSE;
// Validate the email address...
    if (!empty($_POST['email'])) {
// Does that email address exist in the database? #1
        $email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
        $query = 'SELECT `userid`, `user_level`, `secret` FROM `users` WHERE `email`=?';
        $stm = $dbcon->prepare($query);
        $stm->bindParam(1, $email);

        if($stm->execute()){
            if($stm->rowCount() === 1){
                $row = $stm->fetch(PDO::FETCH_NUM);
                $secret = htmlspecialchars($_POST['secret'], ENT_QUOTES); var_dump($row);
                if((int) $row[1] === 0 && $row[2] == $secret){
                    $byId = $row[0];
                }else{
                    echo '<h6 class="h6">If your e-mail and secret are correct, you will receive an e-mail</h6>';
                };
            }else{
                echo 'Please try again.';
            }
        }else{
            print_r($stm->errorInfo()); //Not for production
            echo 'Please try again.';
        }
    }



    if ($byId) {
// If byId for the email address was retrieved, create a random password
        $password = substr ( md5(uniqid(random_int(PHP_INT_MIN , PHP_INT_MAX), true)), 5, 10);
// Update the database table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE `users` SET `password`=? WHERE `userid`=?";
        $stm = $dbcon->prepare($query);
// bind $id to SQL Statement
        $stm->bindParam(1, $hashed_password);
        $stm->bindParam(2, $byId);
// execute query

        if($stm->execute()){
            if($stm->rowCount() === 1){
                // Send an email to the buyer #4
                $emailSubject = "Password recovery for Dove Gallery";
                $emailBody = "<h3 style='text-align: center;'>Your password has been changed to '" . $password;
                $emailBody .= "'.</h3> <p style='color: gray;text-align: center;'>Please login as soon as possible using the new password. ";
                $emailBody .= "Then change it immediately. otherwise, ";
                $emailBody .= "if a hacker has intercepted ";
                $emailBody .= "this email they will know your login details.</p>";
                sendMail($email, $emailSubject, $emailBody, $password);
// Echo a message and exit the code
                echo '<p class="alert alert-info text-center">
Your password has been changed. ';
                echo 'You will shortly receive the new temporary password ';
                echo 'by email.</p>';
                $dbcon = null;
                include ('footer.php');
                exit(); // Stop the script.
            }else{
                echo '<p class="error">Due to a system error, your password ';
                echo 'could not be changed. We apologize for any inconvenience. </p>';
            }
        }else{
            print_r($stm->errorInfo()); //Not for production
            echo 'Please try again.';
        }
    }
    $dbcon = null;
}
catch(Exception $e)
{
    print "The system is busy, please try later. ";
   print $e->getMessage();
}
catch(Error $e)
{
    print "The system is busy, please come back later. ";
    print $e->getMessage();
}



function sendMail($emaill, $emailSubjectt, $emailBodyy, $passwordd){
    $mail = new PHPMailer(TRUE);

    try {
        $mail->CharSet  = 'UTF-8';

        $mail->setFrom('yourEmail', 'Dove Gallery');
        $mail->addAddress($emaill, 'Name');
        $mail->Subject = $emailSubjectt;
        $mail->isHTML(true);
        $mail->Body = $emailBodyy;
        $mail->AltBody = 'Your password has been changed to: ' . $passwordd;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'yourEmail';
        $mail->Password = 'yourPassword';
        $mail->Port = 587;

        /* Uncomment to see SMTP debug output. */
//        $mail->SMTPDebug = 4;

        $mail->send();
    }
    catch (Exception $e)
    {
        echo $e->errorMessage();
    }
    catch (\Exception $e)
    {
        echo $e->getMessage();
    }
}
?>

</div>
</body>
</html>
