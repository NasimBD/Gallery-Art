<?php
function sanitizeString($var)
{
    if(is_array($var)){
        foreach ($var as $element){
            if(!is_array($element)){
                $element = sanitizeString($element);
            }
        }
    }else{
        $var = trim($var);
        if (get_magic_quotes_gpc())
            $var = stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
    }
    return $var;
}


// sticky select wherein $name is the select field name and $value is the option's value under assessment.
function stickySelect($name, $value){
    if(isset($_REQUEST[$name]) && $_REQUEST[$name] == $value){
        return "selected";
    }
}


// sticky select wherein $classs is the option value opted formerly and not the recent $_POST array.
function stickySelect2($classs, $value){
    if (isset($classs) && $classs == $value) {
        return "selected";
    }
}


// prints a form with different fields
function form($title,$first_name,$last_name,$email,$address1,$address2,$city,$state_country,$zcode_pcode,$phone,$paid,$options){
    echo '
<h2 class="text-center">Please edit the information:</h2>
<div class="card border-0 px-3">
                <div class="card-body">
                    <form action="" id="editFrm" method="post">
                        <div class="form-group row mx-0">
                         <label for="title" class="col-md-4 col-form-label">Title:</label>
                            <input type="text" class="form-control col-md-8" id="title" name="title" value="'.$title.'"  maxlength="12" pattern=\'[a-zA-Z][a-zA-Z\s\.]*\' title="Alphabetic, period and space max 12 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="first_name" class="col-md-4 col-form-label">&ast;First Name:</label>
                            <input type="text" class="form-control col-md-8" id="first_name" name="first_name" value="'.$first_name.'" required maxlength="30" pattern="[a-zA-Z][a-zA-Z\s]*" title="Alphabetic and space only max of 30 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="last_name" class="col-md-4 col-form-label">&ast;Last Name:</label>
                            <input type="text" class="form-control col-md-8" id="last_name" name="last_name" value="'.$last_name.'" required maxlength="40" pattern="[a-zA-Z][a-zA-Z\s\-\']*" title="Alphabetic and space only max of 40 characters">
                        </div>

                        <div class="form-group row mx-0">
                            <label for="email" class="col-md-4 col-form-label">&ast;Email:</label>
                            <input type="email" class="form-control col-md-8" id="email" name="email" value="'.$email.'" required maxlength="50">
                        </div>

                         <div class="form-group row mx-0">
                            <label for="level" class="col-md-4 col-form-label">&ast;Membership Class</label>
                            <select name="level" id="level" class="custom-select col-md-8" required>
                                <option value="">select</option>
                                '.$options.'
                            </select>
                        </div>


                        <div class="form-group row mx-0">
                            <label for="address1" class="col-md-4 col-form-label">&ast;Address:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="address1" name="address1" value="'.$address1.'" required pattern="[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*"
                                   title="Alphabetic, numbers, period, comma, dash and space only max of 30
characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="address2" class="col-md-4 col-form-label">Address:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="address2" name="address2" value="'.$address2.'" pattern="[a-zA-Z0-9][a-zA-Z0-9\s\.\,\-]*"
                                   title="Alphabetic, numbers, period, comma, dash and space only max of 30
characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="city" class="col-md-4 col-form-label">&ast;City:</label>
                            <input type="text" class="form-control col-md-8" maxlength="50" id="city" name="city" value="'.$city.'" required pattern="[a-zA-Z][a-zA-Z\s\.]*" title="Alphabetic, period and space only max of 30 characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="state_country:" class="col-md-4 col-form-label">&ast;State/Country:</label>
                            <input type="text" class="form-control col-md-8" maxlength="25" id="state_country" name="state_country" value='.$state_country.' required pattern="[a-zA-Z][a-zA-Z\s\.]*"
                                   title="Alphabetic, period and space only max of 30 characters">
                        </div>


                        <div class="form-group row mx-0">
                            <label for="zcode_pcode" class="col-md-4 col-form-label">&ast;Zip Code/Post Code:</label>
                            <input type="text" class="form-control col-md-8" maxlength="10" id="zcode_pcode" name="zcode_pcode" value="'.$zcode_pcode.'" required pattern="[a-zA-Z0-9][a-zA-Z0-9\s]*"
                                   title="Alphabetic, period and space only max of 30 characters">
                        </div>
                    
                       <div class="form-group row mx-0">
                            <label for="phone" class="col-md-4 col-form-label">Phone Number:</label>
                            <input type="tel" class="form-control col-md-8" maxlength="15" id="phone" name="phone" value="'.$phone.'">
                        </div>
                        
                        
                        <div class="form-group row mx-0">
                            <label for="paid" class="col-md-4 col-form-label">Paid:</label>
                            <input type="text" class="form-control col-md-8" id="paid" name="paid" value="'.$paid.'" required maxlength="3">
                        </div>
                        
                        
                        <input type="hidden" name="id" value="<?php echo $id ?>" />
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-8">
                                <div class="float-left g-recaptcha"
                                     data-sitekey="Yourdatakeygoeshere"></div>
                                </div>
                        </div>
                                              
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <input id="editRecord" class="btn btn-warning" type="submit" name="editRecord" value="Submit">
                                <input id="editRecord" class="btn btn-secondary" type="submit" name="cancel" value="Cancel">
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>';
}



function stickyCheck($name, $value){
    if(isset($_POST['submit'], $_POST[$name])){
        if(is_array($_POST[$name])){
            if(in_array($value, $_POST[$name])){
                echo 'checked';
            }
        }else{
            if($_POST[$name] === $value){
                echo 'checked';
            }
        }
    }
}