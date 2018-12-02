<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/31/18
 * Time: 00:40
 */


$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");
//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$Title = $_POST["Title"];
$Author = $_POST["Author"];
$PublicationYear = $_POST["PublicationYear"];
$Page = $_POST["Page"];
$Location = $_POST["Location"];
$ISBN = $_POST["ISBN"];
$Quantity = $_POST["Quantity"];
$Introduction = $_POST["Introduction"];
$AboutAuthor = $_POST["AboutAuthor"];
$Publisher = $_POST["Publisher"];


$query = "SELECT * FROM BOOK WHERE ISBN = '$ISBN'";
$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) > 0){
    echo 1;
}else{
    $picName = explode(".",$_FILES['file']['name']);
    $picTmpName = $_FILES['file']['tmp_name'];
    $extension = end($picName);
    $dir_base = "../BookCover/".$ISBN.".".$extension;
    move_uploaded_file($picTmpName,$dir_base);
    chmod($dir_base,644);

    $time = time();
    $Date = date("y-m-d-h-i-s",$time);

    $insertQuert = "INSERT INTO BOOK(ISBN,Author,Title,Publisher,PublicationYear,Page,Location,Quantity,Cover,Introduction,AboutAuthor,Date) 
                    VALUES ('$ISBN','$Author','$Title','$Publisher','$PublicationYear','$Page','$Location','$Quantity','$dir_base','$Introduction','$AboutAuthor','$Date')";
    $resultInsert = mysqli_query($link,$insertQuert);
   if($resultInsert)
       echo $dir_base;
   else
       echo 2;
}

//mysqli_free_result($link);
mysqli_close($link);



