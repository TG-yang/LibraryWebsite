document.write("<script language=javascript src='../General/Cookie.js'></script>")
// document.write("<script language=javasript src ='../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js'></script>")
var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var inforEdit = {
    myEdit:function (str) {
        if(str == "edit-user-info-name"){
            document.getElementById("user-info-name").style.display = "none";
            document.getElementById("edit-user-info-name").style.display = "none";
            document.getElementById("input-user-info-name").style.display = "inline";
            document.getElementById("modify-username").style.display = "inline";
            document.getElementById("cancel-username").style.display = "inline";
        }else if(str == "edit-user-info-phone"){
            document.getElementById("user-info-phone").style.display = "none";
            document.getElementById("edit-user-info-phone").style.display = "none";
            document.getElementById("input-user-info-phone").style.display = "inline";
            document.getElementById("modify-phone").style.display = "inline";
            document.getElementById("cancel-phone").style.display = "inline";
        }
    }
}

var cancelEdit = {
    myCancel : function (str) {
        if(str == "cancel-username"){
            document.getElementById("user-info-name").style.display = "inline";
            document.getElementById("edit-user-info-name").style.display = "inline";
            document.getElementById("input-user-info-name").value = "";
            document.getElementById("input-user-info-name").style.display = "none";
            document.getElementById("modify-username").style.display = "none";
            document.getElementById("cancel-username").style.display = "none";
        }else if(str == "cancel-phone"){
            document.getElementById("user-info-phone").style.display = "inline";
            document.getElementById("edit-user-info-phone").style.display = "inline";
            document.getElementById("input-user-info-phone").value = "";
            document.getElementById("input-user-info-phone").style.display = "none";
            document.getElementById("modify-phone").style.display = "none";
            document.getElementById("cancel-phone").style.display = "none";
        }
    }
}

var modifyEdit = {
    myModify : function (str) {
        var useremail = cookie.get("email");

        if(str == "modify-username"){
            var newname = document.getElementById("input-user-info-name").value;
            if(newname == null || newname == ""){
                swal("FAILURE","The new name can not be empty","error");
            }else{
                modifyEdit.myAjax(useremail,newname,1);
            }
        }else if(str == "modify-phone"){
            var newphone = document.getElementById("input-user-info-phone").value;
            if(newphone == null || newphone == ""){
                swal("FAILURE","The new phone number can not be empty","error");
            }else{
                modifyEdit.myAjax(useremail,newphone,2);
            }
        }
    },

    myAjax : function (myemail,str,key) {
        if(key == 1){
            $.ajax({
                type: 'POST',
                data: {
                    email: myemail,
                    username: str,
                },
                url: 'Modify.php',
                success:function (responeText) {
                    if(responeText == 3){
                        swal({title: "SUCCESS",text:"You modify your username successfully",type:"success"}).then(() =>{
                            document.getElementById("user-info-name").innerText = str;
                            document.getElementById("user-name").innerText = str;
                            cancelEdit.myCancel("cancel-username");
                        });
                    }
                }
            })
        }else if(key == 2){
            $.ajax({
                type: 'POST',
                data: {
                    email: myemail,
                    phone: str,
                },
                url: 'Modify.php',
                success:function (responeText) {
                    if(responeText == 0){
                        swal({title: "SUCCESS",text:"You modify your phone number successfully",type:"success"}).then(() =>{
                            document.getElementById("user-info-phone").innerText = str;
                            cancelEdit.myCancel("cancel-phone");
                        });
                    }else if (responeText == 1){
                        swal("FAILURE","The phone has been used!","error");
                    }else if (responeText == 2){
                        swal("FAILURE","Please enter the correct phone number！","error");
                    }
                }
            })
        }
        return false;
    }
}

var modifyPassword = {
    newPassowrd : function () {
        var myemail = cookie.get("email");
        var curPassword = document.getElementById("old-password").value;
        var newPassword = document.getElementById("new-password").value;
        var confirmPassword = document.getElementById("confirm-password").value;

        if(newPassword != confirmPassword)
            swal("FAILURE","The two passwords do not match","error");
        else{
            $.ajax({
                type:'POST',
                data:{
                    email: myemail,
                    password: curPassword,
                    passcode : newPassword,
                },
                url: 'Modify.php',
                success:function (responeText){
                    if(responeText == 4){
                        swal({title:"SUCCESS",text:"You modify your password successfully",type:"success"}).then(() =>{
                            window.location.href = "PersonalPage.html";
                        });
                    }else if(responeText == 5){
                        swal("FAILURE", "The current password is wrong!","error");
                    }
                }
            })
        }
    }
}

var modifyProfile = {
    buttonDisplay:function(){
        document.getElementById("file_upload_button").style.display = "inline";
    },

    myProfile : function () {
        var mypic = document.getElementById('file').files[0];
        var str = document.getElementById('file').value;
        var myemail = cookie.get("email");
        var formFile = new FormData();

        formFile.append("email",myemail);
        formFile.append("file",mypic);

        var index = str.indexOf(".");
        var myType = str.substring(index);
        var maxSize = 10242 * 2.1;

        if(myType != ".jpg" && myType != ".JPG" && myType != ".png" && myType != ".PNG"){
            swal({title: "FAILURE",text:"Please upload jpg or png！",type:"error"}).then(() =>{
                document.getElementById("file_upload_button").style.display = "none";
            });
            return false;
        }else if (document.getElementById('file').files[0].size >= maxSize){
            swal({title: "FAILURE",text:"You can only upload image smaller than 20 KB！",type:"error"}).then(() =>{
                document.getElementById("file_upload_button").style.display = "none";
            });
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "Modify.php",
            data: formFile,
            // dataType: 'json', //声明成功使用json数据类型回调

            //如果传递的是FormData数据类型，那么下来的三个参数是必须的，否则会报错
            cache:false,  //默认是true，但是一般不做缓存
            processData:false, //用于对data参数进行序列化处理，这里必须false；如果是true，就会将FormData转换为String类型
            contentType:false,  //一些文件上传http协议的关系，自行百度，如果上传的有文件，那么只能设置为false
            success: function (data) {
                swal({title: "SUCCESS",text:"You upload your new profile successfully",type:"success"}).then(() =>{
                    document.getElementById("file_upload_button").style.display = "none";
                    document.getElementById("my-profile").src = data;
                });

            }
        })
    }
}