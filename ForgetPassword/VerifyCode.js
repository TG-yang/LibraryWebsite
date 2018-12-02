var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var verifyCode = {
    emailVerify : function () {

        $.ajax({
            type: 'POST',
            data: {
                email: document.getElementById('email').value,
            },
            url: 'VerifyCode.php',
            success : function (data) {
                if(data == 1){
                    swal("FAILURE","This email has not finished register","error");
                }else if(data == 2){
                    swal("SUCCESS","The Verify Code has been sent successfully","success");
                }else if(data == 3){
                    swal("FAILURE","The Verify Code can not be sent","error");
                }else if(data == 4){
                    swal("FAILURE","There is no such email in database","error");
                }else{
                    swal("SUCCESS","The Verify Code has been sent successfully","success");
                }
            }
        })
    }
}