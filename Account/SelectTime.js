document.write("<script language=javascript src='../General/Cookie.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.min.js'></script>");
document.write("<script language=javascript src='../jquery-3.2.1.js'></script>");

var selectTime = {
    mySelect : function (str) {
        var myselect = document.getElementById(str);
        var index = myselect.selectedIndex;
        var myValue = myselect.options[index].value;
        var myemail = cookie.get("email");

        this.refresh();

        $.ajax({
            type: 'POST',
            data: {
                email: myemail,
                myIndex: myValue,
            },
            datatype: 'json',
            url: 'SelectTime.php',
            success : function (data) {
                data = JSON.parse(data);
                var searchResultBoxDiv = document.getElementsByClassName("history-record-box")[0];
                for(var i = 0; i < data.length; ++i){

                    var bookItemDiv = document.createElement("div");
                    searchResultBoxDiv.appendChild(bookItemDiv);
                    bookItemDiv.setAttribute("class","book-item");

                    var recordBookCoverA = document.createElement("a");
                    bookItemDiv.appendChild(recordBookCoverA);
                    recordBookCoverA.setAttribute("class","record-book-cover");

                    var recordBookImg = document.createElement("img");
                    recordBookCoverA.appendChild(recordBookImg);
                    recordBookImg.setAttribute("class","record-book-img");
                    recordBookImg.src = data[i]["Cover"];

                    var recordDetailDiv = document.createElement("div");
                    bookItemDiv.appendChild(recordDetailDiv);
                    recordDetailDiv.setAttribute("class","record-detail");

                    var recordTitleDiv = document.createElement("div");
                    recordDetailDiv.appendChild(recordTitleDiv);
                    recordTitleDiv.setAttribute("class","record-title");

                    var recordTitleA = document.createElement("a");
                    recordTitleDiv.appendChild(recordTitleA);
                    recordTitleA.setAttribute("class","record-title-a");
                    recordTitleA.href = "../Information/Information.html?ISBN=" + data[i]["ISBN"];
                    recordTitleA.innerText = data[i]["Title"];

                    var recordTimeDiv = document.createElement("div");
                    recordDetailDiv.appendChild(recordTimeDiv);
                    recordTimeDiv.setAttribute("class","record-time");

                    var dateOutSpan = document.createElement("span");
                    recordTimeDiv.appendChild(dateOutSpan);
                    dateOutSpan.innerText = "Date Out:";

                    var dateOutDetailSpan = document.createElement("span");
                    recordTimeDiv.appendChild(dateOutDetailSpan);
                    dateOutDetailSpan.innerText = data[i]["Date_out"];

                    var recordTimeDiv2 = document.createElement("div");
                    recordDetailDiv.appendChild(recordTimeDiv2);
                    recordTimeDiv2.setAttribute("class","record-time");

                    var dateDueSpan = document.createElement("span");
                    recordTimeDiv2.appendChild(dateDueSpan);
                    dateDueSpan.innerText = "Date Due:";

                    var dateDueDetailSpan = document.createElement("span");
                    recordTimeDiv2.appendChild(dateDueDetailSpan);
                    dateDueDetailSpan.innerText = data[i]["Due_date"];

                    var recordTimeDiv3 = document.createElement("div");
                    recordDetailDiv.appendChild(recordTimeDiv3);
                    recordTimeDiv3.setAttribute("class","record-time");

                    var returnDateSpan = document.createElement("span");
                    recordTimeDiv3.appendChild(returnDateSpan);
                    returnDateSpan.innerText = "Return Date:";

                    var returnDateDetailSpan = document.createElement("span");
                    recordTimeDiv3.appendChild(returnDateDetailSpan);

                    if(data[i]["Return_date"] == '2018-10-01')
                        returnDateDetailSpan.innerText = "No Return";
                    else
                        returnDateDetailSpan.innerText = data[i]["Return_date"];
                }
            }
        })
    },

    refresh : function () {
        var parentItem = document.getElementsByClassName("history-record-box")[0];
        var childItem = document.getElementsByClassName("book-item")[0];

        while(childItem){
            parentItem.removeChild(childItem);
            childItem = document.getElementsByClassName("book-item")[0];
        }
    }
}

