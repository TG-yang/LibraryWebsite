<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/18/18
 * Time: 12:17
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$ISBN = $_POST['ISBN'];

$query = "select * from BOOK where ISBN = '$ISBN'";// this sql statement will be used query the book information according to the ISBN

$result = mysqli_query($link,$query);
$results = array();

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; // using an array to store the information
}
$json = json_encode($results);// transfer the result to json
echo $json;// send the json to JS file.

//mysqli_free_result($link);
mysqli_close($link);