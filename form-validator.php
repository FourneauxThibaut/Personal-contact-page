<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
clearSession();

// define variables and set to empty values
$firstName = $lastName = $gender = $email = $company = $subject = $message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = validate( ($_POST['firstName']), 'firstName', 'text', 'required' );
    $lastName = validate( ($_POST['lastName']), 'lastName', 'text', 'required' );
    $gender = validate( ($_POST['gender']), 'gender', 'text', 'required' );
    $email = validate( ($_POST['email']), 'email', 'email', 'required' );
    $company = validate( ($_POST['company']), 'company', 'text', 'required' );
    $subject = validate( ($_POST['subject']), 'subject', 'text' );
    $message = validate( ($_POST['message']), 'message', 'text', 'required' );

    // todo if $session 1-5 = error 
    if(isset($_SESSION) && !empty($_SESSION)) {
        header('location:index.php');
    }else{
        $mail = new PHPMailer(true);
        $mailTo = 'thibaut.fourneaux@outlook.com';
        
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'user@example.com';                     //SMTP username
            $mail->Password   = 'secret';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('from@example.com', 'Mailer');
            $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');
        
            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
} 

    function typeValidator( $input, $field, $type )
    {
        if( $type == 'text' ){
            if( gettype($input) === 'string'){ 
                $input = trim($input);
                $input = stripslashes($input);
                $input = htmlspecialchars($input);
                return $input; 
            }
            else { 
                $message = 'the field '.$field.' isn\'t a valid format';
                handleError($field, $message); 
            }
        }
        if( $type == 'email' ){
            if(filter_var($input, FILTER_VALIDATE_EMAIL) !== false) {
                return $input;
            }
            else { 
                $message = 'the field '.$field.' isn\'t a valid email';
                handleError($field, $message); 
            }
        }
    }

    function validate($input, $field, $type, $option = null)
    {
        if ($option == "required")
        {
            if( !empty($input) ){
                typeValidator( $input, $field, $type );
            }
            else{
                $message = 'the field '.$field.' is empty';
                handleError($field, $message);
            }
        }
        else{
            typeValidator( $input, $field, $type );
        }
    }

    function handleError($field, $message){
        /*session create*/
        $errorName = 'error'.$field;
        $_SESSION[$errorName]="$message";
    }

    function clearSession(){
        $helper = array_keys($_SESSION);
        foreach ($helper as $key){
            unset($_SESSION[$key]);
        }
    }

?>
