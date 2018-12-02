var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var editLibrary = {
    myEdit : function (str) {
        var libraryName = document.getElementById(str).value;
        this.editLoad(libraryName);
        $.ajax({
            type: 'POST',
            url: 'EditLibrary.php',
            data:{
                LibraryName: libraryName,
            },
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","There is no such Library Name! Edit Failure!","error");
                }else if(data == 2){
                    document.getElementById("edit-library").style.display = "none";
                    document.getElementById("edit-library-detail").style.display = "inline";
                    // this.editLoad(libraryName);
                }
            }
        })
    },

    editLoad : function (str) {
        $.ajax({
            type: 'POST',
            url: 'EditLibraryLoad.php',
            data: {
                LibraryName: str,
            },
            datatype: 'json',
            success: function (data) {
                data = JSON.parse(data);
                document.getElementById("edit-library-name-detail").value = data["LibraryName"];
                document.getElementById("edit-library-position-detail").value = data["Position"];
                document.getElementById("edit-library-hours-detail").value = data["Hours"];
                document.getElementById("edit-library-phone-detail").value = data["Phone"];
                document.getElementById("edit-library-profile").src = data["Cover"];
            }
        })
    },

    myDelete : function (str) {
        var libraryName = document.getElementById(str).value;

        $.ajax({
            type: 'POST',
            url: 'DeleteLibrary.php',
            data:{
                LibraryName: libraryName,
            },
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","There is no such Library Name! Delete Failure!","error");
                }else if(data == 2){
                    swal("SUCCESS","You have deleted the Library successfully!","success");
                }
            }
        })
    },

    myEditConfirm : function () {
        var LibraryName = document.getElementById("edit-library-name-detail").value;
        var Position = document.getElementById("edit-library-position-detail").value;
        var Hours = document.getElementById("edit-library-hours-detail").value;
        var Phone = document.getElementById("edit-library-phone-detail").value;
        var Cover = document.getElementById('edit-library-file').files[0];
        var str = document.getElementById("edit-library-file").value;
        var img = document.getElementById("edit-library-profile").src;

        var formFile = new FormData();

        formFile.append("LibraryName",LibraryName);
        formFile.append("Position",Position);
        formFile.append("Hours",Hours);
        formFile.append("Phone",Phone);
        formFile.append("Cover",Cover);
        formFile.append("img",img);

        if(str.length != 0){
            var index = str.indexOf(".");
            var myType = str.substring(index);
            var maxSize = 10242 * 1030;

            if(myType != ".jpg" && myType != ".JPG" && myType != ".png" && myType != ".PNG"){
                swal("FAILURE","Please upload jpg or png！","error");
                // swal({title: "FAILURE",text:"Please upload jpg or png！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }else if (document.getElementById('edit-library-file').files[0].size >= maxSize){
                swal("FAILURE","You can only upload image smaller than 100 KB! ","error");
                // swal({title: "FAILURE",text:"You can only upload image smaller than 10 KB！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }
        }

        $.ajax({
            type: 'POST',
            url: "EditLibraryDetail.php",
            data: formFile,
            // dataType: 'json', //声明成功使用json数据类型回调

            //如果传递的是FormData数据类型，那么下来的三个参数是必须的，否则会报错
            cache:false,  //默认是true，但是一般不做缓存
            processData:false, //用于对data参数进行序列化处理，这里必须false；如果是true，就会将FormData转换为String类型
            contentType:false,  //一些文件上传http协议的关系，自行百度，如果上传的有文件，那么只能设置为false
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","An error occurred while editing the library","error");
                }else{
                    swal({title: "SUCCESS",text:"You have edit the library successfully",type:"success"}).then(() =>{
                        document.getElementById("edit-library-profile").src = data;
                    });
                }
            }
        })
    }

}
























