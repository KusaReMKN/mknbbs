const ws = require('ws');
const fs = require('fs');
const https = require('https');

let app = https.createServer({
	key: fs.readFileSync('/etc/letsencrypt/live/www.kusaremkn.com/privkey.pem'),
	cert: fs.readFileSync('/etc/letsencrypt/live/www.kusaremkn.com/cert.pem'),
}, (req, res) => {
	// ダミーリクエスト
	res.writeHead(200);
	res.end("All glory to WebSockets!\n");
}).listen(5001);

const wss = new ws.Server({
	server: app
});

wss.on('connection', (ws, ref) => {
	console.log(`[${new Date().toISOString()}] <Connect>\t(${ref.connection.remoteAddress})`);

	ws.on('message', msg => {	// クライアントからデータが送信された
		console.log(`[${new Date().toISOString()}] <Message>\t(${ref.connection.remoteAddress})\t${msg}`);
		setTimeout(() => wss.clients.forEach(client => client.send(msg)), 100);
	});

	ws.on('close', () => {
		console.log(`[${new Date().toISOString()}] <Close>\t(${ref.connection.remoteAddress})`);
	});
});
