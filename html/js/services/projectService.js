angular.module('timelineApp.services', [], function ($provide) {

	$provide.factory('ProjectService', ['$http', 'AuthService', function($http, AuthService) {
		var root = {};
		root.view = function(successCallback, failureCallbackid) {
			$http.get(AuthService.yii + 'api/project/view/' + id, {}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.myProjects = function(successCallback, failureCallback) {
			$http.get(AuthService.yii + 'api/project/listMine', {}).success(function(data) {	
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.allProjects = function(successCallback, failureCallback) {
			$http.get(AuthService.yii + 'api/project/listAll', {}).success(function(data) {	
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		root.tag = function(successCallback, failureCallback, tag, id) {
			var payload = 'project_id=' + id + '&tag=' + tag;
			$http.post(AuthService.yii + 'api/project/tag/', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// attrs is an object containing desired properties. server side does args checking
		root.create = function(successCallback, failureCallback, attrs) {
			$http.post(AuthService.yii + 'api/project/create/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		};
		// delete is a keyword :(
		root.del = function(successCallback, failureCallback, id) {
			$http.post(AuthService.yii + 'api/project/delete/', 'project_id=' + id, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.update = function(successCallback, failureCallback, attrs) {
			$http.post(AuthService.yii + 'api/project/update/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}		
		root.getLines = function(id, successCallback, failureCallback) {
			var payload = 'project_id=' + id;
			$http.post(AuthService.yii + 'api/project/lines', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'})
			.success(function() {
				successCallback(data);
			}).error(function () {
				failureCallback(data);
			});
		};
		root.getEvents = function(id, successCallback, failureCallback) {
			var payload = 'project_id=' + id;
			$http.post(AuthService.yii + 'api/project/events', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'})
			.success(function() {
				successCallback(data);
			}).error(function () {
				failureCallback(data);
			});
		};
		root.addLine = function(successCallback, failureCallback, line_id, project_id) {
			var payload = 'line_id=' + line_id + '&project_id=' + project_id;
			$http.post(AuthService.yii + 'api/project/addLine', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		root.deleteLine = function(successCallback, failureCallback, line_id, project_id) {
			var payload = 'line_id=' + line_id + '&project_id=' + project_id;
			$http.post(AuthService.yii + 'api/project/deleteLine', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				successCallback(data);
			}).error(function(data) {
				failureCallback(data);
			});
		}
		
		return root;
	}]);
});