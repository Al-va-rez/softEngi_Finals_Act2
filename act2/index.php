<?php
    require_once 'core/dbConfig.php';
    require_once 'core/functions.php';

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Searching Records</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <!-- NAVBAR -->
        <?php include 'navbar.php'; ?>


        <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search record...">
            <input type="submit" name="btn_Search">
            <p><a href="index.php">Clear Search Query</a></p>
        </form>


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


        <!-- SEARCH RESULTS -->
        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Residence</th>
                <th>Email</th>
                <th>Date Added</th>
                <th>Added By</th>
                <th>Has Been Updated</th>
                <th>Action</th>
            </tr>

            <!-- DISPLAY ALL RECORDS -->
            <?php if (!isset($_GET['btn_Search'])) { ?>
                <?php $getAllRecords = getAll_Records($pdo); ?>
                
                <?php foreach ($getAllRecords as $row) { ?>
                    <tr>
                        <td><?= $row['first_Name'] ?></td>
                        <td><?= $row['last_Name'] ?></td>
                        <td><?= $row['dob'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['sex'] ?></td>
                        <td><?= $row['residence'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['date_Added'] ?></td>
                        <td><?= $row['added_By'] ?></td>
                        <td> <!-- HYPERLINK TO UPDATE HISTORY: to easily determine all instances of change made in a specific record -->
                            <?php if ($row['has_Been_Updated'] == 'TRUE') { ?>
                                <a href="activity_Logs.php?id=<?= $row['id'] ?>"><?= 'TRUE' ?></a>
                            <?php } else { ?>
                                <?= 'FALSE' ?><?php } ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                
            <!-- DISPLAY SEARCHED RECORD/S -->
            <?php } else { ?>
                <?php $getRecord = search_Records($pdo, $_GET['inp_Search']); ?>
                
                <?php foreach ($getRecord as $row) { ?>
                    <tr>
                        <td><?= $row['first_Name'] ?></td>
                        <td><?= $row['last_Name'] ?></td>
                        <td><?= $row['dob'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['sex'] ?></td>
                        <td><?= $row['residence'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['date_Added'] ?></td>
                        <td><?= $row['added_By'] ?></td>
                        <td> <!-- HYPERLINK TO UPDATE HISTORY: to easily determine all instances of change made in a specific record -->
                            <?php if ($row['has_Been_Updated'] == 'TRUE') { ?>
                                <a href="activity_Logs.php?id=<?= $row['id'] ?>"><?= 'TRUE' ?></a>
                            <?php } else { ?>
                                <?= 'FALSE' ?><?php } ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
        </table>
    </body>
</html>