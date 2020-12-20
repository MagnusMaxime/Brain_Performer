function forgottenPassword(){
    var mail = document.querySelector("#mail").value;
    window.location.href = '/mot-de-passe-oublie?mail='+encodeURIComponent(mail);
}
