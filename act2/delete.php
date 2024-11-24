<?php 
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deleting applicant record</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <?php $user_Record = getSpecific_Record($pdo, $_GET['id']); ?>

        <h1>Delete Record</h1>

        <div class="delete_Container">
            <h3>First Name: <?= $user_Record['first_Name']; ?></h3>
            <h3>Last Name: <?= $user_Record['last_Name']; ?></h3>
            <h3>Date of Birth: <?= $user_Record['dob']; ?></h3>
            <h3>Age: <?= $user_Record['age']; ?></h3>
            <h3>Sex: <?= $user_Record['sex']; ?></h3>
            <h3>Residence: <?= $user_Record['residence']; ?></h3>
            <h3>Email: <?= $user_Record['email']; ?></h3>
            <h3>Date Added: <?= $user_Record['date_Added']; ?></h3>

            <!-- DELETE -->
            <div class="deleteBtn">
                <form action="core/handleForms.php?id=<?= $_GET['id']; ?>" method="POST">
                    <input type="submit" name="btn_Delete" value="Delete">
                </form>
                <p><a href="index.php">Back to home</a></p>	
            </div>
        </div>
    </body>
</html>