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

    $data["ISBN"] = $row["ISBN"]; //book's ISBN
    $data["Author"] = $row["Author"]; // book's author
    $data["Title"] = $row["Title"];// book title
    $data["Publisher"] = $row["Publisher"];// book publisher
    $data["PublicationYear"] = $row["PublicationYear"];// book publication year
    $data["Page"] = $row["Page"];// book total page
    $data["Location"] = $row["Location"]; // book location
    $data["Quantity"] = $row["Quantity"];// book current quantity
    $data["Cover"] = $row["Cover"];// book cover
    $data["Introduction"] = $row["Introduction"]; // book introduction
    $data["AboutAuthor"] = $row["AboutAuthor"]; // book author's information

    echo json_encode($data); // return a json which store the $data
}

//mysqli_free_result($link);
mysqli_close($link);