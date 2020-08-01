<?php
/* デバッグ時にコメント外すとエラーが見える */
// ini_set("display_errors", "on");

require_once('./.lib/const.php');
require_once('./.lib/thread.php');
require_once('./.lib/threadlist.php');
require_once('./.lib/threadread.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if (isset($_GET['q'])) {
		if (!NewKakiko($_GET['q'])) {
			header("HTTP/2.0 404 Not Found");
			die('書き込みエラー: そんなスレ ('. $_GET['q']. ') 本当にある？<br><a href="./">戻る</a>');
		}
		header('HTTP/2.0 205 Reset');
		// header('Location: /mknbbs/' . $_GET['q']);
		return;
	}
	if (!NewThread()) {
		die('スレ立てエラー: そのスレもう立ってない？');
	}
	header('HTTP/2.0 303 See Other');
	header('Location: /mknbbs/');
	return;
}

if (isset($_GET['q'])) {
	if (!ThreadRead($_GET['q'])) {
		header("HTTP/2.0 404 Not Found");
		die('読み込みエラー: そんなスレないです<br><a href="./">戻る</a>');
	}
	return;
}

ThreadList();
