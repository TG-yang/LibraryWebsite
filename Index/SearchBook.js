document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");
document.write("<script language=javascript src='../General/Cookie.js'></script>");

var mySearch = {
    searchResult : function (str) {
        var queryString = document.getElementById(str).value;
        // window.location.href = "../Index/Index.html?search_text=" + queryString;
        document.getElementById("content_main").style.display = "none";
        document.getElementById("search-result").style.display = "block";
        this.refresh();

        $.ajax({
            type: 'POST',
            data: {
                queryString: queryString,
            },
            datatype: 'json',
            async:false,
            url: 'SearchBook.php',
            success : function (data) {
                data = JSON.parse(data);

                if(data.length == 0){
                    var searchResultBoxDiv = document.getElementsByClassName("search-result-box")[0];

                    var errorSearchDIv = document.createElement("div");
                    searchResultBoxDiv.appendChild(errorSearchDIv);
                    errorSearchDIv.setAttribute("class","error-search");

                    var myH1 = document.createElement("h1");
                    errorSearchDIv.appendChild(myH1);
                    myH1.innerText = "THERE IS NO SUCH BOOK IN OUR LIBRARIES";

                }else{
                    var resLen = data.length;
                    if(resLen > 8){

                        var totalNum = resLen / 8;
                        var searchResultDiv = document.getElementsByClassName("search-result")[0];

                        var paginatorDiv = document.createElement("div");
                        searchResultDiv.appendChild(paginatorDiv);
                        paginatorDiv.setAttribute("class","paginator");

                        // var prevA = document.createElement("a");
                        // paginatorDiv.appendChild(prevA);
                        // prevA.setAttribute("class","prev activate");
                        // prevA.innerText = 'Prev';

                        for(var i = 0; i < totalNum; ++i){
                            var numA = document.createElement("a");
                            paginatorDiv.appendChild(numA);
                            numA.setAttribute("class","num");
                            if(i == 0)
                                numA.setAttribute("class","num activate");
                            numA.innerText = i + 1;
                        }

                        // var NextA = document.createElement("a");
                        // paginatorDiv.appendChild(NextA);
                        // NextA.setAttribute("class","next");
                        // NextA.innerText = 'Next';

                    }

                    var searchResultBoxDiv = document.getElementsByClassName("search-result-box")[0];

                    for(var i = 0; i < resLen; ++i){
                        var itemRootDiv = document.createElement("div");

                        if(i < 8)
                            // itemRootDiv.setAttribute("display","inline-block");
                            itemRootDiv.style.display = "inline-block";
                        else
                            itemRootDiv.style.display = "none";

                        searchResultBoxDiv.appendChild(itemRootDiv);
                        itemRootDiv.setAttribute("class","item-root");

                        var bookCoverA = document.createElement("a");
                        itemRootDiv.appendChild(bookCoverA);
                        bookCoverA.setAttribute("class","book-cover-a");
                        // bookCoverA.setAttribute("href","#");
                        bookCoverA.href = "../Information/Information.html?ISBN=" + data[i]["ISBN"];

                        var resultCoverImg = document.createElement("img");
                        bookCoverA.appendChild(resultCoverImg);
                        resultCoverImg.setAttribute("class","result-cover");
                        resultCoverImg.src = data[i]["Cover"];

                        var searchBookDetailDiv = document.createElement("div");
                        itemRootDiv.appendChild(searchBookDetailDiv);
                        searchBookDetailDiv.setAttribute("class","search-book-detail");

                        var resultTitleDiv = document.createElement("div");
                        searchBookDetailDiv.appendChild(resultTitleDiv);
                        resultTitleDiv.setAttribute("class","result-title");

                        var bookTitleA = document.createElement("a");
                        resultTitleDiv.appendChild(bookTitleA);
                        bookTitleA.setAttribute("class","book-title-a");
                        bookTitleA.setAttribute("href","../Information/Information.html?ISBN=" + data[i]["ISBN"]);
                        bookTitleA.innerText = data[i]["Title"];

                        var resultAuthorDiv = document.createElement("div");
                        searchBookDetailDiv.appendChild(resultAuthorDiv);
                        resultAuthorDiv.setAttribute("class","result-author");
                        resultAuthorDiv.innerText = data[i]["Author"];

                        var resultAbstractDiv = document.createElement("div");
                        searchBookDetailDiv.appendChild(resultAbstractDiv);
                        resultAbstractDiv.setAttribute("class","result-abstract");
                        var intro = data[i]["Introduction"].replace(/<br\/>/g, "\n").replace(/<br\/>/g, "\r");
                        resultAbstractDiv.innerText = intro;
                    }
                }
            }
        })
    },

    refresh : function () {

        var parent = document.getElementsByClassName("search-result")[0];
        var child = document.getElementsByClassName("paginator")[0];
        if(child)
            parent.removeChild(child);

        var parentItem = document.getElementsByClassName("search-result-box")[0];
        var childItem = document.getElementsByClassName("item-root")[0];

        while(childItem){
            parentItem.removeChild(childItem);
            childItem = document.getElementsByClassName("item-root")[0];
        }

        var childError = document.getElementsByClassName("error-search")[0];
        if(childError)
            parentItem.removeChild(childError);
    }

}

$(".search-result").delegate(".num","click",function(){
        var num = this.innerText;
        var itemRootDiv = document.getElementsByClassName("item-root")[0];
        var i = 0;
        while(itemRootDiv){
            itemRootDiv.style.display = "none";
            ++i;
            itemRootDiv = document.getElementsByClassName("item-root")[i];
        }
        i = (num - 1) * 8;
        itemRootDiv = document.getElementsByClassName("item-root")[(num - 1) * 8];
        while(itemRootDiv && i < num * 8){
            itemRootDiv.style.display = "inline-block";
            ++i;
            itemRootDiv = document.getElementsByClassName("item-root")[i];
        }

        var myNum = document.getElementsByClassName("num")[0];
        i = 0;
        while(myNum){
            myNum.setAttribute("class","num");
            ++i;
            myNum = document.getElementsByClassName("num")[i];
        }
        this.setAttribute("class","num activate");

        // if(this.innerText == i){
        //     var next = document.getElementsByClassName("next")[0];
        //     next.setAttribute("class","next activate");
        //     var prev = document.getElementsByClassName("prev")[0];
        //     prev.setAttribute("class","prev");
        // }else if(this.innerText == 1){
        //     var prev = document.getElementsByClassName("prev")[0];
        //     prev.setAttribute("class","prev activate");
        //     var next = document.getElementsByClassName("next")[0];
        //     next.setAttribute("class","next");
        // }else{
        //     var next = document.getElementsByClassName("next")[0];
        //     next.setAttribute("class","next");
        //     var prev = document.getElementsByClassName("prev")[0];
        //     prev.setAttribute("class","prev");
        // }
});
