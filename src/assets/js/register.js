//https://stackoverflow.com/questions/12049620/how-to-get-get-variables-value-in-javascript
$_GET = {};
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
        .toString()
        // get the query string
        .replace(/^.*?\?/, '')
        // and remove any existing hash string (thanks, @vrijdenker)
        .replace(/#.*$/, '')
        .split('&');

    for(var i=0, l=query.length; i<l; i++) {
        var aux = decodeURIComponent(query[i]).split('=');
        $_GET[aux[0]] = aux[1];
    }
}

function manageToken(){
    if (typeof $_GET["token"]!=="undefined"){
        //Il y a un token dans l'url !
        inputToken=document.querySelector("#token");
        inputToken.value=$_GET["token"];//on rentre directement le token dans le formulaire
        inputToken.readOnly=true;//on empêche l'utilisateur de modifier son token
        inputToken.disabled=true;
        console.log("Le token ["+$_GET["token"]+"] a été pris en compte");
        document.querySelector("#token").hidden=true;
        document.querySelector("#token-label").hidden=true;

    }else{
        document.querySelector("#hasToken").hidden=false;
        console.log("Il n'y a pas de token dans l'URL");
    }
}


document.addEventListener("DOMContentLoaded", function(event) {
    // Your code to run since DOM is loaded and ready
    manageToken();
});

