<?php

    /* --- INPUT SECURITY --- */
    function sanitizeInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validatePassword($password) {
        if (strlen($password) > 8) { // longer than 8 char
            $hasLower = false;
            $hasUpper = false;
            $hasNumber = false;

            for ($i = 0; $i < strlen($password); $i++) {
                if (ctype_lower($password[$i])) { // has lower case
                    $hasLower = true; 
                }
                elseif (ctype_upper($password[$i])) { // has upper case
                    $hasUpper = true; 
                }
                elseif (ctype_digit($password[$i])) { // has numbers
                    $hasNumber = true;
                }
                
                if ($hasLower && $hasUpper && $hasNumber) {
                    return true; 
                }
            }
        } else {
            return false; 
        }
    }



    /* --- USER ACCOUNTS --- */
    // CHECK IF ALREADY REGISTERED
    function check_UserExists($pdo, $username) {
        $response = array();

        $sql = "SELECT * FROM user_credentials WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$username])) {

            $userInfo = $stmt->fetch();

            if ($stmt->rowCount() > 0) { // user already in database
                $response = array(
                    "result" => true,
                    "status" => "200",
                    "userInfo" => $userInfo
                );
            } else { // green light for adding user
                $response = array(
                    "status" => "400",
                    "message" => "User not found in database"
                );
            }
        }

        return $response;
    }

    // REGISTER
    function register($pdo, $username, $first_Name, $last_Name, $password) {

        $response = array();
        $check_User = check_UserExists($pdo, $username);

        
        if (!$check_User['result']) {

            $sql = "INSERT INTO user_credentials (username, first_Name, last_Name, password) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$username, $first_Name, $last_Name, $password])) { // add user to database
                $response = array(
                    "status" => "200",
                    "message" => "User added"
                );
            } else {
                $response = array( // user already registered
                    "status" => "400",
                    "message" => "User already registered"
                );
            }
        }

        return $response;
    }

    // FETCH ALL
    function getAll_Users($pdo) {
        $sql = "SELECT * FROM user_credentials";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();
    
        if ($executeQuery) {
            return $query->fetchAll();
        }
    }



    /* --- ACTIVITY LOGS --- */
    // FETCH ALL
    function get_Logs($pdo) {
        $sql = "SELECT * FROM activity_logs";

        $query = $pdo->prepare($sql);

        if ($query->execute()) {
            return $query->fetchAll();
        }
    }

    // FETCH
    function update_Logs($pdo, $applicant_id) {
        $sql = "SELECT * FROM activity_Logs WHERE applicant_id = ? AND operation = 'UPDATE'";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$applicant_id]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // SEARCH
    function search_Logs($pdo, $searchQuery) {
        $sql = "SELECT * FROM activity_Logs WHERE CONCAT(operation, applicant_id, first_Name, last_Name, email, done_By, date_Committed) COLLATE utf8mb4_bin LIKE ? ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // LOG
    function log_Activity($pdo, $operation, $applicant_id, $first_Name, $last_Name, $email, $username) {
        $sql = "INSERT INTO activity_Logs (operation, applicant_id, first_Name, last_Name, email, done_By) VALUES (?,?,?,?,?,?)";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$operation, $applicant_id, $first_Name, $last_Name, $email, $username]);

        if ($executeQuery) {
            return true;
        }
    }



    /* --- RECORDS --- */
    // FETCH ALL
    function getAll_Records($pdo) {

        $sql = "SELECT * FROM applicants ORDER BY last_Name ASC";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute();

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // FETCH
    function getSpecific_Record($pdo, $applicant_id) {
        $sql = "SELECT * FROM applicants WHERE id = ?";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute([$applicant_id]);

        if ($executeQuery) {
            return $query->fetch();
        }
    }

    // SEARCH
    function search_Records($pdo, $searchQuery) {

        $sql = "SELECT * FROM applicants WHERE CONCAT(first_Name, last_Name, dob, age, sex, residence, email, date_Added, added_By, has_Been_Updated) COLLATE utf8mb4_bin LIKE ? ";

        $query = $pdo->prepare($sql);
        $executeQuery = $query->execute(["%" . $searchQuery . "%"]);

        if ($executeQuery) {
            return $query->fetchAll();
        }
    }

    // ADD
    function add_Record($pdo, $first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $added_By) {
        $result = array();

        $sql = "INSERT INTO applicants (first_Name, last_Name, dob, age, sex, residence, email, added_By, has_Been_Updated) VALUES (?,?,?,?,?,?,?,?,'FALSE')";   

        $query = $pdo->prepare($sql);
        $add_Record = $query->execute([$first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $added_By]);

        if ($add_Record) {
            $log_Sql = "SELECT * FROM applicants ORDER BY date_Added DESC LIMIT 1";
            
            $log_Query = $pdo->prepare($log_Sql);
            $log_Query->execute();

            $new_Record = $log_Query->fetch();


            $activity_Log = log_Activity($pdo, "INSERT", $new_Record['id'],
                $new_Record['first_Name'], $new_Record['last_Name'], $new_Record['email'],
                $_SESSION['username']);


            if ($activity_Log) {
                $result = array(
                    "status"=>"200",
                    "message"=>"Record saved!"
                );
            } else {
                $result = array(
                    "status"=>"400",
                    "message"=>"Record failed to save."
                );
            }
        } else {
            $result = array(
                "status"=>"400",
                "message"=>"Record failed to save."
            );
        }

        return $result;
    }

    // UPDATE
    function update_Record($pdo, $first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $record_id) {
        $result = array();

        $sql = "UPDATE applicants
                    SET first_Name = ?,
                        last_Name = ?,
                        dob = ?, 
                        age = ?,
                        sex = ?,
                        residence = ?,
                        email = ?,
                        has_Been_Updated = 'TRUE'
                    WHERE id = ?
                ";   

        $query = $pdo->prepare($sql);
        $update_Record = $query->execute([$first_Name, $last_Name, $dob, $age, $sex, $residence, $email, $record_id]);

        if ($update_Record) {
            $log_Sql = "SELECT * FROM applicants WHERE id = ?";
            
            $log_Query = $pdo->prepare($log_Sql);
            $log_Query->execute([$record_id]);

            $edited_Record = $log_Query->fetch();


            $activity_Log = log_Activity($pdo, "UPDATE", $edited_Record['id'],
                $edited_Record['first_Name'], $edited_Record['last_Name'], $edited_Record['email'],
                $_SESSION['username']);


            if ($activity_Log) {
                $result = array(
                    "status"=>"200",
                    "message"=>"Record updated!"
                );
            } else {
                $result = array(
                    "status"=>"400",
                    "message"=>"Record failed to update."
                );
            }
        } else {
            $result = array(
                "status"=>"400",
                "message"=>"Record failed to update."
            );
        }

        return $result;
    }

    // DELETE
    function delete_Record($pdo, $record_id) {

        $log_Sql = "SELECT * FROM applicants WHERE id = ?";
        
        $log_Query = $pdo->prepare($log_Sql);
        $log_Query->execute([$record_id]);

        $record_To_Delete = $log_Query->fetch();


        $activity_Log = log_Activity($pdo, "DELETE", $record_To_Delete['id'],
            $record_To_Delete['first_Name'], $record_To_Delete['last_Name'], $record_To_Delete['email'],
            $_SESSION['username']);


        if ($activity_Log) {

            $sql = "DELETE FROM applicants WHERE id = ?";

            $query = $pdo->prepare($sql);
            $executeQuery = $query->execute([$record_id]);

            if ($executeQuery) {
                $result = array(
                    "status"=>"200",
                    "message"=>"Record Deleted!"
                );
            } else {
                $result = array(
                    "status"=>"400",
                    "message"=>"Failed to delete record."
                );
            }
            
        } else {
            $result = array(
                "status"=>"400",
                "message"=>"Failed to delete record."
            );
        }

        return $result;
    }
?>