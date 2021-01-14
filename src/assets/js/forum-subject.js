TITLE =  decodeURI(document.location.pathname.split('/')[2])
STEP = 10

/*
 * Append unrendered messages.
 */
function appendMessages(messagesContent) {
	const messages = document.getElementById('messages')
	let message, b, small, line, img, p


	for (messageContent of messagesContent) {
		console.log(messageContent)
		message = document.createElement("div")
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
	}
}

/*
 * Make a ajax request to get more messages.
 */
function loadMessages() {
	const offset = document.getElementById('messages').childElementCount
	const limit = STEP + offset
	const title = encodeURI(TITLE)
	const url = `/forum/${title}/message/charger/${limit}/${offset}`
	console.log(url)
	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		success: function (data) {
			console.log(data)
			appendMessages(Object.values(data))
		}
	})
}

function main() {
	const moreBtn = document.getElementById('button-more')
	moreBtn.addEventListener('click', loadMessages)
}

$(document).ready(main)
