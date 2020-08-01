window.addEventListener('load', () =>
	document.querySelector('textarea').addEventListener('keydown', function (e) {
		let elem, end, start, value;
		if (e.code === 'Tab') {
			elem = e.target;
			start = elem.selectionStart;
			end = elem.selectionEnd;
			value = elem.value;
			elem.value = '' + (value.substring(0, start)) + '\t' + (value.substring(end));
			elem.selectionStart = elem.selectionEnd = start + 1;
			if (e.preventDefault) {
				e.preventDefault();
			}
			return false;
		}
	})
);
