<?php include "DBconnection.php"; 

class loginModel extends DBconnection {

    function goto($string){
        header("$string");
        exit();
    }
    function escape_string($string){
        return mysqli_real_escape_string($this->conn,$string);
    }
    function check_user($username,$password){
        $query = "SELECT * FROM user
        WHERE username = \"".$username."\" AND password = \"".$password."\" LIMIT 1";
        //print_r($query);
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            //die("<strong>WARNING:</strong><br>".mysqli_error());
        }
        return (($result->num_rows==1)?TRUE:FALSE);
    }
    function get_user($username,$password){
        $query = "SELECT * FROM user
        WHERE username = \"".$username."\" AND password = \"".$password."\" LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        // if there is an error in your query, an error message is displayed.
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }
}

class adminModel extends DBconnection {

    function addUser($user){
        $query = "INSERT INTO `user`(`user_id`, `username`, `password`, `fname`, `lname`, `role`, status) 
        VALUES (\"".$user['user_id']."\",\"".$user['username']."\",\"".$user['password']."\",\"".$user['fname']."\",
        \"".$user['lname']."\",\"".$user['role']."\",\"".$user['status']."\")";
        print_r($query);
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        }
        return '101';
    }
    function createwallet($wallet){
        $query="INSERT INTO `wallet`(`user_id`, `amount`) VALUES (\"".$wallet['user_id']."\",\"".$wallet['amount']."\")";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return FALSE;
        }
        return TRUE;
    }
    function removeUser($user){
        $query = "";
    }
    function updateUser($users){
        $query = "";
    }

    //reports
    function gettotalmembers(){
        $query="SELECT COUNT(memberID) totalmembers FROM member";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }
    function getlastweekmembers(){
        $query="SELECT COUNT(memberID) as lastweekmembers FROM (`member`) WHERE YEARWEEK( `regDate` + INTERVAL 1 WEEK ) = YEARWEEK( CURDATE( )  )";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }
    function getallfemales(){
        $query="SELECT COUNT(memberID) as numberoffemales FROM member WHERE gender = 'female'";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }
    function getallmales(){
        $query="SELECT COUNT(memberID) as numberofmales FROM member WHERE gender = 'male'";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }

}
class userModel extends DBconnection {
    function getuser($username){
        $query = "SELECT user_id, username, fname, lname, reg_date ,role,status FROM user
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