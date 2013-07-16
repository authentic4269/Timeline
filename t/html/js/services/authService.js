angular.module('timelineApp.services', [], function ($provide) {
        $provide.factory('UserService', function() {
                var root = {};
                root.username = '';
                root.loggedIn = false;
                return root;
        });

        $provide.factory('AuthService', ['UserService', '$http', '$window', function(UserService, $http, $window) {
                var root = {};
                root.yii = 'http://localhost/t/yii/timeline/index.php';
                root.login = function(username, password) {
                        var payload = ('username=' + username + '&password=' + password);
                        var config = {
                                headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                        }
                        $http.post(root.yii + '/site/login', payload, config).success(function(data) {
                                UserService.loggedIn = true;
                                UserService.username = username;
                                $window.location = "#/";
                                return true;
                        }).error(function(data) {
                                return false;
                        });
                };
                root.logout = function() {
                        $http.put(root.yii + '/site/logout', {}).success(function() {
                                $window.location = "/login";
                        });
                };
                return root;
        }]);
        
        
        
        $provide.factory('Util', [function() {
        	var root = {};
        	root.diff = function(start, end) {
        		var start_seconds = 0;
        	}
        }])
        
        
    	$provide.factory('ProjectService', ['$http', 'AuthService', function($http, AuthService) {
    		var root = {};
    		root.view = function(successCallback, failureCallbackid) {
    			$http.get(AuthService.yii + '/api/project/view/' + id, {}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		root.myProjects = function(successCallback, failureCallback) {
    			$http.get(AuthService.yii + '/api/project/mine', {}).success(function(data) {	
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		root.allProjects = function(successCallback, failureCallback) {
    			$http.get('/api/project/listAll', {}).success(function(data) {	
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		root.getLines = function(id, successCallback, failureCallback) {
    			var payload = ('project_id=' + id);
                var config = {
                        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                }
    			$http.post(AuthService.yii + '/api/project/lines', payload, config)
    			.success(function(data) {
    				successCallback(data);
    			}).error(function (data) {
    				failureCallback(data);
    			});
    		};
    		root.getEvents = function(id, successCallback, failureCallback) {
    			var payload = ('project_id=' + id)
    		    var config = {
    				headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                };
    			$http.post(AuthService.yii + '/api/project/events', payload, config)
    			.success(function(data) {
    				successCallback(data);
    			}).error(function (data) {
    				failureCallback(data);
    			});
    		};
    		root.getTags = function(successCallback, failureCallback, id) {
    			var payload = 'project_id=' + id;
                var config = {
                        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                }
    			$http.post(AuthService.yii + '/api/project/gettags/', payload, config).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		root.tag = function(successCallback, failureCallback, tag, id) {
    			var payload = 'project_id=' + id + '&tag=' + tag;
                var config = {
                        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                }
    			$http.post(AuthService.yii + '/api/project/tag/', payload, config).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		root.deleteTag = function(successCallback, failureCallback, tag, id) {
    			var payload = 'project_id=' + id + '&tag=' + tag;
                var config = {
                        headers: {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}
                }
    			$http.post(AuthService.yii + '/api/project/deletetag/', payload, config).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		// attrs is an object containing desired properties. server side does args checking
    		root.create = function(successCallback, failureCallback, attrs) {
    			$http.post(AuthService.yii + '/api/project/create/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		};
    		// delete is a keyword :(
    		root.del = function(successCallback, failureCallback, id) {
    			$http.post(AuthService.yii + '/api/project/delete/', 'project_id=' + id, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		}
    		root.update = function(successCallback, failureCallback, attrs) {
    			$http.post(AuthService.yii + '/api/project/update/', attrs, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		}
    		root.addLine = function(successCallback, failureCallback, line_id, project_id) {
    			var payload = 'line_id=' + line_id + '&project_id=' + project_id;
    			$http.post(AuthService.yii + '/api/project/addLine', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		}
    		root.deleteLine = function(successCallback, failureCallback, line_id, project_id) {
    			var payload = 'line_id=' + line_id + '&project_id=' + project_id;
    			$http.post(AuthService.yii + '/api/project/deleteLine', payload, {'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).success(function(data) {
    				successCallback(data);
    			}).error(function(data) {
    				failureCallback(data);
    			});
    		}
    		
    		return root;
    	}]);
});

