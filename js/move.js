window.addEventListener('load', () => {
	document.getElementById('goTop').addEventListener('click', () => window.scrollTo({
		top: 0,
		behavior: 'smooth'
	}));
	document.getElementById('goBack').addEventListener('click', () => window.location.href = './');
	document.getElementById('goBottom').addEventListener('click', () => document.getElementById('form').scrollIntoView({
		behavior: 'smooth'
	}));
})
