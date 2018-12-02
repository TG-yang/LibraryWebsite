<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 10/25/18
 * Time: 17:34
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die ("Could not connect to database");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');

$email = $_POST['email']; //the ajax send the email address to server, and php using _POST to get this email address.

if(isset($_POST['email'])){
    $query = "select * from BORROWER where Email = '$email'";// using email address to query the database, which will return the borrower's information.
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_assoc($result);
    $data["Name"] = $row["Name"];// borrower username
    $data["UID"] = $row["UID"]; // borrower student ID
    $data["Type"] = $row["Type"]; // borrower type student or professor
    $data["Email"] = $row["Email"]; // borrower's email
    $data["Phone"] = $row["Phone"]; // borrwer's phone number
    $data["Profile"] = $row["Profile"]; // borrower's avatar
    $data["Deposit"] = $row["Deposit"]; // borrower's account balance.
    echo json_encode($data); // transfer these data to json and send to JS file
    mysqli_free_result($result);
}
mysqli_close($link);
