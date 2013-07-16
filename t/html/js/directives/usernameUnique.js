angular.module('timelineApp.directives').directive('ngUnique', ['$http', 'AuthService', function($http, AuthService) {
	return {
		require: 'ngModel',
		link: function (scope, elem, attrs, ctrl) {
			elem.bind('blur', function (evt) {
				scope.$apply(function () {
					var val = elem.val();
					var req = 'username='+ val;					
					var config = {
							headers: {'Content-Type':'multipart/form-data; charset=UTF-8'}
						}
						$http.post(AuthService.yii + '/site/namecheck', req, config).success(function(data) {
							ctrl.$setValidity('unique', true);
							return true;
						}).error(function(data) {
							ctrl.$setValidity('unique', false);
						});
					
					/*async(ajaxConfiguration)
					.success(function(data, status, headers, config) {
						ctrl.$setValidity('unique', true);
					}).error(function(data, status, headers, config) {
						ctrl.$setValidity('unique', false);
					});*/
				});
        });
      }
    }
  }
]);