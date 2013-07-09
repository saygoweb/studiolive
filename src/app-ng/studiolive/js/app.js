'use strict';

// Declare app level module which depends on filters, and services
angular.module('sgwStudioLive', 
		[
		 'sgwStudioLive.filters', 
		 'sgwStudioLive.services', 
		 'sgwStudioLive.directives', 
		 'sgwStudioLive.controllers'
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
	    			templateUrl: '/app-ng/studiolive/partials/show.html', 
	    			controller: 'ShowCtrl'
	    		}
	    	);
	    $routeProvider.otherwise({redirectTo: '/shows'});
	}])
	;
