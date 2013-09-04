'use strict';

// Declare app level module which depends on filters, and services
angular.module('sgwStudioLive', 
		[
		 'sl.services',
		 'sl.settings',
		 'sl.shows',
		 'sl.show',
		 'sl.scene',
		 'ui.sortable'
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
	;
