<?php
    require_once 'core/handleForms.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="register">
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
            <h1 class="center_Form">REGISTER</h1>
            
            <form class="center_Form" action="core/handleForms.php" method="POST">

                <p> <!-- USERNAME -->
                    <label for="inp_uName">Username: </label>
                    <input type="text" id="inp_uName" name="username">
                </p>

                <p> <!-- FIRST NAME -->
                    <label for="inp_fName">First Name: </label>
                    <input type="text" id="inp_fName" name="first_Name">
                </p>

                <p> <!-- LAST NAME -->
                    <label for="inp_lName">Last Name: </label>
                    <input type="text" id="inp_lName" name="last_Name">
                </p>
                
                <p> <!-- PASSWORD -->
                    <label for="inp_Pass">Password: </label>
                    <input type="password" id="inp_Pass" name="password">
                </p>

                <p> <!-- CONFIRM PASSWORD -->
                    <label for="inp_Pass_Confirm">Confirm Password: </label>
                    <input type="password" id="inp_Pass_Confirm" name="password_conf">
                </p>

                 <!-- SUBMIT -->
                <input type="submit" value="Register" id="register_Btn" name="btn_Register">
            </form>

             <!-- LOGIN -->
            <i><a href="login.php">Back to login</a></i>
        </div>
    </body>
</html>