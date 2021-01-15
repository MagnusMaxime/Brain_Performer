const TITLE =  decodeURI(document.location.pathname.split('/')[2])
const STEP = 10

const moreBtn = document.getElementById('button-more')
const addBtn = document.getElementById('button-add')
const message = document.getElementById('message')
const hr = document.getElementById('hr')

/*
 * Append unrendered messages.
 */
function appendMessages(messagesContent) {
	const messages = document.getElementById('messages')
	let message, b, small, line, img, p
	let n = 0;


	for (messageContent of messagesContent) {
		message = document.createElement("div")
		message.setAttribute("style", "opacity: 0")
		message.setAttribute("id", messageContent["id"])
		message.setAttribute("class", "message")

		b = document.createElement("b")
		b.appendChild(document.createTextNode(
				messageContent["user"]["firstname"]+" "+
				messageContent["user"]["lastname"]
		))
		message.appendChild(b)

		small = document.createElement("small")
		small.appendChild(document.createTextNode(
			messageContent["created"]
		))
		message.appendChild(small)

		message.appendChild(
			document.createElement("br")
		)

		line = document.createElement("div")
		line.setAttribute("class", "message-line")

		img = document.createElement("img")
		img.setAttribute("class", "urlavatar")
		img.setAttribute("src", messageContent["user"]["urlavatar"])
		line.appendChild(img)

		p = document.createElement("p")
		p.appendChild(document.createTextNode(
			messageContent["message"]
		))
		line.appendChild(p)

		message.append(line)
		messages.appendChild(message);

		setTimeout(function(message) {
			$(message).delay(500).animate({ opacity: 1, display: 'block'}, 700);
		}, n*100, message)

		n += 1
	}
}


/*
 * Make a ajax request to get more messages.
 */
function loadMessages(limit=undefined) {
	let offset = document.getElementById('messages').childElementCount
	limit = limit || STEP
	const title = encodeURI(TITLE)
	const url = `/forum/${title}/message/charger/${limit}/${offset}`
	console.log(url)
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		success: function (data) {
			console.log(`Received ${data} successfully.`)
			appendMessages(Object.values(data.messages))
			offset = document.getElementById('messages').childElementCount
			message.select();
			if (data.count == offset) {
				disableMoreBtn()
			} else {
				// hr.scrollIntoView({ block: 'start',  behavior: 'smooth' })
			}
		}
	})
}

/*
 * Post  a new message without reloading the window.
 */
function postMessage() {
	const title = encodeURI(TITLE)
	const url = `/forum/${title}/message/ajouter/`
	const data = $("#message-form").serialize()
	console.log(data)
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		// dataType: 'json',
		success: function(data) {
			console.log(`Posted ${data} successfully.`)
	 	}
	 });
	message.value = ""
	loadMessages(9999999999)
	disableMoreBtn()
	return false; // avoid to execute the actual submit of the form.
}

function disableMoreBtn() {
	// moreBtn.className = ""
	// moreBtn.disabled = true
	moreBtn.setAttribute("style", "display: none")
}

function enableMoreBtn() {
	moreBtn.setAttribute("style", "display: block")
}

function main() {

	moreBtn.addEventListener('click', function() {loadMessages()})
	addBtn.addEventListener('click', postMessage)
	message.addEventListener('keydown', function(event) {
		const keycode = (event.keyCode ? event.keyCode : event.which)
		if (keycode == 13) {
			postMessage()
		}
	})

// 	const $_GET = [];
// 	window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(a,name,value){$_GET[name]=value;});


	const offset = document.getElementById('messages').childElementCount
	if (offset < 10) { // || ($_GET['limit'] == "all")
		disableMoreBtn()
	} else {
		enableMoreBtn()
	}

	window.history.pushState("", "", `/forum/${TITLE}`);

	message.select();
}

$(document).ready(main)
