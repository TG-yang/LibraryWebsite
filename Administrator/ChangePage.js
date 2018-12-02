var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var ChangePage = {
    myPage : function (str) {
        document.getElementById("Home").className = "";
        document.getElementById("Add_Book").className = "";
        document.getElementById("Delete_Book").className = "";
        document.getElementById("Edit_Book").className = "";
        document.getElementById("Borrow_Book").className = "";
        document.getElementById("Return_Book").className = "";
        document.getElementById("Student_Recharge").className = "";
        document.getElementById("Edit_Library").className = "";
        document.getElementById("Add_Library").className = "";
        document.getElementById(str).className = "active";

        switch (str) {
            case "Home":
                this.disapperPage();
                document.getElementById("home-page").style.display = "inline";
                break;
            case "Add_Book":
                this.disapperPage();
                document.getElementById("add-book").style.display = "inline";
                this.removeValue("add-book");
                break;
            case "Delete_Book":
                this.disapperPage();
                document.getElementById("delete-book").style.display = "inline";
                this.removeValue("delete-book");
                break;
            case "Edit_Book":
                this.disapperPage();
                document.getElementById("edit-book").style.display = "inline";
                this.removeValue("edit-book");
                break;
            case "Borrow_Book":
                this.disapperPage();
                document.getElementById("borrow-book").style.display = "inline";
                this.removeValue("borrow-book");
                break;
            case "Return_Book":
                this.disapperPage();
                document.getElementById("return-book").style.display = "inline";
                this.removeValue("return-book");
                break;
            case "Student_Recharge":
                this.disapperPage();
                document.getElementById("student-recharge").style.display = "inline";
                this.removeValue("student-recharge");
                break;
            case "Add_Library":
                this.disapperPage();
                document.getElementById("add-library").style.display = "inline";
                this.removeValue("add-library");
                break;
            case "Edit_Library":
                this.disapperPage();
                document.getElementById("edit-library").style.display = "inline";
                this.removeValue("edit-library");
                break;
            default:
                this.disapperPage();
                break;
        }
    },

    disapperPage : function () {
        document.getElementById("home-page").style.display = "none";
        document.getElementById("student-recharge").style.display = "none";
        document.getElementById("add-book").style.display = "none";
        document.getElementById("borrow-book").style.display = "none";
        document.getElementById("return-book").style.display = "none";
        document.getElementById("delete-book").style.display = "none";
        document.getElementById("edit-book").style.display = "none";
        document.getElementById("edit-book-detail").style.display = "none";
        document.getElementById("add-library").style.display = "none";
        document.getElementById("edit-library").style.display = "none";
        document.getElementById("edit-library-detail").style.display = "none";
    },

    removeValue : function (str) {
        var sss = document.getElementById(str);
        for(i=0; i<sss.getElementsByTagName("input").length; i++){
            sss.getElementsByTagName("input")[i].value="";
        }
        for(i=0; i<sss.getElementsByTagName("img").length; ++i){
            sss.getElementsByTagName("img")[i].src = "../book-profile/normal.jpg";
            if(!sss.getElementsByTagName("img")[i].src.match(/normal.jpg/))
                sss.getElementsByTagName("img")[i].src = "";
        }

        if(str == 'add-book'){
            for(i = 0; i < sss.getElementsByTagName("textarea").length; ++i){
                sss.getElementsByTagName("textarea")[i].value = "";
            }
        }

        if(str == 'student-recharge'){
            document.getElementById('deposit-box').style.display = "none";
        }
    }
}

var addBook = {
    myAdd : function () {
        var bookName = document.getElementById("bookname").value;
        var author = document.getElementById("author").value;
        var year = document.getElementById("publication-year").value;
        var page = document.getElementById("page").value;
        var location = document.getElementById("location").value;
        var ISBN = document.getElementById("ISBN").value;
        var quantity = document.getElementById("quantity").value;
        var cover = document.getElementById('file').files[0];
        var aboutAuthor = document.getElementById("about-author").value;
        var introduction = document.getElementById("about-intro").value;
        var publisher = document.getElementById("publisher").value;

        var myAuthor = aboutAuthor.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
        var myIntro = introduction.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
        var str = document.getElementById('file').value;
        var formFile = new FormData();

        formFile.append("Title",bookName);
        formFile.append("Author",author);
        formFile.append("PublicationYear",year);
        formFile.append("Page",page);
        formFile.append("Location",location);
        formFile.append("ISBN",ISBN);
        formFile.append("Quantity",quantity);
        // formFile.append("Cover",cover);
        formFile.append("Introduction",myIntro);
        formFile.append("AboutAuthor",myAuthor);
        formFile.append("file",cover);
        formFile.append("Publisher",publisher);

        var index = str.indexOf(".");
        var myType = str.substring(index);
        var maxSize = 10242 * 103;

        if(myType != ".jpg" && myType != ".JPG" && myType != ".png" && myType != ".PNG"){
            swal({title: "FAILURE",text:"Please upload jpg or png！",type:"error"}).then(() =>{
                document.getElementById("file_upload_button").style.display = "none";
            });
            return false;
        }else if (document.getElementById('file').files[0].size >= maxSize){
            swal({title: "FAILURE",text:"You can only upload image smaller than 10 KB！",type:"error"}).then(() =>{
                document.getElementById("file_upload_button").style.display = "none";
            });
            return false;
        }

        $.ajax({
            type: 'POST',
            url: "AddBook.php",
            data: formFile,
            // dataType: 'json', //声明成功使用json数据类型回调

            //如果传递的是FormData数据类型，那么下来的三个参数是必须的，否则会报错
            cache:false,  //默认是true，但是一般不做缓存
            processData:false, //用于对data参数进行序列化处理，这里必须false；如果是true，就会将FormData转换为String类型
            contentType:false,  //一些文件上传http协议的关系，自行百度，如果上传的有文件，那么只能设置为false
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","The ISBN has been used!","error");
                }else if(data == 2){
                    swal("FAILURE","Insert the book information is wrong","error");
                }else{
                    swal({title: "SUCCESS",text:"You have added new book successfully",type:"success"}).then(() =>{
                        document.getElementById("my-profile").src = data;
                    });
                }

            }
        })
    }
}