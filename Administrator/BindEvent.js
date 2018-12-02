document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var myBind = {
    inputBind : function (str1,str2) {
        var inputISBN = document.getElementById(str1).value;

        if(inputISBN.length == 13){

            $.ajax({
                type: 'POST',
                url: 'FindCover.php',
                data:{
                    ISBN:inputISBN
                },
                success: function (data) {
                    if(data == 1){
                        swal("FAILURE","There is no such book!","error");
                    }else{
                        document.getElementById(str2).src = data;
                    }
                }
            })
        }else if(inputISBN.length > 13){
            swal("FAILURE","Please enter right ISBN!","error");
        }
    },
    stuInputBind : function (str1,str2) {
        var inputID = document.getElementById(str1).value;

        if(inputID.length == 9){

            $.ajax({
                type: 'POST',
                url: 'FindRechargeID.php',
                data:{
                    ID:inputID
                },
                success: function (data) {
                    if(data == -1){
                        swal("FAILURE","There is no such student ID in the database! Please try again","error");
                    }else{
                        document.getElementById("deposit-box").style.display = "inline";
                        document.getElementById(str2).innerText = data;
                    }
                }
            })
        }
    },

}

