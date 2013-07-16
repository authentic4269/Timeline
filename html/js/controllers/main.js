angular.module('timelineApp.controllers').controller('MainCtrl', ['$scope', '$http', 'UserService', '$window', 'ProjectService', 'AuthService', function($scope, $http, UserService, $window, ProjectService, AuthService) {
	SocialSlider.init('socialSlider');
	var options = {
		changedEl : "select",
		scrollArrows : false
	};
	cuSel(options);
	if (UserService.loggedIn)
	{
		$scope.username = UserService.username;
		alert(UserService.username);
		$scope.loggedIn = true;
	}
	else
	{
		//$window.location = 'login.html';
	}
	function loadLineInfo(data)
	{
		$scope.lines = data;
	}
	function errorLineLoading(data)
	{
	}
	function loadEventInfo(data)
	{
		$scope.events = data;
	}
	function errorEventLoading()
	{
	}
	function loadProjectInfo(data)
	{
		var i = 0;
		if (data.length > 0)
		{
			$scope.project = data[0];
			$scope.project_count = data.length - 1;
			ProjectService.getLines(data[0].id, loadLineInfo, errorLineLoading);
			ProjectService.getEvents (data[0].id, loadEventInfo, errorEventLoading)
		}
		else
		{
			$scope.project = {title: "You don't have any projects yet!", description: "You will see information about your projects here after you make one"}
			$scope.project_count = 0;
		}
	}
	$scope.logout = AuthService.logout;
	function errorProjectLoading(data)
	{
	}
	ProjectService.myProjects(loadProjectInfo, errorProjectLoading);

	
	window.___gcfg = {
		lang: 'en-US'
	};
	
	$scope.inputTags = [];
	var loadTags = function(data) {
		$scope.inputTags = data;
	}
	var errorTags = function(data) { 
		return;
	}
	ProjectService.getTags(loadTags, errorTags, $scope.project.id);

	$scope.addTag = (function() {
			if ($scope.tagText.length == 0) {
				return;
			}
			ProjectService.tag(function(data) { 
				
			}, function(data) {
				
			}, $scope.tagText, $scope.project.id);
			$scope.inputTags.push({name: $scope.tagText});
				$scope.tagText = '';
	});

	$scope.deleteTag = (function(key) {
		if ($scope.inputTags.length > 0 &&
			$scope.tagText.length == 0 &&
			key === undefined) {
			$scope.inputTags.pop();
			ProjectService.deleteTag(function(data) { 
			}, function(data) {
			}, $scope.tagText, $scope.project.id);
		} else if (key != undefined) {
			ProjectService.deleteTag(function(data) { 
			}, function(data) {
			}, $scope.inputTags[key].name, $scope.project.id);
			$scope.inputTags.splice(key, 1);

		}
	});

	// Google Plus button
	(function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	});
	
	// Twitter button
	!function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0],
		p = /^http:/.test(d.location) ? 'http' : 'https';
		if (!d.getElementById(id)) {
			js = d.createElement(s);
			js.id = id; js.src = p + '://platform.twitter.com/widgets.js';
			fjs.parentNode.insertBefore(js, fjs);
		}
	}
	(document, 'script', 'twitter-wjs');
	
	(function() {
	})();
}]);