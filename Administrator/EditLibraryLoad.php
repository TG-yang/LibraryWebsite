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
$data["LibraryName"] = $row["LibraryName"];
$data["Position"] = $row["Position"];
$data["Hours"] = $row["Hours"];
$data["Phone"] = $row["Phone"];
$data["Cover"] = $row["Cover"];

echo json_encode($data);

//mysqli_free_result($link);
mysqli_close($link);