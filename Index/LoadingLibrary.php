<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/14/18
 * Time: 21:39
 */

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

mysqli_set_charset($link,'utf8');

$query = "select * from Library";
$result = mysqli_query($link,$query);
$results = array();

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}
$json = json_encode($results);
echo $json;

mysqli_free_result($result);
mysqli_close($link);
