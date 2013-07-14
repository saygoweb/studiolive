'use strict';

/* Controllers */
var app = angular.module(
		'sl.scene',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('SceneCtrl', ['$scope', 'sceneService', '$routeParams', function($scope, sceneService, $routeParams) {
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
			sceneService.readShow($scope.show.id, function(result) {
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
			for(var i = 0, l = $scope.selected.length; i < l; i++) {
				sceneIds.push($scope.selected[i]);
			}
			if (l == 0) {
				// TODO ERROR
				return;
			}
			sceneService.remove($scope.show.id, sceneIds, function(result) {
				if (result.ok) {
					$scope.queryShow();
				}
			});
		};
		
		// Add Scene
		$scope.addScene = function() {
			var model = {};
			model.id = '';
			model.name = $scope.sceneName;
			console.log("addScene ", model);
			sceneService.update($scope.show.id, model, function(result) {
				if (result.ok) {
					$scope.queryShow();
				}
			});
		};
		
		/*
		$scope.imageSource = function(avatarRef) {
			return avatarRef ? '/images/avatar/' + avatarRef : '/images/avatar/anonymous02.png';
		};
		*/
	
	}])
	;
