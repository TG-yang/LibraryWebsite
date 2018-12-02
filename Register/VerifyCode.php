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
    // 密码字符集，可任意添加你需要的字符
    $chars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l','m', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y','z', 'A', 'B', 'C', 'D',
        'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O',
        'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y','Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    // 在 $chars 中随机取 $length 个数组元素键名
    $keys = array_rand($chars, $length);
    $password = '';
    for($i = 0; $i < $length; $i++)
    {
        // 将 $length 个数组元素连接成字符串
        $password .= $chars[$keys[$i]];
    }
    return $password;
}

function sendMail($to,$title,$content){


    //实例化PHPMailer核心类
    $mail = new PHPMailer\PHPMailer();

    //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
    $mail->SMTPDebug = 1;

    //使用smtp鉴权方式发送邮件
    $mail->isSMTP();

    //smtp需要鉴权 这个必须是true
    $mail->SMTPAuth=true;

    //链接qq域名邮箱的服务器地址
    $mail->Host = 'smtp.gmail.com';

    //设置使用ssl加密方式登录鉴权
    $mail->SMTPSecure = 'ssl';

    //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
    $mail->Port = 465;

    //设置smtp的helo消息头 这个可有可无 内容任意

    //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名

    //设置发送的邮件的编码 可选GB2312  据说utf8在某些客户端收信下会乱码
    $mail->CharSet = 'UTF-8';

    //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
    $mail->FromName = 'Clemson Library';

    //smtp登录的账号 这里填入字符串格式的qq号即可
//    $mail->Username ='369940182';
    $mail->Username ='xxx@gmail.com';
    //smtp登录的密码 使用生成的授权码
    $mail->Password = 'xxx';
    //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
    $mail->From = 'xxx@gmail.com';
    //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
    $mail->isHTML(true);

    //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
    $mail->addAddress($to,'标题啦');

    //添加多个收件人 则多次调用方法即可
    // $mail->addAddress('xxx@163.com','l通知');

    //添加该邮件的主题
    $mail->Subject = $title;

    //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
    $mail->Body = $content;

    //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
    // $mail->addAttachment('./55.jpg','head.jpg');
    //同样该方法可以多次调用 上传多个附件
    // $mail->addAttachment('./Juery-1.1.0.js','jquery.js');

    $status = $mail->send();
    //简单的判断与提示信息
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

