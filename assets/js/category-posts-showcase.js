(function ($) {
	'use strict';

	function initCategoryPostsShowcaseWidget($scope) {
		var $widget = $scope.find('.webo-category-posts-showcase').first();

		if (!$widget.length) {
			return;
		}

		var $track = $widget.find('.webo-category-posts-showcase__track');
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
			prevArrow: $widget.find('.webo-category-posts-showcase__nav-button--prev'),
			nextArrow: $widget.find('.webo-category-posts-showcase__nav-button--next'),
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
		elementorFrontend.hooks.addAction('frontend/element_ready/webo-category-posts-showcase.default', initCategoryPostsShowcaseWidget);
	});
}(jQuery));