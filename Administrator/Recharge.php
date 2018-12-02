<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/2/18
 * Time: 22:58
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['UID'])){
    $ID = $_POST['UID'];
    $Recharge = $_POST['Recharge'];
    $Deposit = intval($_POST['Deposit'] )+ intval($Recharge);

    $query = "UPDATE BORROWER SET Deposit = '$Deposit'  WHERE UID = '$ID'";//using rhe borrower's ID to recharge the person's account
    $result = mysqli_query($link,$query);

    if($result)
        echo $Deposit;
    else
        echo -1;

}

//mysqli_free_result($link);
mysqli_close($link);