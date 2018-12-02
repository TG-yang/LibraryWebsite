<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 2018/10/9
 * Time: 21:56
 */

$link = mysqli_connect('localhost','root','root') or die("Could not connect to database");

$select = mysqli_select_db($link, 'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['email']) && $_POST['password']){
	//if you are administrator, your account is admin@gmail.com and password is admin
	if($_POST['email'] == 'admin@gmail.com' && $_POST['password'] == 'admin'){
		echo 2;
		exit;
	}
	// if you are a borrower, if you want to login, you should input your own email and password
	// we will judge your password.
	$email = $_POST['email'];
	$password = $_POST['password'];
	$query = "select * from BORROWER where Email = '$email' ";
	$result = mysqli_query($link,$query);

	$row = mysqli_fetch_assoc($result);
	if($row['Password'] == $password && $row['Email'] == $email){
	    echo 1;
	}else{
        echo 0;
	}
    mysqli_free_result($result);
}
mysqli_close($link);
?>

