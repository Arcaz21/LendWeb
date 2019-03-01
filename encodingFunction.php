<?php include "../models/encodingModel.php"; 
$submit = isset($_REQUEST['submit'])?$_REQUEST['submit']:NULL;

if($submit == 'encode'){
    $db = new encodingModel();

    $encode['inidate'] = isset($_REQUEST['inidate'])?$_REQUEST['inidate']:NULL;
    $sdate = strtotime($encode['inidate']);
    $encode['regDate'] = date('Y-m-d',$sdate);

    $encode['sdate'] = isset($_REQUEST['sdate'])?$_REQUEST['sdate']:NULL;
    $sdate = strtotime($encode['sdate']);
    $encode['startDate'] = date('Y-m-d',$sdate);

    $encode['ddate'] = isset($_REQUEST['ddate'])?$_REQUEST['ddate']:NULL;
    $ddate = strtotime($encode['ddate']);
    $encode['dueDate'] = date('Y-m-d',$ddate);

    $encode['inipayment'] = isset($_REQUEST['inipayment'])?$_REQUEST['inipayment']:NULL;
    $encode['fname'] = isset($_REQUEST['fname'])?$_REQUEST['fname']:NULL;
    $encode['lname'] = isset($_REQUEST['lname'])?$_REQUEST['lname']:NULL;
    $encode['mname'] = isset($_REQUEST['mname'])?$_REQUEST['mname']:NULL;
    $encode['address'] = isset($_REQUEST['address'])?$_REQUEST['address']:NULL;
    $encode['contact'] = isset($_REQUEST['contact'])?$_REQUEST['contact']:NULL;

    $encode['dailyP'] = isset($_REQUEST['dailyP'])?$_REQUEST['dailyP']:NULL;
    $encode['payment'] = isset($_REQUEST['payment'])?$_REQUEST['payment']:NULL;
    $encode['AccuBal'] = isset($_REQUEST['accbal'])?$_REQUEST['accbal']:NULL;
    $encode['AdvBal'] = isset($_REQUEST['advbal'])?$_REQUEST['advbal']:NULL;
    $encode['encoder'] = isset($_REQUEST['encoder'])?$_REQUEST['encoder']:NULL;
    $encode['balance'] = isset($_REQUEST['rbalance'])?$_REQUEST['rbalance']:NULL;
    $encode['memberID']=substr(md5(uniqid()),0,5);
    $encode['status'] = isset($_REQUEST['status'])?$_REQUEST['status']:NULL;
    $encode['description'] = "Encoding Process.";

    $addmember = $db->addmember($encode);
    while($addmember == '1062'){
        $encode['memberID']=substr(md5(uniqid()),0,5);
        $addmember = $db->addmember($encode);
        print_r($addmember);
        if($addmember == '101'){
            break;
        }
    }
    $encode['accID']=substr(md5(uniqid()),0,5);
    $addaccount = $db->addaccount($encode);
    while($addaccount == '1062'){
        $encode['accID']=substr(md5(uniqid()),0,5);
        $addccount = $db->addaccount($encode);
        print_r($addaccount);
        if($addaccount == '101'){
            break;
        }
    }
    $encode['recordID']=substr(md5(uniqid()),0,5);
    $addrecord = $db->addrecord($encode);
    while($addrecord == '1062'){
        $encode['memberID']=substr(md5(uniqid()),0,5);
        $addrecord = $db->addrecord($encode);
        print_r($addrecord);
        if($addrecord == '101'){
            break;
        }
    }
    $_SESSION['script'] = "<script type='text/javascript'>
$(document).ready(function(e) {
    notifyUser('success');
});
</script>";


    //print_r($encode);
}



?>