document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var myDelete = {
    deleteBook : function () {
        var inputISBN = document.getElementById("delete-book-ISBN").value;

        $.ajax({
            type:'POST',
            url: 'Delete.php',
            data:{
                ISBN:inputISBN
            },
            success: function (data) {
                if(data == 1){
                    swal({title: "SUCCESS",text:"You have deleted the book successfully!！",type:"success"}).then(() =>{
                        document.getElementById("delete-book-ISBN").value = "";
                        document.getElementById("delete-profile").src = "../book-profile/normal.jpg";
                    });
                }else if(data == 0){
                    swal("FAILURE","There is no such book!!","error");
                }
            }
        })

    }
}