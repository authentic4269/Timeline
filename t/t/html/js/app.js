

angular.module('timelineApp', ['timelineApp.filters',
                                                           'timelineApp.services',
                                                           'timelineApp.directives',
                                                           'timelineApp.controllers',
                                                           'prevent-default'
                                                        ])
.config(function($routeProvider) {
        $routeProvider.
                when('/', {controller:'MainCtrl', templateUrl:'views/main.html'}).
                when('/login', {controller:'LoginCtrl', templateUrl:'views/login.html'}).
                when('/register', {controller:'RegisterCtrl', templateUrl:'views/register.html'}).
                otherwise({redirectTo:'/'});
}).run(['$rootScope', '$http', function(scope, $http) {
}]);
angular.module('timelineApp').constant('YII', '../yii/timeline/index.php/api/');
angular.module('timelineApp.controllers', []).constant('YII', '../yii/timeline/index.php/api/');
angular.module('timelineApp.filters', []).constant('YII', '../yii/timeline/index.php/api/');
angular.module('timelineApp.services', []).constant('YII', '../yii/timeline/index.php/api/');
angular.module('timelineApp.directives', []).constant('YII', '../yii/timeline/index.php/api/');
angular.module('timelineApp').constant('YII', '../yii/timeline/index.php/api/');


ScriptLoader.load([
                'js/vendor/html5shiv/html5shiv-min.js',
                'js/vendor/jquery/jquery.js',
                'js/vendor/social-slider.js',
                'js/vendor/cusel/cusel.js',
                'js/vendor/http-auth-interceptor.js',
                'js/vendor/angular-prevent-default.js',
                'js/vendor/raphael/raphael-min.js',
                'js/vendor/tags.js',
                'js/vendor/raphael/raphael.json.js',
                'js/services/authService.js',
                'js/controllers/main.js',
                'js/controllers/login.js',
                'js/controllers/register.js',
                'js/directives/usernameUnique.js',
                'js/directives/blurInputCheck.js'
        ], function() {
                angular.bootstrap(document, ['timelineApp']);
});
