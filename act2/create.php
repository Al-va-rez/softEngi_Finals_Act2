<?php
    require_once 'core/handleForms.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Adding applicant</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body class="add_Record">
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
            <h1 class="center_Form">Add record</h1>

            <form class="center_Form" action="core/handleForms.php" method="POST">

                <p> <!-- FIRST NAME -->
                    <label for="first_Name">First Name: </label> 
                    <input type="text" name="first_Name">
                </p>

                <p> <!-- LAST NAME -->
                    <label for="last_Name">Last Name: </label> 
                    <input type="text" name="last_Name">
                </p>

                <p> <!-- DATE OF BIRTH -->
                    <label for="dob">Date of Birth: </label> 
                    <input type="date" name="dob">
                </p>

                <p> <!-- AGE -->
                    <label for="age">Age:</label>
                    <input type="number" name="age" min="18" max="75">
                </p>

                <p> <!-- SEX -->
                    <label for="sex">Sex: </label>

                    
                    <input type="radio" name="sex" id="option1" value="Male">
                    <label class="radio_button" for="option1">M</label>

                    <input type="radio" name="sex" id="option2" value="Female">
                    <label class="radio_button" for="option2">F</label>
                </p>

                <p> <!-- RESIDENCE -->
                    <label for="residence">Residence: </label> 
                    <input type="text" name="residence">
                </p>

                <p> <!-- EMAIL -->
                    <label for="email">Email: </label> 
                    <input type="email" name="email">
                </p>

                 <!-- SUBMIT -->
                <input type="submit" name="btn_Add">
            </form>

            <i><a href="index.php">Back to home</a></i>
        </div>
    </body>
</html>