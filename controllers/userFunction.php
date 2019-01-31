<?php include "../models/adminModel.php";

$action = isset($_REQUEST['action'])?$_REQUEST['action']:NULL;

$am = new adminModel();

$member['username']= isset($_REQUEST['username'])?$_REQUEST['username']:NULL;
$member['fname']= isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
$member['lname']= isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
$member['contact']= isset($_REQUEST['contact'])?$_REQUEST['contact']:NULL;  
$member['address']= isset($_REQUEST['address'])?$_REQUEST['addresss']:NULL;
$member['address']= isset($_REQUEST['address'])?$_REQUEST['addresss']:NULL;

$collector['username']= isset($_REQUEST['username'])?$_REQUEST['username']:NULL;
$collector['fname']= isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
$collector['lname']= isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
$collector['role']= isset($_REQUEST['role'])?$_REQUEST['role']:NULL;


if($action == 'addmember'){
     $result = $am->adduser($member);
}

if($action == 'deletemember'){
     $result = $am->deleteuser($member);
}

if($action == 'updatemember'){
     $result = $am->updateuser($member);
}

if($action == 'addcollector'){
     $result = $am->addcollector($collector);
}

if($action == 'deletecollector'){
     $result = $am->deletecollector($collector);
}

if($action == 'updatecollector'){
     $result = $am->updatecollector($collector);
}












?>