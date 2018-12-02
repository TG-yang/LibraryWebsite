<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/29/18
 * Time: 17:21
 */

class Backup{
    private $link;
    function __construct(){
//        $this->link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");
//        $select = mysqli_select_db($this->link,'Library_System') or die("Could not connect to Library_System");

        $this->link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
        $select = mysqli_select_db($this->link, 'Library_System_ray6') or die("Could not connect to Library_System");

        mysqli_set_charset($this->link,'utf8');
    }

    function __destruct(){
        mysqli_close($this->link);
        // TODO: Implement __destruct() method.
    }

    function myBackup($file,$table_name,array $title){
        header('Content-Type:test/csv; charset = utf-8');
        $output = fopen($file,"w+");
        fputcsv($output,$title);
        $query = "select * from $table_name";
        $result = mysqli_query($this->link,$query);
        while ($row = mysqli_fetch_assoc($result))
            fputcsv($output,$row);

        fclose($output);

        if($result)
            return true;
        else
            return false;
    }
}

$Library = array("LibraryName","Position","Hours","Phone","Cover");
$BOOK = array("ISBN","Author","Title","Publisher","PublicationYear","Page","Location","Quantity","Cover","Introduction","AboutAuthor","Date");
$BOOK_LOADS = array("BOOK_LOADS_ID","Borrower_ID","Book_ISBN","Date_out","Due_date","Return_date");
$BORROWER = array("Email","UID","Name","Password","Type","Phone","Profile","Deposit","BorrowSum","VerifySum");

$Backup = new Backup();

$isLibrary = $Backup->myBackup('../Data/Library.csv','Library',$Library);
$isBOOK = $Backup->myBackup('../Data/BOOK.csv','BOOK',$BOOK);
$isBOOK_LOADS = $Backup->myBackup('../Data/BOOK_LOADS.csv','BOOK_LOADS',$BOOK_LOADS);
$isBORROWER = $Backup->myBackup('../Data/BORROWER.csv','BORROWER',$BORROWER);

if($isLibrary && $isBOOK && $isBOOK_LOADS && $isBORROWER)
    echo 1;
else
    echo 2;


//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Could not connect to Library_System");
//
//mysqli_set_charset($link,'utf8');
//
//header('Content-Type:test/csv; charset = utf-8');
//$output = fopen('../Data/Library.csv',"w");
//$Library = array("LibraryName","Position","Hours","Phone","Cover");
//fputcsv($output,$Library);
//$query = "select * from Library";
//$result = mysqli_query($link,$query);
//while ($row = mysqli_fetch_assoc($result))
//    fputcsv($output,$row);
//
//fclose($output);
//
//if($result)
//    echo 1;
//else
//    echo 2;
//
//mysqli_close($link);

