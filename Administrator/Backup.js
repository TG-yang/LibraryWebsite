document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var script=document.createElement("script");
script.setAttribute("type","text/javascript");
script.setAttribute("language","javascript");
script.setAttribute("src","../sweetalert-master/docs/assets/sweetalert/sweetalert.min.js");
document.getElementsByTagName("body")[0].appendChild(script);

var Backup = {
    Backup : function () {

        $.ajax({
            type: 'POST',
            url: 'Backup.php',
            success : function (data) {
                if(data == 1){
                    swal("SUCCESS","Backup successfully!","success");
                }else{
                    swal("FAILURE","Backup failure","error");
                }
            }
        })
    }
}

var Recover = {
    Recover : function () {

        $.ajax({
            type: 'POST',
            url:'Recover.php',
            success : function (data) {
                if(data == 1){
                    swal("SUCCESS","Recover successfully!","success");
                }else{
                    swal("FAILURE","Recover failure!","error");
                }
            }
        })
    }
}