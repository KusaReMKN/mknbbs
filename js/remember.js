function SaveMyName() {
	let target = document.getElementById('handle');
	if (target) {
		localStorage.setItem('mknbbs.name', target.value);
	}
	return false;
}

function LoadMyName() {
	let target = document.getElementById('handle');
	target.value = localStorage.getItem('mknbbs.name');
}

window.addEventListener('load', () => {
	LoadMyName();
	document.forms['form'].addEventListener('submit', () => SaveMyName());
});

