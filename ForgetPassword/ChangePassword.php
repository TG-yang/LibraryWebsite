<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/22/18
 * Time: 17:00
 */
$link = mysqli_connect('localhost','root','root') or die("Could not connect to database");

$select = mysqli_select_db($link, 'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

if(!preg_match('/[A-Z]/',$_POST['password'])){
    echo 1;
}else if(isset($_POST['email']) && $_POST['password']){
    $email = $_POST['email'];
    $verifyCode = $_POST['verifyCode'];

    $queryVerify = "select VerifyCode from BORROWER where Email = '$email'";
    $resultVerify = mysqli_query($link,$queryVerify);
    $row = mysqli_fetch_assoc($resultVerify);

    if($verifyCode == $row['VerifyCode']){
        $password = $_POST['password'];
        $query = "update BORROWER set Password = '$password' where Email = '$email' ";
        $result = mysqli_query($link,$query);

        if($result){
            echo 2;
        }else{
            echo 3;
        }
//        mysqli_free_result($result);
    }else
        echo 4;
//    mysqli_free_result($resultVerify);
}

//mysqli_free_result($Link);
mysqli_close($link);
?>

