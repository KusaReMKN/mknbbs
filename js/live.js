window.addEventListener('load', () => {
	const WebSocketServer = `ws://${location.hostname}:5001`;
	const ThreadID = document.getElementById('ThreadID').textContent;
	const wss = new WebSocket(WebSocketServer);

	wss.addEventListener('message', e => {
		console.log(`LIVE: Message for Thread ${e.data}`);
		if (e.data === ThreadID) {
			let req = new XMLHttpRequest();
			req.open('GET', window.location.href);
			req.responseType = 'document';
			req.addEventListener('load', () => {
				let res = req.response;
				let Kakikos = res.getElementById('KakikoList')?.getElementsByClassName('kakiko-body');
				if (Kakikos === undefined) {
					console.log('LIVE: SERVER KAKIKO ERROR');
					return;
				}
				if (document.getElementById('KakikoList') === null) {
					console.log('LIVE: CLIENT KAKIKO ERROR');
					return;
				}

				let lastRes = document.getElementById('KakikoList').getElementsByClassName('kakiko-body').length;
				for (let i = lastRes; i < Kakikos.length; i++) {
					console.log(`LIVE: RES #${i + 1}`, Kakikos.item(i));
					// リプライボタンの適用
					Kakikos.item(i).querySelector('.replyTo').addEventListener('click', () => {
						const repString = `[>>${i + 1}](#res${i + 1})\n`;
						elem = document.getElementById('message');
						start = elem.selectionStart;
						end = elem.selectionEnd;
						value = elem.value;
						elem.value = '' + (value.substring(0, start)) + repString + (value.substring(end));
						elem.selectionStart = elem.selectionEnd = start + repString.length;
						elem.focus();
					});
					// コードブロックの Highlight js 適用
					Kakikos.item(i).querySelectorAll('pre code').forEach((block) => {
						hljs.highlightBlock(block);
					});
					document.getElementById('KakikoList').appendChild(Kakikos.item(i));

					// 数式表示
					MathJax.Hub.Queue(["Typeset", MathJax.Hub, `res${i + 1}`]);
				}

				// 画面スクロールは最新のレスが表示されている時だけになりました
				let rect = document.getElementById(`res${lastRes}`).getBoundingClientRect();

				if (0 < rect.bottom && rect.top < window.innerHeight) {
					document.getElementById(`res${lastRes + 1}`).scrollIntoView({
						behavior: "smooth"
					});
				}

				AnchorFrom();
				ResSmooth();

				console.log('LIVE: Done.');
			});
			req.send();
			console.log('LIVE: Requesting ...');
		}
	});

	document.forms.namedItem('form').addEventListener('submit', () => {
		console.log('LIVE: Submitting ...');
		let req = new XMLHttpRequest();
		req.open('POST', window.location.href);
		req.addEventListener('load', () => {
			document.getElementById('message').value = '';
			console.log('LIVE: Submitted');
		});
		req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		req.send('message=' + encodeURIComponent(document.getElementById('message').value) + '&handle=' + encodeURIComponent(document.getElementById('handle').value));
		wss.send(ThreadID);
		return false;
	});

	AnchorFrom();
	ResSmooth();

	console.log('MKNBBS Live is enabled!!');

	function AnchorFrom() {
		const kakikos = document.getElementById('KakikoList').getElementsByClassName('kakiko-body');
		for (const lister of kakikos) {
			const select = lister.querySelector('select');
			select.innerHTML = '<option value="">...</option>';
			for (const k of kakikos) {
				const anchors = k.getElementsByTagName('a');
				for (const a of anchors) {
					if (RegExp(`#${lister.id}$`).test(a.href)) {
						const option = document.createElement('option');
						option.textContent = '<< ' + k.querySelector('.handle').textContent;
						option.value = k.id;
						select.appendChild(option);
					}
				}
			}
			select.oninput = function () {
				if (this.value !== "") {
					document.getElementById(this.value).scrollIntoView({
							behavior: "smooth"
					});
					this.value = "";
				}
			}
		}
	}

	function ResSmooth() {
		const anchors = document.getElementsByTagName('a');
		for (const a of anchors) {
			if (RegExp(`${ThreadID}#res[0-9]+$`).test(a.href)) {
				a.onclick = function (e) {
					document.getElementById(a.href.match(/res[0-9]+$/)[0]).scrollIntoView({
							behavior: "smooth"
					});
					e.preventDefault();
				}
			}
		}
	}
});

