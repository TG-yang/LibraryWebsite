<?php


/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 2018/10/9
 * Time: 21:56
 */
//$link = mysqli_connect('localhost','root','root') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System') or die("Cound not connect to Library_System");
$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");

$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");
mysqli_set_charset($link,'utf8');

// this wil judge whether or not the username, UID, email, password, confirm password,phone is empty
// it also judge whether the email address format is correct, and judge whether or not the password contains at least one capital letter
// it will also judge whether the confirm password is same as the password.

if(!$_POST['username']){
    echo 3;
}else if(!$_POST['UID']){
    echo 4;
}else if(!$_POST['email'] || !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $_POST['email'])){
    echo 5;
}else if(!$_POST['password']){
    echo 6;
}else if(!preg_match('/[A-Z]/',$_POST['password'])){
    echo 7;
}else if(!$_POST['confirm']){
    echo 8;
}else if($_POST['password'] != $_POST['confirm']){
    echo 9;
}else if(!$_POST['phone']){
    echo 10;
}else{
    $name = $_POST['username'];//borrower username
    $id = $_POST['UID'];// borrower UID
    $email = $_POST['email'];// borrower email
    $password = $_POST['password'];// borrower password
    $confirm = $_POST['confirm'];// borrower confirm
    $phone = $_POST['phone'];// borrower phone number
    $profile = "../user-profile/user-normal.jpg";// the default avatar
    $type = $_POST['type'];// the borrower type.
    $Deposit = 10;//default your account balance is 10
    $BorrowSum = 0; // defalut you never borrow the book
    $VerifyCode = $_POST['verifyCode'];// your verify code.

    $queryID = "select * from BORROWER where UID = '$id' ";
    $resultID = mysqli_query($link,$queryID);

    if(mysqli_num_rows($resultID) > 0){

        echo 0;
    }else{
        $queryVerify = "select VerifyCode from BORROWER where Email = '$email'";
        $resultVerify = mysqli_query($link,$queryVerify);
        $row = mysqli_fetch_assoc($resultVerify);
        if($row['VerifyCode'] == $VerifyCode){// judge whether or not the verify code you input is same as the verify code which is stored in database.
            $updateQuery = "UPDATE BORROWER SET UID = '$id', Name = '$name', Password = '$password', Type = '$type',
                            Phone = '$phone',Profile = '$profile',Deposit = '$Deposit',BorrowSum = '$BorrowSum' WHERE Email = '$email'";
            mysqli_query($link,$updateQuery);
            echo 2;
        }else{
            echo 1;
        }
        mysqli_free_result($resultVerify);
    }
    mysqli_free_result($resultID);
}

mysqli_close($link);

?>


