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

function main(){
    options={title: {
            display: true,
            text: 'Battements par minute'
        }};
    var ctx = document.getElementById('myChart').getContext('2d');
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: DATA.line,
        options: options,

    });
}

document.addEventListener("DOMContentLoaded", function(event) {
    DATA =  JSON.parse(document.querySelector("#data").value)
    RESULTS = JSON.parse(document.querySelector("#results").value)
    if (typeof DATA.line === "undefined") {
        DATA.line = {
            labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            datasets: [{
                data: [108, 110, 112, 114, 118, 120, 124, 118, 121, 124],
                label: "Patient",
                borderColor: "#3e95cd",
                fill: false
            }]
        }
    }

    main();
});

