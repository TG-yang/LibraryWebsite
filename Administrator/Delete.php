<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/31/18
 * Time: 15:09
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

if(isset($_POST['ISBN'])){
    $ISBN = $_POST['ISBN'];

    $query1 = "select * from BOOK where ISBN = '$ISBN'";
    $result1 = mysqli_query($link,$query1);

    if(mysqli_num_rows($result1) > 0){ // if the database has this ISBN, you can delete this book
        $query = "DELETE FROM BOOK WHERE ISBN = '$ISBN'";
        $result = mysqli_query($link,$query);
        echo 1;
    }else{
        echo 0;
    }
}

//mysqli_free_result($link);
mysqli_close($link);