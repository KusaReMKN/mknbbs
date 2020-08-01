<?php

/**
 * IP アドレスからユーザ ID をはじき出す
 * 引数は $_SERVER['REMOTE_ADDR'] の値
 */
function GetUserID(string $RemoteAddress)
{
	return substr(
		hash(
			'sha256',
			date('dmy') . $RemoteAddress
		),
		-8
	);
}

/**
 * スレタイからスレッド ID をはじき出す
 * 引数はスレタイ文字列
 */
function CreateThreadID(string $ThreadTitle)
{
	return substr(
		hash(
			'sha256',
			$ThreadTitle
		),
		-16
	);
}
