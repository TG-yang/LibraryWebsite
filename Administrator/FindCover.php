<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/31/18
 * Time: 13:41
 */


$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['ISBN'])){
    $ISBN = $_POST['ISBN'];
    $query = "SELECT * FROM BOOK WHERE ISBN = '$ISBN'"; //using the ISBN to find out the cover information
    $result = mysqli_query($link,$query);

    if(mysqli_num_rows($result) == 0){
        echo 1;
    }else{
        $row = mysqli_fetch_assoc($result);
        echo $row["Cover"];
    }

}

//mysqli_free_result($link);
mysqli_close($link);