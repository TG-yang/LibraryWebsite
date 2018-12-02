<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/16/18
 * Time: 21:35
 */


$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$LibraryName = $_POST['LibraryName'];
$query = "select * from Library where LibraryName = '$LibraryName'";
$result = mysqli_query($link,$query);

$row = mysqli_fetch_assoc($result);
$data["LibraryName"] = $row["LibraryName"]; //library name
$data["Position"] = $row["Position"];// library postion
$data["Hours"] = $row["Hours"];// library hours
$data["Phone"] = $row["Phone"];// library phone number
$data["Cover"] = $row["Cover"];// library cover

echo json_encode($data); //transfer the $data into json and then send to the JS file, which will be caught by ajax/

//mysqli_free_result($link);
mysqli_close($link);