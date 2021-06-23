const btnLed = document.getElementById('toggleLed');
const response = document.getElementById('response');

btnLed.addEventListener('click', changeLedColor);


/*
 * Change la couleur de la LED
 */
function changeLedColor() {
	console.log("button clicked");
	$.get('/toggle-led', (data) => {
		console.log("led changed successfully");
		response.innerText = "La led a changé de couleur";
		setTimeout(() => {
			response.innerText = "";
		}, 1000);
	});
}

