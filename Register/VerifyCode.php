<?php
/**
 * Created by PhpStorm.
 * User: wenyangzheng
 * Date: 11/22/18
 * Time: 14:43
 */
require_once("./src/PHPMailer.php");
require_once("./src/SMTP.php");

use PHPMailer\PHPMailer;

function make_password( $length = 8 ){
    // Password character set, you can add any character you need
    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    // Randomly get $length array element key names in $chars
    $keys = array_rand($chars, $length);
    $password = '';
    for($i = 0; $i < $length; $i++)
    {
        // Join $length array elements into a string
        $password .= $chars[$keys[$i]];
    }
    return $password;
}

function sendMail($to,$title,$content){


    //Instantiate the PHPMailer core class
    $mail = new PHPMailer\PHPMailer();

    //Whether to enable smtp debug for debugging development environment is recommended to open the production environment comment out to disable debug debug mode by default
    $mail->SMTPDebug = 1;

    //Send mail using smtp authentication
    $mail->isSMTP();

    //Smtp requires authentication. This must be true.
    $mail->SMTPAuth=true;

    //Link the server address of the glaik domain mailbox
    $mail->Host = 'smtp.gmail.com';

    //Set the login authentication using ssl encryption.
    $mail->SMTPSecure = 'ssl';

    //Set ssl to connect to the remote server port number of the smtp server.
    //The previous default is 25, but now the new one seems to be unavailable. Optional 465 or 587
    $mail->Port = 465;

    //Set the encoding of the sent mail Optional GB2312 It is said that utf8 will be garbled under some client receiving
    $mail->CharSet = 'UTF-8';

    //Set the sender's name (nickname) Any content that displays the sender's name in front of the sender's email address of the recipient's email
    $mail->FromName = 'Clemson Library';

    //Smtp login account
//    $mail->Username ='369940182';
    $mail->Username ='xxx@gmail.com';
    //Smtp login password Use the generated authorization code
    $mail->Password = 'xxx';
    //Set the sender's email address. Fill in the "Sender's Mailbox" mentioned above.
    $mail->From = 'xxx@gmail.com';
    //Whether the body of the message is html-coded Note that this is a method no longer a property true or false
    $mail->isHTML(true);

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to,'...');

    //添加该邮件的主题
    $mail->Subject = $title;

    //Add the body of the message Set the isHTML to true above,
    // then it can be a complete html string.
    // For example, use the file_get_contents function to read the local html file.
    $mail->Body = $content;

    $status = $mail->send();

    if($status) {
        return true;
    }else{
        return false;
    }
}

$link = mysqli_connect('localhost','root','root') or die("Could not connect to database");

$select = mysqli_select_db($link, 'Library_System') or die("Cound not connect to Library_System");
//$link = mysqli_connect('mysql1.cs.clemson.edu','LbrySystm_8j2b','Zhengwenyang1995!') or die("Could not connect to database");
//
//$select = mysqli_select_db($link, 'Library_System_ray6') or die("Cound not connect to Library_System");
mysqli_set_charset($link,'utf8');

//when you register the database, you should receive a verify code using your email.
if(isset($_POST['email'])){
    $email = $_POST['email'];
    $query = "select * from BORROWER where Email = '$email'";
    $result = mysqli_query($link,$query);

    if($result && mysqli_num_rows($result)){
        $row = mysqli_fetch_assoc($result);
        if($row['UID'] == ''){
            $verifyCode = make_password(6);
            $content = "The Verify Code is: ".$verifyCode;

            $query = "UPDATE BORROWER SET VerifyCode = '$verifyCode' WHERE Email = '$email'";
            $res = mysqli_query($link,$query);
            if($res){
                $flag = sendMail($email,'Library Register',$content);
                if($flag)
                    echo 2;
                else
                    echo 3;
            }
            mysqli_free_result($res);
        }else{
            echo 1;
        }
    }else{
        $verifyCode = make_password(6);
        $content = "The Verify Code is: ".$verifyCode;

        $insertQuert = "insert into BORROWER(UID,Name,Password,Type,Email,Phone,Profile,Deposit,BorrowSum,VerifyCode)
						values ('','','','','$email','','',0,0,'$verifyCode')";
        $res = mysqli_query($link,$insertQuert);
        if($res){
            $flag = sendMail($email,'Library Register',$content);
            if($flag)
                echo 2;
            else
                echo 3;
        }
        mysqli_free_result($res);
    }
    mysqli_free_result($result);
}

mysqli_close($link);

