angular.module('timelineApp.directives').directive('checkUser', ['$rootScope', '$location', 'UserService', function ($root, $window, UserService) {
	return {
		link: function (scope, elem, attrs, ctrl) {
			$root.$on('$routeChangeStart', function(event, currRoute, prevRoute){
				if (!UserService.loggedIn && !prevRoute.access.isFree) {
					$window.location("login.html");
				}
				/*
				* IMPORTANT:
				* It's not difficult to fool the previous control,
				* so it's really IMPORTANT to repeat the control also in the backend,
				* before sending back from the server reserved information.
				*/
			});
		}
	}
}]);