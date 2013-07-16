// timelineApp.animation('fade-hide', function() {
  // return {
	// setup : function(element) {
	// },
	// start : function(element, done, memo) {
		// element.animate({}, function() {
			// //вызывается при завершении анимации
			// console.log('asdasd');
			// done();
		// });
	// // var timer = setTimeout(function(){
		// // console.log('asdasd')
		// // //element.addClass("opened");
		// // done();
	  // // }, 500);
	// }
  // };
// });

// timelineApp.animation('repeat-enter',  function() {
  // return { 
    // setup : function(element) {
      // //jQuery(element).css({ 'line-height': 0 });
	  // console.log('sdf')
    // },
    // start : function(element, done, memo) {
      // //jQuery(element).animate({ 'line-height': '20px' }, function() { done(); });
	  // console.log('sdf11')
    // }
  // };
// });

angular.module('timelineApp').animation('animated fadeOut', function() {
  var getScope = function(e) {
    return angular.element(e).scope();
  };
  return {
    setup : function(element) {
      var $scope = getScope(element);
    },
    start : function(element, done, memo) {
      var $scope = getScope(element);
    },
    cancel : function(element, done) {
      var $scope = getScope(element);
    }
  };
});