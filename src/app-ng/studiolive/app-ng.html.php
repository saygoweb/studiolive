<!doctype html>
<html lang="en" ng-app="sgwStudioLive">
<head>
	<meta charset="utf-8">
	<title>Studio Live</title>
	<link rel="stylesheet" href="/css/bootstrap.css" />
	<link rel="stylesheet" href="/css/font-awesome.min.css">
	<link rel="stylesheet" href="/app-ng/studiolive/css/app.css" />
	<link rel="stylesheet" href="/app-ng/common/css/sgw-ui.css" />
	<script src="/js/lib/jquery-1.8.3.min.js"></script>
	<script src="/js/lib/jquery-ui-1.10.3.custom.min.js"></script>
</head>
<body>
<div ng-controller="StudioLiveCtrl">
<ul class="breadcrumb indicator right">
	<li class="settings"><a href="#/settings"><i class="icon-gear"></i></a></li>
	<li class="connection">localhost<i ng-class="connected"></i></li>
</ul>
<ul id="top" breadcrumbs></ul>
</div>
<div ng-view></div>
<div id="version" style="clear: both">Studio Live: <span><?php echo $version;?></span></div>

<script	src="/js/lib/angular_stable_1.0.7/angular.js"></script>
<script	src="/js/lib/ng-ui-bootstrap-tpls-0.4.0.js"></script>
<script	src="/js/lib/sortable.js"></script>

<?php foreach($scripts as $script): ?>
<script src="<? echo $script; ?>"></script>
<?php endforeach; ?>

</body>
</html>