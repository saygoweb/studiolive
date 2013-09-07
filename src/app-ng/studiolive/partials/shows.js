'use strict';

/* Controllers */
var app = angular.module(
		'sl.shows',
		[ 'sl.services', 'palaso.ui.listview', 'ui.bootstrap' ]
	)
	.controller('ShowsCtrl', ['$scope', 'showService', 'casparService', function($scope, showService, casparService) {
		
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
		
		// List
		$scope.shows = [];
		$scope.queryShows = function() {
			showService.list(function(result) {
				if (result.ok) {
					$scope.shows = result.data.entries;
					$scope.showCount = result.data.count;
				}
			});
		};
		
		// Remove
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
			showService.remove(showIds, function(result) {
				if (result.ok) {
					$scope.queryShows();
					// TODO
				}
			});
		};
		
		$scope.selectUser = function(item) {
			console.log("Called selectUser(", item, ")");
		};
		
		// Create
		$scope.addShow = function() {
			var model = {};
			model.id = '';
			model.name = $scope.name;
			console.log("addShow ", model);
			showService.update(model, function(result) {
				if (result.ok) {
					// TODO broadcast notice and add
					$scope.queryShows();
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
