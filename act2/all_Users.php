<?php  
    require_once 'core/functions.php'; 
    require_once 'core/handleForms.php'; 

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <?php include 'navbar.php'; ?>

        <h2 class="below_Navbar">All Users</h2>
        <table>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date Added</th>
            </tr>
            <?php $getAll_Users = getAll_Users($pdo); ?>
            <?php foreach ($getAll_Users as $row) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['first_Name'] ?></td>
                    <td><?= $row['last_Name'] ?></td>
                    <td><?= $row['date_Added'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </body>
</html>