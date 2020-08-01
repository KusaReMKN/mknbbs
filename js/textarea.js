window.addEventListener('load', () =>
	document.querySelector('textarea').addEventListener('keydown', function (e) {
		if (e.code === 'Tab') {
			let elem, end, start, value;
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
		if (e.code === 'Enter' && e.ctrlKey) {
			document.getElementById('submit').click();
			if (e.preventDefault) {
				e.preventDefault();
			}
			return false;
		}
	})
);
