angular.module('timeeventApp.services', [], function ($provide) {

	$provide.factory('lineService', ['$http', Constants, function($http, Constants) {
		var root = {};
		root.view = function(successCallback, failureCallback, id) {
			$http.get(Constants.yii + 'api/line/view/' . id, {}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.list = function(successCallback, failureCallback) {
			$http.get(Constants.yii + 'api/line/list', {}).success(function(data) {	
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.tag = function(successCallback, failureCallback, tag, id) {
			var payload = 'line_id=' . id . '&tag=' . tag;
			$http.post(Constants.yii + 'api/line/tag/', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// attrs is an object containing desired properties. server side does args checking
		root.create = function(successCallback, failureCallback, attrs) {
			$http.post(Constants.yii + 'api/line/create/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// delete is a keyword :(
		root.del = function(successCallback, failureCallback, id) {
			$http.post(Constants.yii + 'api/line/delete/', {'line_id=' . id}, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.update = function(successCallback, failureCallback, attrs) {
			$http.post(Constants.yii + 'api/line/update/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.addEvent = function(successCallback, failureCallback, event_id, line_id) {
			var payload = 'event_id=' . event_id . '&line_id=' . line_id;
			$http.post(Constants.yii + 'api/line/addEvent', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.deletEevent = function(successCallback, failureCallback, event_id, line_id) {
			var payload = 'event_id=' . event_id . '&line_id=' . line_id;
			$http.post(Constants.yii + 'api/line/deleteEvent', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		
		return root;
	}]);
});