<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/24/18
 * Time: 22:41
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$email = $_POST['email']; // borrower's email address.

if(isset($_POST['phone'])){ // borrower's phone number.
    $phone = $_POST['phone'];
    $query = "SELECT * FROM BORROWER WHERE Phone = '$phone' "; // using phone number to query the database and return the borrower's information
    $result = mysqli_query($link,$query);

    if(strlen($phone) != 10){
        echo 2;
    }else if(mysqli_num_rows($result) > 0){
        echo 1;
    }else{
        $query1 = "UPDATE BORROWER SET Phone = '$phone' WHERE Email = '$email' ";
        $result1 = mysqli_query($link,$query1);
        echo 0;
        //mysqli_free_result($result1);
    }
//    mysqli_free_result($result);
}else if(isset($_POST['username'])){
    $username = $_POST['username'];
    $query = "UPDATE BORROWER SET Name = '$username' WHERE Email = '$email' ";
    $result = mysqli_query($link,$query);
    if($result){
        echo 3;
    }
//    mysqli_free_result($result);

}else if(isset($_POST['password'])){  // this if statement using to update the password.
    $oldPassword = $_POST['password'];
    $newPassword = $_POST['passcode'];
    $query1 = "SELECT * FROM BORROWER WHERE Email = '$email' AND Password = '$oldPassword'";
    $result1 = mysqli_query($link,$query1);

    if(mysqli_num_rows($result1) == 0){
        echo 5;
    }else{
        $query = "UPDATE BORROWER SET Password = '$newPassword' WHERE Email = '$email'";
        $result = mysqli_query($link,$query);
        if($result){
            echo 4;
        }
//        mysqli_free_result($result);
    }
//    mysqli_free_result($result1);

}else if(!empty($_FILES['file'])){ // this if stament using to update personal avatar.


    $picName = explode(".",$_FILES['file']['name']); // using "." to split a string to an arrary.
    $picTmpName = $_FILES['file']['tmp_name']; // return the file's temporary name
    $extension = end($picName); // return the picture's type(jpg or png)
    $time = time(); //return the time
    $dir_base = "../user-profile/".$email.date("y-m-d-h-i-s",$time).".".$extension; // general a new picture address in server.
    move_uploaded_file($picTmpName,$dir_base); // upload the picture to the server
    chmod($dir_base,644); // set the picture's permission.

    $query = "UPDATE BORROWER SET Profile = '$dir_base' WHERE Email = '$email'";
    $result = mysqli_query($link,$query);
    if($result) {
        echo $dir_base;
    }
//    mysqli_free_result($result);
}
mysqli_close($link);


