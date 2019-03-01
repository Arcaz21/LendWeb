 <?php include "../models/DBconnection.php"; 


class transactionModel extends DBconnection {
    //accounts function
    function goto($string){
        header("$string");
        exit();
    }
    function getaccounts(){
        $query = "SELECT  `accID`,  `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`, concat(fname,' ',mname,' ',lname) as name FROM `account` JOIN member ON member.memberID = account.memberID";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function getaccountcount($id){
        $query = "SELECT COUNT(accID) from account WHERE memberID = \"".$id."\"";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function getaccountcleared($id){
        $query = "SELECT COUNT(accID) from account WHERE memberID = \"".$id."\" AND status = 'cleared'";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function addaccount($account){
        $query="INSERT INTO `account`(`accID`,  `creditAmnt`, `memberID`, `balance`, `dailyPayment`, `startDate`, `dueDate`, `status`)
        VALUES (\"".$account['accID']."\",\"".$account['creditAmnt']."\",\"".$account['memberID']."\",\"".$account['totalCredit']."\",\"".$account['dailyPayment']."\",
        \"".$account['startDate']."\",\"".$account['dueDate']."\",\"".$account['status']."\")";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        }
        return '101';
    }
    function getpendingaccount(){
        $query = "SELECT concat(fname,' ',lname), creditAmnt, balance, dailyPayment, startDate, dueDate,reg_date FROM account JOIN user ON account.user_id = user.user_id";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;

    }
    function getexpectedcollection(){
        $query="SELECT *, SUM(dailyPayment) as TotalCollection FROM account WHERE status != 'cleared'";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;

    }

    //records function
    function getrecord($memberID){
        $query = "SELECT member.memberID as memID,records.accID,recordID,payment,dailyPayment,creditBalance,account.balance as accountbalance,AccuBal,AdvBal,recDate,
        description,records.status as recStatus FROM `member` JOIN account on account.memberID = member.memberID 
        JOIN records on records.accID = account.accID WHERE member.memberID = '$memberID' GROUP BY recDate DESC LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function getAllrecords(){
        $query="SELECT * FROM `member` JOIN account on account.memberID = member.memberID 
        JOIN records on records.accID = account.accID GROUP BY recDate";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function addrecord($record){
        $query="INSERT INTO `records`(`recordID`, `user_id`, `accID`, `payment`, `creditBalance`, `AccuBal`, `AdvBal`, `description`, `status`) 
        VALUES (\"".$record['recordID']."\",\"".$record['user_id']."\",\"".$record['accID']."\",\"".$record['payment']."\",\"".$record['balance']."\",\"".$record['AccuBal']."\",\"".$record['AdvBal']."\",\"".$record['description']."\",\"".$record['status']."\")";
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
    //Use When in LIVE Production
    // function getmembers($id){
    //     $query = "SELECT * FROM (SELECT account.status as accstatus, user_id,latest.accID,memberID,creditBalance,AccuBal,AdvBal, latest.status FROM(SELECT * FROM (SELECT * FROM (SELECT MAX(recDate) as latestdate FROM records GROUP BY accID) as latest_record INNER JOIN records ON records.recDate = latest_record.latestdate) as aa WHERE date(latestdate) != date(CURDATE())) as latest INNER JOIN account ON account.accID = latest.accID) as latest_account JOIN member ON member.memberID = latest_account.memberID WHERE user_id = \"".$id."\" AND accstatus = 'uncleared' OR accstatus = 'overdue' ";
    //     $result = mysqli_query($this->conn,$query);
    //     if(!$result) {
    //         die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
    //     }
    //     $res = array();
    //     while ($row = mysqli_fetch_array($result)){
    //         array_push($res, $row);
    //     }
    //     return ($result->num_rows>0)? $res: FALSE;
    // }
    function getmembers($id){
        $query = "SELECT * FROM (SELECT account.status as accstatus, user_id,latest.accID,memberID,creditBalance,AccuBal,AdvBal, latest.status FROM(SELECT * FROM (SELECT * FROM (SELECT MAX(recDate) as latestdate FROM records GROUP BY accID) as latest_record INNER JOIN records ON records.recDate = latest_record.latestdate ) as aa WHERE date(aa.recDate) != date(CURDATE()) && date(latestdate) != date(CURDATE()) ) as latest INNER JOIN account ON account.accID = latest.accID) as latest_account JOIN member ON member.memberID = latest_account.memberID WHERE user_id = \"".$id."\" AND accstatus = 'uncleared' OR accstatus = 'overdue'";
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

    function getmembers1(){
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
    function transact($transact){

        $payment = $transact['payment'];
        $accubal = $transact['accubal'];
        $advbal = $transact['advbal'];
        $daily = $transact['daily'];
        $balance = $transact['accountbalance'];

        if($accubal == 0.00 && $accubal == 0.00){
            if($payment == $balance){
                $transact['payment'] = $payment;
                $transact['AccuBal'] = "0.00";
                $transact['AdvBal'] = "0.00";
                $transact['description'] = "ACCOUNT DONE";;    
                $transact['status'] = "full";
                $transact['accstatus'] = "cleared";
                $transact['balance'] = ($balance-$payment);
                print_r($transact);
                $calculation = TRUE;
            }else{
                if($payment>$balance){
                    echo "ERROR";
                }else{
                    if($payment == $daily){
                        echo "DONE!";
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = "0.00";
                        $transact['AdvBal'] = "0.00";
                        $transact['description'] = "Normal Payment";;    
                        $transact['status'] = "partial";
                        $transact['accstatus'] = "uncleared";
                        $transact['balance'] = ($balance-$payment);
                        print_r($transact);
                        $calculation = TRUE;
                    }else{
                        if($payment>$daily){
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = "0.00";
                            $transact['AdvBal'] = $payment-$daily;
                            $transact['description'] = "Advance Payment";
                            $transact['status'] = "partial";
                            $transact['accstatus'] = "uncleared";
                            $transact['balance'] = ($balance-$payment);
                            print_r($transact);
                            $calculation = TRUE;
                        }else{
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = $daily-$payment;
                            $transact['AdvBal'] = "0.00";
                            $transact['description'] = "Accumulated Payment";   
                            $transact['status'] = "partial";
                            $transact['accstatus'] = "uncleared";
                            $transact['balance'] = ($balance-$payment);
                            print_r($transact);
                            $calculation = TRUE;
                        }
                    }
                }   
            }
        }else{
            if($payment == $balance){
                $transact['payment'] = $payment;
                $transact['AccuBal'] = "0.00";
                $transact['AdvBal'] = "0.00";
                $transact['description'] = "ACCOUNT DONE";;    
                $transact['status'] = "full";
                $transact['accstatus'] = "cleared";
                $transact['balance'] = ($balance-$payment);
                print_r($transact);
                $calculation = TRUE;
            }else{
                if($advbal != 0.00){
                    //has advance
                    if(($advbal+$payment) == $balance){
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = "0.00";
                        $transact['AdvBal'] = "0.00";
                        $transact['description'] = "ACCOUNT DONE!";    
                        $transact['status'] = "full";
                        $transact['accstatus'] = "cleared";
                        $transact['balance'] = ($balance-($advbal+$payment));
                        print_r($transact);
                        $calculation = TRUE;
                    }else{
                        if(($advbal+$payment)>$balance){
                            echo "ERROR LIMIT REACHED";
                            
                        }else{
                            if(($advbal+$payment) == $daily){
                                $transact['payment'] = $payment;
                                $transact['AccuBal'] = "0.00";
                                $transact['AdvBal'] = "0.00";
                                $transact['description'] = "Normal Payment";
                                $transact['status'] = "partial";
                                $transact['accstatus'] = "uncleared";
                                $transact['balance'] = ($balance-($advbal+$payment));
                                print_r($transact);
                                $calculation = TRUE;
                            }else{
                                if(($advbal+$payment)>$daily){
                                    $transact['payment'] = $payment;
                                    $transact['AccuBal'] = "0.00";
                                    $transact['AdvBal'] = "0.00";//(($advbal+$payment)-$daily);
                                    $transact['description'] = "Advance Payment";   
                                    $transact['status'] = "partial";
                                    $transact['accstatus'] = "uncleared";
                                    $transact['balance'] = ($balance-($advbal+$payment));
                                    print_r($transact);
                                    $calculation = TRUE;
                                }else{
                                    $transact['payment'] = $payment;
                                    $transact['AccuBal'] = $daily-($advbal-$payment);
                                    $transact['AdvBal'] = "0.00";
                                    $transact['description'] = "Accumulated Payment";    
                                    $transact['status'] = "partial";
                                    $transact['accstatus'] = "uncleared";
                                    $transact['balance'] = ($balance-($advbal+$payment));
                                    print_r($transact);
                                    $calculation = TRUE;
                                }
                            }
                        }
                    }
                }else{
                    if($accubal != 0.00){
                        //has accumulated
                        print_r(abs($accubal-$payment));
                        if(abs($accubal-$payment) == $balance){
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = "0.00";
                            $transact['AdvBal'] = "0.00";
                            $transact['description'] = "ACCOUNT DONE!";    
                            $transact['status'] = "full";
                            $transact['accstatus'] = "cleared";
                            $transact['balance'] = ($balance-abs($accubal-$payment));
                            print_r($transact);
                            $calculation = TRUE;
                        }else{
                            if(abs($accubal-$payment)>$balance){
                                echo "ERROR! LIMIT REACHED";
                                
                            }else{
                                if(abs($accubal+$daily)==$payment){
                                    $transact['payment'] = $payment;
                                    $transact['AccuBal'] = "0.00";
                                    $transact['AdvBal'] = "0.00";
                                    $transact['description'] = "Normal Payment";    
                                    $transact['status'] = "partial";
                                    $transact['accstatus'] = "uncleared";
                                    $transact['balance'] = ($balance);
                                    print_r($transact);
                                    $calculation = TRUE;
                                }else{
                                    if(abs($accubal+$daily)>$payment){
                                            $transact['payment'] = $payment;
                                            $transact['AccuBal'] = abs(($accubal+$daily)-$payment);
                                            $transact['AdvBal'] = "0.00";
                                            $transact['description'] = "Accumulated Payment";    
                                            $transact['status'] = "partial";
                                            $transact['accstatus'] = "uncleared";
                                            $transact['balance'] = ($balance);
                                            print_r($transact);
                                            $calculation = TRUE;
                                        
                                    }else{
                                        $transact['payment'] = $payment;
                                        $transact['AccuBal'] = "0.00";
                                        $transact['AdvBal'] = abs(abs($accubal+$daily)-$payment);
                                        $transact['description'] = "Advance Payment";    
                                        $transact['status'] = "partial"; 
                                        $transact['accstatus'] = "uncleared";
                                        $transact['balance'] = abs($balance-$daily);
                                        print_r($transact);
                                        $calculation = TRUE;
                                    }
                                }
                            }
                        }
                    }
                }
            }   
        }
        
        if($calculation == TRUE){
            $query="INSERT INTO `records`(`recordID`,`user_id`, `accID`, `payment`, `AccuBal`,`creditBalance`, `AdvBal`, `description`, `status`) 
            VALUES (\"".$transact['recordID']."\",\"".$transact['user_id']."\",\"".$transact['accID']."\",\"".$transact['payment']."\",\"".$transact['AccuBal']."\",\"".$transact['balance']."\",\"".$transact['AdvBal']."\",\"".$transact['description']."\",\"".$transact['status']."\")";
            print_r($query);
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }
            $query = "UPDATE `account` SET `balance`=\"".$transact['balance']."\",`status`=\"".$transact['accstatus']."\" WHERE `accID` = \"".$transact['accID']."\"";
            print_r($query);
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            } 
            $query = "UPDATE `wallet` SET `amount`= `amount` + \"".$transact['payment']."\" WHERE user_id = \"".$transact['user_id']."\"";
            print_r($query);
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }
            $query="INSERT INTO `wallet_record`(`wid`, `amount`, `type`, `description`) 
            VALUES (\"".$transact['wid']."\",
            \"".$transact['amount']."\",
            \"".$transact['type']."\",
            \"".$transact['description_wallet']."\")";
            print_r($query);
            $result = mysqli_query($this->conn,$query);
            if(!$result){
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
                return mysqli_error($this->conn);
            }  
            return "101";
        }
    }

    function currtotalcollection($id){
        $query="SELECT sum(payment) as TotalCollection FROM records WHERE date(recDate) = date(CURDATE()) && user_id = \"".$id."\"";
        $result = mysqli_query($this->conn, $query);
        $res = array();
        while ($row = mysqli_fetch_array($result)){
            array_push($res, $row);
        }
        return ($result->num_rows>0)? $res: FALSE;
    }
    function gettotalwallet($id){
        $query="SELECT amount as TotalWallet FROM wallet WHERE user_id = \"".$id."\"";
        $result = mysqli_query($this->conn, $query);
        // if there is an error in your query, an error message is displayed.
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }


    //wallet function
    function getwallet($id){
        $query="SELECT * FROM wallet WHERE user_id = \"".$id."\"";
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
    function getwalletid($id){
        $query="SELECT wid from wallet where user_id = \"".$id."\" ";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;

    }
    function addexp($exp){
        $query="UPDATE `wallet`SET amount =  (amount - \"".$exp['amount']."\") WHERE user_id = \"".$exp['user_id']."\" ";
        print($query);
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
            return FALSE;
        }
        $query="INSERT INTO `wallet_record`(`wid`, `amount`, `type`, `description`) 
        VALUES (\"".$exp['wid']."\",
        \"".$exp['amount']."\",
        \"".$exp['type']."\",
        \""."Reference Number: ".$exp['refnumber']." Purpose: ".$exp['purpose']."\")";
        print($query); 
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
            return FALSE;
        }
        return TRUE;
    }
    function newwallet($exp){
        $query="INSERT INTO `wallet`(`user_id`) VALUES (\"".$exp['user_id']."\")";
        print($query);
        $result = mysqli_query($this->conn, $query);
            if(!$result) {
                die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
                return FALSE;
            }
            return TRUE;
    }
    function subwallet_addmember($exp){
        $query="UPDATE `wallet`SET amount =  (amount - \"".$exp['amount']."\") WHERE user_id = \"".$exp['user_id']."\" ";
        print($query);
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
            return FALSE;
        }
        $query="INSERT INTO `wallet_record`(`wid`, `amount`, `type`, `description`) 
        VALUES (\"".$exp['wid']."\",
        \"".$exp['amount']."\",
        \"".$exp['type']."\",
        \"".$exp['description']."\")";
        print($query); 
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
            return FALSE;
        }
        return TRUE;
    }
    function getexp($wid){
        $query="SELECT SUM(amount) as exptotal FROM wallet_record WHERE date(recDate) = date(CURDATE()) && type = 'expenses' && wid = \"".$wid."\" ";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
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

    function deleteuser($status){

        $query="UPDATE user SET status = \"".$status."\"";

        // $query = "DELETE FROM `user` WHERE user_id = \"".$id."\"";
        // $result = mysqli_query($this->conn, $query);
        // if(!$result){
        //     die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn)); 
        //     return FALSE;
        // }return TRUE;
    }
    
}
class userModel extends DBconnection {
    function getuser($username){
        $query = "SELECT user_id, username,password, fname, lname, reg_date ,role FROM user
				WHERE username = \"".$username."\" LIMIT 1";
        $result = mysqli_query($this->conn, $query);
        if(!$result) {
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        }
        $row = $result->fetch_object();
        return $row;
    }
    function getusers(){
        $query = "SELECT user_id, username, password, fname, lname, reg_date ,role,status FROM user";
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
}
?>