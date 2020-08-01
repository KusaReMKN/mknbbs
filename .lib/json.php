<?php

function GetJSONFile(string $FileName)
{
	if (!file_exists($FileName)) {
		return false;
	}
	return json_decode(file_get_contents($FileName), true);
}

function PutJSONFile(string $FileName, array $Object)
{
	file_put_contents($FileName, json_encode($Object));
}
