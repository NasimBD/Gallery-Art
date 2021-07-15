<?php
$user_level = (int)0; //for ordinary members.
$paid = 'no'; //default
try {

    require_once "includeFiles/PDO_connect.php";
    require_once "includeFiles/functions.php";

 //---------------------------------------------------------------------
    if(!isset($_POST['submit'])){
        $title= '';
        $first_name ='';
        $last_name ='';
        $email ='';
        $address1 ='';
        $address2 ='';
        $city ='';
        $state_country ='';
        $zcode_pcode ='';
        $phone ='';
        $secret = '';
    }

    //----------------------------------------------------- isset($_POST['submit'])

    if(isset($_POST['submit'])){
        $title = sanitizeString($_POST['title']);
        if ((!empty($title)) && (preg_match('/[a-zA-Z][a-zA-Z\s\.]*/i', $title)) && (strlen($title) <= 12)) {
            $title = $title;
        }else{
            $title = NULL; // Title is optional
        }

    $first_name = sanitizeString($_POST['first_name']);
    if((!empty($first_name)) && preg_match('/[a-zA-Z][a-zA-Z\s]*/', $first_name) && (strlen($first_name)) <= 30){
        $first_name = $first_name;
    } else {
        $errors[] = '- First name missing or not alphabetic and space characters. Max 30.';
    }

        $last_name = sanitizeString($_POST['last_name']);
        if((!empty($last_name)) && preg_match('/[a-zA-Z][a-zA-Z\s]*/', $last_name) && (strlen($last_name)) <= 40){
            $first_name = $first_name;
        } else {
            $errors[] = '- Last name missing or not alphabetic and space characters. Max 40.';
        }


    $email = sanitizeString($_POST['email']);
    if (empty($email) || (!filter_var($email, FILTER_VALIDATE_EMAIL)) || (strlen($email > 60))) {
        $errors[] = '- You forgot to enter your email or the e-mail format is incorrect.';
    }


    $password1 = sanitizeString($_POST['password1']);
    if(empty($password1)) {
        $errors[] = '- You forgot to enter a password.';
    }else{
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,12}$/', $password1)){
            $errors[] = 'Invalid password, 8 to 12 chars, 1 upper, 1 lower, 1 number, 1 special.';
        }else{
            $password2 = sanitizeString($_POST['password2']);
            if ($password1 !== $password2) {
                $errors[] = '- Your two passwords did not match.';
            }
        }
    }

    $class = sanitizeString($_POST['level']);
    if(strlen($class) > 0 && strlen($class) <= 6 ){ //I didn't choose empty() as option's value might be 0.
        $class = $class;
    }else {
        $errors[] = 'Missing valid Level Selection.';
    }


    $address1 = sanitizeString($_POST['address1']);
    if (!empty($address1) && (preg_match('/[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*/', $address1)) && (strlen($address1) <= 30)){
        $address1 = $address1;
    } else {
        $errors[] = '- Missing address. Numeric, alphabetic, period, comma, dash and space.Max 30.';
    }


    $address2 = sanitizeString($_POST['address2']);
    if(!empty($address2) && (preg_match('/[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*/', $address2)) && (strlen($address2) <= 30)){
        $address2 = $address2;
    }else{
            $address2 = NULL;
        }


    $city = sanitizeString($_POST['city']);
    if (!empty($city) && preg_match('/[a-zA-Z][a-zA-Z\s\.]*/', $city) && (strlen($city) <= 30)){
        $city = $city;
    } else{
        $errors[] = '- Missing city. Only alphabetic, period and space. Max 30.';
    }


    $state_country = sanitizeString($_POST['state_country']);
    if (!empty($state_country) && preg_match('/[a-zA-Z][a-zA-Z\s\.]*/', $state_country) && (strlen($state_country) <= 30)){
        $state_country = $state_country;
    } else{
        $errors[] = '- Missing State/Country. Only alphabetic, period and space. Max 30.';
    }


    $zcode_pcode = sanitizeString($_POST['zcode_pcode']);
    if (!empty($zcode_pcode) && preg_match('/[a-zA-Z0-9][a-zA-Z0-9\s]*/', $zcode_pcode) && (strlen($zcode_pcode) <= 10)){
        $zcode_pcode = $zcode_pcode;
    } else{
        $errors[] = '- Missing zip code or post code. Alpha, numeric, space only max 30 characters';
    }


    $phone = sanitizeString($_POST['phone']);
    if (!empty($phone) && is_numeric($phone) && (strlen($phone) <= 15)){   //Mine. Book's way is different.
        $phone = $phone;
    } else{
        $phone = NULL;
    }



    $secret = sanitizeString($_POST['secret']);
    if ((!empty($secret)) && (preg_match('/[a-zA-Z][a-zA-Z\s\.\,\-]*/i', $secret)) && (strlen($secret) <= 30)) {
        $secret = $secret;
    }else{
        $errors[] = 'Missing secret answer. Only alphabetic, period, comma, dash and space. Max 30.';
    }


    //-------------------------------------- $errors array
        if(!empty($errors)){
            $errorString = implode("<br>", $errors);
        }elseif(empty($errors)){
            //Determine whether the email address has already been registered #2
            $query2 = "SELECT `email` FROM `users` WHERE email=?";
            $stmt2 = $dbcon->prepare($query2);
            $stmt2->bindParam(1,$email);
var_dump($stmt2); print_r($stmt2); print $query2;
            if($stmt2->execute()){
                if($stmt2->rowCount() === 0){
                    //The email address has not been registered
                    // Register the user in the database...
                    // Hash password current 60 characters but can increase
                    $query3 = "INSERT INTO `users` SET `userid`=NULL , `title`=?, `first_name`=?, `last_name`=?, `email`=?, `password`=?, `registration_date`=Now(), `user_level`=?, `class`=?, `address1`=?, `address2`=?, `city`=?, `state_country`=?, `zcode_pcode`=?, `phone`=?, `secret`=?";
                    $stmt3 = $dbcon->prepare($query3);
                    $passwordHshd = password_hash($password1, PASSWORD_DEFAULT);
                    $stmt3->bindParam(1 ,$title);
                    $stmt3->bindParam(2 ,$first_name);
                    $stmt3->bindParam(3 ,$last_name);
                    $stmt3->bindParam(4 ,$email);
                    $stmt3->bindParam(5 ,$passwordHshd);
                    $stmt3->bindParam(6 ,$user_level);
                    $stmt3->bindParam(7 ,$class);
                    $stmt3->bindParam(8 ,$address1);
                    $stmt3->bindParam(9 ,$address2);
                    $stmt3->bindParam(10 ,$city);
                    $stmt3->bindParam( 11,$state_country);
                    $stmt3->bindParam(12 ,$zcode_pcode);
                    $stmt3->bindParam(13 ,$phone);
                    $stmt3->bindParam(14 ,$secret);

                    if($stmt3->execute()){
                        if($stmt3->rowCount() === 1){
                            // One record inserted
                            header("location: register-thanks.php?class=" . $class);
                            exit();
                        }else{
                            // If it did not run OK.
                            // Public message:
                            $errorString = "- System Error<br />You could not be registered due to a system error. We apologize for any inconvenience.";
                            //echo '<p>' .$dbcon->error() . '<br><br>Query: ' . $query . '</p>';
                        }
                    }else{
                        // Debugging message below do not use in production
                        print_r($stmt2->errorInfo());
                        print "The system is busy please try later";
                    }
                    $dbcon = null; // Close the database connection.
                }else{
                    //The email address is already registered
                    $errorString = '- The email address is already registered.';
                }
            }else{
                // Debugging message below do not use in production
                print_r($stmt2->errorInfo());
                print "The system is busy please try later";
            }
        }
    }
}
    catch(Exception $e) // We finally handle any problems here #11
    {
        print "An Exception occurred. Message: " . $e->getMessage();
        print "The system is busy please try later";
    }
    catch(Error $e)
    {
        print "An Error occurred. Message: " . $e->getMessage();
        print "The system is busy please try again later.";
    }







