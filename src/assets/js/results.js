const btnResults = document.getElementById('btnResults');
btnResults.addEventListener('click', loadResults);
var resultsURL = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=GETLOG&TEAM=0000";

/*
 * Affiche les résultats de la carte
 */
function loadResults() {
	$.ajax({
		type: "GET",
		url: resultsURL,
		// dataType: 'json',
		success: function () {
			console.log("sent results successfully");
			$('#results')
		},
		error: function () {
			console.log("failed to send results");
		}
	});
}

