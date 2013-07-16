angular.module('timelineApp.services').factory('UserService', function() {
	var root = {};
	root.username = '';
	root.loggedIn = false;
	return root;
});
