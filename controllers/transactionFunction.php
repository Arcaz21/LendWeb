<?php include "../models/transactionModel.php";
$tm = new transactionModel();
 $users = new userModel();
$action = isset($_REQUEST['action'])?$_REQUEST['action']:NULL;

$page = isset($_SESSION['page'])?$_SESSION['page']:NULL;

$user= isset($_REQUEST['user'])?$_REQUEST['user']:NULL;

$submit = isset($_REQUEST['submit'])?$_REQUEST['submit']:NULL;

if($submit == 'pay'){

    $payment['memberID'] = isset($_REQUEST['memberID'])?$_REQUEST['memberID']:NULL;

    //print_r($payment);

    $record = $tm->getrecord($payment['memberID']);
    $transact['accountbalance'] = $record[0]['accountbalance'];
    $transact['payment'] = isset($_REQUEST['payment'])?$_REQUEST['payment']:NULL;
    $transact['accubal'] =  $record[0]['AccuBal'];
    $transact['advbal'] =  $record[0]['AdvBal'];
    $transact['daily'] =  $record[0]['dailyPayment'];
    $transact['accID'] = $record[0]['accID'];
    $transact['user_id'] = isset($_REQUEST['uid'])?$_REQUEST['uid']:NULL;
    $transact['recordID']=substr(md5(uniqid()),0,5);

    $getwallet = $tm->getwallet($transact['user_id']);

    $transact['wid'] = $getwallet[0]['wid'];
    $transact['type'] = 'payment';
    $transact['amount'] = $transact['payment'];
    $transact['description_wallet'] = "Payment from: ".$record[0]['memID']." Received by: ".$transact['user_id'];

    //print_r($transact);
    $record = $tm->transact($transact);
    while($record == '1062'){
        $transact['recordID']=substr(md5(uniqid()),0,5);
        $record = $tm->transact($transact);
        //print_r($record);
        if($record == '101'){
        // $_SESSION['script'] = "<script type='text/javascript'>
        // $(document).ready(function(e) {
        //     notifyUser('success');
        // });
        // </script>";
            break;
        }
    }
}

if($action == 'transact'){
    $transaction['fullid']= isset($_REQUEST['fullid'])?$_REQUEST['fullid']:NULL;
    $transaction['amtpayment']= isset($_REQUEST['amtpayment'])?$_REQUEST['amtpayment']:NULL;
    $transaction['userID']= isset($_REQUEST['userID'])?$_REQUEST['userID']:NULL;

    //print_r($transaction);
    // $account = $tm->getaccount($transaction);
    // if($getaccount != null){
    //     $addtransaction = $tm->addtrans($transaction,$account);
    // }
    
}

if($action == 'addmember'){
    $member['uid'] =isset($_REQUEST['uid'])?$_REQUEST['uid']:NULL;
    $member['fname']= isset($_REQUEST['first-name'])?$_REQUEST['first-name']:NULL;
    $member['lname']= isset($_REQUEST['last-name'])?$_REQUEST['last-name']:NULL;
    $member['mname']= isset($_REQUEST['middle-name'])?$_REQUEST['middle-name']:NULL;
    $member['contact']= isset($_REQUEST['contact-num'])?$_REQUEST['contact-num']:NULL;
    $member['street']= isset($_REQUEST['street'])?$_REQUEST['street']:NULL;
    $member['barangay']= isset($_REQUEST['barangay'])?$_REQUEST['barangay']:NULL;
    $member['province']= isset($_REQUEST['province'])?$_REQUEST['province']:NULL;
    $member['city']= isset($_REQUEST['city'])?$_REQUEST['city']:NULL;
    $member['zcode']= isset($_REQUEST['zcode'])?$_REQUEST['zcode']:NULL;
    $member['country']= isset($_REQUEST['country'])?$_REQUEST['country']:NULL;
    $member['gender']= isset($_REQUEST['gender'])?$_REQUEST['gender']:NULL;
    $member['address'] = $member['street'].",".$member['barangay'].",".$member['province'].",".$member['city'].",".$member['country']." ".$member['zcode'];
    $member['status'] ="initial";
    $member['rating']= "0";
    $member['memberID']=substr(md5(uniqid()),0,5);
    $member['amount'] =isset($_REQUEST['amount'])?$_REQUEST['amount']:NULL;
    $member['uid'] =isset($_REQUEST['uid'])?$_REQUEST['uid']:NULL;

    //print_r($member);

    $getwallet = $tm->getwallet($member['uid']);
    if($getwallet[0]['amount'] > $member['amount']){
        //add memeber
        $addmember = $tm->addmember($member);
        while($addmember == '1062'){
            $member['memberID']=substr(md5(uniqid()),0,5);
            $addmember = $tm->addmember($member);
            //print_r($addmember);
            if($addmember == '101'){
                break;
            }
        }
        //add account
        $account = $tm->calculate($member);
        $account['accID']=substr(md5(uniqid()),0,5);
        $account['memberID'] = $member['memberID'];
        $account['uid'] = $member['uid'];
        // print_r($account);
        $addaccount = $tm->addaccount($account);
        while($addaccount == '1062'){
            $account['accID']=substr(md5(uniqid()),0,5);
            $addccount = $tm->addaccount($account);
            //print_r($addaccount);
            if($addaccount == '101'){
                break;
            }
        }
        //add record
        $record['recordID']=substr(md5(uniqid()),0,5);
        $record['description']='Initial Record - New Member';
        $record['accID'] = $account['accID'];
        $record['AccuBal'] = 0;
        $record['AdvBal'] = 0;
        $record['payment'] = 0;
        $record['balance'] = $account['creditAmnt'];
        $record['status'] = 'initial';
        $record['user_id'] = $member['uid'];
        $addrecord = $tm->addrecord($record);
        while($addrecord == '1062'){
            $record['recordID']=substr(md5(uniqid()),0,5);
            $addrecord = $tm->addrecord($record);
            //print_r($addrecord);
            if($addrecord == '101'){
                break;
            }
        }

        $exp['user_id'] = $record['user_id'];
        $exp['amount'] = $record['balance'];
        $exp['type'] = "loan";
        $exp['description'] = $member['fname']." ".$member['mname']." ".$member['lname']." ID:".$member['memberID'];
        $exp['wid'] = $getwallet[0]['wid'];
        $subwallet = $tm->subwallet_addmember($exp);
       
        $_SESSION['script'] = "<script type='text/javascript'>
        $(document).ready(function(e) {
            notifyUser('success');
        });
        </script>";

    }else{
        $_SESSION['script'] = "<script type='text/javascript'>
        $(document).ready(function(e) {
            notifyUser('balance');
        });
        </script>";

    }

}

if($submit == "addaccountpage"){
    $memberID = isset($_REQUEST['memberID'])?$_REQUEST['memberID']:NULL;
    $countall = $tm->getaccountcount($memberID);
    $countcleared = $tm->getaccountcleared($memberID);
    print_r($countall);
    echo " ";
    print_r($countcleared);

    if($countall != $countcleared){
        echo "ERROR";
    }else{
       // $_SESSION['addmemid'] = $memberID;
       //  $url = "Location: c_addacc.php";
       //  $tm->goto($url); 
    }
    
}

if($submit == "addaccount"){

    $member['amount'] =isset($_REQUEST['amount'])?$_REQUEST['amount']:NULL;
    $member['uid'] =isset($_REQUEST['uid'])?$_REQUEST['uid']:NULL;
    $member['memberID'] =isset($_REQUEST['memberID'])?$_REQUEST['memberID']:NULL;
    //add account
    $account = $tm->calculate($member);
    $account['accID']=substr(md5(uniqid()),0,5);
    $account['memberID'] = $member['memberID'];
    $account['memberID'] = $member['uid'];
    // print_r($account);
    $addaccount = $tm->addaccount($account);
    while($addaccount == '1062'){
        $account['accID']=substr(md5(uniqid()),0,5);
        $addccount = $tm->addaccount($account);
        print_r($addaccount);
        if($addaccount == '101'){
            break;
        }
    }

    //add record
    $record['recordID']=substr(md5(uniqid()),0,5);
    $record['description']='Initial Record - New Member';
    $record['accID'] = $account['accID'];
    $record['AccuBal'] = 0;
    $record['AdvBal'] = 0;
    $record['payment'] = 0;
    $record['status'] = 'initial';
    $addrecord = $tm->addrecord($record);
    while($addrecord == '1062'){
        $record['recordID']=substr(md5(uniqid()),0,5);
        $addrecord = $tm->addrecord($record);
        print_r($addrecord);
        if($addrecord == '101'){
            break;
        }
    }

}

print_r($submit);
if($submit == "deluser"){
    $id = isset($_REQUEST['userid'])?$_REQUEST['userid']:NULL;
    $deleteuser = $tm->deleteuser("inactive");
    $getusers = $users->getusers();
}
print_r($submit);
if($submit == "addexp"){

    $exp['refnumber'] =isset($_REQUEST['refnumber'])?$_REQUEST['refnumber']:NULL;
    $exp['password'] =isset($_REQUEST['pwd'])?$_REQUEST['pwd']:NULL;
    $exp['amount'] =isset($_REQUEST['amount'])?$_REQUEST['amount']:NULL;
    $exp['purpose'] =isset($_REQUEST['purpose'])?$_REQUEST['purpose']:NULL;
    $exp['user_id'] =isset($_REQUEST['uid'])?$_REQUEST['uid']:NULL;
    $exp['type'] ='expenses';
    $db = new userModel();
    $data =$db->getuser($_SESSION['username']);
    print_r($data->password);
    if($data->password == $exp['password']){
        $getwallet = $tm->getwallet($exp['user_id']);
        $exp['wid'] = $getwallet[0]['wid'];
        $addexp = $tm->addexp($exp);
        var_dump($addexp);

        if($addexp){
        $_SESSION['script'] = "<script type='text/javascript'>
        $(document).ready(function(e) {
            notifyUser('success');
        });
        </script>";
        }else{
         $_SESSION['script'] = "<script type='text/javascript'>
        $(document).ready(function(e) {
            notifyUser('error');
        });
        </script>";
        }

    }else{
        $_SESSION['script'] = "<script type='text/javascript'>
        $(document).ready(function(e) {
            notifyUser('passworderror');
        });
        </script>";
    }

    
    


   
}

//Page Conditions
if($page == 'a_users.php'){
    $getusers = $users->getusers();
}
if($page == 'c_lendees.php'){
    $getmembers = $tm->getmembers1();
}
if($page == 'c_home.php'){
    $id = isset($_SESSION['user_id'])?$_SESSION['user_id']:NULL;
    $getmembers = $tm->getmembers($id);
}
if($page == 'c_report.php'){

    $getrecord = $tm->getAllrecords();
}
if($page == 'c_accounts.php'){
    $getaccounts = $tm->getaccounts();
}
if($page == 'c_wallet.php'){

    $db = new userModel();
    $data =$db->getuser($_SESSION['username']);
    echo $data->user_id;

    $id =  $data->user_id;
    $grandtotal = $tm->gettotalwallet($id);
    $getexpectedcollection = $tm->getexpectedcollection();
    if($getexpectedcollection[0]['TotalCollection'] == NULL){
        $getexpectedcollection[0]['TotalCollection'] = "0.00";
    }
    $currtotalcollection = $tm->currtotalcollection($id);
    if($currtotalcollection[0]['TotalCollection'] == NULL){
        $currtotalcollection[0]['TotalCollection'] = "0.00";
    }
    $walletid = $tm->getwalletid($id);
    $gettotalexpenses = $tm->getexp($walletid->wid);
    if($gettotalexpenses->exptotal == NULL){
        $gettotalexpenses->exptotal = "0.00";
    }

    
}
if($page == 'c_addlend.php'){
    //$getwallet = $tm->getwallet();
}





?>