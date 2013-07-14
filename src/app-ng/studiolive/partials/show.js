'use strict';

/* Controllers */
var app = angular.module(
		'sl.show',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('ShowCtrl', ['$scope', 'showService', '$routeParams', function($scope, showService, $routeParams) {
		$scope.show = {};
		$scope.show.id = $routeParams.showId;
		// Selection
		$scope.selected = [];
		$scope.updateSelection = function(event, item) {
			var selectedIndex = $scope.selected.indexOf(item);
			var checkbox = event.target;
			if (checkbox.checked && selectedIndex == -1) {
				$scope.selected.push(item);
			} else if (!checkbox.checked && selectedIndex != -1) {
				$scope.selected.splice(selectedIndex, 1);
			}
		};
		$scope.isSelected = function(item) {
			return item != null && $scope.selected.indexOf(item) >= 0;
		};
		
		// Read
		$scope.queryShow = function() {
			showService.read($scope.show.id, function(result) {
				if (result.ok) {
					$scope.show = result.data;
				}
			});
		};
		$scope.queryShow();

		// Remove
		$scope.removeScenes = function() {
			console.log("removeScenes");
			var sceneIds = [];
			for(var l = $scope.selected.length, i = l; i >= 0; i--) {
				sceneIds.push($scope.selected[i].id);
			}
			if (l == 0) {
				// TODO ERROR
				return;
			}
			// TODO remove from show
		};
		
		// Add Scene
		$scope.addScene = function() {
			var model = {};
			model.id = '';
			model.name = $scope.sceneName;
			console.log("addScene ", model);
		};
		
		/*
		$scope.imageSource = function(avatarRef) {
			return avatarRef ? '/images/avatar/' + avatarRef : '/images/avatar/anonymous02.png';
		};
		*/
	
	}])
	;
