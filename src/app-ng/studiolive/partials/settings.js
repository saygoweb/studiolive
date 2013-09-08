'use strict';

/* Controllers */
var module = angular.module(
	'sl.settings',
	[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
);
module.controller('SettingsCtrl', ['$scope', 'breadcrumbService', 'showService', '$timeout',
                                   function($scope, breadcrumbService, showService, $timeout) {
	breadcrumbService.set('top',
			[
			 {href: '#/shows', label: 'All Shows'},
			 {href: '#/settings', label: 'Settings'},
			]
	);
	
	$scope.debug = {};
	$timeout(function() {
		$scope.debug.setTab = true;  
	}, 0);

	$scope.settings = {};
	var read = function() {
		showService.settingsRead(function(result) {
			if (result.ok) {
				$scope.settings = result.data;
			}
		});
	};
	read();
	
	$scope.update = function() {
		showService.settingsUpdate($scope.settings, function(result) {
			if (result.ok) {
				console.log('settings update ok');
			}
		});
	};
	
	// Cameras
	$scope.addCamera = function() {
		var model = {};
		model.name = '';
		model.uri = '';
		
		if ($scope.settings.cameras == undefined) {
			$scope.settings.cameras = [];
		}
		
		$scope.settings.cameras.push(model);
	};
	$scope.addCamera();
	
	$scope.removeCamera = function(index) {
		$scope.settings.cameras.splice(index, 1);
		if ($scope.settings.cameras.length == 0) {
			$scope.addCamera();
		}
	};
	
	// Previews
	$scope.addPreview = function() {
		var model = {};
		model.channel = '';
		model.uriRx = '';
		model.uriTx = '';
		
		if ($scope.settings.previews == undefined) {
			$scope.settings.previews = [];
		}
		
		$scope.settings.previews.push(model);
	};
	$scope.addPreview();
	
	$scope.removePreview = function(index) {
		$scope.settings.previews.splice(index, 1);
		if ($scope.settings.previews.length == 0) {
			$scope.addPreview();
		}
	};
	
}]);
