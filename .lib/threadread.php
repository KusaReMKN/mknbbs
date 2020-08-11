<?php

require_once('thread.php');

function ThreadRead(string $ThreadID)
{
	$object = GetJSONFile(ThreadDir . $ThreadID . ThreadExt);
	if ($object === false) {
		return false;
	}
?>
	<!DOCTYPE html>
	<html lang="ja" prefix="og: http://ogp.me/ns#">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Twitter用 -->
		<meta name="twitter:card" content="summary">
		<meta name="twitter:site" content="@KusaReMKN">
		<meta name="twitter:creator" content="@KusaReMKN">
		<meta property="og:title" content="<?= $object['thread']['title'] ?> — MKNBBS">
		<meta property="og:type" content="article">
		<meta property="og:description" content="MKNBBS は KusaReMKN によるインターネット掲示板です">
		<meta property="og:url" content="https://www.kusaremkn.com/mknbbs/<?= $ThreadID ?>">
		<meta property="og:image" content="https://www.kusaremkn.com/img/mkn.png">
		<title><?= $object['thread']['title'] ?> — MKNBBS</title>
		<meta name="description" content="MKNBBS は KusaReMKN によるインターネット掲示板です">
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="./css/new.css" type="text/css">
		<link rel="stylesheet" href="./css/code.css" typ e="text/css">
		<link rel="stylesheet" href="./css/mknbbs.css" type="text/css">
		<script src="./js/highlight.pack.js"></script>
		<script src="./js/textarea.js"></script>
		<script src="./js/move.js"></script>
		<script src="./js/remember.js"></script>
		<script src="./js/live.js"></script>
		<script src="./js/reply.js"></script>
		<script>
			hljs.initHighlightingOnLoad();
		</script>
		<!-- 数式 -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.7/MathJax.js?config=TeX-AMS_CHTML"></script>
		<style>
			/* MathJax 画面溢れはスクロール */
			.MJXc-display {
				scrollbar-width: none;
				overflow-x: scroll;
				overflow-y: visible;
			}
			/* スクロールバー非表示 */
			.MJXc-display::-webkit-scrollbar {
				display: none;
			}
		</style>
	</head>

	<body>
		<header>
			<h1><?= $object['thread']['title'] ?></h1>
			<div class="status">ID: <span id="ThreadID"><?= $ThreadID ?></span></div>
		</header>

		<article>
			<section id="KakikoList">
				<?php PrintThreadItem($object); ?>
			</section>
			<section>
				<form action="./<?= $ThreadID ?>" method="POST" id="form" onsubmit="return false;">
					<fieldset>
						<legend>書き込み</legend>
						<div>
							<label>
								Handle Name
								<input type="text" name="<?= Handle ?>" id="<?= Handle ?>">
							</label>
						</div>
						<div>
							<label>
								Message <img class="markdown-mark" height="18" src="./img/markdown-mark.svg" alt="Markdown is supported">
								<a href="https://memo.kusaremkn.com/mknbbs" target="_blank">Markdown チートシート</a>
								<textarea class="input-message" name="<?= Message ?>" id="<?= Message ?>" placeholder="Markdown 記法が利用できます！" required></textarea>
							</label>
						</div>
						<div class="align-right">
							<input type="submit" id="submit" value="書き込む">
						</div>
					</fieldset>
				</form>
			</section>
		</article>
		<div class="moveButtons">
			<img id="goTop" class="moveButton" src="./img/toparrow.svg" alt="上">
			<img id="goBack" class="moveButton" src="./img/leftarrow.svg" alt="戻る">
			<img id="goBottom" class="moveButton" src="./img/bottomarrow.svg" alt="下">
		</div>
		<footer>
			<a href="./usage.html">使い方など</a>
			<span>© 2020 KusaReMKN</span>
		</footer>
	</body>

	</html>

<?php
	return true;
}
