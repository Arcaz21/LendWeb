 <?php include "../models/DBconnection.php"; 


class transactionModel extends DBconnection {
    //accounts function
    function getaccounts($trans){
        $query = "SELECT `accID`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status` FROM `account`";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function addaccount($account){
        $query="INSERT INTO `account`(`accID`, `creditAmnt`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`)
        VALUES (\"".$account['accID']."\",\"".$account['creditAmnt']."\",\"".$account['memberID']."\",\"".$account['totalCredit']."\",\"".$account['dailyPayment']."\",
        \"".$account['startDate']."\",\"".$account['dueDate']."\",\"".$account['status']."\")";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        }
        return '101';

    }

    //records function
    function getrecord($memberID){
        $query = "SELECT member.memberID as memID,records.accID,recordID,payment,creditBalance,AccuBal,AdvBal,recDate,
        description,records.status as recStatus FROM `member` JOIN account on account.memberID = member.memberID 
        JOIN records on records.accID = account.accID WHERE member.memberID = '$memberID' GROUP BY recDate DESC LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function addrecord($record){
        $query="INSERT INTO `records`(`recordID`, `accID`, `payment`, `AccuBal`, `AdvBal`, `description`) 
        VALUES (\"".$record['recordID']."\",\"".$record['accID']."\",\"".$record['payment']."\",\"".$record['AccuBal']."\",\"".$record['AdvBal']."\",\"".$record['description']."\")";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        }
        return '101';
    }

    //members functions
    function addmember($member){
        
        $query = "INSERT INTO `member`(`memberID`, `fname`, `lname`, `mname`, `contact`, `address`, `gender`, `rating`) 
        VALUES (\"".$member['memberID']."\",\"".$member['fname']."\",\"".$member['lname']."\",
        \"".$member['mname']."\",\"".$member['contact']."\",\"".$member['address']."\",\"".$member['gender']."\",\"".$member['rating']."\")";
        $result = mysqli_query($this->conn, $query);
		    if(!$result) {
				return mysqli_error($this->conn);
			}
			return '101';
    }
    function getmembers(){
        $query = "SELECT * FROM `member`";
        $result = mysqli_query($this->conn,$query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function calculate($member){
            if($member['amount'] != NULL){
                //interest and dialy payment calculation
                $account['days'] = 60;
                $account['creditAmnt'] =$member['amount'];
                $account['interest'] = ($member['amount']*.20);
                $account['totalCredit'] = $member['amount'] + $account['interest'];
                $account['dailyPayment'] = $account['totalCredit']/$account['days'];

                //date calculation
                $account['startDate'] = date('Y-m-d H:m:s');
                $account['dueDate'] = date('Y-m-d H:m:s', strtotime("+60 days"));

                //default status
                $account['status'] = "uncleared";
                return $account;
            }else{return FALSE;}
            

    }

    //unused functions    
    function checkid($memberID){
        $query = "SELECT * FROM member WHERE `memberID` = $memberID";
        $result = mysqli_query($this->conn, $query);
		if(!$result) {
			die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
			return FALSE;
		}
		return (($result->num_rows>0)? TRUE: FALSE);
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