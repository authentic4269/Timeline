angular.module('timelineApp.controllers').controller('RegisterCtrl', ['$scope', '$http', 'AuthService', function($scope, $http, AuthService) {
	$scope.submit = function() {
		var payload = ('username=' + $scope.register.username + '&password=' + $scope.register.password +
			'&first_name=' + $scope.register.firstname + '&last_name=' + $scope.register.lastname + 
			'&email=' + $scope.register.email);
		var config = {
			headers: {'Content-Type':'application/x-www-form-urlencoded;; charset=UTF-8'}
		}
		$http.post(AuthService.yii + '/site/register', payload, config).success(function(data) {
			return true;
		}).error(function(data) {
			return false;
		});
	};
	
	$scope.unique = function(name) {
		if (!(typeof(name) === 'string'))
		{
			return false;
		}
		var url = AuthService.yii + "/site/namecheck";
		var config = {
				headers: {'Content-Type':'application/x-www-form-urlencoded;; charset=UTF-8'}
		}
		var payload = ('username=' + name);
		$http.post(AuthService.yii + "/site/namecheck", payload, config).success(function(data) {
			$scope.registerForm.username.$setValidity("unique", true);
		}).error(function(data) {
			$scope.registerForm.username.$setValidity("unique", false);
		});
		return true;
	};
}]);