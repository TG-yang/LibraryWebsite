document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var myAddLibrary = {
    addLibrary : function () {
        var name = document.getElementById("library-name").value;
        var position = document.getElementById("library-position").value;
        var hours = document.getElementById("library-hours").value;
        var phone = document.getElementById("library-phone").value;
        var cover = document.getElementById('library-file').files[0];
        var str = document.getElementById('library-file').value;
        var formFile = new FormData();

        formFile.append("LibraryName",name);
        formFile.append("Position",position);
        formFile.append("Hours",hours);
        formFile.append("Phone",phone);
        formFile.append("Cover",cover);

        if(str != "" || str != null){
            var index = str.indexOf(".");
            var myType = str.substring(index);
            var maxSize = 10242 * 103;
            if(myType != ".jpg" && myType != ".JPG" && myType != ".png" && myType != ".PNG"){
                swal("FAILURE","Please upload jpg or png！","error");
                // swal({title: "FAILURE",text:"Please upload jpg or png！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }else if (document.getElementById('library-file').files[0].size >= maxSize){
                swal("FAILURE","You can only upload image smaller than 10 KB! ","error");
                // swal({title: "FAILURE",text:"You can only upload image smaller than 10 KB！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }
        }

        $.ajax({
            type: 'POST',
            url: "AddLibrary.php",
            data: formFile,
            // dataType: 'json', //声明成功使用json数据类型回调

            //如果传递的是FormData数据类型，那么下来的三个参数是必须的，否则会报错
            cache:false,  //默认是true，但是一般不做缓存
            processData:false, //用于对data参数进行序列化处理，这里必须false；如果是true，就会将FormData转换为String类型
            contentType:false,  //一些文件上传http协议的关系，自行百度，如果上传的有文件，那么只能设置为false
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","It has the same LibraryName in database","error");
                }else if(data == 2){
                    swal("FAILURE","An error occurred while adding the library","error");
                }else{
                    swal({title: "SUCCESS",text:"You have add the library successfully",type:"success"}).then(() =>{
                        document.getElementById("library-profile").src = data;
                    });
                }
            }
        })
    }
}