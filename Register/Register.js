var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);


var username = document.forms["registerForm"]["username"];
var ID = document.forms["registerForm"]["ID"];
var email = document.forms["registerForm"]["email"];
var password = document.forms["registerForm"]["password"];
var confirm = document.forms["registerForm"]["confirm"];
var phone = document.forms["registerForm"]["phone"];

//Getting all error display object
var name_error = document.getElementById("name_error");
var ID_error = document.getElementById("ID_error");
var email_error = document.getElementById("email_error");
var password_error = document.getElementById("password_error");
var confirm_error = document.getElementById("confirm_error");
var phone_error = document.getElementById("phone_error");

//Setting all event listeners
username.addEventListener("blur",nameVerify,true);
ID.addEventListener("blur",IDVerify,true);
email.addEventListener("blur",emailVerify,true);
password.addEventListener("blur",passwordVerify,true);
confirm.addEventListener("blur",confirmVerify,true);
phone.addEventListener("blur",phoneVerify,true);

//Setting all event listeners
username.addEventListener("blur",nameVerify,true);
ID.addEventListener("blur",IDVerify,true);
email.addEventListener("blur",emailVerify,true);
password.addEventListener("blur",passwordVerify,true);
confirm.addEventListener("blur",confirmVerify,true);
phone.addEventListener("blur",phoneVerify,true);

$('#register_submit').click(function () {

    var type = document.getElementsByName("type");
    var chkObjs;
    for (var i=0;i<type.length;i++){ //遍历Radio
        if(type[i].checked){
            chkObjs=type[i].value;
        }
    }
    $.ajax({
        type: 'POST',
        data: {
            email:document.getElementById("email").value,
            UID:document.getElementById(("ID")).value,
            username:document.getElementById(("username")).value,
            password:document.getElementById(("password")).value,
            confirm:document.getElementById(("confirm")).value,
            phone:document.getElementById(("phone")).value,
            type:chkObjs,
            verifyCode:document.getElementById("verify-code").value,
        },
        url: 'Register.php',
        success:function (responeText) {
            if(responeText == 0){
                swal("FAILURE","The UID has been registered","error");
            }else if(responeText == 1){
                swal("FAILURE","The Verify Code is wrong!","error");
            }else if(responeText == 2){
                 // window.location = "../Login/login.html";
                swal({title: "SUCCESS",text:"You Register successfully",type:"success"}).then(() =>{
                    window.location = "../Login/login.html";
                });
            }else if(responeText == 3){
                username.style.border = "1px solid red";
                name_error.textContent = "Name is required";
                username.focus();
            }else if(responeText == 4){
                ID.style.border = "1px solid red";
                ID_error.textContent = "ID is required";
                ID.focus();
            }else if(responeText == 5){
                email.style.border = "1px solid red";
                if(document.getElementById("email").value == ""){
                    email_error.textContent = "Email is required";
                }else{
                    email_error.textContent = "Your email address is not correct";
                }
                email.focus();
            }else if(responeText == 6){
                password.style.border = "1px solid red";
                password_error.textContent = "Password is required";
                password.focus();
            }else if (responeText == 7){
                password.style.border = "1px solid red";
                password_error.textContent = "The password contains at least 1 capital letter";
                password.focus();
            }else if(responeText == 8){
                confirm.style.border = "1px solid red";
                confirm_error.textContent = "Confirm password is required";
                confirm.focus();
            }else if(responeText == 9){
                confirm.style.border = "1px solid red";
                confirm_error.innerHTML = "The two passwords do not match";
            }else if(responeText == 10){
                phone.style.border = "1px solid red";
                phone_error.textContent = "Phone is required";
                phone.focus();
            }else{
                swal("Warning","Connecting database failure","warning");
            }
        }
    })
    return false;
})

function nameVerify(){
    if(username.value != ""){
        username.style.border = "1px solid #5E6E66";
        name_error.innerHTML = "";
        return true;
    }
}

function IDVerify(){
    if(ID.value != ""){
        ID.style.border = "1px solid #5E6E66";
        ID_error.innerHTML = "";
        return true;
    }
}

function emailVerify(){
    if(email.value != ""){
        email.style.border = "1px solid #5E6E66";
        email_error.innerHTML = "";
        return true;
    }
}

function passwordVerify(){
    if(password.value != ""){
        password.style.border = "1px solid #5E6E66";
        password_error.innerHTML = "";
        return true;
    }
}

function confirmVerify(){
    if(confirm.value != ""){
        confirm.style.border = "1px solid #5E6E66";
        confirm_error.innerHTML = "";
        return true;
    }

    if(confirm.value == password.value){
        confirm.style.border = "1px solid #5E6E66";
        confirm_error.innerHTML = "";
        return true;
    }
}

function phoneVerify(){
    if(phone.value != ""){
        phone.style.border = "1px solid #5E6E66";
        phone_error.innerHTML = "";
        return true;
    }
}

