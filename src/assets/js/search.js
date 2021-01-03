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


table=document.querySelector("#main-table")

function update(){

    satut_filter=parseInt(document.querySelector("#statut-filter").value)
    sex_filter=parseInt(document.querySelector("#sex-filter").value)

    search_input=document.querySelector("#search-input").value.trim().toLowerCase()

    for (const user of USERS_JSON) {
        var html_element=document.querySelector("#user-"+user.id)
        html_element.hidden=false
        console.log(user);
        if (satut_filter!=-1){
            html_element.hidden=satut_filter!=user.grade//on cache si l'utilisateur n'a pas le grade du filtre
        }
        if (sex_filter!=-1){
            html_element.hidden=html_element.hidden || (sex_filter!=user.sex)
        }
        if(search_input!=""){
            var fullName = ((user.sex=="0" ? "M. " : "Mme. ") + user.firstname+" "+user.lastname).toLowerCase()
            if (fullName.includes(search_input)){
                //la recherche correspond au nom du l'utilisateur
            }else{
                html_element.hidden=true
            }
        }


        if(document.querySelector("#minage-filter").value!=""){
            html_element.hidden=html_element.hidden || user.age<parseInt(document.querySelector("#minage-filter").value)
        }

        if(document.querySelector("#maxage-filter").value!=""){
            html_element.hidden=html_element.hidden || user.age>parseInt(document.querySelector("#maxage-filter").value)
        }


    }


}

document.addEventListener("DOMContentLoaded", function(event) {
    // Your code to run since DOM is loaded and ready
    if (typeof $_GET["q"]!=="undefined"){
        document.querySelector("#search-input").value=$_GET["q"]

    }
    console.log(USERS_JSON);

    document.querySelector("#statut-filter").addEventListener("change", update);
    document.querySelector("#sex-filter").addEventListener("change", update);
    document.querySelector("#search-input").addEventListener("change", update);

    document.querySelector("#minage-filter").addEventListener("change",function (evt) {
        if (parseInt(document.querySelector("#minage-filter").value)>parseInt(document.querySelector("#maxage-filter").value)){
            document.querySelector("#maxage-filter").value=document.querySelector("#minage-filter").value
        }
        update()
    });

    document.querySelector("#maxage-filter").addEventListener("change",function (evt) {
        if (parseInt(document.querySelector("#minage-filter").value)>parseInt(document.querySelector("#maxage-filter").value)){
            document.querySelector("#minage-filter").value=document.querySelector("#maxage-filter").value
        }
        update()
    });

    update()
});
