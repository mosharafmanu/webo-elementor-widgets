(function ($) {
	'use strict';

	function closeItem($item) {
		$item.removeClass('is-active');
		$item.find('.webo-hotspot-popup__trigger').attr('aria-expanded', 'false');
		$item.find('.webo-hotspot-popup__card').attr('aria-hidden', 'true');
	}

	function openItem($item) {
		var $widget = $item.closest('.webo-hotspot-popup');

		$widget.find('.webo-hotspot-popup__item.is-active').not($item).each(function () {
			closeItem($(this));
		});

		$item.addClass('is-active');
		$item.find('.webo-hotspot-popup__trigger').attr('aria-expanded', 'true');
		$item.find('.webo-hotspot-popup__card').attr('aria-hidden', 'false');
		positionCard($item);
	}

	function positionCard($item) {
		var card = $item.find('.webo-hotspot-popup__card').get(0);

		if (!card) {
			return;
		}

		card.style.setProperty('--popup-shift-x', '0px');
		card.style.setProperty('--popup-shift-y', '0px');

		window.requestAnimationFrame(function () {
			var rect = card.getBoundingClientRect();
			var margin = 16;
			var shiftX = 0;
			var shiftY = 0;
			var isMobile = window.innerWidth <= 767;

			if (rect.right > window.innerWidth - margin) {
				shiftX = window.innerWidth - margin - rect.right;
			}

			if (rect.left + shiftX < margin) {
				shiftX += margin - (rect.left + shiftX);
			}

			if (isMobile && rect.bottom > window.innerHeight - margin) {
				shiftY = window.innerHeight - margin - rect.bottom;
			}

			if (rect.top + shiftY < margin) {
				shiftY += margin - (rect.top + shiftY);
			}

			card.style.setProperty('--popup-shift-x', shiftX + 'px');
			card.style.setProperty('--popup-shift-y', shiftY + 'px');
		});
	}

	function initHotspotPopup($scope) {
		var $widgets = $scope.find('.webo-hotspot-popup');

		if (!$widgets.length && $scope.hasClass('webo-hotspot-popup')) {
			$widgets = $scope;
		}

		$widgets.each(function () {
			var $widget = $(this);

			$widget.off('.weboHotspotPopup');

			$widget.on('click.weboHotspotPopup', '.webo-hotspot-popup__trigger', function (event) {
				event.preventDefault();

				var $item = $(this).closest('.webo-hotspot-popup__item');

				if ($item.hasClass('is-active')) {
					closeItem($item);
					return;
				}

				openItem($item);
			});

			$widget.on('click.weboHotspotPopup', '.webo-hotspot-popup__close', function (event) {
				event.preventDefault();
				closeItem($(this).closest('.webo-hotspot-popup__item'));
			});

			$widget.on('click.weboHotspotPopup', '.webo-hotspot-popup__mobile-toggle', function (event) {
				var $currentItem = $(this).closest('.webo-hotspot-popup__mobile-item');

				event.preventDefault();

				if ($currentItem.hasClass('is-active')) {
					$currentItem.removeClass('is-active');
					$currentItem.find('.webo-hotspot-popup__mobile-toggle').attr('aria-expanded', 'false');
					$currentItem.find('.webo-hotspot-popup__mobile-panel').attr('aria-hidden', 'true');
					return;
				}

				$widget.find('.webo-hotspot-popup__mobile-item.is-active').each(function () {
					var $item = $(this);

					$item.removeClass('is-active');
					$item.find('.webo-hotspot-popup__mobile-toggle').attr('aria-expanded', 'false');
					$item.find('.webo-hotspot-popup__mobile-panel').attr('aria-hidden', 'true');
				});

				$currentItem.addClass('is-active');
				$currentItem.find('.webo-hotspot-popup__mobile-toggle').attr('aria-expanded', 'true');
				$currentItem.find('.webo-hotspot-popup__mobile-panel').attr('aria-hidden', 'false');
			});

			$widget.find('.webo-hotspot-popup__item.is-active').each(function () {
				openItem($(this));
			});

			$widget.find('.webo-hotspot-popup__mobile-item').each(function () {
				var $item = $(this);
				var isActive = $item.hasClass('is-active');

				$item.find('.webo-hotspot-popup__mobile-toggle').attr('aria-expanded', isActive ? 'true' : 'false');
				$item.find('.webo-hotspot-popup__mobile-panel').attr('aria-hidden', isActive ? 'false' : 'true');
			});
		});
	}

	$(document).on('keyup.weboHotspotPopup', function (event) {
		if (event.key !== 'Escape') {
			return;
		}

		$('.webo-hotspot-popup__item.is-active').each(function () {
			closeItem($(this));
		});
	});

	$(window).on('resize.weboHotspotPopup', function () {
		$('.webo-hotspot-popup__item.is-active').each(function () {
			positionCard($(this));
		});
	});

	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/webo-hotspot-popup.default', initHotspotPopup);
	});
}(jQuery));
