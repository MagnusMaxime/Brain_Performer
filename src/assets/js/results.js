led = document.getElementById("led");
btnChange = document.getElementById("change");
led.addEventListener('click', refreshLedState);
btnChange.addEventListener('click', changeLedColor);

/*
 * Change la couleur de la LED
 */
function changeLedColor() {
	console.log("button clicked");
	$.get('/toggle-led', (data) => {
		console.log("led changed successfully");
	});
}


/*
 * Rafraichit l'état de la led.
 */
function refreshLedState() {
	$.get('/led', (data) => {
		if (data == "on") {
			led.src = img_on;
		}
		if (data == "off") {
			led.src = img_off;
		}
	});
}

function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}

setInterval(refreshLedState, 1000);
