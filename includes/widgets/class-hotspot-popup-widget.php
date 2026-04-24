<?php
namespace Webo_Elementor_Widgets\Widgets;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hotspot_Popup_Widget extends Widget_Base {
	public function get_name(): string {
		return 'webo-hotspot-popup';
	}

	public function get_title(): string {
		return esc_html__( 'Webo Hotspot Popup', 'webo-elementor-widgets' );
	}

	public function get_icon(): string {
		return 'eicon-image-hotspot';
	}

	public function get_categories(): array {
		return [ 'webo-widgets' ];
	}

	public function get_keywords(): array {
		return [ 'webo', 'hotspot', 'popup', 'trigger', 'image' ];
	}

	public function get_style_depends(): array {
		return [ 'webo-hotspot-popup' ];
	}

	public function get_script_depends(): array {
		return [ 'webo-hotspot-popup' ];
	}

	protected function register_controls(): void {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Section Title', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'H3 - Section headline', 'webo-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'   => esc_html__( 'Section Background', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_responsive_control(
			'background_position',
			[
				'label'     => esc_html__( 'Background Position', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'center center',
				'options'   => [
					'left top'      => esc_html__( 'Left Top', 'webo-elementor-widgets' ),
					'left center'   => esc_html__( 'Left Center', 'webo-elementor-widgets' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'webo-elementor-widgets' ),
					'center top'    => esc_html__( 'Center Top', 'webo-elementor-widgets' ),
					'center center' => esc_html__( 'Center Center', 'webo-elementor-widgets' ),
					'center bottom' => esc_html__( 'Center Bottom', 'webo-elementor-widgets' ),
					'right top'     => esc_html__( 'Right Top', 'webo-elementor-widgets' ),
					'right center'  => esc_html__( 'Right Center', 'webo-elementor-widgets' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'webo-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .webo-hotspot-popup' => 'background-position: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'background_size',
			[
				'label'     => esc_html__( 'Background Size', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'cover',
				'options'   => [
					'auto'    => esc_html__( 'Auto', 'webo-elementor-widgets' ),
					'cover'   => esc_html__( 'Cover', 'webo-elementor-widgets' ),
					'contain' => esc_html__( 'Contain', 'webo-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .webo-hotspot-popup' => 'background-size: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'section_height',
			[
				'label'      => esc_html__( 'Section Height', 'webo-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh' ],
				'range'      => [
					'px' => [
						'min' => 320,
						'max' => 900,
					],
					'vh' => [
						'min' => 40,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 680,
				],
				'selectors'  => [
					'{{WRAPPER}} .webo-hotspot-popup' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$repeater = new Repeater();

		$repeater->add_control(
			'hotspot_title',
			[
				'label'       => esc_html__( 'Headline', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'H7 - Card headline', 'webo-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'hotspot_text',
			[
				'label'   => esc_html__( 'Paragraph', 'webo-elementor-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'TXT - Psant, ut fugiat utibus nobis ne velique volupis nulparum ginihit quatide ma doloreis esites eration quis ex endusam litunt ecip.', 'webo-elementor-widgets' ),
				'rows'    => 5,
			]
		);

		$repeater->add_control(
			'position_x',
			[
				'label'      => esc_html__( 'Horizontal Position', 'webo-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
			]
		);

		$repeater->add_control(
			'position_y',
			[
				'label'      => esc_html__( 'Vertical Position', 'webo-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range'      => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => '%',
					'size' => 50,
				],
			]
		);

		$repeater->add_control(
			'open_default',
			[
				'label'        => esc_html__( 'Open by Default', 'webo-elementor-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'webo-elementor-widgets' ),
				'label_off'    => esc_html__( 'No', 'webo-elementor-widgets' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->start_controls_section(
			'section_hotspots',
			[
				'label' => esc_html__( 'Hotspots', 'webo-elementor-widgets' ),
			]
		);

		$this->add_control(
			'hotspots',
			[
				'label'       => esc_html__( 'Triggers', 'webo-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'hotspot_title' => esc_html__( 'H7 - Card headline', 'webo-elementor-widgets' ),
						'hotspot_text'  => esc_html__( 'TXT - Psant, ut fugiat utibus nobis ne velique volupis nulparum ginihit quatide ma doloreis esites eration quis ex endusam litunt ecip.', 'webo-elementor-widgets' ),
						'position_x'    => [
							'unit' => '%',
							'size' => 31,
						],
						'position_y'    => [
							'unit' => '%',
							'size' => 57,
						],
					],
					[
						'hotspot_title' => esc_html__( 'Equipment storage', 'webo-elementor-widgets' ),
						'hotspot_text'  => esc_html__( 'Organized compartments keep intervention tools visible, secure, and ready for fast access during each response.', 'webo-elementor-widgets' ),
						'position_x'    => [
							'unit' => '%',
							'size' => 43,
						],
						'position_y'    => [
							'unit' => '%',
							'size' => 41,
						],
					],
					[
						'hotspot_title' => esc_html__( 'Modular systems', 'webo-elementor-widgets' ),
						'hotspot_text'  => esc_html__( 'Flexible modules can be adapted around the crew workflow and vehicle requirements.', 'webo-elementor-widgets' ),
						'position_x'    => [
							'unit' => '%',
							'size' => 65,
						],
						'position_y'    => [
							'unit' => '%',
							'size' => 42,
						],
						'open_default'  => 'yes',
					],
				],
				'title_field' => '{{{ hotspot_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'webo-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Title Color', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .webo-hotspot-popup__title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .webo-hotspot-popup__title-wrap::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'webo-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(6, 9, 16, 0.52)',
				'selectors' => [
					'{{WRAPPER}} .webo-hotspot-popup::before' => 'background: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render(): void {
		$settings       = $this->get_settings_for_display();
		$hotspots       = $settings['hotspots'] ?? [];
		$background_url = ! empty( $settings['background_image']['url'] ) ? $settings['background_image']['url'] : Utils::get_placeholder_image_src();

		if ( empty( $hotspots ) ) {
			return;
		}

		$this->add_render_attribute(
			'wrapper',
			[
				'class' => 'webo-hotspot-popup',
				'style' => 'background-image: url(' . esc_url( $background_url ) . ');',
			]
		);
		?>
		<section <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
			<div class="webo-hotspot-popup__inner">
				<?php if ( ! empty( $settings['section_title'] ) ) : ?>
					<div class="webo-hotspot-popup__title-wrap">
						<h3 class="webo-hotspot-popup__title"><?php echo esc_html( $settings['section_title'] ); ?></h3>
					</div>
				<?php endif; ?>

				<div class="webo-hotspot-popup__mobile-media" style="background-image: url(<?php echo esc_url( $background_url ); ?>);"></div>

				<div class="webo-hotspot-popup__map">
					<?php foreach ( $hotspots as $index => $hotspot ) : ?>
						<?php $this->render_desktop_hotspot( $hotspot, $index ); ?>
					<?php endforeach; ?>
				</div>

				<div class="webo-hotspot-popup__mobile-list">
					<?php foreach ( $hotspots as $index => $hotspot ) : ?>
						<?php $this->render_mobile_hotspot( $hotspot, $index ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}

	private function render_desktop_hotspot( array $hotspot, int $index ): void {
		$x          = $this->get_position_value( $hotspot, 'position_x', 50 );
		$y          = $this->get_position_value( $hotspot, 'position_y', 50 );
		$is_open    = 'yes' === ( $hotspot['open_default'] ?? '' );
		$popup_id   = $this->get_id() . '-hotspot-popup-' . $index;
		$title      = $hotspot['hotspot_title'] ?? '';
		$text       = $hotspot['hotspot_text'] ?? '';
		$item_class = 'webo-hotspot-popup__item';

		if ( $is_open ) {
			$item_class .= ' is-active';
		}
		?>
		<div class="<?php echo esc_attr( $item_class ); ?>" style="--hotspot-x: <?php echo esc_attr( (string) $x ); ?>%; --hotspot-y: <?php echo esc_attr( (string) $y ); ?>%;">
			<button class="webo-hotspot-popup__trigger" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $popup_id ); ?>">
				<span class="webo-hotspot-popup__trigger-icon" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php echo esc_html__( 'Open hotspot details', 'webo-elementor-widgets' ); ?></span>
			</button>

			<div id="<?php echo esc_attr( $popup_id ); ?>" class="webo-hotspot-popup__card" role="dialog" aria-hidden="<?php echo $is_open ? 'false' : 'true'; ?>">
				<button class="webo-hotspot-popup__close" type="button" aria-label="<?php echo esc_attr__( 'Close hotspot details', 'webo-elementor-widgets' ); ?>"></button>

				<?php if ( ! empty( $title ) ) : ?>
					<h4 class="webo-hotspot-popup__card-title"><?php echo esc_html( $title ); ?></h4>
				<?php endif; ?>

				<?php if ( ! empty( $text ) ) : ?>
					<div class="webo-hotspot-popup__card-text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function render_mobile_hotspot( array $hotspot, int $index ): void {
		$is_open  = 'yes' === ( $hotspot['open_default'] ?? '' );
		$item_id  = $this->get_id() . '-hotspot-mobile-' . $index;
		$item_cls = 'webo-hotspot-popup__mobile-item';
		$title    = $hotspot['hotspot_title'] ?? '';
		$text     = $hotspot['hotspot_text'] ?? '';

		if ( $is_open ) {
			$item_cls .= ' is-active';
		}
		?>
		<div class="<?php echo esc_attr( $item_cls ); ?>">
			<button class="webo-hotspot-popup__mobile-toggle" type="button" aria-expanded="<?php echo $is_open ? 'true' : 'false'; ?>" aria-controls="<?php echo esc_attr( $item_id ); ?>">
				<span class="webo-hotspot-popup__mobile-toggle-icon" aria-hidden="true"></span>
				<span class="webo-hotspot-popup__mobile-toggle-label"><?php echo esc_html( $title ); ?></span>
			</button>

			<div id="<?php echo esc_attr( $item_id ); ?>" class="webo-hotspot-popup__mobile-panel" aria-hidden="<?php echo $is_open ? 'false' : 'true'; ?>">
				<?php if ( ! empty( $text ) ) : ?>
					<div class="webo-hotspot-popup__mobile-text"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}

	private function get_position_value( array $hotspot, string $key, int $fallback ): float {
		$value = $hotspot[ $key ]['size'] ?? $fallback;
		$value = is_numeric( $value ) ? (float) $value : (float) $fallback;

		return max( 0, min( 100, $value ) );
	}
}
