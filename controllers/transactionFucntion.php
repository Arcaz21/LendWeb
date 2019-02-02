<?php include "../models/transactionModel.php";

$action = isset($_REQUEST['action'])?$_REQUEST['action']:NULL;
print_r($action);

$tm = new transactionModel();

$user= isset($_REQUEST['user'])?$_REQUEST['user']:NULL;
print_r($user);

if($action == 'transact'){
    $transaction['fullid']= isset($_REQUEST['fullid'])?$_REQUEST['fullid']:NULL;
    $transcation['amtpayment']= isset($_REQUEST['amtpayment'])?$_REQUEST['amtpayment']:NULL;
    $transcation['userID']= isset($_REQUEST['userID'])?$_REQUEST['userID']:NULL;
    $transcation['memberID']= isset($_REQUEST['memberID'])?$_REQUEST['memberID']:NULL;

    // $account = $tm->getaccount($transaction);
    // if($getaccount != null){
    //     $addtransaction = $tm->addtrans($transaction,$account);
    // }
    
}
print_r($action);
if($action == 'addmember'){

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
    $member['rating']= "1";
    $member['memberID']=uniqid();

    print_r($member);
    // $addmember = $tm->addmember($member);
    // while($addmember == '1062'){
	// 	$member['memberID']=uniqid();
	// 	$adduser = $db->adduser($id,$name);
	// 	print_r($adduser);
	// 	if($adduser == '101'){
	// 		break;
	// 	}
	// }
    // if($addmember){
    //     echo "MEMBER ADDED";
    //     //header("location: ./home.php");
    // }

}
?>