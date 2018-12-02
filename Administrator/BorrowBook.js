document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var myBorrow = {
    borrowBook : function (str1,str2) {
        var book_ISBN = document.getElementById(str1).value;
        var ID = document.getElementById(str2).value;

        $.ajax({
            type: 'POST',
            url: 'BorrowBook.php',
            data:{
                ISBN: book_ISBN,
                UID: ID
            },
            success: function (data) {
                if(data == 1){
                    swal("FAILURE","The ID is invalid!","error");
                }else if(data == 2){
                    swal("FAILURE","This borrower has borrowed 3 book, therefore he or she can't borrow extra books!","error");
                }else if(data == 3){
                    swal("FAILURE","The ISBN is invalid!","error");
                }else if(data == 4){
                    swal("FAILURE","This book has been borrowed by other people","error");
                }else if(data == 5){
                    swal("SUCCESS","You have borrowed the book successfully!",'success');
                }else if (data == 6){
                    swal("FAILURE","Some mistakes occurred during the borrowing process","error");
                }else if (data == 7){
                    swal("FAILURE","The Borrower's account balance is insufficient","error");
                }
            }
        })
    }
}

