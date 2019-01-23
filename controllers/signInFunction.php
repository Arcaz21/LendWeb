<?php include "./models/adminModel.php";

//Login Validation and verification
if(isset($_POST['submit'])){
    $db = new loginModel();
    $user = ($_REQUEST['username'])?$_REQUEST['username']:NULL;
    $pass = ($_REQUEST['password'])?$_REQUEST['password']:NULL;

    $username = $db->escape_string($user);
    $password = $db->escape_string($pass);
    
    print_r($user);
    print_r($pass);
    $check = $db->check_user($username,$password);
    if($check){
        $getuser = $db->get_user($username,$password);
        print_r($getuser->role);
        if($getuser->role == 'admin'){
            echo "<-ADMIN LOG-IN->";
        }
        if($getuser->role == 'user'){
            echo "<-USER LOG-IN->";
        }
        if($getuser->role == 'collector'){
            echo "<-COLLECTOR LOG-IN->";
        }
    }else{
        print_r("Sign-In Error!");
    }
   
}
//Login End

?>