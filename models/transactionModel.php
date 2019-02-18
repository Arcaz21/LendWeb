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
        $query="INSERT INTO `records`(`recordID`, `accID`, `payment`, `AccuBal`, `AdvBal`, `description`, `status`) 
        VALUES (\"".$record['recordID']."\",\"".$record['accID']."\",\"".$record['payment']."\",\"".$record['AccuBal']."\",\"".$record['AdvBal']."\",\"".$record['description']."\",\"".$record['status']."\")";
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
        $query = "SELECT *,account.memberID as accMemberID FROM `member` JOIN account ON account.memberID = member.memberID";
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
        if($balance > $payment+$advbal){
            if($advbal == 0){
                echo "No advance balance. ";
            if($accubal == 0){
                echo"No accumulated balance. ";
                if($daily > $payment){
                    $remainder = abs($daily-$payment);
                    $accubal = $accubal+$remainder;
                        echo "Accumulated Balance: ".$accubal;
                        echo "Advance Balance: ".$advbal;
                        echo "Total Balance: ".($balance-$payment);
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = $accubal;
                        $transact['AdvBal'] = ($advbal);
                        $transact['description'] = "Normal Payment";;    
                        $transact['status'] = "partial";
                        $transact['balance'] = ($balance-$payment);
                }else{
                    if($daily == $payment){
                        $remaining = abs($daily-$payment);
                        echo "Accumulated Balance: ".$accubal;
                        echo "Advance Balance: ".$advbal;
                        echo "Total Balance: ".($balance-$payment);
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = $accubal;
                        $transact['AdvBal'] = ($advbal);
                        $transact['description'] = "Normal Payment";
                        $transact['status'] = "partial";
                        $transact['balance'] = ($balance-$payment);
                    }else{
                        $advbal = $advbal+abs($daily-$payment);
                        echo "Accumulated Balance: ".$accubal;
                        echo "Advance Balance: ".$advbal;
                        echo "Total Balance: ".($balance-$payment);
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = $accubal;
                        $transact['AdvBal'] = ($advbal);
                        $transact['description'] = "Normal Payment";
                        $transact['status'] = "partial";
                        $transact['balance'] = ($balance-$payment);
                    }
                }
            }else{
                echo"has accumulated balance. ";
                $totalbalance = $daily+$accubal;
                if($totalbalance <= $balance){
                    echo "Continue";
                    echo $totalbalance." ".$balance;
                    if($totalbalance == $payment){
                        $remaining = abs($totalbalance-$payment);
                        echo "Equals 1. Remaning Balance: ".$remaining;
                        echo "Accumulated Balance: ".$accubal;
                        echo "Advance Balance: ".$advbal;
                        echo "Total Balance: ".($balance-$payment);
                        $transact['payment'] = $payment;
                        $transact['AccuBal'] = ($accubal-$accubal);
                        $transact['AdvBal'] = ($advbal);
                        $transact['description'] = "Normal Payment";
                        $transact['status'] = "partial";
                        $transact['balance'] = ($balance-$payment);
                    }else{
                        if($totalbalance > $payment){
                            $accubal = abs($totalbalance-$payment);
                            echo "Accumulated Balance: ".$accubal;
                            echo "Advance Balance: ".$advbal;
                            echo "Total Balance: ".($balance-$payment);
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = ($accubal-$accubal);
                            $transact['AdvBal'] = ($advbal);
                            $transact['description'] = "Normal Payment";
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-$payment);
                        }else{
                            $advbal = abs($totalbalance-$payment);
                            echo "Accumulated Balance: ".$accubal;
                            echo "Advance Balance: ".$advbal;
                            echo "Total Balance: ".($balance-$payment);
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = ($accubal-$accubal);
                            $transact['AdvBal'] = ($advbal);
                            $transact['description'] = "Normal Payment";
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-$payment);
                        }
                    }
                }else{
                    echo "balance exeeds";
                    echo "Accumulated Balance: ".$accubal;
                    echo "Advance Balance: ".$advbal;
                    echo " Balance: ".($balance-$payment);
                }
            }
            }else{
                echo "has advance balance. ";
                $totalpayment = $payment+$advbal;
                if($totalpayment == $balance){
                    echo "Account Done!";
                    echo "Accumulated Balance: ".$accubal;
                    echo "Advance Balance: ".($advbal-$advbal);
                    echo "Total Balance: ".($balance-$payment);
                    $transact['payment'] = $payment;
                    $transact['AccuBal'] = ($accubal-$accubal);
                    $transact['AdvBal'] = ($advbal-$advbal);
                    $transact['description'] = "Account fully Paid.";
                    $transact['status'] = "full";
                    $transact['balance'] = ($balance-$totalpayment);
                }else{
                    echo $totalpayment." ".$balance;
                    if($totalpayment > $balance){
                        echo "EXCEEDS LIMIT";
                        echo "Accumulated Balance: ".$accubal;
                        echo "Advance Balance: ".$advbal;
                        echo "Total Balance: ".($balance-$totalpayment);
                    }else{
                        if($totalpayment == $daily){
                            $remaining = abs($totalpayment - $daily);
                                echo "Equals 2. Remaining Balance: ".$remaining;
                                echo "Accumulated Balance: ".$accubal;
                                echo "Advance Balance: ".$advbal;
                                echo "Total Balance: ".($balance-$payment);
                                $transact['payment'] = $payment;
                                $transact['AccuBal'] = $accubal;
                                $transact['AdvBal'] = ($advbal-$advbal);
                                $transact['description'] = "Normal Payment";
                                $transact['status'] = "partial";
                                $transact['balance'] = ($balance-$totalpayment);
                        }else{ echo "Payment not equals to daily. ";
                            if($totalpayment > $daily){
                                $advbal= (abs($totalpayment-$daily));
                                echo "Accumulated Balance: ".$accubal;
                                echo "Advance Balance: ".$advbal;
                                echo "Total Balance: ".($balance-$payment);
                                $transact['payment'] = $payment;
                                $transact['AccuBal'] = $accubal;
                                $transact['AdvBal'] = ($advbal-$advbal);
                                $transact['description'] = "Normal Payment";
                                $transact['status'] = "partial";
                                $transact['balance'] = ($balance-$totalpayment);
                            }else{
                                $a = $totalpayment-$daily;
                                $accubal=$accubal+(abs($a));
                                echo "Accumulated Balance: ".$accubal;
                                echo "Advance Balance: ".$advbal;
                                echo "Total Balance: ".($balance-$payment);
                                $transact['payment'] = $payment;
                                $transact['AccuBal'] = $accubal;
                                $transact['AdvBal'] = ($advbal-$advbal);
                                $transact['description'] = "Normal Payment";
                                $transact['status'] = "partial";
                                $transact['balance'] = ($balance-$totalpayment);
                            }
                        }
                    }
                }
                
            }
        }else{
            if($balance == $payment+$advbal){
                $totalpayment = $payment+$advbal;
                echo "Account Done!";
                echo "Accumulated Balance: ".$accubal;
                echo "Advance Balance: ".($advbal-$advbal);
                echo "Payment: ".$payment;
                echo "Total Balance: ".($balance-$payment);
                $transact['payment'] = $payment;
                $transact['AccuBal'] = ($accubal-$accubal);
                $transact['AdvBal'] = ($advbal-$advbal);
                $transact['description'] = "Account fully Paid.";
                $transact['status'] = "full";
                $transact['balance'] = ($balance-$payment);
            }else{
                $error = "Total payment exceeds remaining balance.";
                return $error;
            }
        }

        //print_r($transact);

        $query="INSERT INTO `records`(`recordID`, `accID`, `payment`, `AccuBal`,`creditBalance`, `AdvBal`, `description`, `status`) 
        VALUES (\"".$transact['recordID']."\",\"".$transact['accID']."\",\"".$transact['payment']."\",\"".$transact['AccuBal']."\",\"".$transact['balance']."\",\"".$transact['AdvBal']."\",\"".$transact['description']."\",\"".$transact['status']."\")";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        }
        $query = "UPDATE `account` SET `balance`=\"".$transact['balance']."\" WHERE `accID` = \"".$transact['accID']."\"";
        $result = mysqli_query($this->conn,$query);
        if(!$result){
            die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
            return mysqli_error($this->conn);
        } return "101";



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