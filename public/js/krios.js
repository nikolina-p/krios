function showPatient(id){
    window.location = "/patient/"+id;
}

function deleteFile(id){
    if(confirm("Obriši snimak?")){
        let response = ajaxCall('/file/delete/'+id);
        if (response.status == 204) {
            document.getElementById(id).style.display = "none";
        }
    }
}

function deleteUser(id){
    let response = ajaxCall('/users/delete/'+id);
    if (response.status == 200) {
        document.getElementById(id).style.display = "none";
    }
}

function ajaxCall(route){
    let ajax = null;
    if(window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        ajax = new XMLHttpRequest();
    } else {
        // code for IE6, IE5
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
    }
    try{
        ajax.onreadystatechange = function(){
            return ajax;
        }
    }catch(e){
        return false;
    }
    ajax.open("POST", route, false);
    ajax.send();
    return ajax;
}
