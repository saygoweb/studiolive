'use strict';

/* Controllers */
var app = angular.module(
		'sl.scene',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('SceneCtrl', ['$scope', 'breadcrumbService', 'sceneService', '$routeParams', '$timeout', 
	                          function($scope, breadcrumbService, sceneService, $routeParams, $timeout) {
		$scope.debug = {};
		$timeout(function() {
			$scope.debug.setTab = true;  
		}, 0);

		$scope.settings = {};
		$scope.show = {};
		$scope.show.id = $routeParams.showId;
		$scope.scene = {};
		$scope.state = {};
		$scope.state.sceneId = $routeParams.sceneId;

		breadcrumbService.set('top',
				[
				 {href: '#/shows', label: 'All Shows'},
				 {href: '#/show/' + $scope.show.id, label: ''},
				 {href: '#/show/' + $routeParams.showId + '/' + $routeParams.sceneId, label: ''},
				]
		);
		var updateBreadcrumbs = function() {
			breadcrumbService.updateCrumb('top', 1, { label: $scope.show.name });
			breadcrumbService.updateCrumb('top', 2, { label: $scope.scene.name });
		};
		// Read
		$scope.queryShow = function() {
			sceneService.readShow($scope.show.id, function(result) {
				if (result.ok) {
					$scope.show = result.data.show;
					$scope.settings = result.data.settings;
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
			console.log("watch show", newValue);
			$scope.updateScene();
			$scope.updateSceneList();
			updateBreadcrumbs();
		});
		
		$scope.$watch("state.sceneId", function(newValue, oldValue) {
			console.log("watch currentSceneId", newValue);
			$scope.updateScene();
		});
		
		$scope.updateScene = function() {
			if ($scope.show.scenes == undefined) {
				return;
			}
			$scope.scene = $scope.show.scenes[$scope.state.sceneId];
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


		};
		
		// Scene List
		$scope.updateSceneList = function() {
			console.log('update scene list: ', $scope.show);
			if ($scope.show.scenesIndex == undefined) {
				return;
			}
			$scope.scenes = [];
			for (var i = 0, c = $scope.show.scenesIndex.length; i < c; i++) {
				var scene = $scope.show.scenes[$scope.show.scenesIndex[i]]; 
				var model = {};
				model.id = scene.id;
				model.name = scene.name;
				$scope.scenes.push(model);
			}
			console.log('scene list: ', $scope.scenes);
		};
		
		// Scene Actions
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
		
		$scope.dataRefreshClick = function(actionId, actionItem) {
			var action = $scope.show.actions[actionId];
			console.log("dataRefresh: ", actionId, actionItem, action);
			sceneService.previewAction(action, 'update', actionItem, function(result) {
				if (result.ok) {
					console.log('dataRefresh ok');
				}
			});
		};

		// SHOW TIME
		$scope.stInClick = function(actionId) {
			sceneService.executeAction($scope.show.id, $scope.scene.id, actionId, 'in', null, function(result) {
				if (result.ok) {
					console.log('in click ok');
				}
			});
		};
		$scope.stOutClick = function(actionId) {
			sceneService.executeAction($scope.show.id, $scope.scene.id, actionId, 'out', null, function(result) {
				if (result.ok) {
					console.log('out click ok');
				}
			});
		};

		// PREVIEW
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
		
		$scope.previewSnap = function(preview) {
			$scope.snap = !$scope.snap;
//			sceneService.snap(preview.channel, '', function(result) {
//				if (result.ok) {
//					
//				}
//			})
		};
		
	}])
	;
