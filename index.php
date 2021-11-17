<?php
if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Thibaut Fourneaux</h1>
        <?php 
            if(isset($_SESSION['success'])) { 
        ?>
        <div class="success">
            <?php echo $_SESSION["success"] ?>
        </div>
        <?php } ?>
    </header>
    <main>
        <section id="contactSection">
            <section id="contact">
                <h2>Contact</h2>
                <form action="form-validator.php" method="post">

                    <section class="nameContent">
                        <div>
                            <?php if(isset($_SESSION['errorfirstName'])) { ?>

                                <label for="firstName">FirstName</label>
                                <input type="text" name="firstName" id="firstName" placeholder="<?php echo $_SESSION["errorfirstName"] ?>">
                                
                            <?php
                                unset($_SESSION["errorfirstName"]); } else { 
                            ?>
                                <label for="firstName">FirstName</label>
                                <input type="text" name="firstName" id="firstName">
                                
                            <?php } ?>
                        </div>
                        <div>
                            <?php if(isset($_SESSION['errorlastName'])) { ?>

                            <label for="lastName">LastName</label>
                            <input type="text" name="lastName" id="lastName" placeholder="<?php echo $_SESSION["errorlastName"] ?>">

                            <?php
                            unset($_SESSION["errorlastName"]); } else { 
                            ?>
                            <label for="lastName">LastName</label>
                            <input type="text" name="lastName" id="lastName">

                            <?php } ?>
                        </div>
                    </section>

                    <section class="identityContent">
                        <div>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="round">
                                <option value="male" id="male">Male</option>
                                <option value="female" id="female">Female</option>
                            </select>
                        </div>
                        <div>
                            <?php if(isset($_SESSION['erroremail'])) { ?>

                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="<?php echo $_SESSION["erroremail"] ?>">

                            <?php
                            unset($_SESSION["erroremail"]); } else { 
                            ?>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email">

                            <?php } ?>
                        </div>
                    </section>
        
                    <section class="subtitleContent">
                        <div>
                            <?php if(isset($_SESSION['errorcompany'])) { ?>

                            <label for="company">Company</label>
                            <input type="text" name="company" id="company" placeholder="<?php echo $_SESSION["errorcompany"] ?>">

                            <?php
                            unset($_SESSION["errorcompany"]); } else { 
                            ?>
                            <label for="company">Company</label>
                            <input type="text" name="company" id="company">

                            <?php } ?>
                        </div>
                        <div>
                            <label for="subject">Subject</label>
                            <select name="subject" id="subject" class="round">
                                <option value="job" id="job">Job</option>
                                <option value="internship" id="internship">Internship</option>
                                <option selected value="Other" id="Other">Other</option>
                            </select>
                        </div>
                    </section>
                    <div>
                        <?php if(isset($_SESSION['errormessage'])) { ?>

                        <label for="message">Message</label>
                        <textarea id="message" name="message" placeholder="<?php echo $_SESSION["errormessage"] ?>"></textarea>

                        <?php
                        unset($_SESSION["errormessage"]); } else { 
                        ?>
                        <label for="message">Message</label>
                        <textarea id="message" name="message"></textarea>

                        <?php } ?>
                    </div>
                    <input type="submit" value="Submit">
                </form>
            </section>
            <?php 
                if(isset($_SESSION['success'])) { 
            ?>
                <section id="contactImage2">
            <?php } else { ?>
                <section id="contactImage1">
            <?php } ?>
            </section>
        </section>
    </main>
    <footer>
        <ul>
            <li>
                <a href="#">linkedin</a>
            </li>
            <li>
                <a href="#">github</a>
            </li>
            <li>
                <a href="#">codepen</a>
            </li>
        </ul>
    </footer>
</body>
</html>