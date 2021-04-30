// Globales
const URI_TITLE = document.location.pathname.split('/')[2]
const TITLE =  decodeURI(URI_TITLE)
const STEP = 10

// Récupération des éléments html utiles
const moreBtn = document.getElementById('button-more')
const addBtn = document.getElementById('button-add')
const message = document.getElementById('message')
const hr = document.getElementById('hr')

/*
 * Affiche de nouveaux messages.
 */
function appendMessages(messagesContent) {
	const messages = document.getElementById('messages')
	let message, b, small, line, img, p, button
	let n = 0;


	for (messageContent of messagesContent) {
		let i
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

		if (userId == messageContent["user"]["id"]) {
			button = document.createElement("button")
			button.setAttribute("id", `button-del-${messageContent['id']}`)
			button.setAttribute("class", "button-del")
			i = document.createElement("i")
			i.setAttribute("class", "far fa-trash-alt")
			button.appendChild(i)
			message.appendChild(button)
		}

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

		setTimeout(function(message, id) {
			$(message).delay(500).animate({ opacity: 1, display: 'block'}, 700)
		}, n*100, message, messageContent['id'])

		if (userId == messageContent["user"]["id"]) {
			addEventListenerOnButtonDeleteMessage(
				messageContent["id"],
				i
			)
		}

		n += 1
		delete i
	}
}


/*
 * Envoie une requête ajax pour charger plus de messages.
 */
function loadMessages(limit=undefined) {
	let offset = document.getElementById('messages').childElementCount
	limit = limit || STEP
	const url = `/ticket/${URI_TITLE}/message/charger/${limit}/${offset}`
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
 * Poste un nouveau message sans recharger la page et affiche
 * ce message sur la page.
 */
function postMessage() {
	const url = `/add`
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
	setTimeout(function() {
		loadMessages(9999999999)
		console.log('loading now')
	}, 1000);
	disableMoreBtn()
}

/*
 * Supprime un message tout en douceur.
 */
function deleteMessage(id) {
	msg = document.getElementById(id)
	$(msg).fadeOut(500, function(){
		$(msg).css({"visibility":"hidden",display:'block'}).slideUp()
	})
	msg.remove()
}

/*
 * Supprime un message en envoyant une requête post au serveur php
 * et en supprimant son affichage sur la page.
 */
function postDeleteMessage(id) {
	console.log(title)
	const url = `/ticket/message/supprimer/${id}`
	const data = {id}
	console.log(data)
	$.ajax({
		type: "POST",
		url: url,
		data: data,
		// dataType: 'json',
		success: function(data) {
			console.log(`Deleted message ${id} successfully.`)
	 	}
	 });
	deleteMessage(id)
}

/*
 * Cache le bouton 'Voir plus de messages'.
 */
function disableMoreBtn() {
	moreBtn.setAttribute("style", "display: none")
}

/*
 * Affiche le bouton 'Voir plus de messages'.
 */
function enableMoreBtn() {
	moreBtn.setAttribute("style", "display: block")
}

/*
 * Find a user id given a message id using the DOM.
 */
// function getUserIdFromMessageId(id) {
// 	msg = document.getElementById(`${id}`)
// }

function addEventListenerOnButtonDeleteMessage(id, i) {
	// Vérifie si l'utilisateur à le droit de supprimer un
	i.addEventListener('click', () => postDeleteMessage(id))
}


/*
 * Ajoute des event listener pour supprimer des messages en
 * appuyant sur les boutons supprimer. Cela s'applique sur tous
 * les messages déjà existants et est nécessaire que lors du
 * premier chargement.
 */
function addEventListenersOnButtonsDeleteMessage() {
	const btns = document.getElementsByClassName('button-del')
	for (let btn of btns) {
		addEventListenerOnButtonDeleteMessage(
			Number(btn.id.split('-')[2]),
			btn.getElementsByTagName('i')[0]
		)
	}

}

/*
 * Fonction principale du script.
 * - Ajoute des event listeners pour l'affichage, l'envoie et
 * 	 la suppression de messages.
 * - Gère la supression du bouton 'Voir plus de messages' en
 *   en cas de non nécessité.
 */
function main() {

	// Ajouts des event listeners
	moreBtn.addEventListener('click', function() {loadMessages()})
	addBtn.addEventListener('click', postMessage)
	message.addEventListener('keydown', function(event) {
		const keycode = (event.keyCode ? event.keyCode : event.which)
		if (keycode == 13) {
			postMessage()
		}
	})
	addEventListenersOnButtonsDeleteMessage()

	// Vérifie la nécessité du bouton 'Voir plus de messages'.
	const offset = document.getElementById('messages').childElementCount
	if (offset < 10) { // || ($_GET['limit'] == "all")
		disableMoreBtn()
	} else {
		enableMoreBtn()
	}

	// Nettoie l'url
	window.history.pushState("", "", `/ticket/${TITLE}`);

	// préselectionne l'input pour envoyer des nouveaux messages.
	message.select();
}

$(document).ready(main)
