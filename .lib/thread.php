<?php

require_once('const.php');
require_once('createid.php');
require_once('json.php');
require_once('Parsedown.php');

function NewThread()
{
	if (empty($_POST[ThreadTitle]) || empty($_POST[Message])) {
		return false;
	}
	$ThreadTitle = $_POST[ThreadTitle];
	$AuthorID = GetUserID($_SERVER['REMOTE_ADDR']);
	$DateTime = date('c');
	$UserAgent = $_SERVER['HTTP_USER_AGENT'];

	$ThreadID = CreateThreadID($ThreadTitle);

	// 重複するファイルがある場合はスレ立てできない
	if (file_exists(ThreadDir . $ThreadID . ThreadExt)) {
		return false;
	}

	// スレッド名をエスケープする
	$ThreadTitle = htmlentities($ThreadTitle);

	// スレッドの情報
	$Thread = [
		'title' => $ThreadTitle,
		'author' => $AuthorID,
		'dateTime' => $DateTime,
		'id' => $ThreadID,
		'userAgent' => $UserAgent,
	];

	// ファイルのコンテナ
	$File = [
		'thread' => $Thread,
		'kakiko' => [],
	];

	// スレを立てる
	PutJSONFile(ThreadDir . $ThreadID . ThreadExt, $File);

	// 1 を書き込む
	return NewKakiko($ThreadID);
}

function NewKakiko(string $ThreadID)
{
	if (empty($_POST[Message])) {
		return false;
	}
	$AuthorID = GetUserID($_SERVER['REMOTE_ADDR']);
	$DateTime = date('c');
	$Handle = empty($_POST[Handle]) ? '名無しの暇人🍊' : $_POST[Handle];
	$Message = $_POST[Message];
	$UserAgent = $_SERVER['HTTP_USER_AGENT'];

	// スレッドが見つからない
	if (!file_exists(ThreadDir . $ThreadID . ThreadExt)) {
		return false;
	}

	// 読み込む
	if (($object = GetJSONFile(ThreadDir . $ThreadID . ThreadExt)) === false) {
		return false;
	}

	// ハンドルネームをエスケープする
	$Handle = htmlentities($Handle);

	$kakiko = [
		'author' => $AuthorID,
		'dateTime' => $DateTime,
		'handle' => $Handle,
		'message' => $Message,
		'userAgent' => $UserAgent,
	];

	// 書き込みに追加
	$object['kakiko'][] = $kakiko;

	// 書き出し
	PutJSONFile(ThreadDir . $ThreadID . ThreadExt, $object);

	return true;
}

function PrintThreadList()
{
	function cmp($a, $b)
	{
		return $b['time'] - $a['time'];
	}

	if (($FileNameList = glob(ThreadDir . '*.json')) === false) {
		echo 'エラーかもしれない';
		return false;
	}
	echo '<div>';

	$FileList = [];

	foreach ($FileNameList as $FileName) {
		$FileList[] = [
			'name' => $FileName,
			'time' => filemtime($FileName),
		];
	}

	usort($FileList, 'cmp');

	foreach ($FileList as $ThreadFile) {
		$object = GetJSONFile($ThreadFile['name']);
		echo '<div class="ThreadListItem">', '<a href="', $object['thread']['id'], '">', $object['thread']['title'], ' (', count($object['kakiko']), 'レス)', '</a>', '</div>';
	}
	echo '</div>';
}

function PrintThreadItem(array $object)
{
	$Parsedown = new Parsedown();
	$Parsedown->setSafeMode(true);
	for ($i = 0; $i < count($object['kakiko']); $i++) {
		$kakiko = $object['kakiko'][$i];
		echo '<div class="kakiko-body" id="res', $i + 1, '">';
		echo '<div class="handle">', $i + 1, ': ', $kakiko['handle'], '</div>';
		echo '<div class="markdown-body">', $Parsedown->text($kakiko['message']), '</div>';
		echo '<div class="status">', '<button class="replyTo" title="返信する">💬</button> ', 'ID: ', $kakiko['author'], ' / ', $kakiko['dateTime'], '</div>';
		echo '</div>';
	}
}
