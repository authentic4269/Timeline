angular.module('timelineApp.controllers').controller('LoginCtrl', ['$scope', 'AuthService', function($scope, AuthService) {

	
	
    $scope.loginMaster= {
            username: '',
            password: ''
    };
    
    $scope.reset = function() {
            $scope.login = angular.copy($scope.loginMaster);
    };
    $scope.user = AuthService.username;
    $scope.reset();
	$scope.submitLogin = function() {
		AuthService.login($scope.login.username, $scope.login.password);

	};
	 
	$scope.logout = function() {
		AuthService.logout();
	};
}]);
	 


