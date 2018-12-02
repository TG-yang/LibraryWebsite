var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

document.write("<script language=javascript src='../General/Cookie.js'></script>");

$('#Login_submit').click(function () {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    if(email.val != '' && password.val != ''){
        $.ajax({
            type: 'POST',
            data: {
                email:document.getElementById("email").value,
                password:document.getElementById("password").value
            },
            url: 'Login.php',
            success:function (responeText) {
                if(responeText == 0){
                    swal("FAILURE","The password or the email is wrong","error");
                }else if(responeText == 1){
                    // cookie.set("email",document.getElementById("email").value,2);
                    // swal("SUCCESS","You login successfully","success");
                    //
                    cookie.set("email",document.getElementById("email").value,2);
                    swal({title: "SUCCESS",text:"You login successfully",type:"success"}).then(() =>{
                        window.location.href = "../Index/Index.html";
                    });
                }else if(responeText == 2){
                    swal({title: "SUCCESS",text:"Admin login successfully",type:"success"}).then(() =>{
                        window.location.href = "../Administrator/MainAdminister.html";
                    });
                } else{
                    swal("Warning","Connecting the database fail","error");
                }
            }
        })
    }
    return false;
})
