 <?php include "../models/DBconnection.php"; 


class transactionModel extends DBconnection {

    function getaccount($trans){
        $query = "SELECT `accID`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status` FROM `account`";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function addaccount($account){
        
    }
    function addmember($member){
        $query = "INSERT INTO `member`(`memberID`, `fname`, `lname`, `contact`, `address`, `rating`) 
        VALUES (\"".$member['memberID']."\",\"".$member['fname']."\",\"".$member['lname']."\",
        \"".$member['contact']."\",\"".$member['address']."\",\"".$member['rating']."\")";
        $result = mysqli_query($this->conn, $query);
		    if(!$result) {
				die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
				return FALSE;
			}
			return TRUE;
    }
    function checkid($memberID){
        $query = "SELECT * FROM member WHERE `memberID` = $memberID";
        $result = mysqli_query($this->conn, $query);
		if(!$result) {
			die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
			return FALSE;
		}
		return (($result->num_rows>0)? TRUE: FALSE);
    }

    function addtranscation(){

    }
    
    function addloan(){

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