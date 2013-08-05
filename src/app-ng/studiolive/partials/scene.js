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

		// Read
		$scope.queryShow = function() {
			sceneService.readShow($scope.show.id, function(result) {
				if (result.ok) {
					$scope.show = result.data;
					$scope.showActions = $scope.show.actions.slice(0); // Shallow clone the array.
					$scope.sceneActions = [];
					
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
					console.log("update: " + e.target.id);
					console.log("update: " + $scope.sceneActions.id);
				}
			},
			connectWith: "ul.actionList",
			cursor: "pointer",
			dropOnEmpty: true
		};
		
	}])
	;
