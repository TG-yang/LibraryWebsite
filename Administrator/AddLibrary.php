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

$LibraryName  = $_POST['LibraryName']; // library name
$Position = $_POST['Position']; // library position
$Hours = $_POST['Hours']; // library hours
$Phone = $_POST['Phone']; // library phone number

$query = "SELECT * FROM Library WHERE LibraryName = '$LibraryName'";
$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) > 0){  // if this library name has existed in our database, return 1
    echo 1;
}else{
    $picName = explode(".",$_FILES['Cover']['name']); //using "." to split the string into an array
    $picTmpName = $_FILES['Cover']['tmp_name']; // the picture's temporary address
    $extension = end($picName);// the picture's type
    $LibraryNamePic =  strtr($LibraryName, array(' '=>'')); // eliminate the space
    $dir_base = "../LibraryCover/".$LibraryNamePic.".".$extension; // the picture's new address in our database
    move_uploaded_file($picTmpName,$dir_base); // upload the picture into our server
    chmod($dir_base,644); // set the picture's permission

    $insertQuert = "INSERT INTO Library(LibraryName,Position,Hours,Phone,Cover) VALUES ('$LibraryName','$Position','$Hours','$Phone','$dir_base')";
    $resultInsert = mysqli_query($link,$insertQuert);
    if($resultInsert)
        echo $dir_base;
    else
        echo 2;
}

//mysqli_free_result($link);
mysqli_close($link);