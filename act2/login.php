<?php
    require_once 'core/handleForms.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="login">
        <div class="center_Form">

            <!-- OPERATIONS MESSAGE: green text if it worked; otherwise red -->
            <?php
                if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

                    if ($_SESSION['status'] == "200") {

                        echo "<h1 class='center_Form' style='color: green;'>{$_SESSION['message']}</h1>";

                    } else {
                        echo "<h1 class='center_Form' style='color: red;'>{$_SESSION['message']}</h1>";
                    }
                }
                unset($_SESSION['message']);
                unset($_SESSION['status']);
            ?>

            
            <!-- INPUTS -->
            <h1 class="center_Form">LOGIN</h1>
            
            <form class="center_Form" action="core/handleForms.php" method="POST">

                <p> <!-- USERNAME -->
                    <label for="inp_uName">Username: </label>
                    <input type="text" id="inp_uName" name="username">
                </p>
                
                <p> <!-- PASSWORD -->
                    <label for="inp_uPass">Password: </label>
                    <input type="password" id="inp_uPass" name="password">
                </p>

                <!-- SUBMIT -->
                <input type="submit" value="login" id="loginBtn" name="btn_Login">
            </form>

            <!-- REGISTER -->
            <i><a href="register.php">Register</a></i>
        </div>
    </body>
</html>