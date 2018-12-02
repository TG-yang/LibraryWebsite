<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/14/18
 * Time: 23:03
 */


$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$LibraryName  = $_POST['LibraryName'];
$Position = $_POST['Position'];
$Hours = $_POST['Hours'];
$Phone = $_POST['Phone'];

$query = "SELECT * FROM Library WHERE LibraryName = '$LibraryName'";
$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) > 0){
    echo 1;
}else{
    $picName = explode(".",$_FILES['Cover']['name']);
    $picTmpName = $_FILES['Cover']['tmp_name'];
    $extension = end($picName);
    $LibraryNamePic =  strtr($LibraryName, array(' '=>''));
    $dir_base = "../LibraryCover/".$LibraryNamePic.".".$extension;
    move_uploaded_file($picTmpName,$dir_base);
    chmod($dir_base,644);

    $insertQuert = "INSERT INTO Library(LibraryName,Position,Hours,Phone,Cover) VALUES ('$LibraryName','$Position','$Hours','$Phone','$dir_base')";
    $resultInsert = mysqli_query($link,$insertQuert);
    if($resultInsert)
        echo $dir_base;
    else
        echo 2;
}

//mysqli_free_result($link);
mysqli_close($link);