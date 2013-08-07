'use strict';

/* Controllers */
var app = angular.module(
		'sl.scene',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('SceneCtrl', ['$scope', 'sceneService', '$routeParams', '$timeout', function($scope, sceneService, $routeParams, $timeout) {
		$scope.debug = {};
		$timeout(function() {
		  $scope.debug.actionsTab = true;  
		}, 0);

		$scope.show = {};
		$scope.show.id = $routeParams.showId;
		$scope.scene = {};
		$scope.scene.id = $routeParams.sceneId;

		// Read
		$scope.queryShow = function() {
			sceneService.readShow($scope.show.id, function(result) {
				if (result.ok) {
					$scope.show = result.data;
//					$scope.showActions = $scope.show.actions.slice(0); // Shallow clone the array.
//					$scope.sceneActions = [];
					
//					$scope.showActions = ['a', 'b', 'c'];
//					$scope.sceneActions = [];
				}
			});
		};
		$scope.queryShow();
		
		// Sort
		$scope.sortOptions = {
			update: function(e, ui) {
				if (e.target.id == 'destList') {
					$scope.canUpdate = true;
				}
			},
			connectWith: "ul.actionList",
			cursor: "pointer"
		};
		
		// Show actions / Scene actions
		$scope.$watch("show", function(newValue, oldValue) {
			console.log("watch show", newValue);
			if ($scope.show.scenes == undefined) {
				return;
			}
			$scope.scene = $scope.show.scenes[$scope.scene.id];
			var showActions = [];
			var sceneActions = [];
			for (var i = 0, l = $scope.scene.actions.length; i < l; i++) {
				var action = $scope.show.actions[$scope.scene.actions[i]];
				sceneActions.push(action);
			}
			for (var id in $scope.show.actions) {
				var action = $scope.show.actions[id];
				if ($scope.scene.actions.indexOf(action.id) == -1) {
					showActions.push(action);
				}
			}
			$scope.showActions = showActions;
			$scope.sceneActions = sceneActions;
		});
		
		$scope.$watch("sceneActions", function(newValue, oldValue) {
			console.log('watch sceneActions', newValue);
			if ($scope.canUpdate == undefined) {
				return;
			}
			var sceneActions = [];
			for (var i = 0, l = $scope.sceneActions.length; i < l; i++) {
				sceneActions.push($scope.sceneActions[i].id);
			}
			$scope.scene.actions = sceneActions;
			console.log('updating sceneActions');
			sceneService.update($scope.show.id, $scope.scene, function(result) {
				if (result.ok) {
					// TODO notify CP 2013-07
					console.log('scene update ok');
				}
			});
			
		}, true);

		
	}])
	;
