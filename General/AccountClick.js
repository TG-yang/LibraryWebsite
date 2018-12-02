document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var divObj ={
    show:function(){
        document.getElementById("table-box").style.display = "inline";
    },
    hidden :function(){
        document.getElementById("table-box").style.display = "none";
    }
}