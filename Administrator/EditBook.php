<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/31/18
 * Time: 16:05
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['ISBN'])){
    $ISBN = $_POST['ISBN'];
    $query = "SELECT * FROM BOOK WHERE ISBN = '$ISBN'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_assoc($result);

    $data["ISBN"] = $row["ISBN"];
    $data["Author"] = $row["Author"];
    $data["Title"] = $row["Title"];
    $data["Publisher"] = $row["Publisher"];
    $data["PublicationYear"] = $row["PublicationYear"];
    $data["Page"] = $row["Page"];
    $data["Location"] = $row["Location"];
    $data["Quantity"] = $row["Quantity"];
    $data["Cover"] = $row["Cover"];
    $data["Introduction"] = $row["Introduction"];
    $data["AboutAuthor"] = $row["AboutAuthor"];

    echo json_encode($data);
}

//mysqli_free_result($link);
mysqli_close($link);