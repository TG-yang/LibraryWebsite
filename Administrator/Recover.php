<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/29/18
 * Time: 19:27
 */

class Recover{
    private $link;
    function __construct(){
//        $this->link = mysqli_connect('localhost','root','root') or die ("Could not connect to database");
//        $select = mysqli_select_db($this->link,'Library_System') or die("Could not connect to Library_System");

        $this->link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
        $select = mysqli_select_db($this->link, 'Library_System_ray6') or die("Could not connect to Library_System");

        mysqli_set_charset($this->link,'utf8');
        // if we want to recover the database, the first step is to delete all the information in database.
        $delete1 = "delete from Library";
        mysqli_query($this->link,$delete1);

        $delete2 = "delete from BOOK";
        mysqli_query($this->link,$delete2);

        $delete3 = "delete from BOOK_LOADS";
        mysqli_query($this->link,$delete3);

        $delete4 = "delete from BORROWER";
        mysqli_query($this->link,$delete4);
    }

    function __destruct(){
        mysqli_close($this->link);
        // TODO: Implement __destruct() method.
    }

    function myRecover($tableName,$file){
        $output = fopen($file,"r"); // open the file with the read only permission.
        $isRecover = false;
        switch ($tableName){
            case 1:
                while(($csvdata = fgetcsv($output)) !== FALSE){
                    //Fill in the information to each parameter
                    //The parameter's order should be same as the backup file.
                    $LibraryName = $csvdata[0];
                    $Position = $csvdata[1];
                    $Hours = $csvdata[2];
                    $Phone = $csvdata[3];
                    $Cover = $csvdata[4];

                    if($LibraryName == 'LibraryName')
                        continue;

                    $query = "insert into Library(LibraryName,Position,Hours,Phone,Cover) values ('$LibraryName','$Position','$Hours','$Phone','$Cover')";
                    $result = mysqli_query($this->link,$query);
                    $isRecover = true;
                }
                break;
            case 2:
                fgetcsv($output);
                while(($csvdata = fgetcsv($output)) !== FALSE){
                    $ISBN = $csvdata[0];
                    $Author = $csvdata[1];
                    $Title = $csvdata[2];
                    $Publisher = $csvdata[3];
                    $PublicationYear = $csvdata[4];
                    $Page = $csvdata[5];
                    $Location = $csvdata[6];
                    $Quantity = $csvdata[7];
                    $Cover = $csvdata[8];
                    $Introduction = $csvdata[9];
                    $AboutAuthor = $csvdata[10];
                    $Date = $csvdata[11];

                    $query = "insert into BOOK(ISBN,Author,Title,Publisher,PublicationYear,Page,Location,Quantity,Cover,Introduction,AboutAuthor,Date) 
                              values ('$ISBN','$Author','$Title','$Publisher','$PublicationYear','$Page','$Location','$Quantity','$Cover','$Introduction','$AboutAuthor','$Date')";
                    $result = mysqli_query($this->link,$query);
                    $isRecover = true;
                }
                break;
            case 3:
                fgetcsv($output);
                while(($csvdata = fgetcsv($output)) !== FALSE){
                    $BOOK_LOADS_ID = $csvdata[0];
                    $Borrower_ID = $csvdata[1];
                    $Book_ISBN = $csvdata[2];
                    $Date_out = $csvdata[3];
                    $Due_date = $csvdata[4];
                    $Return_date = $csvdata[5];

                    $query = "insert into BOOK_LOADS(BOOK_LOADS_ID,Borrower_ID,Book_ISBN,Date_out,Due_date,Return_date)
                              values ('$BOOK_LOADS_ID','$Borrower_ID','$Book_ISBN','$Date_out','$Due_date','$Return_date')";
                    $result = mysqli_query($this->link,$query);
                    $isRecover = true;
                }
                break;
            case 4:
                fgetcsv($output);
                while(($csvdata = fgetcsv($output)) !== FALSE){
                    $Email = $csvdata[0];
                    $UID = $csvdata[1];
                    $Name = $csvdata[2];
                    $Password = $csvdata[3];
                    $Type = $csvdata[4];
                    $Phone = $csvdata[5];
                    $Profile = $csvdata[6];
                    $Deposit = $csvdata[7];
                    $BorrowSum = $csvdata[8];
                    $VerifyCode = $csvdata[9];

                    $query = "insert into BORROWER(Email,UID,Name,Password,Type,Phone,Profile,Deposit,BorrowSum,VerifyCode)
                              values ('$Email','$UID','$Name','$Password','$Type','$Phone','$Profile','$Deposit','$BorrowSum','$VerifyCode')";
                    $result = mysqli_query($this->link,$query);
                    $isRecover = true;
                }
                break;
        }
        fclose($output);
        return $isRecover;
    }
}

$Recover = new Recover();
$isLibrary = $Recover->myRecover(1,'../Data/Library.csv'); // the first parameter is about the table name, the second parameter is the file's address in our server.
$isBOOK = $Recover->myRecover(2,'../Data/BOOK.csv');
$isBOOK_LOADS = $Recover->myRecover(3,'../Data/BOOK_LOADS.csv');
$isBORROWER = $Recover->myRecover(4,'../Data/BORROWER.csv');


if($isLibrary && $isBOOK && $isBOOK_LOADS && $isBORROWER)
    echo 1;
else
    echo 2;