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
        $output = fopen($file,"w+"); // if exist this file, it will be cleared the content and then write the new information, or it will be built and write the new information
        fputcsv($output,$title); // write what attributes this table include into this file.
        $query = "select * from $table_name";
        $result = mysqli_query($this->link,$query);
        while ($row = mysqli_fetch_assoc($result)) // write the database information into this file.
            fputcsv($output,$row);

        fclose($output); // close this input file.

        if($result)
            return true;
        else
            return false;
    }
}

$Library = array("LibraryName","Position","Hours","Phone","Cover"); // the library table's attributes
$BOOK = array("ISBN","Author","Title","Publisher","PublicationYear","Page","Location","Quantity","Cover","Introduction","AboutAuthor","Date"); // the BOOK table's attributes
$BOOK_LOADS = array("BOOK_LOADS_ID","Borrower_ID","Book_ISBN","Date_out","Due_date","Return_date"); // the BOOK_LOADS table's attributes
$BORROWER = array("Email","UID","Name","Password","Type","Phone","Profile","Deposit","BorrowSum","VerifySum");// the BORROWER table's attributes

$Backup = new Backup();
//using Backup class to backup our table.
$isLibrary = $Backup->myBackup('../Data/Library.csv','Library',$Library);
$isBOOK = $Backup->myBackup('../Data/BOOK.csv','BOOK',$BOOK);
$isBOOK_LOADS = $Backup->myBackup('../Data/BOOK_LOADS.csv','BOOK_LOADS',$BOOK_LOADS);
$isBORROWER = $Backup->myBackup('../Data/BORROWER.csv','BORROWER',$BORROWER);

if($isLibrary && $isBOOK && $isBOOK_LOADS && $isBORROWER) // if all table backup successfully return 1
    echo 1;
else
    echo 2;


