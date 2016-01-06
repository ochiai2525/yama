//// 入力中のフォームの色を変更する////

// 入力中のフォームの色
function msOver(obj) {
    obj.style.borderColor = '#FF00FF';
    obj.style.backgroundColor = '#FFFFCC';
}

// 通常のフォームの色
function msOut(obj) {
    obj.style.borderColor = '#CCCCCC';
    obj.style.backgroundColor = '#FFFFFF';
}


function movePage(path){ 
    document.frm.action = path; 
    document.frm.submit(); 
}

function movePage_link(path){ 
    document.frm.action = path; 
    document.frm.submit(); 
    return false;
}

function movePage_fileup(path){ 
    document.frm.action  = path; 
    document.frm.enctype = "multipart/form-data";
    document.frm.submit(); 
}

function Random_Start(length) {

    var str1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var str2 = "abcdefghijklmnopqrstuvwxyz";
    var str3 = "0123456789";
    var strX = str1 + str2 + str3 ;
    var strI = "";
    var strR = "";
    for (i = 0; i < length ; i++){
        strI = Math.floor(Math.random() * strX.length);
        strR += strX.substr(strI,1);
    };
    document.form.AttestationPassword.value=strR;
}

