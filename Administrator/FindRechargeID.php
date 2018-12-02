<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/2/18
 * Time: 21:00
 */


$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['ID'])){
    $ID = $_POST['ID'];
    $query = "SELECT * FROM BORROWER WHERE UID = '$ID'"; //using the UID to find out the borrower's balance.
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result) == 0){
        echo -1;
    }else{
        $row = mysqli_fetch_assoc($result);
        echo $row["Deposit"];
    }
}

//mysqli_free_result($link);
mysqli_close($link);

