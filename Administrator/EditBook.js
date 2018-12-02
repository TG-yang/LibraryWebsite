document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var myEdit = {
    editButton : function () {
        var cover = document.getElementById("edit-profile").src;
        var n = cover.search(/normal/i);

        if(n != -1){
            swal("FAILURE","There is no such ISBN! Please try again!","error");
        }else{
            document.getElementById("edit-book").style.display = "none";
            document.getElementById("edit-book-detail").style.display = "inline";
            this.editLoad();
            document.getElementById("edit-book-ISBN").value = "";
            document.getElementById("edit-profile").src = "../book-profile/normal.jpg";
        }
    },

    editLoad :function () {
        var inputISBN = document.getElementById("edit-book-ISBN").value;
        $.ajax({
            type:'POST',
            url: 'EditBook.php',
            data:{
                ISBN:inputISBN
            },
            datatype: 'json',
            success: function (data) {
                data = JSON.parse(data);
                document.getElementById("edit-bookname").value = data.Title;
                document.getElementById("edit-author").value = data.Author;
                document.getElementById("edit-publisher").value = data.Publisher;
                document.getElementById("edit-publication-year").value = data.PublicationYear;
                document.getElementById("edit-page").value = data.Page;
                document.getElementById("edit-location").value = data.Location;
                document.getElementById("edit-ISBN").value = data.ISBN;
                document.getElementById("edit-quantity").value = data.Quantity;
                document.getElementById("edit-my-profile").src = data.Cover;

                var aboutAuthor = data.AboutAuthor.replace(/<br\/>/g, "\n").replace(/<br\/>/g, "\r");
                var intro = data.Introduction.replace(/<br\/>/g, "\n").replace(/<br\/>/g, "\r");

                document.getElementById("edit-about-author").innerText = aboutAuthor;
                document.getElementById("edit-about-intro").innerText = intro;
            }

        })
    },

    editSubmit : function () {
        var bookName = document.getElementById("edit-bookname").value;
        var author = document.getElementById("edit-author").value;
        var publisher = document.getElementById("edit-publisher").value;
        var year = document.getElementById("edit-publication-year").value;
        var page = document.getElementById("edit-page").value;
        var location = document.getElementById("edit-location").value;
        var ISBN = document.getElementById("edit-ISBN").value;
        var quantity = document.getElementById("edit-quantity").value;
        var cover = document.getElementById('edit-file').files[0];
        var aboutAuthor = document.getElementById("edit-about-author").value;
        var introduction = document.getElementById("edit-about-intro").value;
        var img = document.getElementById("edit-my-profile").src;

        var myAuthor = aboutAuthor.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
        var myIntro = introduction.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
        var str = document.getElementById('edit-file').value;
        var formFile = new FormData();

        formFile.append("Title",bookName);
        formFile.append("Author",author);
        formFile.append("Publisher",publisher);
        formFile.append("PublicationYear",year);
        formFile.append("Page",page);
        formFile.append("Location",location);
        formFile.append("ISBN",ISBN);
        formFile.append("Quantity",quantity);
        formFile.append("Cover",cover);
        formFile.append("file",cover);
        formFile.append("Introduction",myIntro);
        formFile.append("AboutAuthor",myAuthor);
        formFile.append("img",img);
        // if(!cover.empty()){
        //     formFile.append("Cover",cover);
        // }

        if(str.length != 0){
           // alert(str);
            var index = str.indexOf(".");
            var myType = str.substring(index);
            var maxSize = 10242 * 103;

            if(myType != ".jpg" && myType != ".JPG" && myType != ".png" && myType != ".PNG"){
                swal("FAILURE","Please upload jpg or png！","error");
                // swal({title: "FAILURE",text:"Please upload jpg or png！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }else if (document.getElementById('edit-file').files[0].size >= maxSize){
                swal("FAILURE","You can only upload image smaller than 10 KB! ","error");
                // swal({title: "FAILURE",text:"You can only upload image smaller than 10 KB！",type:"error"}).then(() =>{
                //     document.getElementById("file_upload_button").style.display = "none";
                // });
                return false;
            }
        }

        $.ajax({
            type: 'POST',
            url: "Editbookdetail.php",
            data: formFile,
            // dataType: 'json', //声明成功使用json数据类型回调

            //如果传递的是FormData数据类型，那么下来的三个参数是必须的，否则会报错
            cache:false,  //默认是true，但是一般不做缓存
            processData:false, //用于对data参数进行序列化处理，这里必须false；如果是true，就会将FormData转换为String类型
            contentType:false,  //一些文件上传http协议的关系，自行百度，如果上传的有文件，那么只能设置为false
            success: function (data) { 
                if(data == 1){
                    swal("FAILURE","An error occurred while editing the book","error");
                }else{
                    swal({title: "SUCCESS",text:"You have edit the book successfully",type:"success"}).then(() =>{
                        document.getElementById("edit-my-profile").src = data;
                    });
                }
            }
        })
    }
}
