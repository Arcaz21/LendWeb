<?php include "../models/adminModel.php";

$submit = isset($_REQUEST['submit'])?$_REQUEST['submit']:NULL;
$page = isset($_SESSION['page'])?$_SESSION['page']:NULL;
$admin = new adminModel();

if($submit == "adduser"){
	echo "HELLO";
	$user['username'] = isset($_REQUEST['uname'])?$_REQUEST['uname']:NULL;
	$user['password'] = isset($_REQUEST['pwd'])?$_REQUEST['pwd']:NULL;
	$user['fname'] = isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
	$user['lname'] = isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
	$user['role'] = isset($_REQUEST['role'])?$_REQUEST['role']:NULL;
    $user['status'] = isset($_REQUEST['status'])?$_REQUEST['status']:NULL;
	$user['user_id'] = substr(md5(uniqid()),0,5);

	//print_r($user);
	$adduser = $admin->addUser($user);
    while($adduser == '1062'){
        $user['user_id']=substr(md5(uniqid()),0,5);
        $adduser = $admin->addUser($user);
        //print_r($record);
        if($adduser == '101'){
        // $_SESSION['script'] = "<script type='text/javascript'>
        // $(document).ready(function(e) {
        //     notifyUser('success');
        // });
        // </script>";
            break;
        }
    }
    $wallet['user_id'] = $user['user_id'];
    $wallet['amount'] = 0;
    $createwallet = $admin->createwallet($wallet);
}
if($page == "a_home.php"){
    $gettotalmembers = $admin->gettotalmembers();
    $getlastweekmembers = $admin->getlastweekmembers();
    $getallfemales = $admin->getallfemales();
    $getallmales = $admin->getallmales();
}



?>