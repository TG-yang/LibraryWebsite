document.write("<script language=javascript src='../General/Cookie.js'></script>");
document.write("<script language=javascript src='SelectTime.js'></script>");
function load() {
    var useremail = cookie.get("email");
    if(useremail != null && useremail != ""){
        document.getElementById("Login").style.display = "none";
        document.getElementById("Register").style.display = "none";
        document.getElementById("account").innerHTML = useremail;
        document.getElementById("account-box").style.display = "inline";
    }
    loadInfo.myLoadInfo();
}

var loadInfo = {
    myLoadInfo : function () {
        var myemail = cookie.get("email");

        selectTime.mySelect('time-select');

        $.ajax({
            type: 'POST',
            data: {
                email: myemail,
            },
            datatype: 'json',
            url: 'Loading.php',
            success:function (data) {

                data = JSON.parse(data);
                document.getElementById("user-info-name").innerText = data.Name;
                document.getElementById("personalUID").innerText = data.UID;
                document.getElementById("personalEmail").innerText = data.Email;
                document.getElementById("personalType").innerText = data.Type;
                document.getElementById("user-info-phone").innerText = data.Phone;
                document.getElementById("user-name").innerText = data.Name;
                document.getElementById("my-profile").src = data.Profile;
                document.getElementById("personalDeposit").innerText = data.Deposit + " USD";
            }
        })


    }
}