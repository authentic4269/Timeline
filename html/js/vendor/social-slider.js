var SocialSlider = (function(){
	var ITEM_MARGIN = 8,
		SLIDER_PADDING = 8;

	var _container = null,
		_sliderWrapper = null,
		_sliderItems = null,

		_sliderWidth = 0,
		_sliderItemsWidth = 0;

	function initSlider() {
		_sliderItemsWidth = 0;

		_sliderItems.find('.item').each(function(index, obj) {
			_sliderItemsWidth += $(obj).width() + ITEM_MARGIN * 2;
		});

		_sliderItems.width(_sliderItemsWidth);
	}

	function bindEvents() {
		_container.find('.prev').unbind('click').bind('click', function(){
			var left = +_sliderItems.css('left').replace('px', '');
			left += 80;

			if(left > 0) {
				left = 0;
			}

			_sliderItems.animate({left: left + 'px'}, 400);
		});

		_container.find('.next').unbind('click').bind('click', function(){
			var left = +_sliderItems.css('left').replace('px', '');
			left -= 80;

			if(_sliderItemsWidth + SLIDER_PADDING*2 + left <= _sliderWidth) {
				left = _sliderWidth - _sliderItemsWidth - SLIDER_PADDING*2;
			}

			_sliderItems.animate({left: left + 'px'}, 400);
		});
	}

	return {
		init: function(containerId) {
			_container = $('#' + containerId);
			_sliderWrapper = _container.find('.social-items-wrapper');
			_sliderItems = _container.find('.social-items')

			_sliderWidth = _sliderWrapper.width();

			initSlider(containerId);
			bindEvents();
		}
	};
})();