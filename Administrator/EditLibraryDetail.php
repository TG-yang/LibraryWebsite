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
    $LibraryName = $_POST['LibraryName'];
    $Position = $_POST['Position'];
    $Hours = $_POST['Hours'];
    $Phone = $_POST['Phone'];
    $img = $_POST['img'];

    if(!empty($_FILES['Cover']['tmp_name'])){
        $picName = explode(".",$_FILES['Cover']['name']);
        $picTmpName = $_FILES['Cover']['tmp_name'];
        $extension = end($picName);
        $LibraryNamePic =  strtr($LibraryName, array(' '=>''));
        $dir_base = "../LibraryCover/".$LibraryNamePic.".".$extension;
        move_uploaded_file($picTmpName,$dir_base);
        chmod($dir_base,644);

        $query = "UPDATE Library SET Position = '$Position', Hours = '$Hours', Phone = '$Phone',
                  Cover = '$dir_base' WHERE LibraryName = '$LibraryName'";
        $result = mysqli_query($link,$query);
        if($result)
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
