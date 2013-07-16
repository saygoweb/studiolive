'use strict';

/* Controllers */
var module = angular.module(
	'sl.show',
	[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
);
module.controller('ShowCtrl', ['$scope', 'sceneService', '$routeParams', function($scope, sceneService, $routeParams) {
	$scope.isActive=true;
	$scope.show = {};
	$scope.show.id = $routeParams.showId;
	// Read
	$scope.queryShow = function() {
		sceneService.readShow($scope.show.id, function(result) {
			if (result.ok) {
				$scope.show = result.data;
			}
		});
	};
	$scope.queryShow();
}]);
module.controller('ShowScenesCtrl', ['$scope', 'sceneService', '$routeParams', function($scope, sceneService, $routeParams) {
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
		model.name = this.sceneName;
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

}]);
module.controller('ShowActionsCtrl', ['$scope', 'showService', 'sceneService', '$routeParams', function($scope, showService, sceneService, $routeParams) {
	//$scope.isActive = true;
	//$scope.currentAction = {"name": "Action 2"};
	
	$scope.bugText = 'Bug Text';

	$scope.saveShow = function() {
		console.log("saveShow() ", $scope.show);
		showService.update($scope.show, function(result) {
			if (result.ok) {
				// TODO Notify CP 2013-07
			}
		});
	};
	
	//---------------------------------------------------------------
	// ACTIONS
	//---------------------------------------------------------------
	$scope.currentAction = undefined;

	// Watch action list
	$scope.$watch('show.actions', function(newValue, oldValue) {
		console.log('actions watch ', newValue);
		if (!newValue) {
			return;
		}
		$scope.currentAction = newValue[0];
	});
	
	// Watch action select
	$scope.$watch('currentAction', function(newValue, oldValue) {
		console.log('currentAction', newValue);
		$scope.bugText = newValue;
	});
	
	$scope.addAction = function() {
		console.log("addAction()");
		var model = {};
		model.name = $scope.newActionName;
		$scope.show.actions.push(model);
		$scope.currentAction = model;
	};
	
	$scope.removeAction = function() {
		console.log("removeAction()");
		var selectedIndex = $scope.show.actions.indexOf($scope.currentAction);
		$scope.show.actions.splice(selectedIndex, 1);
	};
	
	//---------------------------------------------------------------
	// Commands
	//---------------------------------------------------------------
	$scope.currentCommand = undefined;
	
	$scope.allCommands = 
		[
		 {'cat': 'Input',  'type': 'Camera'},
		 {'cat': 'Input',  'type': 'Image'},
		 {'cat': 'Input',  'type': 'Stream'},
		 {'cat': 'Input',  'type': 'Video'},
		 {'cat': 'Mixer',  'type': 'Geometry'},
		 {'cat': 'Mixer',  'type': 'Opacity'},
		 {'cat': 'Mixer',  'type': 'Chroma'},
		 {'cat': 'Output', 'type': 'File'}
		];
	$scope.newCommandType = $scope.allCommands[0];
	$scope.chromaColors = ['Green', 'Blue'];

	$scope.addCommand = function() {
		console.log('addCommand()');
		var model = {};
		model.name = 'New Command';
		model.type = $scope.newCommandType.type;
		if ($scope.currentAction.commands == undefined) {
			$scope.currentAction.commands = [];
		}
		$scope.currentAction.commands.push(model);
		$scope.currentCommand = model;		
	};
	
	$scope.removeCommand = function(index) {
		console.log('removeCommand() ', index);
		$scope.currentAction.commands.splice(index, 1);
	};
	
	$scope.selectCommand = function(command) {
		console.log('selectCommand() ', command);
		$scope.currentCommand = command;
	};
	
	
	/*
	$scope.imageSource = function(avatarRef) {
		return avatarRef ? '/images/avatar/' + avatarRef : '/images/avatar/anonymous02.png';
	};
	*/

}]);
