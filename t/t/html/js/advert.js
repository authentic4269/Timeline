var Advert = (function(){
	var sidebar = $('.sidebar'),
		sidebarItems = $('.sidebar-items'),
		advWrapper = $('.adv-wrapper');

	return {
		show: function(callback) {
			sidebarItems.css({height: '353px'});
			sidebar.css({height: '390px'});
			advWrapper.css({opacity: 1}).fadeIn('fast');

			if(typeof callback === "function") {
				callback();
			}
		},
		hide: function(callback) {
			advWrapper.animate({opacity: 0}, 500, function() {
				advWrapper.hide();
				sidebar.css({height: '630px'});
				sidebarItems.css({height: '594px'});

				if(typeof callback === "function") {
					callback();
				}
			});
		}
	};
})();