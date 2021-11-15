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
    <title>Document</title>
</head>
<body>
    <header>
        <h1>Thibaut Fourneaux</h1>
    </header>
    <main>
        <section id="contact">
            <form action="form-validator.php" method="post">
                <div>
                    <div>
                        <label for="firstName">FirstName</label>
                        <input type="text" name="firstName" id="firstName">
                        <?php
                            if(isset($_SESSION['errorfirstName']))
                            {
                                echo $_SESSION["errorfirstName"];
                                // unset($_SESSION["errorfirstName"]);
                            }
                        ?>
                    </div>
                    <div>
                        <label for="lastName">LastName</label>
                        <input type="text" name="lastName" id="lastName">
                    </div>
                </div>
                <div>
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="male" id="male">Male</option>
                        <option value="female" id="female">Female</option>
                    </select>
                </div>
                <div>
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email">
                </div>
                <div>
                    <label for="company">Company</label>
                    <input type="text" name="company" id="company">
                </div>
                <div>
                    <label for="subject">Subject</label>
                    <select name="subject" id="subject">
                        <option value="job" id="job">Job</option>
                        <option value="internship" id="internship">Internship</option>
                        <option selected value="Other" id="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message"
                            rows="5" cols="33">
                    </textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </section>
    </main>
    <footer>
        <ul>
            <li>
                <a href="mailto:fourneaux.thibaut@gmail.com">fourneaux.thibaut@gmail.com</a>
            </li>
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