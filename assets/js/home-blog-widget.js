(function ($) {
	'use strict';

	function initHomeBlogWidget($scope) {
		var $widget = $scope.find('.webo-home-blog').first();

		if (!$widget.length) {
			return;
		}

		var $track = $widget.find('.webo-home-blog__track');
		var enableCarousel = $widget.data('carousel') === 'yes';

		if ($track.hasClass('slick-initialized')) {
			$track.slick('unslick');
		}

		if (!enableCarousel || typeof $.fn.slick !== 'function' || $track.children().length < 2) {
			return;
		}

		$track.slick({
			slidesToShow: parseInt($widget.data('slides-desktop'), 10) || 2,
			slidesToScroll: 1,
			arrows: $widget.data('arrows') === 'yes',
			prevArrow: $widget.find('.webo-home-blog__nav-button--prev'),
			nextArrow: $widget.find('.webo-home-blog__nav-button--next'),
			speed: parseInt($widget.data('speed'), 10) || 500,
			infinite: $widget.data('infinite') === 'yes',
			dots: false,
			adaptiveHeight: false,
			rtl: $('body').hasClass('rtl'),
			responsive: [
				{
					breakpoint: 1025,
					settings: {
						slidesToShow: parseInt($widget.data('slides-tablet'), 10) || 2
					}
				},
				{
					breakpoint: 768,
					settings: {
						slidesToShow: parseInt($widget.data('slides-mobile'), 10) || 1
					}
				}
			]
		});
	}

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/webo-home-blog-widget.default', initHomeBlogWidget);
	});
}(jQuery));