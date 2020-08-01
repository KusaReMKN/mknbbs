window.addEventListener('load', () => {
	let RepButton = document.getElementsByClassName('replyTo');
	for (let i = 0; i < RepButton.length; i++) {
		RepButton.item(i).addEventListener('click', () => {
			const repString = `[>>${i + 1}](#res${i + 1})\n`;

			elem = document.getElementById('message');
			start = elem.selectionStart;
			end = elem.selectionEnd;
			value = elem.value;
			elem.value = '' + (value.substring(0, start)) + repString + (value.substring(end));
			elem.selectionStart = elem.selectionEnd = start + repString.length;
			elem.focus();
		});
	}
});