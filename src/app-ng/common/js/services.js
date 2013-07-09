'use strict';

// Services
// StudioLive common services
angular.module('sl.services', ['jsonRpc'])
	.service('showService', ['jsonRpc', function(jsonRpc) {
		jsonRpc.connect('/api/studiolive.php'); // Note this doesn't actually 'connect', it simply sets the connection url.

		this.read = function(id, callback) {
			jsonRpc.call('show_read', [id], callback);
		};
		this.update = function(model, callback) {
			jsonRpc.call('show_update', [model], callback);
		};
		this.remove = function(id, callback) {
			jsonRpc.call('show_delete', [id], callback);
		};
		this.list = function(callback) {
			// TODO Paging CP 2013-07
			jsonRpc.call('show_list', [], callback);
		};
	}])
	;
