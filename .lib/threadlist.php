<?php
function ThreadList()
{
?>
	<!DOCTYPE html>
	<html lang="ja">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>MKNBBS</title>
		<meta name="description" content="MKNBBS は KusaReMKN によるインターネット掲示板です">
		<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700;900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@500;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="./css/new.css" type="text/css">
		<link rel="stylesheet" href="./css/mknbbs.css" type="text/css">
		<script src="./js/textarea.js"></script>
		<script src="./js/remember.js"></script>
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
			<h1>MKNBBS</h1>
		</header>
		<nav>
			<?php PrintThreadList(); ?>
		</nav>
		<form action="./" method="POST" id="form">
			<fieldset>
				<legend>新しいスレッドを立てる</legend>
				<div>
					<label>
						Thread Name
						<input type="text" name="<?= ThreadTitle ?>" required>
					</label>
				</div>
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
					<input type="submit" id="submit" value="スレッドを立てる">
				</div>
			</fieldset>
		</form>
		<footer>
			<a href="./usage.html">使い方など</a>
			<span>© 2020 KusaReMKN</span>
		</footer>
	</body>

	</html>
<?php
}
