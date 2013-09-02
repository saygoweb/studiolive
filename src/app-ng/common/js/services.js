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
		this.remove = function(showIds, callback) {
			jsonRpc.call('show_delete', [showIds], callback);
		};
		this.list = function(callback) {
			// TODO Paging CP 2013-07
			jsonRpc.call('show_list', [], callback);
		};
		this.updateAction = function(showId, model, callback) {
			jsonRpc.call('show_updateAction', [showId, model], callback);
		};
		this.removeAction = function(showId, actionId, callback) {
			jsonRpc.call('show_removeAction', [showId, actionId], callback);
		};
		this.previewAction = function(action, operation, callback) {
			jsonRpc.call('caspar_executeAction', [action, operation, null], callback);
		};
	}])
	.service('sceneService', ['jsonRpc', function(jsonRpc) {
		jsonRpc.connect('/api/studiolive.php'); // Note this doesn't actually 'connect', it simply sets the connection url.

		this.readShow = function(showId, callback) {
			jsonRpc.call('show_read', [showId], callback);
		};
		this.read = function(showId, sceneId, callback) {
			jsonRpc.call('scene_read', [showId, sceneId], callback);
		};
		this.update = function(showId, model, callback) {
			jsonRpc.call('scene_update', [showId, model], callback);
		};
		this.remove = function(showId, sceneIds, callback) {
			jsonRpc.call('scene_delete', [showId, sceneIds], callback);
		};
		this.updateScenesIndex = function(showId, sceneIds, callback) {
			jsonRpc.call('show_updateScenesIndex', [showId, sceneIds], callback);
		};
		this.executeAction = function(showId, sceneId, actionId, operation, callback) {
			jsonRpc.call('scene_executeAction', [showId, sceneId, actionId, operation], callback);
		};
		this.executeCommand = function(command, operation, callback) {
			jsonRpc.call('caspar_executeCommand', [command, operation], callback);
		};
		this.previewAction = function(action, operation, sceneUserData, callback) {
			jsonRpc.call('caspar_executeAction', [action, operation, sceneUserData], callback);
		};
	}])
	;
