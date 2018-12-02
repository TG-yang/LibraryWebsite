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
    $ISBN = $_POST['ISBN'];
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $Publisher = $_POST['Publisher'];
    $PublicationYear = $_POST['PublicationYear'];
    $Page = $_POST['Page'];
    $Location = $_POST['Location'];
    $Quantity = $_POST['Quantity'];
//    $Cover = $_POST['Cover'];
    $Introduction = $_POST['Introduction'];
    $AboutAuthor = $_POST['AboutAuthor'];
    $img = $_POST['img'];

    if(!empty($_FILES['Cover']['tmp_name'])){
        $picName = explode(".",$_FILES['Cover']['name']);
        $picTmpName = $_FILES['Cover']['tmp_name'];
        $extension = end($picName);
        $time = time();
        $dir_base = "../BookCover/".$ISBN."-".date("y-m-d-h-i-s",$time).".".$extension;
        move_uploaded_file($picTmpName,$dir_base);
        chmod($dir_base,644);

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

