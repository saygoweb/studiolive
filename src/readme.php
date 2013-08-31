<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Studio Live Readme</title>
	<link rel="stylesheet" href="/css/bootstrap.css" />
</head>
<body>
<div ng-app="sgw.ui.markdown">
<markdown>
<?php
$file = 'README.md';
if (file_exists($file)) {
	include($file);
} else {
	$file = '../README.md';
	if (file_exists($file)) {
		include($file);
	}
}
?>
</markdown>
</div>

<script	src="/js/lib/angular_stable_1.0.7/angular.js"></script>
<script	src="/js/lib/markdown-ng-min.js"></script>
  
</body>
</html>