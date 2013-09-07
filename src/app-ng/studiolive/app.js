'use strict';

// Declare app level module which depends on filters, and services
angular.module('sgwStudioLive', 
		[
		 'sl.services',
		 'sl.settings',
		 'sl.shows',
		 'sl.show',
		 'sl.scene',
		 'ui.sortable',
		 'sgw.ui.breadcrumb'
		])
.config(['$routeProvider', function($routeProvider) {
    $routeProvider.when(
    		'/shows', 
    		{
    			templateUrl: '/app-ng/studiolive/partials/shows.html', 
    			controller: 'ShowsCtrl'
    		}
	    );
	    $routeProvider.when(
    		'/show/:showId', 
    		{
    			templateUrl: '/app-ng/studiolive/partials/show.html' ,
    			controller: 'ShowCtrl'
    		}
    	);
	    $routeProvider.when(
    		'/show/:showId/:sceneId', 
    		{
    			templateUrl: '/app-ng/studiolive/partials/scene.html.php', 
    			controller: 'SceneCtrl'
    		}
    	);
	    $routeProvider.when(
    		'/settings', 
    		{
    			templateUrl: '/app-ng/studiolive/partials/settings.html', 
    			controller: 'SettingsCtrl'
    		}
	    );
    $routeProvider.otherwise({redirectTo: '/shows'});
}])
.controller('StudioLiveCtrl', ['$scope', 'breadcrumbService', 'casparService', function($scope, breadcrumbService, casparService) {
	breadcrumbService.push('top', { href: '#/shows', label: 'All Shows' });
	
	$scope.$watch(function() { return casparService.state; }, function(state) {
		console.log('casparService state change: ', state);
		$scope.connected = (state.connected) ? 'icon-circle' : 'icon-circle-blank';
	}, true);

}])
;
