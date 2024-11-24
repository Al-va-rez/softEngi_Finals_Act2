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
        <title>Activity Logs</title>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    <body>
        <?php include 'navbar.php'; ?>

         <!-- SEARCH BOX -->
        <form class="below_Navbar" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="text" name="inp_Search" placeholder="search log...">
            <input type="submit" name="btn_Search">
            <!-- CLEAR SEARCH QUERY: and returns to normal logs page -->
            <p><a href="activity_Logs.php">Clear Search Query</a></p>
        </form>


        <!-- OPERATIONS MESSAGE: green text if it worked; otherwise red -->
        <?php if (isset($_SESSION['message'])) { ?>

            <?php if ($_SESSION['status'] == '200') { ?>
                <h1 style="color: green;"><?= $_SESSION['message']; ?></h1>
            <?php } else { ?>
                <h1 style="color: red;"><?= $_SESSION['message']; ?></h1>
            <?php } ?>
        <?php }
            unset($_SESSION['message']);
        ?>

        <!-- UPDATE LOGS OF SPECIFIC APPLICANT -->
        <?php if (isset($_GET['id'])) { ?>
            <h3 class="below_Navbar">Update history of Applicant <?= $_GET['id'] ?></h3>
            <table>
                <tr>
                    <th>Log ID</th>
                    <th>Done By</th>
                    <th>Date Committed</th>
                </tr>
                <?php $update_Logs = update_Logs($pdo, $_GET['id']); ?>
                <?php foreach ($update_Logs as $row) { ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['done_By'] ?></td>
                        <td><?= $row['date_Committed'] ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else { ?> <!-- ELSE, SHOW ALL LOGS -->
            <table>
                <tr>
                    <th>Log ID</th>
                    <th>Operation</th>
                    <th>Applicant ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Done By</th>
                    <th>Date Committed</th>
                </tr>
                <!-- ALL ACTIVITY LOGS -->
                <?php if (!isset($_GET['btn_Search'])) { ?>
                    <?php $get_Logs = get_Logs($pdo); ?>
                    <?php foreach ($get_Logs as $row) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>

                            <!-- CHANGE TEXT COLOR BASED ON OPERATION -->
                            <td
                                <?php if ($row['operation'] == 'INSERT') { ?> style="color:blue"
                                    <?php } else if ($row['operation'] == 'UPDATE') { ?> style="color:green"
                                    <?php } else if ($row['operation'] == 'DELETE') { ?> style="color:red"
                                <?php } ?>>

                                <!-- THE ACTUAL TEXT -->
                                <?= $row['operation'] ?>
                            </td>
                            
                            <td><?= $row['applicant_id'] ?></td>
                            <td><?= $row['first_Name'] ?></td>
                            <td><?= $row['last_Name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['done_By'] ?></td>
                            <td><?= $row['date_Committed'] ?></td>
                        </tr>
                    <?php } ?>
                <!-- SEARCHED LOGS -->
                <?php }  else { ?>
                    <?php $getSpecific_Logs = search_Logs($pdo, $_GET['inp_Search']); ?>

                    <?php foreach ($getSpecific_Logs as $row) { ?>
                        <tr>
                            <td><?= $row['id'] ?></td>

                            <!-- CHANGE TEXT COLOR BASED ON OPERATION -->
                            <td
                                <?php if ($row['operation'] == 'INSERT') { ?> style="color:blue"
                                    <?php } else if ($row['operation'] == 'UPDATE') { ?> style="color:green"
                                    <?php } else if ($row['operation'] == 'DELETE') { ?> style="color:red"
                                <?php } ?>>

                                <!-- THE ACTUAL TEXT -->
                                <?= $row['operation'] ?>
                            </td>
                            
                            <td><?= $row['applicant_id'] ?></td>
                            <td><?= $row['first_Name'] ?></td>
                            <td><?= $row['last_Name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['done_By'] ?></td>
                            <td><?= $row['date_Committed'] ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        <?php } ?>
    </body>
</html>