<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/4/18
 * Time: 16:55
 */

$link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");

$select = mysqli_select_db($link,'Library_System') or die("Cound not connect to Library_System");

//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");

mysqli_set_charset($link,'utf8');


if(isset($_POST['UID']) && isset($_POST['ISBN'])){

    $Borrower_ID = $_POST['UID'];
    $Book_ISBN = $_POST['ISBN'];
    $fine = $_POST['fine'];

    $querySearch = "SELECT * FROM BOOK_LOADS WHERE Borrower_ID = '$Borrower_ID' AND Book_ISBN = '$Book_ISBN' ";
    $resultSearch = mysqli_query($link,$querySearch);
    $row2 = mysqli_fetch_assoc($resultSearch);
    $Return_date =  $row2['Return_date'];
    $Due_date = $row2['Due_date'];

    if($Return_date != "2018-10-01"){
        echo 2;
    }else{
        $time = time();
        $Return_date = date("y-m-d",$time);
        $updateQuery = "UPDATE BOOK_LOADS SET Return_date = '$Return_date' WHERE Borrower_ID = '$Borrower_ID' AND Book_ISBN = '$Book_ISBN'";
        $updateResult = mysqli_query($link,$updateQuery);
        if($updateResult){
            $IDquery = "SELECT * FROM BORROWER WHERE UID = '$Borrower_ID'";
            $IDresult = mysqli_query($link,$IDquery);
            $row = mysqli_fetch_assoc($IDresult);
            $BorrowSum = $row['BorrowSum'];
            $BorrowSum -= 1;
            $Deposit = $row['Deposit'];

            $Due_date_array = explode("-",$Due_date);
            $Date_return_array = explode("-",$Return_date);
            $Date_result = ($Date_return_array[0] - $Due_date_array[0] + 2000) * 365 + ($Date_return_array[1] - $Due_date_array[1]) * 30 + $Date_return_array[2] - $Due_date_array[2];
            if($Date_result > 0)
                $Deposit = $Deposit - $fine - $Date_result;
            else
                $Deposit = $Deposit - $fine;

            $updateID = "UPDATE BORROWER SET BorrowSum = '$BorrowSum',Deposit = '$Deposit' WHERE  UID = '$Borrower_ID' ";
            mysqli_query($link,$updateID);

            $ISBNquery = "SELECT * FROM BOOK WHERE ISBN = '$Book_ISBN'";
            $ISBNresult = mysqli_query($link,$ISBNquery);
            $row1 = mysqli_fetch_assoc($ISBNresult);
            $Quantity = $row1['Quantity'];
            $Quantity += 1;
            $ISBNupdate = "UPDATE BOOK SET Quantity = '$Quantity' WHERE ISBN = '$Book_ISBN'";
            mysqli_query($link,$ISBNupdate);

            echo 1;
        }else{
            echo 0;
        }
    }

}

//mysqli_free_result($link);
mysqli_close($link);