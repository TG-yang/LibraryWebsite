<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/25/18
 * Time: 17:34
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$email = $_POST['email'];

if(isset($_POST['email'])){
    $query = "select * from BORROWER where Email = '$email'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_assoc($result);
    $data["Name"] = $row["Name"];
    $data["UID"] = $row["UID"];
    $data["Type"] = $row["Type"];
    $data["Email"] = $row["Email"];
    $data["Phone"] = $row["Phone"];
    $data["Profile"] = $row["Profile"];
    $data["Deposit"] = $row["Deposit"];
    echo json_encode($data);
    mysqli_free_result($result);
}
mysqli_close($link);
