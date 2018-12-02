document.write("<script language=javascript src='../General/Cookie.js'></script>");

var myLoad = {
    load : function () {
        var useremail = cookie.get("email");
        if(useremail != null && useremail != ""){
            document.getElementById("Login").style.display = "none";
            document.getElementById("Register").style.display = "none";
            document.getElementById("account").innerHTML = useremail;
            document.getElementById("account-box").style.display = "inline";
        }
        $.ajax({
            type: 'POST',
            url: 'Loading.php',
            data: {
                email: useremail,
            },
            datatype: 'json',
            success:function (data) {
                data = JSON.parse(data);
                for(var i = 0; i < data.length; ++i){
                    var myul = document.getElementsByClassName("list-col")[0];

                    var newli = document.createElement("li");
                    myul.appendChild(newli);
                    newli.setAttribute("class","newbook-li");

                    var newdivCover = document.createElement("div");
                    newli.appendChild(newdivCover);
                    newdivCover.setAttribute("class","cover");

                    var newCovera = document.createElement("a");
                    newdivCover.appendChild(newCovera);
                    newCovera.setAttribute("class", "cover-a");
                    newCovera.href = "../Information/Information.html?ISBN=" + data[i]["ISBN"];

                    var newCoverImg = document.createElement("img");
                    newCovera.appendChild(newCoverImg);
                    newCoverImg.setAttribute("class","cover-img");
                    newCoverImg.src = data[i]["Cover"];
                    // newCoverImg.title = data[i]["ISBN"];

                    var newDivInfo = document.createElement("div");
                    newli.appendChild(newDivInfo);
                    newDivInfo.setAttribute("class", "info");

                    var newDivTitle = document.createElement("div");
                    newDivInfo.appendChild(newDivTitle);
                    newDivTitle.setAttribute("class","title");

                    var newA = document.createElement("a");
                    newDivTitle.appendChild(newA);
                    // newA.href = "#";
                    newA.innerText = data[i]["Title"];
                    newA.href = "../Information/Information.html?ISBN=" + data[i]["ISBN"];

                    var newDivAuthor = document.createElement("div");
                    newDivInfo.appendChild(newDivAuthor);
                    newDivAuthor.setAttribute("class","author");
                    newDivAuthor.innerText = data[i]["Author"];
                }
            }
        });

        $.ajax({
            type: 'POST',
            url: 'LoadingLibrary.php',
            data: {
                email: useremail,
            },
            datatype: 'json',
            success: function (data) {
                data = JSON.parse(data);
                for(var i = 0; i < data.length; ++i){
                    var myDiv = document.getElementsByClassName("location-box")[0];

                    var locDiv = document.createElement("div");
                    myDiv.appendChild(locDiv);
                    locDiv.setAttribute("class","location");

                    var myA = document.createElement("a");
                    locDiv.appendChild(myA);
                    myA.setAttribute("class","img_loc");
                    var myCover = 'url(' + data[i]["Cover"] + ')';
                    myA.style.backgroundImage = myCover;
                    myA.setAttribute("href","#");

                    var infoDiv = document.createElement("div");
                    locDiv.appendChild(infoDiv);
                    infoDiv.setAttribute("class","loc_info");

                    var myH3 = document.createElement("h3");
                    infoDiv.appendChild(myH3);
                    myH3.setAttribute("class","library-title")

                    var myA2 = document.createElement("a");
                    myH3.appendChild(myA2);
                    myA2.setAttribute("class","name_loc");
                    myA2.setAttribute("href","#");
                    myA2.innerText = data[i]["LibraryName"];

                    var hoursDiv = document.createElement("div");
                    infoDiv.appendChild(hoursDiv);
                    hoursDiv.setAttribute("class","hours");

                    var mySpan = document.createElement("span");
                    hoursDiv.appendChild(mySpan);
                    mySpan.innerText = data[i]["Hours"];

                    var locaInfoDiv = document.createElement("div");
                    infoDiv.appendChild(locaInfoDiv);
                    locaInfoDiv.setAttribute("class","location_info");

                    var mySpan2 = document.createElement("span");
                    locaInfoDiv.appendChild(mySpan2);
                    mySpan2.setAttribute("class","location_map");
                    mySpan2.innerText = data[i]["Position"];
                    mySpan2.innerText += " ";

                    var mySpan3 = document.createElement("span");
                    locaInfoDiv.appendChild(mySpan3);
                    mySpan3.setAttribute("class","phone");
                    mySpan3.innerText = data[i]["Phone"];
                }
            }
        })
    },

};