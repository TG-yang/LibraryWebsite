document.write("<script language=javascript src='../General/Cookie.js'></script>");

var InformationLoad = {
    load : function () {
        var useremail = cookie.get("email");
        if (useremail != null && useremail != "") {
            document.getElementById("Login").style.display = "none";
            document.getElementById("Register").style.display = "none";
            document.getElementById("account").innerHTML = useremail;
            document.getElementById("account-box").style.display = "inline";
        }
        // var ISBN = cookie.get("ISBN");
        var address = window.location.search;
        var ISBN = this.getISBN(address);

        $.ajax({
            type: 'POST',
            data: {
                ISBN : ISBN,
            },
            url: 'Loading.php',
            datatype: 'json',
            success : function (data) {
                data = JSON.parse(data);
                document.getElementById("book-name").innerText = data[0]["Title"];
                document.getElementById("mainpica").href = data[0]["Cover"];
                document.getElementById("mainpicimg").src = data[0]["Cover"];
                document.getElementById("author").innerText = data[0]["Author"];
                document.getElementById("publisher").innerText = data[0]["Publisher"];
                document.getElementById("publicationyear").innerText = data[0]["PublicationYear"];
                document.getElementById("page").innerText = data[0]["Page"];
                document.getElementById("location").innerText = data[0]["Location"];
                document.getElementById("ISBN").innerText = data[0]["ISBN"];
                document.getElementById("quantity").innerText = data[0]["Quantity"];

                var aboutAuthor = data[0]["AboutAuthor"].replace(/<br\/>/g, "\n").replace(/<br\/>/g, "\r");
                var intro = data[0]["Introduction"].replace(/<br\/>/g, "\n").replace(/<br\/>/g, "\r");

                document.getElementById("author_information").innerText = aboutAuthor;
                document.getElementById("information_box").innerText = intro;
            }
        })
    },
    getISBN : function (url) {

        if (url.indexOf("?") != -1) {
            //判断是否有参数?
            var str = url.substr(1); //从第一个字符开始 因为第0个是?号 获取所有除问号的所有符串
            var strs = str.split("="); //用等号进行分隔 （因为知道只有一个参数

        }
        return strs[1];
    }
}


