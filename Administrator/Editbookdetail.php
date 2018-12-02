<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/2/18
 * Time: 13:43
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['ISBN'])){
    $ISBN = $_POST['ISBN']; // book's ISBN
    $Title = $_POST['Title']; // book's title
    $Author = $_POST['Author']; // book's author
    $Publisher = $_POST['Publisher']; // book publisher
    $PublicationYear = $_POST['PublicationYear']; // book publication year
    $Page = $_POST['Page'];// book page
    $Location = $_POST['Location']; // book location in library
    $Quantity = $_POST['Quantity'];// book current quantity
//    $Cover = $_POST['Cover'];
    $Introduction = $_POST['Introduction'];//book introduction
    $AboutAuthor = $_POST['AboutAuthor'];// book author information
    $img = $_POST['img']; // book image

    if(!empty($_FILES['Cover']['tmp_name'])){
        $picName = explode(".",$_FILES['Cover']['name']); // using "." to split the string into an array
        $picTmpName = $_FILES['Cover']['tmp_name']; // book's temporary name
        $extension = end($picName); // picture's type
        $time = time();
        $dir_base = "../BookCover/".$ISBN."-".date("y-m-d-h-i-s",$time).".".$extension; // picture new address in server
        move_uploaded_file($picTmpName,$dir_base);// upload the picture into the server.
        chmod($dir_base,644);// set the picture's permission

        $query = "UPDATE BOOK SET Title = '$Title', Author = '$Author', Publisher = '$Publisher', PublicationYear = '$PublicationYear',
                  Page = '$Page', Location = '$Location', Quantity = '$Quantity', Cover = '$dir_base', Introduction = '$Introduction',
                  AboutAuthor = '$AboutAuthor' WHERE ISBN = '$ISBN'";
        $result = mysqli_query($link,$query);
        if($result)
            echo $dir_base;
    }else{
        $query = "UPDATE BOOK SET Title = '$Title', Author = '$Author', Publisher = '$Publisher', PublicationYear = '$PublicationYear',
                  Page = '$Page', Location = '$Location', Quantity = '$Quantity', Introduction = '$Introduction',
                  AboutAuthor = '$AboutAuthor' WHERE ISBN = '$ISBN'";
        $result = mysqli_query($link,$query);
        if($result)
            echo $img;
        else
            echo 1;
    }

}

//mysqli_free_result($link);
mysqli_close($link);

