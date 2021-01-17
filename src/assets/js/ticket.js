$('textarea').on('paste input', function () {
	if ($(this).outerHeight() > this.scrollHeight){
			$(this).height(1)
	}
	while ($(this).outerHeight() < this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth"))){
			$(this).height($(this).height() + 1)
	}
});

console.log('forum.js ouvre toi');
