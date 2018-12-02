document.write("<script language=javascript src='Cookie.js'></script>")

var myLogout ={
    out:function () {
        cookie.delete("email");
        window.location.href = "../Index/Index.html";
    }
}