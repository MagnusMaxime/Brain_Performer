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


function search (){
    window.location.href = "/rechercher?q="+encodeURIComponent(document.querySelector("#search-input").value);
}

document.addEventListener("DOMContentLoaded", function(event) {

    document.querySelector("#search-input").addEventListener("change", search);

});
