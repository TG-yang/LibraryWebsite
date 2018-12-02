<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/17/18
 * Time: 14:55
 */

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

mysqli_set_charset($link,'utf8');

$queryString = $_POST['queryString'];
// this is search book function, and it will search the book though the fuzzy matching(using the LIKE and %)
$query = "select Cover,Author,Title,Introduction, ISBN from BOOK where Title = '$queryString' OR Title LIKE '%$queryString' OR 
          Title LIKE '%$queryString%' OR Title LIKE '$queryString%' ";

$result = mysqli_query($link,$query);
$results = array();

while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row; // using an array to store the search result
}
$json = json_encode($results); // transfer the result into json
echo $json;// send the json code to JS file

mysqli_free_result($result);
mysqli_close($link);
