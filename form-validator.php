<?php

/*session is started if you don't write this line can't use $_Session  global variable*/
session_start();

// define variables and set to empty values
$firstName = $lastName = $gender = $email = $company = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = validate( ($_POST["name"]), 'text', 'required' );
    $firstName = validate( ($_POST['firstName']), 'text', 'required' );
    $lastName = validate( ($_POST['lastName']), 'text', 'required' );
    $gender = validate( ($_POST['gender']), 'text', 'required' );
    $email = validate( ($_POST['email']), 'email', 'required' );
    $company = validate( ($_POST['company']), 'text', 'required' );
    $subject = validate( ($_POST['subject']), 'text' );
    $message = validate( ($_POST['message']), 'text', 'required' );
} 

    function typeValidator( $input, $type )
    {
        if( $type == 'text' ){
            if( gettype($input) === 'string'){ 
                $input = trim($input);
                $input = stripslashes($input);
                $data = htmlspecialchars($data);
                return $input; 
            }
            else { 
                header('location:index.php?msg=1');
            }
        }
        if( $type == 'email' ){
            if( filter_var($email, FILTER_VALIDATE_EMAIL) ){ return $input; }
            else { return false; }
        }
    }

    function validate($input, $type, $option = null)
    {
        if ($option == "required")
        {
            if( !empty($_POST[$input]) ){
                typeValidator( $input, $type );
            }
            else{
                handleError($input, 'le champ '.$input.' est vide');
            }
        }
        else{
            typeValidator( $input, $type );
        }
    }

    function handleError($input, $message){
        /*session created*/
        $errorName = 'error' + $input;
        $_SESSION["$errorName"]="$message";
        var_dump($_SESSION);
        echo "<hr>";
        // header('location:index.php');
    }

?>