'use strict';

/* Controllers */
var app = angular.module(
		'sgwStudioLive.controllers',
		[ 'sl.services', 'palaso.ui.listview', 'palaso.ui.typeahead', 'ui.bootstrap' ]
	)
	.controller('ShowsCtrl', ['$scope', 'showService', function($scope, showService) {
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
		
		$scope.shows = [];
		$scope.queryShows = function() {
			showService.list(function(result) {
				if (result.ok) {
					$scope.shows = result.data.entries;
					$scope.showCount = result.data.count;
				}
			});
		};
		
		$scope.removeShows = function() {
			console.log("removeShows");
			var showIds = [];
			for(var i = 0, l = $scope.selected.length; i < l; i++) {
				showIds.push($scope.selected[i].id);
			}
			if (l == 0) {
				// TODO ERROR
				return;
			}
			showService.removeShows(showIds, function(result) {
				if (result.ok) {
					$scope.queryShows();
					// TODO
				}
			});
		};
		
		$scope.selectUser = function(item) {
			console.log("Called selectUser(", item, ")");
		};
		
	    $scope.addModes = {
	    	'addNew': { 'en': 'Create New', 'icon': 'icon-user'},
	    	'addExisting' : { 'en': 'Add Existing', 'icon': 'icon-user'},
	    	'invite': { 'en': 'Send Invite', 'icon': 'icon-envelope'}
	    };
	    $scope.addMode = 'addNew';
		
		$scope.queryUser = function(term) {
			console.log('searching for ', term);
			userService.typeahead(term, function(result) {
				// TODO Check term == controller view value (cf bootstrap typeahead) else abandon.
				if (result.ok) {
					$scope.users = result.data.entries;
					$scope.updateAddMode();
				}
			});
		};
		$scope.addModeText = function(addMode) {
			return $scope.addModes[addMode].en;
		};
		$scope.addModeIcon = function(addMode) {
			return $scope.addModes[addMode].icon;
		};
		$scope.updateAddMode = function() {
			// TODO This isn't adequate.  Need to watch the 'term' and 'selection' also. CP 2013-07
			if ($scope.users.length == 0) {
				$scope.addMode = 'addNew';
			} else if ($scope.users.length == 1) {
				$scope.addMode = 'addExisting';
			}
		};
		
		$scope.addProjectUser = function() {
			var model = {};
			if ($scope.addMode == 'addNew') {
				model.name = $scope.term;
			} else if ($scope.addMode == 'addExisting') {
				model.id = $scope.user.id;
			} else if ($scope.addMode == 'invite') {
				$model.email = $scope.term;
			}
			console.log("addUser ", model);
			projectService.updateUser($scope.projectId, model, function(result) {
				if (result.ok) {
					// TODO broadcast notice and add
					$scope.queryProjectUsers();
				}
			});
		};
	
		$scope.selectUser = function(item) {
			console.log('user selected', item);
			$scope.user = item;
			$scope.term = item.name;
		};
	
		$scope.imageSource = function(avatarRef) {
			return avatarRef ? '/images/avatar/' + avatarRef : '/images/avatar/anonymous02.png';
		};
	
	}])
	;
