<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/19/18
 * Time: 21:58
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");
//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$email = $_POST["email"];
$myIndex = $_POST["myIndex"]; // this parameter using to differentiate whether it is  7 days' recording, a month's recording or a year's recording.

if(isset($_POST['email'])){
    $query = "select UID from BORROWER where Email = '$email'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_assoc($result);
    $UID = $row["UID"];
    $time = time();
    $Date_now = date("y-m-d",$time);
    $continue_date;

    switch ($myIndex){
        case "1":
            $continue_date = date('Y-m-d',strtotime('-1 year')); // using to search last 1 year's recording.
            break;
        case "2":
            $continue_date = date('Y-m-d',strtotime('-1 month'));// using to search last 1 month's recording.
            break;
        case "3":
            $continue_date = date('Y-m-d',strtotime('-7 day'));// using to search last 1 week's recording.
            break;
    }

    $query2 = "select BOOK_LOADS.Date_out, BOOK_LOADS.Due_date, BOOK_LOADS.Return_date, BOOK.Cover, BOOK.Title,BOOK.ISBN
               from BOOK_LOADS, BOOK
               where BOOK_LOADS.Borrower_ID = '$UID' and BOOK_LOADS.Book_ISBN = BOOK.ISBN and BOOK_LOADS.Date_out > '$continue_date' and
               (BOOK_LOADS.Date_out < '$Date_now' OR BOOK_LOADS.Date_out = '$Date_now')";
    $result2 = mysqli_query($link,$query2);
    $results = array();

    while ($row = mysqli_fetch_assoc($result2)) {
        $results[] = $row; // store the search result in an array
    }

    $json = json_encode($results); // transfer the arrary into a json
    echo $json; // send this json to JS file
}
mysqli_close($link);
