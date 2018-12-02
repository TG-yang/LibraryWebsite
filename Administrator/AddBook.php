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

$Title = $_POST["Title"]; // book's title
$Author = $_POST["Author"]; // book's author
$PublicationYear = $_POST["PublicationYear"]; // book's publication year
$Page = $_POST["Page"];// book's total page
$Location = $_POST["Location"];// book's location in library
$ISBN = $_POST["ISBN"]; //book's ISBN
$Quantity = $_POST["Quantity"];// book's current quantity
$Introduction = $_POST["Introduction"];//book's introduction
$AboutAuthor = $_POST["AboutAuthor"]; // book author's information
$Publisher = $_POST["Publisher"]; // book's publisher


$query = "SELECT * FROM BOOK WHERE ISBN = '$ISBN'";
$result = mysqli_query($link,$query);
if(mysqli_num_rows($result) > 0){ // if this ISBN has existed in our database, it will return 1 which means you can not insert this book in our library, you should change the ISBN
    echo 1;
}else{
    $picName = explode(".",$_FILES['file']['name']); //using the "." to block the string into an array.
    $picTmpName = $_FILES['file']['tmp_name']; // the picture's temporary name in our code.
    $extension = end($picName); // the picture's type
    $dir_base = "../BookCover/".$ISBN.".".$extension; // the picture's new address in server
    move_uploaded_file($picTmpName,$dir_base); // upload the picture into the server
    chmod($dir_base,644); // set the picture's permission

    $time = time();
    $Date = date("y-m-d-h-i-s",$time);

    $insertQuert = "INSERT INTO BOOK(ISBN,Author,Title,Publisher,PublicationYear,Page,Location,Quantity,Cover,Introduction,AboutAuthor,Date) 
                    VALUES ('$ISBN','$Author','$Title','$Publisher','$PublicationYear','$Page','$Location','$Quantity','$dir_base','$Introduction','$AboutAuthor','$Date')";
    $resultInsert = mysqli_query($link,$insertQuert);
   if($resultInsert) // if insert the book successfully, it will return the picture's address, which will be used to show the picture in our web page.
       echo $dir_base;
   else
       echo 2;
}

//mysqli_free_result($link);
mysqli_close($link);



