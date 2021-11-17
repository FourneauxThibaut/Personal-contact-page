<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
    
    $firstName = ($_POST['firstName']);
    $lastName = ($_POST['lastName']);
    $gender = ($_POST['gender']);
    $email = ($_POST['email']);
    $company = ($_POST['company']);
    $subject = ($_POST['subject']);
    $message = ($_POST['message']);

    // todo if $session 1-5 = error 
    if(isset($_SESSION) && !empty($_SESSION)) {
        header('location:index.php');
    }else{
        $mail = new PHPMailer(true);
        
        $mail->From = $email;
        $mail->Sender = $email;
        $mail->FromName = $firstName.' '.$lastName;

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.thibaut-fourneaux.be';            //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->SMTPKeepAlive = true;                                //SMTP connection will not close after each email sent, reduces SMTP overhead
            $mail->Username   = $_ENV['myEmail'];                       //SMTP username
            $mail->Password   = $_ENV['myPassword'];                    //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->addAddress('thibaut.fourneaux@outlook.com');
        
            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $subject;
            $mail->WordWrap   = 50; 			                        //Nombre de caracteres pour le retour a la ligne automatique
            $mail->Body    = 'This mail is from '.$firstName.' '.$lastName.' <br><br> '.$message;
        
            $mail->send();
            
            $message = 'Your Email has been shipped !';
            handleSuccess($message);

            header('location:index.php');
        } catch (Exception $e) {
            header('location:index.php');
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
                $input = utf8_decode($input);
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

    function handleSuccess($message){

        $_SESSION['success']="$message";
        
    }

    function handleError($field, $message ){
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
