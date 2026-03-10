(function ($) {
	'use strict';

	function initTestimonialCard($scope) {
		var $widget = $scope.find('.webo-testimonial-card').first();

		if (!$widget.length) {
			return;
		}

		var $track = $widget.find('.webo-testimonial-card__track');
		var enableCarousel = $widget.data('carousel') === 'yes';

		if ($track.hasClass('slick-initialized')) {
			$track.slick('unslick');
		}

		if (!enableCarousel || typeof $.fn.slick !== 'function' || $track.children().length < 2) {
			return;
		}

		$track.slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			fade: true,
			cssEase: 'ease',
			arrows: $widget.data('arrows') === 'yes',
			dots: $widget.data('dots') === 'yes',
			prevArrow: $widget.find('.webo-testimonial-card__arrow--prev'),
			nextArrow: $widget.find('.webo-testimonial-card__arrow--next'),
			appendDots: $widget.find('.webo-testimonial-card__dots'),
			autoplay: $widget.data('autoplay') === 'yes',
			autoplaySpeed: parseInt($widget.data('autoplay-speed'), 10) || 5000,
			speed: parseInt($widget.data('speed'), 10) || 600,
			infinite: $widget.data('infinite') === 'yes',
			adaptiveHeight: false,
			rtl: $('body').hasClass('rtl')
		});
	}

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/webo-testimonial-card.default', initTestimonialCard);
	});
}(jQuery));