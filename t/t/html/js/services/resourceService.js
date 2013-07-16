angular.module('timelineApp.services', [], function ($provide) {

	$provide.factory('resourceService', ['$http', function($http) {
		var root = {};
		root.view = function(id) {
			$http.get(YII . 'api/resource/view/' . id, {}).success(function(data) {
				return data;
			}).failure(function(data) {
				return data;
			});
		};
		root.list = function() {
			$http.get(YII . 'api/resource/list', {}).success(function(data) {	
				return data;
			}).failure(function(data) {
				return data;
			});
		};
		root.tag = function(tag, id) {
			var payload = {'resource_id': id, 'tag': tag};
			$http.post(YII . 'api/resource/tag/', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				return data;
			}).failure(function(data) {
				return data;
			});
		};
		// attrs is an object containing desired properties. server side does args checking
		root.create = function(attrs) {
			$http.post(YII . 'api/resource/create/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				return data;
			}).failure(function(data) {
				return data;
			});
		};
		// delete is a keyword :(
		root.del = function(id) {
			$http.post(YII . 'api/resource/delete/', {'resource_id': id}, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				return data;
			}).failure(function(data) {
				return data;
			});
		}
		root.update = function(attrs) {
			$http.post(YII . 'api/resource/update/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
				return data;
			}).failure(function(data) {
				return data;
			});
		}

		
		return root;
	}]);
});