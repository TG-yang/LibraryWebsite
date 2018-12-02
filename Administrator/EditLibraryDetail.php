<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/16/18
 * Time: 22:04
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['LibraryName'])){
    $LibraryName = $_POST['LibraryName']; // library name
    $Position = $_POST['Position'];// library position
    $Hours = $_POST['Hours']; // library hours
    $Phone = $_POST['Phone'];// library phone number
    $img = $_POST['img']; // library image

    if(!empty($_FILES['Cover']['tmp_name'])){ // judge whether or not you plan to send the picture to server
        $picName = explode(".",$_FILES['Cover']['name']);// using the "." to split the string into an array
        $picTmpName = $_FILES['Cover']['tmp_name']; // the picture temporary name
        $extension = end($picName);// the picture's type
        $LibraryNamePic =  strtr($LibraryName, array(' '=>'')); // eliminate the space
        $dir_base = "../LibraryCover/".$LibraryNamePic.".".$extension; // the picture new address in our server
        move_uploaded_file($picTmpName,$dir_base); // upload the picture into the server
        chmod($dir_base,644);// the picture's permission

        $query = "UPDATE Library SET Position = '$Position', Hours = '$Hours', Phone = '$Phone',
                  Cover = '$dir_base' WHERE LibraryName = '$LibraryName'";
        $result = mysqli_query($link,$query);
        if($result) // if we update the database successfully, it will return the picture's address, which will used to display the picture in the web page.
            echo $dir_base;
    }else{
        $query = "UPDATE Library SET Position = '$Position', Hours = '$Hours', Phone = '$Phone'
                  WHERE LibraryName = '$LibraryName'";
        $result = mysqli_query($link,$query);

        if($result){
            echo $img;
        }else
            echo 1;
    }

}

//mysqli_free_result($link);
mysqli_close($link);
