<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/14/18
 * Time: 16:39
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$query = "select Cover,Author,Title,ISBN from BOOK ORDER BY Date DESC LIMIT 8";//this will query 8 results and this result will be shown in index page.
//this 8 result is the newest in our database.

$result = mysqli_query($link,$query);
$results = array();

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; // using an array to store the query result.
}
$json = json_encode($results);
echo $json;//send the json to the JS file

mysqli_free_result($result);
mysqli_close($link);
