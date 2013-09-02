'use strict';

/* Controllers */
var app = angular.module(
		'sl.scene',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('SceneCtrl', ['$scope', 'sceneService', '$routeParams', '$timeout', function($scope, sceneService, $routeParams, $timeout) {
		$scope.debug = {};
		$timeout(function() {
			$scope.debug.setTab = true;  
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
				}
			});
		};
		$scope.queryShow();
		
		$scope.saveScene = function() {
			console.log('scene update...');
			sceneService.update($scope.show.id, $scope.scene, function(result) {
				if (result.ok) {
					// TODO notify CP 2013-07
					console.log('scene updated ok');
				}
			});
			
		};
		
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
			//console.log("watch show", newValue);
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

			$scope.updateDataSet($scope.sceneActions);
		});
		
		$scope.$watch("sceneActions", function(newValue, oldValue) {
			//console.log('watch sceneActions', newValue);
			if ($scope.canUpdate == undefined) {
				return;
			}
			var sceneActions = [];
			for (var i = 0, l = $scope.sceneActions.length; i < l; i++) {
				sceneActions.push($scope.sceneActions[i].id);
			}
			$scope.scene.actions = sceneActions;
			//console.log('updating sceneActions');
			$scope.saveScene();
			$scope.updateDataSet($scope.sceneActions);
			
		}, true);
		
		// DATA
		$scope.updateDataSet = function(sceneActions) {
			if ($scope.scene.dataSet == undefined) {
				$scope.scene.dataSet = {};
			}
			for (var i = 0, l = $scope.sceneActions.length; i < l; i++) {
				var action = $scope.sceneActions[i];
//				if (action.id in $scope.scene.dataSet) {
//					continue; // A poor optimization.  We may want to rebuild
//				}
				for (var j = 0, m = action.commands.length; j < m; j++) {
					var command = action.commands[j];
					switch (command.type) {
					case 'Flash Template':
						if (!(action.id in $scope.scene.dataSet)) {
							$scope.scene.dataSet[action.id] = {};
						}
						var actionItem = $scope.scene.dataSet[action.id];
						actionItem['name'] = action.name;
						if (!('data' in actionItem)) {
							actionItem['data'] = {};
						}
						for (var k = 0, n = command.dataSet.length; k < n; k++) {
							var dataItem = command.dataSet[k];
							if (dataItem.fieldId in actionItem.data || dataItem.useDefaultOnly) {
								continue;
							}
							var model = {};
							model.name = dataItem.name;
							model.value = dataItem.value;
							actionItem.data[dataItem.fieldId] = model;
						}
						break;
					}
					
				}
			}
			//console.log('dataSet', $scope.scene.dataSet);
		};
		
		// SHOW TIME
		$scope.stInClick = function(actionId) {
			sceneService.executeAction($scope.show.id, $scope.scene.id, actionId, 'in', function(result) {
				if (result.ok) {
					console.log('in click ok');
				}
			});
		};
		$scope.stOutClick = function(actionId) {
			sceneService.executeAction($scope.show.id, $scope.scene.id, actionId, 'out', function(result) {
				if (result.ok) {
					console.log('out click ok');
				}
			});
		};

		// PREVIEW
		$scope.previews = 
			[
			 {name: 'preview1', channel: 1, urlRx: 'udp://@:12345', urlTx: 'udp://127.0.0.1:12345'},
			 {name: 'preview2', channel: 2, urlRx: 'udp://@:12346', urlTx: 'udp://127.0.0.1:12346'},
			];
//		$scope.previews = 
//			[
//			 {name: 'preview1', channel: 1, urlRx: 'udp://@239.7.7.1:12345', urlTx: 'udp://239.7.7.1:12345'},
//			 {name: 'preview2', channel: 2, urlRx: 'udp://@239.7.7.1:12346', urlTx: 'udp://239.7.7.1:12346'},
//			];
		
		$scope.previewPlay = function(preview) {
			var model = {};
			model.type = 'StreamOut';
			model.channel = preview.channel;
			model.resourceName = preview.urlTx;
			sceneService.executeCommand(model, 'in', function(result) {
				if (result.ok) {
					console.log('play click ok');
				}
			});
		};
		
		$scope.previewStop = function(preview) {
			var model = {};
			model.type = 'StreamOut';
			model.channel = preview.channel;
			model.resourceName = preview.urlTx;
			sceneService.executeCommand(model, 'out', function(result) {
				if (result.ok) {
					console.log('stop click ok');
				}
			});			
		};
		
	}])
	;
