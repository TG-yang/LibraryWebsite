<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/2/18
 * Time: 23:59
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

    $IDquery = "SELECT * FROM BORROWER WHERE UID = '$Borrower_ID'";
    $IDresult = mysqli_query($link,$IDquery);
    if(mysqli_num_rows($IDresult) == 0){ // if there is on this ID in our database, it will return 1
        echo 1;
    }else {
        $row = mysqli_fetch_assoc($IDresult);
        $BorrowSum = $row['BorrowSum'];
        if($BorrowSum >= 3) // if this borrower has borrowed three books now, it will return 2, which means he or she can not borrow book.
            echo 2;
        else{
            if($row['Deposit'] <= 0){ // if the borrower balance is 0, it will return 7
                echo 7;
            }else{
                $ISBNquery = "SELECT * FROM BOOK WHERE ISBN = '$Book_ISBN'";
                $ISBNresutl = mysqli_query($link,$ISBNquery);
                if(mysqli_num_rows($ISBNresutl) == 0){ // if there is no such ISBN in our database, it will return 3
                    echo 3;
                }else{
                    $row1 = mysqli_fetch_assoc($ISBNresutl);
                    $Quantity = $row1['Quantity'];
                    if($Quantity == 0){ // if all the this book's copy have been borrowed out, it will return 4
                        echo 4;
                    }else{
                        $time = time();
                        $Date_out = date("y-m-d",$time); //return the current date.
                        $Due_date = date('Y-m-d',strtotime('+3 day')); //returnthe due date.
                        $Return_date = "2018-10-1";
                        $BOOK_LOADS_ID = $Borrower_ID."-".$Book_ISBN."-".$Date_out;
                        $insertQuert = "insert into BOOK_LOADS(Borrower_ID,Book_ISBN,Date_out,Due_date,Return_date,BOOK_LOADS_ID)
						values ('$Borrower_ID','$Book_ISBN','$Date_out','$Due_date','$Return_date','$BOOK_LOADS_ID')";
                        $result = mysqli_query($link,$insertQuert);

                        if($result){
                            $BorrowSum += 1;
                            $IDupdate = "UPDATE BORROWER SET BorrowSum = '$BorrowSum' WHERE UID = '$Borrower_ID' ";
                            mysqli_query($link,$IDupdate);

                            $Quantity -= 1;
                            $ISBNupdate = "UPDATE BOOK SET Quantity = '$Quantity' WHERE ISBN = '$Book_ISBN'";
                            mysqli_query($link,$ISBNupdate);
                            echo 5;
                        }else{
                            echo 6;
                        }
                    }
                }
            }
        }
    }
}

//mysqli_free_result($link);
mysqli_close($link);
