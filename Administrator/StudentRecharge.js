document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var myRecharge = {
    stuRecharge : function (str1,str2,str3) {
        var ID = document.getElementById(str1).value;
        var recharge = document.getElementById(str2).value;
        var deposit = document.getElementById(str3).innerText;

        $.ajax({
            type: 'POST',
            url: 'Recharge.php',
            data:{
                UID: ID,
                Recharge:recharge,
                Deposit:deposit
            },
            success: function (data) {
                if(data == -1){
                    swal("FAILURE","The recharge process has produced some errors!","error");
                }else{
                    swal({title: "SUCCESS",text:"You recharge successfully",type:"success"}).then(() =>{
                        document.getElementById(str3).innerText = data;
                    });
                }
            }
        })
    }
}

