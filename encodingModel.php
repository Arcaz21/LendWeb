<?php include "../models/DBconnection.php";  

    class encodingModel extends DBconnection {

        function addmember($encode){
            $query = "INSERT INTO `member`(`memberID`, `fname`, `lname`,`mname`,`contact`,`address`) 
            VALUES (\"".$encode['memberID']."\",\"".$encode['fname']."\",\"".$encode['lname']."\",\"".$encode['mname']."\",\"".$encode['contact']."\",\"".$encode['address']."\")";
            $result = mysqli_query($this->conn,$query);
            if(!$result){
               die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }
            return '101';
        }

        function addaccount($encode){
            $query="INSERT INTO `account`(`accID`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`)
            VALUES (\"".$encode['accID']."\",\"".$encode['memberID']."\",\"".$encode['balance']."\",\"".$encode['dailyP']."\",
            \"".$encode['startDate']."\",\"".$encode['dueDate']."\",\"".$encode['status']."\")";
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }
            return '101';

        }

        function addRecord($encode){
            $query="INSERT INTO `records`(`recordID`, `accID`, `payment`, `creditBalance`, `AccuBal`, `AdvBal`, `recDate`, `description`, `status`)
            VALUES (\"".$encode['recordID']."\",\"".$encode['accID']."\",\"".$encode['payment']."\",\"".$encode['balance']."\",\"".$encode['AccuBal']."\",\"".$encode['AdvBal']."\",\"".$encode['regDate']."\",\"".$encode['description']."\",\"".$encode['status']."\")";
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }
            return '101';
        }
    }
    class userModel extends DBconnection {
        function getuser($username){
            $query = "SELECT user_id, username, fname, lname, reg_date ,role FROM user
                    WHERE username = \"".$username."\" LIMIT 1";
            $result = mysqli_query($this->conn, $query);
            if(!$result) {
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            }
            $row = $result->fetch_object();
            return $row;
        }
    }
?>