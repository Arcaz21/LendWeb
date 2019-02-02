<?php include "../models/adminModel.php";

$action = isset($_REQUEST['action'])?$_REQUEST['action']:NULL;

$am = new adminModel();

$member['username']= isset($_REQUEST['username'])?$_REQUEST['username']:NULL;
$member['fname']= isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
$member['lname']= isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
$member['contact']= isset($_REQUEST['contact'])?$_REQUEST['contact']:NULL;  
$member['address']= isset($_REQUEST['address'])?$_REQUEST['addresss']:NULL;
$member['address']= isset($_REQUEST['address'])?$_REQUEST['addresss']:NULL;

$user['username']= isset($_REQUEST['username'])?$_REQUEST['username']:NULL;
$user['fname']= isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
$user['lname']= isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
$user['role']= isset($_REQUEST['role'])?$_REQUEST['role']:NULL;


if($action == 'addmember'){
     $memberID = rand(100,1000);
     $checkID = $tm->checkid($memberID);
     $result = $am->adduser($member);
}

if($action == 'deletemember'){
     $result = $am->deleteuser($member);
}

if($action == 'updatemember'){
     $result = $am->updateuser($member);
}












?>