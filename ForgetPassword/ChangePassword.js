var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var changePassword = {
    myChangePassword : function () {

        if(document.getElementById("password").value != document.getElementById("confirm-password").value){
            swal("FAILURE","The two passwords do not match","error");
        }else{
            $.ajax({
                type: 'POST',
                data: {
                    email: document.getElementById('email').value,
                    verifyCode: document.getElementById('Verify-Code').value,
                    password: document.getElementById("password").value,
                },
                url: 'ChangePassword.php',
                success : function (data) {
                    if(data == 1){
                        swal("FAILURE","The password should contain at least 1 capital letter","error");
                    }else if(data == 2){
                        swal({title: "SUCCESS",text:"The password has been changed successfully",type:"success"}).then(() =>{
                            window.location.href = "../Login/login.html";
                        });
                    }else if(data == 3){
                        swal("FAILURE","Change password failure","error");
                    }else if(data == 4){
                        swal("FAILURE","Verify Code is wrong","error");
                    }
                }
            })
        }
    }
}