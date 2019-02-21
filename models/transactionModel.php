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
        $query = "SELECT *,account.memberID as accMemberID FROM `member` JOIN account ON account.memberID = member.memberID GROUP BY startDate DESC LIMIT 1";
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
                $transact['balance'] = ($balance-$payment);
                print_r($transact);
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
                        $transact['balance'] = ($balance-$payment);
                        print_r($transact);
                    }else{
                        if($payment>$daily){
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = "0.00";
                            $transact['AdvBal'] = $payment-$daily;
                            $transact['description'] = "Advance Payment";
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-$payment);
                            print_r($transact);
                        }else{
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = $daily-$payment;
                            $transact['AdvBal'] = "0.00";
                            $transact['description'] = "Accumulated Payment";   
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-$payment);
                            print_r($transact);
                        }
                    }
                }   
            }
        }
        if($advbal != 0.00){
            //has advance
            if(($advbal+$payment) == $balance){
                $transact['payment'] = $payment;
                $transact['AccuBal'] = "0.00";
                $transact['AdvBal'] = "0.00";
                $transact['description'] = "ACCOUNT DONE!";    
                $transact['status'] = "full";
                $transact['balance'] = ($balance-($advbal+$payment));
                print_r($transact);
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
                        $transact['balance'] = ($balance-($advbal+$payment));
                        print_r($transact);
                    }else{
                        if(($advbal+$payment)>$daily){
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = "0.00";
                            $transact['AdvBal'] = "0.00";//(($advbal+$payment)-$daily);
                            $transact['description'] = "Advance Payment";   
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-($advbal+$payment));
                            print_r($transact);
                        }else{
                            $transact['payment'] = $payment;
                            $transact['AccuBal'] = $daily-($advbal-$payment);
                            $transact['AdvBal'] = "0.00";
                            $transact['description'] = "Accumulated Payment";    
                            $transact['status'] = "partial";
                            $transact['balance'] = ($balance-($advbal+$payment));
                            print_r($transact);
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
                    $transact['balance'] = ($balance-abs($accubal-$payment));
                    print_r($transact);
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
                            $transact['balance'] = ($balance);
                            print_r($transact);
                        }else{
                            if(abs($accubal+$daily)>$payment){
                                    $transact['payment'] = $payment;
                                    $transact['AccuBal'] = abs(($accubal+$daily)-$payment);
                                    $transact['AdvBal'] = "0.00";
                                    $transact['description'] = "Accumulated Payment";    
                                    $transact['status'] = "partial";
                                    $transact['balance'] = ($balance);
                                    print_r($transact);
                                
                            }else{
                                $transact['payment'] = $payment;
                                $transact['AccuBal'] = "0.00";
                                $transact['AdvBal'] = abs(abs($accubal+$daily)-$payment);
                                $transact['description'] = "Advance Payment";    
                                $transact['status'] = "partial";
                                $transact['balance'] = abs($balance-$daily);
                                print_r($transact);
                            }
                        }
                    }
                }
            }
        }

        
        // if($balance > $payment+$advbal){
        //     if($advbal == 0){
        //         echo "No advance balance. ";
        //     if($accubal == 0){
        //         echo"No accumulated balance. ";
        //         if($daily > $payment){
        //             $remainder = abs($daily-$payment);
        //             $accubal = $accubal+$remainder;
        //                 echo "A1 - Accumulated Balance: ".$accubal;
        //                 echo "Advance Balance: ".$advbal;
        //                 echo "Total Balance: ".($balance-$payment);
        //                 $transact['payment'] = $payment;
        //                 $transact['AccuBal'] = $accubal;
        //                 $transact['AdvBal'] = ($advbal);
        //                 $transact['description'] = "Normal Payment";;    
        //                 $transact['status'] = "partial";
        //                 $transact['balance'] = ($balance-$payment);
        //         }else{
        //             if($daily == $payment){
        //                 $remaining = abs($daily-$payment);
        //                 echo "A-2 Accumulated Balance: ".$accubal;
        //                 echo "Advance Balance: ".$advbal;
        //                 echo "Total Balance: ".($balance-$daily);
        //                 $transact['payment'] = $payment;
        //                 $transact['AccuBal'] = $accubal;
        //                 $transact['AdvBal'] = ($advbal);
        //                 $transact['description'] = "Normal Payment";
        //                 $transact['status'] = "partial";
        //                 $transact['balance'] = ($balance-$daily);
        //             }else{
        //                 $advbal = $advbal+abs($daily-$payment);
        //                 echo "A-3 Accumulated Balance: ".$accubal;
        //                 echo "Advance Balance: ".$advbal;
        //                 echo "Total Balance: ".($balance-$daily);
        //                 $transact['payment'] = $payment;
        //                 $transact['AccuBal'] = $accubal;
        //                 $transact['AdvBal'] = ($advbal);
        //                 $transact['description'] = "Normal Payment";
        //                 $transact['status'] = "partial";
        //                 $transact['balance'] = ($balance-$daily);
        //             }
        //         }
        //     }else{
        //         echo"has accumulated balance. ";
        //         $totalbalance = $daily+$accubal;
        //         if($totalbalance <= $balance){
        //             echo "Continue";
        //             echo $totalbalance." ".$balance;
        //             if($totalbalance == $payment){
        //                 $remaining = abs($totalbalance-$payment);
        //                 echo "Equals 1. Remaning Balance: ".$remaining;
        //                 echo "A-4 Accumulated Balance: ".$accubal;
        //                 echo "Advance Balance: ".$advbal;
        //                 echo "Total Balance: ".($balance-$payment);
        //                 $transact['payment'] = $payment;
        //                 $transact['AccuBal'] = ($accubal-$accubal);
        //                 $transact['AdvBal'] = ($advbal);
        //                 $transact['description'] = "Normal Payment";
        //                 $transact['status'] = "partial";
        //                 $transact['balance'] = ($balance-$payment);
        //             }else{
        //                 if($totalbalance > $payment){
        //                     $accubal = abs($totalbalance-$payment);
        //                     echo "A-5 Accumulated Balance: ".$accubal;
        //                     echo "Advance Balance: ".$advbal;
        //                     echo "Total Balance: ".($balance-$payment);
        //                     $transact['payment'] = $payment;
        //                     $transact['AccuBal'] = ($accubal-$accubal);
        //                     $transact['AdvBal'] = ($advbal);
        //                     $transact['description'] = "Normal Payment";
        //                     $transact['status'] = "partial";
        //                     $transact['balance'] = ($balance-$payment);
        //                 }else{
        //                     $advbal = abs($totalbalance-$payment);
        //                     echo "A-6 Accumulated Balance: ".$accubal;
        //                     echo "Advance Balance: ".$advbal;
        //                     echo "Total Balance: ".($balance-$payment);
        //                     $transact['payment'] = $payment;
        //                     $transact['AccuBal'] = ($accubal-$accubal);
        //                     $transact['AdvBal'] = ($advbal);
        //                     $transact['description'] = "Normal Payment";
        //                     $transact['status'] = "partial";
        //                     $transact['balance'] = ($balance-$payment);
        //                 }
        //             }
        //         }else{
        //             echo "balance exeeds";
        //             echo "Accumulated Balance: ".$accubal;
        //             echo "Advance Balance: ".$advbal;
        //             echo " Balance: ".($balance-$payment);
        //         }
        //     }
        //     }else{
        //         echo "has advance balance. ";
        //         $totalpayment = $payment+$advbal;
        //         if($totalpayment == $balance){
        //             echo "Account Done!";
        //             echo "A-7 Accumulated Balance: ".$accubal;
        //             echo "Advance Balance: ".($advbal-$advbal);
        //             echo "Total Balance: ".($balance-$payment);
        //             $transact['payment'] = $payment;
        //             $transact['AccuBal'] = ($accubal-$accubal);
        //             $transact['AdvBal'] = ($advbal-$advbal);
        //             $transact['description'] = "Account fully Paid.";
        //             $transact['status'] = "full";
        //             $transact['balance'] = ($balance-$totalpayment);
        //         }else{
        //             echo $totalpayment." ".$balance;
        //             if($totalpayment > $balance){
        //                 echo "EXCEEDS LIMIT";
        //                 echo "Accumulated Balance: ".$accubal;
        //                 echo "Advance Balance: ".$advbal;
        //                 echo "Total Balance: ".($balance-$totalpayment);
        //             }else{
        //                 if($totalpayment == $daily){
        //                     $remaining = abs($totalpayment - $daily);
        //                         echo "Equals 2. Remaining Balance: ".$remaining;
        //                         echo "A-8 Accumulated Balance: ".$accubal;
        //                         echo "Advance Balance: ".$advbal;
        //                         echo "Total Balance: ".($balance-$payment);
        //                         $transact['payment'] = $payment;
        //                         $transact['AccuBal'] = $accubal;
        //                         $transact['AdvBal'] = ($advbal-$advbal);
        //                         $transact['description'] = "Normal Payment";
        //                         $transact['status'] = "partial";
        //                         $transact['balance'] = ($balance-$totalpayment);
        //                 }else{ echo "Payment not equals to daily. ";
        //                     if($totalpayment > $daily){
        //                         $advbal= (abs($totalpayment-$daily));
        //                         echo "A-9 Accumulated Balance: ".$accubal;
        //                         echo "Advance Balance: ".$advbal;
        //                         echo "Total Balance: ".($balance-$payment);
        //                         $transact['payment'] = $payment;
        //                         $transact['AccuBal'] = $accubal;
        //                         $transact['AdvBal'] = ($advbal-$advbal);
        //                         $transact['description'] = "Normal Payment";
        //                         $transact['status'] = "partial";
        //                         $transact['balance'] = ($balance-$totalpayment);
        //                     }else{
        //                         $a = $totalpayment-$daily;
        //                         $accubal=$accubal+(abs($a));
        //                         echo "A-10 Accumulated Balance: ".$accubal;
        //                         echo "Advance Balance: ".$advbal;
        //                         echo "Total Balance: ".($balance-$payment);
        //                         $transact['payment'] = $payment;
        //                         $transact['AccuBal'] = $accubal;
        //                         $transact['AdvBal'] = ($advbal-$advbal);
        //                         $transact['description'] = "Normal Payment";
        //                         $transact['status'] = "partial";
        //                         $transact['balance'] = ($balance-$totalpayment);
        //                     }
        //                 }
        //             }
        //         }
                
        //     }
        // }else{
        //     echo $advbal+$payment;
        //     if($balance == $payment+$advbal){
        //         $totalpayment = $payment+$advbal;
        //         echo "Account Done!";
        //         echo "A-11 Accumulated Balance: ".$accubal;
        //         echo "Advance Balance: ".($advbal-$advbal);
        //         echo "Payment: ".$payment;
        //         echo "Total Balance: ".($balance-$payment);
        //         $transact['payment'] = $payment;
        //         $transact['AccuBal'] = ($accubal-$accubal);
        //         $transact['AdvBal'] = ($advbal-$advbal);
        //         $transact['description'] = "Account fully Paid.";
        //         $transact['status'] = "full";
        //         $transact['balance'] = ($balance-$totalpayment);
        //         $transact['status'] = "cleared";
        //         $_SESSION['script'] = "<script type='text/javascript'>
        //         $(document).ready(function(e) {
        //             notifyUser('done');
        //         });
        //         </script>";
        //         $query = "UPDATE `account` SET `balance`=\"".$transact['balance']."\",`status`=\"".$transact['status']."\" WHERE `accID` = \"".$transact['accID']."\"";
        //         $result = mysqli_query($this->conn,$query);
        //         if(!$result){
        //             die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        //             return mysqli_error($this->conn);
        //         } return "101";
        //     }else{
        //         $_SESSION['script'] = "<script type='text/javascript'>
        //         $(document).ready(function(e) {
        //             notifyUser('exceeds');
        //         });
        //         </script>";
        //         return FALSE;
        //     }
        // }


        // $query="INSERT INTO `records`(`recordID`, `accID`, `payment`, `AccuBal`,`creditBalance`, `AdvBal`, `description`, `status`) 
        // VALUES (\"".$transact['recordID']."\",\"".$transact['accID']."\",\"".$transact['payment']."\",\"".$transact['AccuBal']."\",\"".$transact['balance']."\",\"".$transact['AdvBal']."\",\"".$transact['description']."\",\"".$transact['status']."\")";
        // print_r($query);
        // $result = mysqli_query($this->conn,$query);
        // if(!$result){
        //     die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        //     return mysqli_error($this->conn);
        // }
        // $query = "UPDATE `account` SET `balance`=\"".$transact['balance']."\" WHERE `accID` = \"".$transact['accID']."\"";
        // print_r($query);
        // $result = mysqli_query($this->conn,$query);
        // if(!$result){
        //     die("<strong>WARNING:</strong><br>" . mysqli_error($this->conn));
        //     return mysqli_error($this->conn);
        // } return "101";

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