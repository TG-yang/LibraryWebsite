document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var myReturn = {
    returnBook : function (str1,str2,str3) {
        var book_ISBN = document.getElementById(str1).value;
        var ID = document.getElementById(str2).value;
        var fine = document.getElementById(str3).value;

        $.ajax({
            type: 'POST',
            url: 'ReturnBook.php',
            data:{
                ISBN: book_ISBN,
                UID: ID,
                fine: fine,
            },
            success: function (data) {
                if(data == 1){
                    swal("SUCCESS","You have returned the book successfully!",'success');
                }else if(data == 0){
                    swal("FAILURE","Some mistakes occurred during the returning process","error");
                }else if(data == 2){
                    swal("FAILURE","You never borrowed this book, so returning book failure!","error");
                }
            }
        })
    }
}

