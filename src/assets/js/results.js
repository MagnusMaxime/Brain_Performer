led = document.getElementById("led");
led.addEventListener('click', changeLedColor);

/*
 * Change la couleur de la LED
 */
function changeLedColor() {
	console.log("button clicked");
	$.get('/toggle-led', (data) => {
		console.log("led changed successfully");
		led.src = img_on;
		setTimeout(() => {
			led.src = img_off;
		}, 1000);
	});
}

