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
            session_start();
            $url = "Location: ./views/a_home.php";
            $_SESSION['username'] =  $getuser->username;
            $_SESSION['password'] =  $getuser->password;
            $_SESSION['role'] =  $getuser->role;
            $db->goto($url);
        }
        if($getuser->role == 'user'){
            echo "<-USER LOG-IN->";
        }
        if($getuser->role == 'collector'){
            echo "<-COLLECTOR LOG-IN->";
            session_start();
            $url = "Location: ./views/c_home.php";
            $_SESSION['username'] =  $getuser->username;
            $_SESSION['password'] =  $getuser->password;
            $_SESSION['role'] =  $getuser->role;
            print_r($_SESSION['username']);
            $db->goto($url);
        }
    }else{
        print_r("Sign-In Error!");
    }
   
}
//Login End

?>