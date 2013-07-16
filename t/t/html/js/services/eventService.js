angular.module('timelineApp.services', [], function ($provide) {

	$provide.factory('EventService', ['$http', function($http) {
		var root = {};
		root.view = function(id, successCallback, failureCallback) {
			$http.get(Constants.yii + 'api/event/view/' . id, {}).success(function(data) {
				successCalback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.list = function(successCallback, failureCallback) {
			$http.get(Constants.yii + 'api/event/list', {}).success(function(data) {	
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.tag = function(successCallback, failureCallback, tag, id) {
			var payload = 'event_id='.id . '&tag='.tag};
			$http.post(Constants.yii + 'api/event/tag/', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// attrs is an object containing desired properties. server side does args checking
		root.create = function(successCallback, failureCallback, attrs) {
			$http.post(Constants.yii + 'api/event/create/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// delete is a keyword :(
		root.del = function(successCallback, failureCallback, id) {
			$http.post(Constants.yii + 'api/event/delete/', 'event_id='.id, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.update = function(successCallback, failureCallback, attrs) {
			$http.post(Constants.yii + 'api/event/update/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.addResource = function(successCallback, failureCallback, resource_id, event_id) {
			var payload = 'resource_id='.resource_id . '&event_id='.event_id;
			$http.post(Constants.yii + 'api/event/addResource', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.deleteResource = function(successCallback, failureCallback, resource_id, event_id) {
			var payload = 'resource_id='.resource_id . '&event_id='.event_id};
			$http.post(Constants.yii + 'api/event/deleteResource', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		
		return root;
	}]);
});