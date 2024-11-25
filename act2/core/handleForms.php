<?php
    require_once 'dbConfig.php';
    require_once 'functions.php';


    /* --- USERS --- */
    // REGISTER
    if (isset($_POST['btn_Register'])) {

        if (!empty($_POST['username']) && !empty($_POST['first_Name']) && !empty($_POST['last_Name']) && !empty($_POST['password'])) {

            $username = sanitizeInput($_POST['username']);
            $first_Name = sanitizeInput($_POST['first_Name']);
            $last_Name = sanitizeInput($_POST['last_Name']);

            if ($_POST['password'] == $_POST['password_conf']) {

                if (validatePassword(sanitizeInput($_POST['password']))) { // check password strength

                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // encrypt password
                    $result = register($pdo, $username, $first_Name, $last_Name, $password); // add user

                    $_SESSION['status'] = $result['status'];
                    $_SESSION['message'] = $result['message'];
                    header("Location: ../login.php");

                } else { // weak password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Password should be more than 8 characters and should contain both uppercase, lowercase, and numbers.";
                    header("Location: ../register.php");
                }
            } else { // passwords not the same
                $_SESSION['status'] = "400";
                $_SESSION['message'] = "Passwords are not the same";
                header("Location: ../register.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../register.php");
        }
    }

    // LOGIN
    if (isset($_POST['btn_Login'])) {

        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);

        if (!empty($username) && !empty($password)) {

            $check_User = check_UserExists($pdo, $username); 

            if ($check_User['status'] == '200') { // user found in database
                $username_FromDB = $check_User['userInfo']['username'];
                $password_FromDB = $check_User['userInfo']['password'];

                if (password_verify($password, $password_FromDB)) {

                    $_SESSION['username'] = $username_FromDB;
                    header('Location: ../index.php');
                    
                } else { // wrong password
                    $_SESSION['status'] = "400";
                    $_SESSION['message'] = "Wrong password.";
                    header("Location: ../login.php");
                }
            } else { // wrong username
                $_SESSION['status'] = $check_User['status'];
                $_SESSION['message'] = $check_User['message'];
                header("Location: ../login.php");
            }
        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../login.php");
        }
    }

    // LOGOUT
    if (isset($_GET['btn_Logout'])) {
        unset($_SESSION['username']);
        header('Location: ../index.php');
    }



    /* --- RECORDS --- */
    // CREATE
    if (isset($_POST['btn_Add'])) {
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $dob = sanitizeInput($_POST['dob']);
        $age = sanitizeInput($_POST['age']);
        $sex = sanitizeInput($_POST['sex']);
        $residence = sanitizeInput($_POST['residence']);
        $email = sanitizeInput($_POST['email']);
        $added_By = $_SESSION['username'];

        if (!empty($first_Name) && !empty($last_Name) && !empty($dob) && !empty($age) && !empty($sex) && !empty($residence) && !empty($email)) {

            $result = add_Record($pdo, $first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $added_By);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../index.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../create.php");
        }
    }

    // UPDATE
    if (isset($_POST['btn_Edit'])) {
        $first_Name = sanitizeInput($_POST['first_Name']);
        $last_Name = sanitizeInput($_POST['last_Name']);
        $dob = sanitizeInput($_POST['dob']);
        $age = sanitizeInput($_POST['age']);
        $sex = sanitizeInput($_POST['sex']);
        $residence = sanitizeInput($_POST['residence']);
        $email = sanitizeInput($_POST['email']);
        $applicant_id = $_GET['id'];

        if (!empty($first_Name) && !empty($last_Name) && !empty($dob) && !empty($age) && !empty($sex) && !empty($residence) && !empty($email)) {

            $result = update_Record($pdo, $first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $applicant_id);

            $_SESSION['status'] = $result['status'];
            $_SESSION['message'] = $result['message'];
            header("Location: ../index.php");

        } else { // missing info
            $_SESSION['status'] = "400";
            $_SESSION['message'] = "Missing info";
            header("Location: ../edit.php");
        }
    }

    // DELETE
    if (isset($_POST['btn_Delete'])) {
        $applicant_id = $_GET['id'];

        $result = delete_Record($pdo, $applicant_id);

        $_SESSION['status'] = $result['status'];
        $_SESSION['message'] = $result['message'];
        header("Location: ../index.php");
    }
?>